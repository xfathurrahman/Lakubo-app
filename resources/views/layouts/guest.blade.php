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
<body class="login px-0" id="auth">
{{ $slot }}
<!-- BEGIN: JS Assets-->
<script src="{{ asset('js/midone_app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.6.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2-searchInputPlaceholder.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>
<!-- END: JS Assets-->
<script>
    // Toggle Pass
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        if (type === 'password') {
            togglePassword.innerHTML = `<i class="fa-regular fa-eye-slash h-6 w-6"></i>`;
        } else {
            togglePassword.innerHTML = `<i class="fa-regular fa-eye h-6 w-6"></i>`;
        }
    });
</script>
@yield('script')
</body>
</html>
