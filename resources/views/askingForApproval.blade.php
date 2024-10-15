<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asking For Approval</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        a {
            padding: 10px 20px;
            background-color: red;
            color: white;
            font-weight: bold;
            font-size: 20px;
            text-decoration: none;
        }
    </style>
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
                    <h1>Accept your Application</h1>
                </div>
            </div>
        </div>
        <div class="part-2">
            <p>Thank you for your application for the job position. Please let us know your interest</p>
            <br>
            {{ $applicationId }}<br>
            {{ $companyId }}
            <p class="content">
                <a href="http://127.0.0.1:8000/api/respond?application_id={{ $applicationId }}&organization_id={{ $companyId }}&response=interested" style="background: blue;">Interested</a>
                <a href="http://127.0.0.1:8000/api/respond?application_id={{ $applicationId }}&organization_id={{ $companyId }}&response=not_interested">Not Interested</a>
            </p>
            <p>Take care!</p>
            <h4>Regards:</h4>
            <h2>Security Plus<h2>
        </div>
    </div>




</body>

</html>