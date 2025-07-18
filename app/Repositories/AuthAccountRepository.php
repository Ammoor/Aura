<?php

namespace App\Repositories;

use App\Models\User;

class AuthAccountRepository
{
    public function addAuthAccount(array $authAccountData, User $user)
    {
        return $user->authAccounts()->create($authAccountData);
    }
    public function getAuthAccount(string $providerId, User $user)
    {
        return $user->authAccounts()->where('provider_id', $providerId)->first();
    }
}
