<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Deletion - {{ config('app.name') }}</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #007bff; padding-bottom: 20px;">
            <h1 style="color: #007bff; margin: 0; font-size: 28px;">Account Deletion Confirmed</h1>
        </div>

        <!-- Content -->
        <div style="margin-bottom: 30px;">
            <p style="font-size: 16px; margin-bottom: 15px;">Dear {{ $userData['first_name'] }},</p>

            <p style="font-size: 16px; margin-bottom: 15px;">We're sorry to see you go! Your
                <strong>{{ config('app.name') }}</strong> account has been successfully deleted as requested.</p>

            <p style="font-size: 16px; margin-bottom: 20px;">This email serves as confirmation that your account and
                associated data have been permanently removed from our systems.</p>
        </div>

        <!-- Deletion Confirmation -->
        <div
            style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 25px; text-align: center; border-radius: 8px; margin: 25px 0;">
            <p style="margin: 0 0 10px 0; font-size: 14px; opacity: 0.9;">Account Status</p>
            <div
                style="font-size: 32px; font-weight: bold; letter-spacing: 2px; font-family: 'Courier New', monospace;">
                🗑️ DELETED
            </div>
        </div>

        <!-- What Was Deleted -->
        <div
            style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid #007bff; margin: 25px 0;">
            <h3 style="color: #007bff; margin: 0 0 15px 0; font-size: 18px;">What Was Deleted:</h3>
            <ul style="margin: 0; padding-left: 20px;">
                <li style="margin-bottom: 8px;">Your personal profile information</li>
                <li style="margin-bottom: 8px;">Account settings and preferences</li>
                <li style="margin-bottom: 8px;">Login credentials and security data</li>
                <li style="margin-bottom: 0;">All associated account data</li>
            </ul>
        </div>

        <!-- Important Notice -->
        <div
            style="background-color: #fff3cd; padding: 20px; border-radius: 6px; border-left: 4px solid #ffc107; margin: 25px 0;">
            <h3 style="color: #856404; margin: 0 0 15px 0; font-size: 18px;">⚠️ Important Notice</h3>
            <p style="margin: 0 0 10px 0; font-size: 16px; color: #856404;">
                <strong>This action is permanent and cannot be undone.</strong>
            </p>
            <p style="margin: 0; font-size: 16px; color: #856404;">
                If you wish to use {{ config('app.name') }} again in the future, you'll need to create a new account.
            </p>
        </div>

        <!-- Feedback -->
        <div
            style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid #007bff; margin: 25px 0;">
            <h3 style="color: #007bff; margin: 0 0 15px 0; font-size: 18px;">We Value Your Feedback</h3>
            <p style="margin: 0; font-size: 16px;">
                If you have any feedback about your experience with {{ config('app.name') }}, we'd love to hear from
                you.
                Your input helps us improve our service for future users.
            </p>
        </div>

        <!-- Support -->
        <p style="font-size: 16px; margin: 25px 0 15px 0;">Thank you for being part of the {{ config('app.name') }}
            community. We hope to see you again in the future!</p>

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
