<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request - CrwdCtrl</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #EF7C79;
            margin-bottom: 15px;
        }
        .title {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .content {
            margin-bottom: 40px;
        }
        .button {
            display: inline-block;
            background-color: #EF7C79;
            color: #ffffff;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 25px 0;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #D76C69;
        }
        .footer {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }
        .warning {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .warning strong {
            color: #92400e;
        }
        .contact-info {
            background-color: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .contact-info h3 {
            color: #EF7C79;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .url-box {
            background-color: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            word-break: break-all;
            font-size: 14px;
            color: #6b7280;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">CrwdCtrl</div>
            <h1 class="title">Password Reset Request</h1>
        </div>

        <div class="content">
            @if($userName)
                <p>Hello <strong>{{ $userName }}</strong>,</p>
            @else
                <p>Hello,</p>
            @endif

            <p>You are receiving this email because we received a password reset request for your CrwdCtrl account.</p>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            </div>

            <p><strong>Important:</strong> This password reset link will expire in 60 minutes for your security.</p>

            <div class="warning">
                <strong>Security Notice:</strong> If you did not request a password reset, no further action is required. This link will expire automatically.
            </div>

            <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
            <div class="url-box">{{ $resetUrl }}</div>
        </div>

        <div class="contact-info">
            <h3>Need Help?</h3>
            <p>📞 +63 912 345 6789</p>
            <p>✉️ hello@crwdctrl.space</p>
            <p>📍 Bataan, Philippines</p>
        </div>

        <div class="footer">
            <p><strong>CrwdCtrl</strong> - Celebrate Life's Special Moments</p>
            <p>This email was sent from your CrwdCtrl account. If you have any questions, please contact our support team.</p>
            <p style="margin-top: 15px; font-size: 12px; color: #9ca3af;">&copy; 2025 CrwdCtrl. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 