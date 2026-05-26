<!DOCTYPE html>
<html>
<head><title>Verify Email</title></head>
<body>
    <h2>Please Verify Your Email</h2>
    <p>We sent a link to your email. Click it to activate your account.</p>

    @if (session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Resend Verification Email</button>
    </form>
</body>
</html>
