<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                padding-bottom: 40px;
                margin: 0;
            }

            .content {
                text-align: center;
            }
        </style>

        <link href="/css/app.css" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            @include('_navbar')

            @yield('content')

            <flash message="{{ session('flash.message') }}" type="{{ session('flash.type') }}"></flash>
        </div>
    </body>
    <script src="/js/app.js"></script>
    <script src="/js/mousetrap.min.js"></script>
</html>
