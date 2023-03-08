<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="bg-color">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    </head>
    <body class="py-5">
        @include('components.mobile-menu')
        @include('layouts.side-menu')
        <script src="{{ asset('js/midone_app.js') }}"></script>
        <script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
        <script src="{{ asset('js/toastify.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.js') }}"></script>
        <script src="{{ asset('js/parsley.min.js') }}"></script>
        <script src="{{ asset('js/image-uploader.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script src="{{ asset('js/select2-custom.js') }}"></script>
        @yield('script')
        @yield('script-navbar')
    </body>
</html>
