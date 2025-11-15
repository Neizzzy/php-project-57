<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('Task Manager') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <div class="min-h-[36px] mt-1">
                @include('flash::message')
            </div>

            <main>
                @yield('content')
            </main>
        </div>
    </body>
    <script>
        setTimeout(() => {
            document.querySelectorAll('div.alert:not(.alert-important)').forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 350);
            });
        }, 3000);
    </script>
</html>
