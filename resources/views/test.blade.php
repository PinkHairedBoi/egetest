<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link rel="shortcut icon" href="{{asset('favicon.svg')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>БиоТест</title>
    <style>
        .topNav {
            border-bottom: 1px solid #e6eaee;
        }
    </style>
</head>

<body>
    <div id="test" class="container">
        <test></test>
    </div>

    <!--Scripts!-->
    <script type="text/javascript" src="{{ asset('js/test.js') }}"></script>

    <!--Css!-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</body>

</html>