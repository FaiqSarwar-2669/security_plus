<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/welcomeMail.css') }}">
    <title>Reminder Registeration</title>
</head>

<body>
    <div class="main-content">
        <div class="body-main">
            <div class="part-1">
                <div class="image">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="image">
                </div>
                <div class="content">
                    <h1>Welcome</h1>
                    <h3>To</h3>
                    <h1>Security Plus</h1>
                </div>
            </div>
        </div>
        <div class="part-2">
            <h2>Hello {{$Company}}</h2>
            <p class="content">Thank you for choosing Security Plus, where your security is our priority!<br><br>

                Your application for registration of {{$Company}} has been successfully submitted. However, we noticed that you haven't provided all the necessary information about your {{$Company}}.<br><br>

                {{$data}}<br><br>

                Here at Security Plus, we are committed to providing you with a secure and reliable service. You can trust us to keep your data safe and secure.

                Thank you for trusting us with your security needs. We look forward to serving you.
            </p><br><br>
            <p>Take care!</p>
            <h4>Best regards,</h4>
            <h2>The Security Plus Team<h2>
        </div>
    </div>
</body>

</html>