<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>
        @yield('title')
    </title>

@yield('head')

@include('assets')

<body>
@yield('content')
</body>
</html>