<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CrwdCtrl - Your Temporary Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .tagline {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-text {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
            text-align: center;
        }
        .message {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 25px;
            line-height: 1.7;
        }
        .password-box {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border: 2px solid #d1d5db;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .password-label {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .password {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            background: white;
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            display: inline-block;
            min-width: 200px;
        }
        .warning {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 25px 0;
        }
        .warning-title {
            font-weight: 600;
            color: #92400e;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        .warning-icon {
            margin-right: 8px;
            font-size: 18px;
        }
        .warning-text {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 25px 0;
            text-align: center;
            transition: transform 0.2s ease;
        }
        .login-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .contact-info {
            color: #9ca3af;
            font-size: 12px;
            margin: 0;
        }
        .contact-info a {
            color: #667eea;
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .welcome-text {
                font-size: 20px;
            }
            .password {
                font-size: 18px;
                min-width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">CrwdCtrl</div>
            <p class="tagline">Event Management Made Simple</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="welcome-text">Welcome to CrwdCtrl!</h1>
            
            <p class="message">
                Hello <strong>{{ $name }}</strong>,<br><br>
                Your account has been successfully created by an administrator. To get started, you'll need to use the temporary password below to log in for the first time.
            </p>

            <!-- Temporary Password Box -->
            <div class="password-box">
                <div class="password-label">Your Temporary Password</div>
                <div class="password">{{ $temporaryPassword }}</div>
            </div>

            <!-- Security Warning -->
            <div class="warning">
                <div class="warning-title">
                    <span class="warning-icon">⚠️</span>
                    Security Notice
                </div>
                <p class="warning-text">
                    For your security, please change this temporary password immediately after your first login. This password is only valid for initial access.
                </p>
            </div>

            <!-- Login Button -->
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="login-button">
                    Login to Your Account
                </a>
            </div>

            <p class="message">
                If you have any questions or need assistance, please don't hesitate to contact our support team. We're here to help you get started with CrwdCtrl!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                Best regards,<br>
                <strong>The CrwdCtrl Team</strong>
            </p>
            <p class="contact-info">
                Need help? Contact us at <a href="mailto:support@crwdctrl.com">support@crwdctrl.com</a><br>
                © 2025 CrwdCtrl. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>