<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserEmailConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;
    private array $userData;
    private string $verificationCode;
    private int $verificationCodeExpireAfter; // In minutes.

    /**
     * Create a new message instance.
     */
    public function __construct(array $userData, string $verificationCode, int $verificationCodeExpireAfter)
    {
        $this->userData = $userData;
        $this->verificationCode = $verificationCode;
        $this->verificationCodeExpireAfter = $verificationCodeExpireAfter;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.user-email-confirmation',
            with: [
                'userData' => $this->userData,
                'verificationCode' => $this->verificationCode,
                'verificationCodeExpireAfter' => $this->verificationCodeExpireAfter,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
