<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Temporary Password</title>
</head>
<body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
    <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
        <h2 style='color: #2563eb;'>Welcome to CrwdCtrl!</h2>
        <p>Hello {{ $name }},</p>
        <p>Your account has been created successfully. Here is your temporary password:</p>
        <div style='background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;'>
            <strong style='font-size: 18px; color: #1f2937;'>{{ $temporaryPassword }}</strong>
        </div>
        <p><strong>Important:</strong> Please change your password after your first login for security purposes.</p>
        <p>If you have any questions, please contact our support team.</p>
        <p>Best regards,<br>The CrwdCtrl Team</p>
    </div>
</body>
</html>