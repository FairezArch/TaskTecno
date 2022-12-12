<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    @vite(['resources/js/app.js'])
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: rgb(226 226 226 / 21%);
        }
    </style>
</head>

<body class="antialiased">
    @include('pages.component.navbar')
    <main>
        <div class="container my-3">
            @yield('content')
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            // $.each($('.navbar-nav').find('li'), function() {
            //     $(this).toggleClass('active',
            //         window.location.pathname.indexOf($(this).find('a').attr('href')) > -1);
            // });

            // $('.navbar-nav').on('click', 'a', function() {
            //     $('.navbar-nav a.active').removeClass('active')
            //     $(this).addClass('active');
            // })
        });
    </script>
    @yield('script')
</body>

</html>
