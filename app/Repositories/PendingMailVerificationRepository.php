<?php

namespace App\Repositories;

use App\Models\PendingMailVerification;

class PendingMailVerificationRepository
{
    public function updateOrCreate($pendingData)
    {
        return PendingMailVerification::updateOrCreate($pendingData);
    }
    public function get($pendingData)
    {
        return PendingMailVerification::where('email', $pendingData['email'])->where('verification_code', $pendingData['verification_code'])->where('expires_at', '>=', now())->exists();
    }
    public function delete($pendingData)
    {
        return PendingMailVerification::where('email', $pendingData['email'])->where('verification_code', $pendingData['verification_code'])->delete();
    }
}
