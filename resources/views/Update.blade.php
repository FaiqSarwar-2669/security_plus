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
                </div>
            </div>
        </div>
        <div class="part-2">
            <h2>Hi Dear</h2>
            <p class="content">
                {{$content}}
            </p>
            <p>Take care!</p>
            <h4>Regards:</h4>
            <h2>Security Plus<h2>
        </div>
    </div>
</body>

</html>