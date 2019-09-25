<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{mix('css/app.css')}}"/>
    </head>
    <body>
        @include('layouts._header')
        @yield('content')
        @include('layouts._footer')
    </body>
</html>