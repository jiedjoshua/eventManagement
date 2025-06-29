<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #EF7C79 0%, #D76C69 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #EF7C79;
            margin-bottom: 5px;
        }
        .field-value {
            background: white;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #EF7C79;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
        <p>CrwdCtrl Event Management</p>
    </div>
    
    <div class="content">
        <p>You have received a new contact form submission from your website. Here are the details:</p>
        
        <div class="field">
            <div class="field-label">Name:</div>
            <div class="field-value">{{ $contactData['first_name'] }} {{ $contactData['last_name'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $contactData['email'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Phone:</div>
            <div class="field-value">{{ $contactData['phone'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Event Type:</div>
            <div class="field-value">{{ ucfirst($contactData['event_type']) }}</div>
        </div>
        
        @if(isset($contactData['event_date']) && $contactData['event_date'])
        <div class="field">
            <div class="field-label">Preferred Event Date:</div>
            <div class="field-value">{{ \Carbon\Carbon::parse($contactData['event_date'])->format('F j, Y') }}</div>
        </div>
        @endif
        
        @if(isset($contactData['message']) && $contactData['message'])
        <div class="field">
            <div class="field-label">Message:</div>
            <div class="field-value">{{ $contactData['message'] }}</div>
        </div>
        @endif
        
        <div class="footer">
            <p>This message was sent from the contact form on your website.</p>
            <p>Please respond to the customer at: <a href="mailto:{{ $contactData['email'] }}">{{ $contactData['email'] }}</a></p>
        </div>
    </div>
</body>
</html> 