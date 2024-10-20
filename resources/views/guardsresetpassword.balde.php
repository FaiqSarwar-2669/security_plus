<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/resetPasswordMail.css') }}">
    <title>Password Reset</title>
</head>

<body>
    <div class="main-content">
        <div class="body-main">
            <div class="part-1">
                <div class="image">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="image">
                </div>
                <div class="content">
                    <h1>Security Plus</h1>
                    <h3>To</h3>
                    <h1>Reset Password</h1>
                </div>
            </div>
        </div>
        <div class="part-2">
            <h2>Hi {{ $Name }}</h2>
            <p class="content">We’re happy to see you among our users. We received a request to reset the password for your account.
                <br>Your new password is: <span class="password">{{ $Password }}</span>
                <br>Log in with this password, then change your password as desired.
            </p>
            <p>Take care!</p>
            <h4>Regards:</h4>
            <h2>Security Plus<h2>
        </div>
    </div>
</body>

</html>