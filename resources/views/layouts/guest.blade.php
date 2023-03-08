<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('style')
    </head>
    <body class="login sm:!overflow-hidden" id="auth">
        {{ $slot }}
        <script src="{{ asset('js/midone_app.js') }}"></script>
        <script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
        <script src="{{ asset('js/parsley.min.js') }}"></script>
        <script src="{{ asset('js/toggle-password.js') }}"></script>
        @yield('script')
    </body>
</html>
