<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PasswordResetMail;

class ResendService
{
    public function sendTemporaryPassword($email, $name, $temporaryPassword)
    {
        try {
            Mail::to($email)->send(new \App\Mail\TemporaryPassword($name, $temporaryPassword));

            Log::info('Resend email sent successfully', [
                'email' => $email,
                'name' => $name
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Resend email failed', [
                'email' => $email,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    public function sendPasswordResetEmail($email, $resetUrl, $userName = null)
    {
        try {
            // Use Laravel Mail with SMTP (Brevo SMTP is configured)
            Mail::to($email)->send(new PasswordResetMail($resetUrl, $userName));

            Log::info('Password reset email sent successfully via SMTP', [
                'email' => $email,
                'userName' => $userName
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Password reset email failed', [
                'email' => $email,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}