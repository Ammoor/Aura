<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use App\Mail\UserEmailConfirmationMail;
use App\Mail\RegistrationWelcomeMail;
use App\Repositories\PendingMailVerificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Exception;

class MailService
{
    private PendingMailVerificationRepository $pendingMailVerificationRepository;
    private UserRepository $userRepository;
    private string $defaultProfileImagePath = 'Aura/profile-images/default_profile_image.jpg';
    private int $verificationCodeExpireAfter = 10; // In minutes.
    public function __construct(PendingMailVerificationRepository $pendingMailVerificationRepository, UserRepository $userRepository)
    {
        $this->pendingMailVerificationRepository = $pendingMailVerificationRepository;
        $this->userRepository = $userRepository;
    }
    private function completeRegistration($userEmail)
    {
        $userData = Cache::get($userEmail);
        $userData['profile_image_path'] = $this->defaultProfileImagePath;
        Cache::delete($userEmail);
        return $this->userRepository->register($userData)->createToken('user_token')->plainTextToken;
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
        $this->pendingMailVerificationRepository->updateOrCreate($pendingData);
        return Mail::to($userData['email'])->send(
            new UserEmailConfirmationMail($userData, $pendingData['verification_code'], $this->verificationCodeExpireAfter)
        );
    }
    public function resendVerificationMail($userEmail)
    {
        try {
            $userData = Cache::get($userEmail);
            return $this->sendVerificationMail($userData);
        } catch (Exception $e) {
            throw ValidationException::withMessages(['email' => 'The selected email is invalid.']);
        }
    }
    public function verifyEmail($userData)
    {
        $isUserVerified = $this->pendingMailVerificationRepository->get($userData);
        if ($isUserVerified) {
            $this->pendingMailVerificationRepository->delete($userData);
            Mail::to($userData['email'])->send(
                new RegistrationWelcomeMail()
            );
            return $this->completeRegistration($userData['email']);
        }
        return $isUserVerified;
    }
}
