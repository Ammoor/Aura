<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Repositories\AuthAccountRepository;
use App\Services\MailService;
use App\Repositories\UserRepository;
use App\Helpers\S3MediaHelper;

class UserService
{
    private UserRepository $userRepository;
    private AuthAccountRepository $authAccountRepository;
    private MailService $mailService;
    private string $defaultProfileImagePath = 'Aura/profile-images/default_profile_image.jpg';
    public function __construct(UserRepository $userRepository, AuthAccountRepository $authAccountRepository, MailService $mailService)
    {
        $this->userRepository = $userRepository;
        $this->authAccountRepository = $authAccountRepository;
        $this->mailService = $mailService;
    }
    public function authAccountUser($userData, $providerName)
    {
        $authAccountData['provider_id'] = $userData->getId();
        $authAccountData['provider'] = $providerName;

        $user = $this->userRepository->getUserByEmail($userData->getEmail());
        if ($user) {
            $authAccount = $this->authAccountRepository->getAuthAccount($authAccountData['provider_id'], $user);
            if (!$authAccount) {
                $this->authAccountRepository->addAuthAccount($authAccountData, $user);
                if (!$user->has_auth_account) {
                    $user->update(['has_auth_account' => true]);
                }
            }
            return $user->createToken('user_token')->plainTextToken;
        }

        $userNameParts = explode(' ', $userData->getName());
        $userAttributes = [
            'first_name' => $userNameParts[0] ?? '',
            'last_name' => $userNameParts[1] ?? '',
            'email' => $userData->getEmail(),
            'has_auth_account' => true,
            'profile_image_path' => $this->defaultProfileImagePath,
        ];
        $user = $this->userRepository->register($userAttributes);
        $this->authAccountRepository->addAuthAccount($authAccountData, $user);
        return $user->createToken('user_token')->plainTextToken;
    }
    public function logIn(array $userData)
    {
        return auth()->attempt(['email' => $userData['email'], 'password' => $userData['password']]) ? auth()->user()->createToken('user_token')->plainTextToken : null;
    }
    public function register(array $userData)
    {
        $userData['password'] = Hash::make($userData['password']);
        Cache::put('user_temp_data', $userData, now()->addDays(7));
        return $this->mailService->sendVerificationMail($userData);
    }
    public function logOut()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
    public function getUserData()
    {
        return $this->userRepository->getUserData();
    }
    public function updateUserData($userData)
    {
        $authUser = $this->userRepository->getUserData();
        if (array_key_exists('profile_image', $userData)) {

            if ($authUser->profile_image_path !== $this->defaultProfileImagePath) {
                $userData['profile_image_path'] = S3MediaHelper::update($userData['profile_image'], $authUser->profile_image_path, 'profile_images');
            } else {
                $userData['profile_image_path'] = S3MediaHelper::store($userData['profile_image'], 'profile_images');
            }
        }
        return $this->userRepository->updateUserData($userData);
    }
    public function deleteUserData()
    {
        return $this->userRepository->deleteUserData();
    }
}
