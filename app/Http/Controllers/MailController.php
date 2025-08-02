<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Requests\resendVerificationMailRequest;
use App\Helpers\ApiResponseFormat;

class MailController extends Controller
{
    private MailService $mailService;
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function verifyEmail(VerifyEmailRequest $request)
    {
        $isUserVerified = $this->mailService->verifyEmail($request->validated());
        if ($isUserVerified) {
            return ApiResponseFormat::successResponse(201, 'Email verified and user registered successfully.', ['userToken' => $isUserVerified]);
        }
        return ApiResponseFormat::failedResponse(422, 'Invalid or expired code.');
    }
    public function resendEmail(resendVerificationMailRequest $request)
    {
        $this->mailService->resendVerificationMail($request->email);
        return ApiResponseFormat::successResponse(200, 'Confirmation email sent.');
    }
}
