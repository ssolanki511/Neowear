<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <style>
        body {
            background: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Neue Montreal', sans-serif;
        }
        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .title {
            font-family: 'Neue Montreal Bold', sans-serif;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 18px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 10px;
        }
        .username {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 24px;
        }
        .verify-btn {
            display: inline-block;
            background: #2563eb;
            font-weight: bold;
            margin-top: 8px;
            padding: 10px 32px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="title">Verify your email address</h2>
        <p class="subtitle">Hello, <span class="username">{{ $email }}</span>. Please confirm that you want to use this as your Neowear account email address.</p>
        <a href="{{ url('send_dynamic_mail/'.$token.'/'.$email) }}" class="verify-btn" style="color:white;">Verify Email</a>
    </div>
</body>
</html>