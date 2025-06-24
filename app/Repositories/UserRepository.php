<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function register(array $userData)
    {
        return User::create($userData);
    }
}
