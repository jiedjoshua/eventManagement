<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
}