<!DOCTYPE html>
<html lang="uz">

<head>
    @include('parts.head')
    @yield('style')
</head>

<body>
    @yield('main')
    @yield('script')
    @vite(['resources/js/app.js'])
</body>

</html>
