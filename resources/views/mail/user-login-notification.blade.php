<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Login - {{ config('app.name') }}</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #007bff; padding-bottom: 20px;">
            <h1 style="color: #007bff; margin: 0; font-size: 28px;">🔐 New Login Detected</h1>
        </div>

        <!-- Content -->
        <div style="margin-bottom: 30px;">
            <p style="font-size: 16px; margin-bottom: 15px;">Hello {{ $userData['first_name'] }},</p>

            <p style="font-size: 16px; margin-bottom: 15px;">We detected a new login to your
                <strong>{{ config('app.name') }}</strong> account.</p>
        </div>

        <!-- Security Notice -->
        <div
            style="background-color: #fff3cd; padding: 20px; border-radius: 6px; border-left: 4px solid #ffc107; margin: 25px 0;">
            <h3 style="color: #856404; margin: 0 0 15px 0; font-size: 18px;">⚠️ Security Notice</h3>
            <p style="margin: 0; font-size: 16px; color: #856404;">
                If this wasn't you, please secure your account immediately by changing your password and reviewing your
                account activity.
            </p>
        </div>

        <!-- Support -->
        <p style="font-size: 16px; margin: 25px 0 15px 0;">If you have any concerns about your account security, please
            don't hesitate to contact our support team immediately.</p>

        <p style="font-size: 16px; margin: 25px 0;">
            Best regards,<br>
            <strong style="color: #007bff;">The {{ config('app.name') }} Security Team</strong>
        </p>

        <!-- Footer -->
        <div style="border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; text-align: center;">
            <p style="font-size: 12px; color: #666; margin: 0 0 10px 0;">
                <em>This is an automated security message. Please do not reply to this email.</em>
            </p>
            <p style="font-size: 12px; color: #666; margin: 0;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>

    </div>
</body>

</html>
