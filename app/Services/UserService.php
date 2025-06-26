<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\AuthAccountRepository;
use Illuminate\Support\Facades\Hash;

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
        return $this->userRepository->register($userData)->createToken('user_token')->plainTextToken;
    }
    public function logOut()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
