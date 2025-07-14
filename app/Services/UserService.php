<?php

namespace App\Services;

use App\Helpers\S3MediaHelper;
use App\Helpers\LocalMediaHelper;
use App\Repositories\UserRepository;
use App\Repositories\AuthAccountRepository;
use App\Mail\UserEmailConfirmationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Exception;

class UserService
{
    private UserRepository $userRepository;
    private AuthAccountRepository $authAccountRepository;
    private string $appName;
    public function __construct(UserRepository $userRepository, AuthAccountRepository $authAccountRepository)
    {
        $this->userRepository = $userRepository;
        $this->authAccountRepository = $authAccountRepository;
        $this->appName = config('app.name');
    }
    public function authAccountUser($userData)
    {
        $authAccountData['provider_id'] = $userData->getId();
        $authAccountData['provider'] = $userData->provider_name;

        $isUserExists = $this->userRepository->getUserByEmail($userData->getEmail());
        if ($isUserExists) {
            $isAuthAccountExists = $this->authAccountRepository->getAuthAccount($authAccountData['provider_id']);
            if (!$isAuthAccountExists) {
                $this->authAccountRepository->addAuthAccount($authAccountData);
            }
            return $isUserExists->createToken('user_token')->plainTextToken;
        }

        $userNameParts = explode(' ', $userData->getName());
        $userAttributes = [
            'first_name' => $userNameParts[0] ?? '',
            'last_name' => $userNameParts[1] ?? '',
            'email' => $userData->getEmail(),
            'has_auth_account' => true,
        ];
        $user = $this->userRepository->register($userAttributes);
        $authAccountData['user_id'] = $user->id;
        $this->authAccountRepository->addAuthAccount($authAccountData);
        return $user->createToken('user_token')->plainTextToken;
    }
    public function logIn(array $userData)
    {
        return auth()->attempt(['email' => $userData['email'], 'password' => $userData['password']]) ? auth()->user()->createToken('user_token')->plainTextToken : null;
    }
    public function register(array $userData)
    {
        if (array_key_exists('password', $userData)) {
            $userData['password'] = Hash::make($userData['password']);
        }
        $userData['profile_image_path'] = 'profile-images/default_profile_image.jpg';
        return $this->userRepository->register($userData)->createToken('user_token')->plainTextToken;
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

            if ($authUser->profile_image_path !== 'profile-images/default_profile_image.jpg') {

                $userData['profile_image_path'] = LocalMediaHelper::update($userData['profile_image'], $authUser->profile_image_path, 'profile-images');
                S3MediaHelper::update($userData['profile_image'], $this->appName . '/' . $authUser->profile_image_path, $this->appName . '/' . $userData['profile_image_path']);
            } else {

                $userData['profile_image_path'] = LocalMediaHelper::store($userData['profile_image'], 'profile-images');
                S3MediaHelper::store($userData['profile_image'], $this->appName . '/' . $userData['profile_image_path']);
            }
        }
        return $this->userRepository->updateUserData($userData);
    }
    public function deleteUserData()
    {
        return $this->userRepository->deleteUserData();
    }
}
