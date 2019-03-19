<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset('adminfavicon.png')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>БиоАдмин</title>
    <style>
        .topNav {
            border-bottom: 1px solid #e6eaee;
        }
    </style>
</head>

<body>
    <div id="admin" class="container">
    @include('layouts.admin.header')
        <router-view></router-view>
    </div>
    <!--Scripts!-->
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <!--Css!-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</body>

</html>