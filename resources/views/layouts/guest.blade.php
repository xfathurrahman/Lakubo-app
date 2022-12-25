<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/midone-app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/midone-_app.css') }}">
</head>
<body class="login" id="auth">
{{ $slot }}
<!-- BEGIN: JS Assets-->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.6.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
<!-- END: JS Assets-->
@yield('script')
</body>
</html>
