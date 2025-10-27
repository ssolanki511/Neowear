<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inquiry Reply</title>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 24px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 16px;
        }
        .message {
            color: #444444;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .reply-box {
            background: #e8f0fe;
            border: 1px solid #cbd5e1;
            padding: 16px;
            border-radius: 6px;
            color: #1e3a8a;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #eeeeee;
            padding-top: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="title">Hello {{ $email }},</p>

        <p class="message">We received your inquiry and here is our reply:</p>

        <div class="reply-box">
            {{ $reply }}
        </div>

        <p class="message">
            If you have any further questions, just reply to this email and we’ll be happy to help.
        </p>

        <div class="footer">
            <p>Best regards,</p>
            <p><strong>NeoWear Support</strong></p>
            <p>Email: {{ $support_email }}</p>
        </div>
    </div>
</body>
</html>
