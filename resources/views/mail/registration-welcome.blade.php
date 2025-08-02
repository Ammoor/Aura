<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }}</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #007bff; padding-bottom: 20px;">
            <h1 style="color: #007bff; margin: 0; font-size: 28px;">🎉 Welcome to {{ config('app.name') }}!</h1>
        </div>

        <!-- Content -->
        <div style="margin-bottom: 30px;">
            <p style="font-size: 16px; margin-bottom: 15px;">Dear {{ $userData['first_name'] }},</p>

            <p style="font-size: 16px; margin-bottom: 15px;">Congratulations! Your email has been successfully verified
                and your <strong>{{ config('app.name') }}</strong> account is now active and ready to use!</p>

            <p style="font-size: 16px; margin-bottom: 20px;">You're now part of our amazing community where your
                experience is our top priority. Here's what you can do next:</p>
        </div>

        <!-- Success Message -->
        <div
            style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 25px; text-align: center; border-radius: 8px; margin: 25px 0;">
            <p style="margin: 0 0 10px 0; font-size: 14px; opacity: 0.9;">Account Status</p>
            <div
                style="font-size: 32px; font-weight: bold; letter-spacing: 2px; font-family: 'Courier New', monospace;">
                ✅ VERIFIED
            </div>
        </div>

        <!-- Next Steps -->
        <div
            style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid #007bff; margin: 25px 0;">
            <h3 style="color: #007bff; margin: 0 0 15px 0; font-size: 18px;">What's Next?</h3>
            <ul style="margin: 0; padding-left: 20px;">
                <li style="margin-bottom: 8px;">Explore your dashboard and customize your profile</li>
                <li style="margin-bottom: 8px;">Connect with other members of our community</li>
                <li style="margin-bottom: 8px;">Check out our latest features and updates</li>
                <li style="margin-bottom: 0;">Don't forget to follow us on social media for tips and updates</li>
            </ul>
        </div>

        <!-- Support -->
        <p style="font-size: 16px; margin: 25px 0 15px 0;">Thank you for choosing {{ config('app.name') }}. We're
            excited to have you on board and look forward to providing you with an amazing experience!</p>

        <p style="font-size: 16px; margin: 25px 0;">
            Best regards,<br>
            <strong style="color: #007bff;">The {{ config('app.name') }} Team</strong>
        </p>

        <!-- Footer -->
        <div style="border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; text-align: center;">
            <p style="font-size: 12px; color: #666; margin: 0 0 10px 0;">
                <em>This is an automated message. Please do not reply to this email.</em>
            </p>
            <p style="font-size: 12px; color: #666; margin: 0;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>

    </div>
</body>

</html>
