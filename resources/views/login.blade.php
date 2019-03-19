<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link rel="shortcut icon" href="{{asset('favicon.svg')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Биотест Авторизация</title>
</head>

<body>
    <div id="login">
        <login></login>
    </div>
    <!--Scripts!-->
    <script type="text/javascript" src="{{ asset('js/login.js') }}"></script>
    <!--Css!-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</body>

</html>