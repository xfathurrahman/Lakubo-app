<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite([])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="login" id="auth">
{{ $slot }}
<!-- BEGIN: JS Assets-->
<script src="{{ asset('js/midone_app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.6.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2-searchInputPlaceholder.js') }}"></script>
<!-- END: JS Assets-->
@yield('script')
</body>
</html>
