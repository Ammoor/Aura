<?php

namespace App\Services;

use App\Mail\UserEmailConfirmationMail;
use App\Repositories\PendingMailVerificationRepository;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailService
{
    private PendingMailVerificationRepository $pendingMailVerificationRepository;
    private int $verificationCodeExpireAfter = 10; // In minutes.
    public function __construct(PendingMailVerificationRepository $pendingMailVerificationRepository)
    {
        $this->pendingMailVerificationRepository = $pendingMailVerificationRepository;
    }
    private function generateRandomCode()
    {
        return (string) random_int(100000, 999999);
    }
    public function sendVerificationMail($userData)
    {
        $pendingData['email'] = $userData['email'];
        $pendingData['verification_code'] = $this->generateRandomCode();
        $pendingData['expires_at'] = now()->addMinutes($this->verificationCodeExpireAfter);
        $this->pendingMailVerificationRepository->store($pendingData);
        return Mail::to($userData['email'])->send(
            new UserEmailConfirmationMail($userData, $pendingData['verification_code'],$this->verificationCodeExpireAfter)
        );
    }
    public function verifyEmail($userData)
    {
        $isUserVerified = $this->pendingMailVerificationRepository->get($userData);
        if ($isUserVerified) {
            $this->pendingMailVerificationRepository->delete($userData);
        }
        return $isUserVerified;
    }
}
