<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.brevo.com/v3';

    public function __construct()
    {
        $this->apiKey = config('mail.mailers.smtp.password');
    }

    public function sendEmail($to, $subject, $htmlContent, $fromEmail = null, $fromName = null)
    {
        try {
            $fromEmail = $fromEmail ?? config('mail.from.address');
            $fromName = $fromName ?? config('mail.from.name');

            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'content-type' => 'application/json',
            ])->post($this->baseUrl . '/smtp/email', [
                'sender' => [
                    'name' => $fromName,
                    'email' => $fromEmail,
                ],
                'to' => [
                    [
                        'email' => $to,
                    ]
                ],
                'subject' => $subject,
                'htmlContent' => $htmlContent,
            ]);

            if ($response->successful()) {
                Log::info('Brevo email sent successfully', [
                    'to' => $to,
                    'subject' => $subject,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('Brevo email failed', [
                    'to' => $to,
                    'subject' => $subject,
                    'response' => $response->json(),
                    'status' => $response->status()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Brevo email exception', [
                'to' => $to,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendPasswordResetEmail($email, $resetUrl, $userName = null)
    {
        $subject = 'Password Reset Request - Event Management System';
        
        $htmlContent = view('emails.password-reset', [
            'resetUrl' => $resetUrl,
            'userName' => $userName
        ])->render();

        return $this->sendEmail($email, $subject, $htmlContent);
    }
} 