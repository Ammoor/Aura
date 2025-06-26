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
        return User::where('email',$userEmail)->first();
    }
}
