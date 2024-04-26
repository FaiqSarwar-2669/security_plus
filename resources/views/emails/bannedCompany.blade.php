<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/welcomeMail.css') }}">
    <title>Banned Company</title>
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
            <h2>Hello {{$fname}} {{$lname}},</h2>
            <p class="content">We feel sad to inform you that your {{$Company}}'s access to Security Plus has been suspended due to a violation of our rules and regulations.<br><br>

                We take the safety and security of our platform and community very seriously. Unfortunately, we have found evidence of behavior that violates our community guidelines, including harassment or other forms of misconduct.<br><br>

                As a result, we have temporarily banned your {{$Company}}'s access to our platform.<br><br>

                If you believe this action was taken in error or would like to appeal this decision, please contact our support team at support@securityplus.com.

                Thank you for your understanding.</p>
            <p>Take care!</p>
            <h4>Best regards,</h4>
            <h2>The Security Plus Team<h2>
        </div>
    </div>
</body>

</html>