<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>
        @yield('title')
    </title>

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="title" content="@yield('title')">

@yield('head')

@include('assets')

<body>

@include('parts/flash')

@yield('content')

</body>
</html>