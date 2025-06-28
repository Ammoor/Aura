<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function register(array $userData)
    {
        return User::create($userData);
    }
    public function getUserByEmail($userEmail)
    {
        return User::where('email', $userEmail)->first();
    }
    public function getUserData()
    {
        return auth()->user();
    }
    public function updateUserData($userData)
    {
        return auth()->user()->update($userData);
    }
    public function deleteUserData()
    {
        return auth()->user()->delete();
    }
}
