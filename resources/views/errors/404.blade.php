<!DOCTYPE html>
<html>

<head>
    <title>404 Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        h1 {
            font-size: 100px;
            color: #dc3545;
            margin: 0;
        }

        p {
            font-size: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>
    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 80px; margin-bottom: 20px;">
    </a>
    <h1>404</h1>
    <p>Sorry, the page you are looking for was not found.</p>
    @php
    $redirect_value = getDashboardLinkByRole();
    @endphp
    <a href="{{$redirect_value}}">Go back to Home</a>
</body>

</html>
