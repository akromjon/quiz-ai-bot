<!DOCTYPE html>
<html lang="uz">
    <head>
        @include('parts.head')
    </head>
    <body>
        <div class="container">
            @include('parts.header')
            <main>
                @yield('main')
            </main>
        </div>
        @include('parts.script')
    </body>
</html>
