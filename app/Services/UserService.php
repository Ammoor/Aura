<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
