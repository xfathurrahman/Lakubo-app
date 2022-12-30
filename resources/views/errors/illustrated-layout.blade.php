<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="py-5">
<div class="container">
    <!-- BEGIN: Error Page -->
    <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
        <div class="-intro-x lg:mr-20">
            @yield('image')
        </div>
        <div class="text-white mt-10 lg:mt-0">
            <div class="intro-x text-8xl font-medium">@yield('code')</div>
            @yield('message')
        </div>
    </div>
    <!-- END: Error Page -->
</div>

<script type="text/javascript" src="{{ asset('js/midone_app.js') }}"></script>
@yield('script')

</body>
</html>
