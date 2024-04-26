<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/welcomeMail.css') }}">
    <title>verification</title>
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
            <h2>Hello {{$fname}} {{$lname}}</h2>
            <p class="content">We are very exited to inform you that your {{$Company}}'s registration on Security Plus has been successfully approved!<br><br>

                You can now fully utilize the capabilities of our platform. Security Plus provides a wide range of features to help you manage your business efficiently and securely. Some points that you keep in your mind:

            <ol>
                <li>Please take a moment to familiarize yourself with our system if you haven't already.</li>
                <li>Kindly adhere to the roles and policies of our system.</li>
                <li>You will receive email notifications about any updates or changes to the system.</li>
                <li>In case of any misconduct, harassment, or reports against your {{$Company}}, the administrator reserves the right to suspend or ban your {{$Company}} from our platform.</li>
            </ol>

            We understand the importance of security and privacy for your business. So, your data is protected with security measures.<br><br>

            Thank you {{$fname}} {{$lname}} for choosing Security Plus. We are committed to providing you with the best tools and services to help your {{$Company}} grow and succeed.</p>
            <p>Take care!</p>
            <h4>Best regards,</h4>
            <h2>The Security Plus Team<h2>
        </div>
    </div>
</body>

</html>