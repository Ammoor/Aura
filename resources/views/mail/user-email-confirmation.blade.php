@component('mail::message')
    # Dear, {{ $userData['first_name'] }}

    Thanks for joining __Aura__ – where your experience is our priority.

    Thank you for signing up. To complete your registration, please verify your email address by entering the verification
    code below:

    @component('mail::panel')
        **{{ $verificationCode }}**
    @endcomponent

    This code is valid for a **{{ $verificationCodeExpireAfter }} minutes**. Please do not share it with anyone.

    Cheers!
    The Aura Team
@endcomponent
