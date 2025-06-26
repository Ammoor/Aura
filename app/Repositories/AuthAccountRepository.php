<?php

namespace App\Repositories;

use App\Models\AuthAccount;

class AuthAccountRepository
{
    public function addAuthAccount($authAccountData)
    {
        return AuthAccount::create($authAccountData);
    }
    public function getAuthAccount($providerId)
    {
        return AuthAccount::where('provider_id', $providerId)->first();
    }
}
