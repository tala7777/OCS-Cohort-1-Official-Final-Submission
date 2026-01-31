<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Approved</title>
</head>
<body style="font-family: sans-serif; background-color: #f3f4f6; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h1 style="color: #1e293b; margin-top: 0;">Congratulations!</h1>
        <p style="color: #4b5563; font-size: 16px; line-height: 1.5;">
            Dear {{ $user->name }},
        </p>
        <p style="color: #4b5563; font-size: 16px; line-height: 1.5;">
            We are pleased to inform you that your lawyer account has been successfully <strong>approved</strong>.
        </p>
        <p style="color: #4b5563; font-size: 16px; line-height: 1.5;">
            You now have full access to answer questions, publish articles, and engage with potential clients on our platform.
        </p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('login') }}" style="background-color: #eab308; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                Login to Your Account
            </a>
        </div>
        <p style="color: #6b7280; font-size: 14px; margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px;">
            If you have any questions, please contact our support team.
            <br>
            Regards,<br>
            The Ask a Lawyer Team
        </p>
    </div>
</body>
</html>
