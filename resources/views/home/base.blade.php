<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lakubo - Lapak UMKM Boyolali">
    <meta name="keywords" content="umkm boyolali, web app">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="author" content="Fathurrahman">
    @yield('head')
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
    @yield('body')
</html>
