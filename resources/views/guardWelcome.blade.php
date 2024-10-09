<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <title>Welcome Guard</title>
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
                    <h1>Welcome to Our Application</h1>
                </div>
            </div>
        </div>
        <div class="part-2">
            <h2>Dear {{ $first }} <span>{{ $last }}</span></h2>
            <p class="content">
            Welcome to the <strong>{{$Company}}</strong> team! We are excited to have you on board as part of our security team. 
            Your skills and experience will be a valuable 
            addition to our mission to provide a safe and secure environment for our clients.
            </p>
            <p class="content">
                Below are your login credentials to access the company's portal:
                <br>Your Username : <span class="password">{{ $email }}</span>
                <br>Your password : <span class="password">{{ $password }}</span>
                <br>Application link : <span class="password">N/A</span>
                <br>Log in with this Temporary password, you can change it after login into the mobile application.
            </p>
            <p>Take care!</p>
            <h4>Regards:</h4>
            <h2>Security Plus<h2>
        </div>
    </div>
</body>

</html>