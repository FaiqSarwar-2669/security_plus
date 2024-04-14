<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/welcomeMail.css') }}">
    <title>welcome</title>
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
            <h2>Hi {{ $name }},</h2>
            <p class="content">Welcome to Security plus. We’re happy to see you among our users.
                Security plus mission is to provide secure system to manage your security organizations, so we are sure that, with our Application services, you can get lot features.
                Learn more about us in our video-guide, where you’ll find detailed information about our Application services, learn more about its features, and get tips on how to use it for your business growth.</p>
            <p>Take care!</p>
            <h4>Regards:</h4>
            <h2>Security Plus<h2>
        </div>
    </div>
</body>

</html>