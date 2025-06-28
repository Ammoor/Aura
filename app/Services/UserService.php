<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\AuthAccountRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helpers\MediaHelper;

class UserService
{
    private UserRepository $userRepository;
    private AuthAccountRepository $authAccountRepository;
    public function __construct(UserRepository $userRepository, AuthAccountRepository $authAccountRepository)
    {
        $this->userRepository = $userRepository;
        $this->authAccountRepository = $authAccountRepository;
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
    private function uploadProfileImage($profileImage, $profileImagePath) // Upload the images to the AWS S3 disk for production.
    {
        return Storage::disk('s3')->put($profileImagePath, file_get_contents($profileImage), 'public');
    }
    public function updateUserData($userData)
    {
        $authUser = $this->userRepository->getUserData();
        if (array_key_exists('profile_image', $userData)) {
            $userData['profile_image_path'] = MediaHelper::update($userData['profile_image'], $authUser->profile_image_path, 'profile-images');
            $this->uploadProfileImage($userData['profile_image'], $userData['profile_image_path']);
        }
        return $this->userRepository->updateUserData($userData);
    }
    public function deleteUserData()
    {
        return $this->userRepository->deleteUserData();
    }
}
