<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TemporaryPassword;

class TestResend extends Command
{
    protected $signature = 'resend:test {email}';
    protected $description = 'Test Resend email sending';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Testing Resend configuration...');
        
        $apiKey = config('services.resend.api_key');
        $fromEmail = config('mail.from.address');
        $fromName = config('mail.from.name');
        
        if (!$apiKey) {
            $this->error('❌ Resend API key not found in .env file');
            $this->info('Get your API key from: https://resend.com/api-keys');
            return 1;
        }
        
        $this->info("API Key: " . substr($apiKey, 0, 10) . "...");
        $this->info("From Email: " . $fromEmail);
        $this->info("From Name: " . $fromName);
        $this->info('✅ Resend credentials found');
        
        try {
            $this->info('Testing email sending...');
            
            // Test with a simple email first
            Mail::raw('This is a test email from Resend.', function($message) use ($email) {
                $message->to($email)
                        ->subject('Simple Test Email');
            });
            
            $this->info('✅ Simple email sent successfully!');
            
            // Now test with the Mailable class
            $this->info('Testing with Mailable class...');
            Mail::to($email)->send(new TemporaryPassword('Test User', 'test123456'));
            
            $this->info('✅ Mailable email sent successfully!');
            
        } catch (\Exception $e) {
            $this->error('❌ Email sending failed');
            $this->error('Error: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile());
            $this->error('Line: ' . $e->getLine());
            return 1;
        }
        
        return 0;
    }
}