@extends('home.base')

@section('body')
    <body id="main-app" class="font-sans flex flex-col min-h-screen">
        <div id="loading-page" class="flex items-center justify-center h-screen">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-12 w-12 text-indigo-600" viewBox="0 0 24 24"></svg>
                <p class="text-gray-700 mt-2 font-semibold text-lg">Memuat...</p>
            </div>
        </div>

        <nav class="px-4 py-2 shadow bg-white fixed w-full z-20 top-0 left-0 border-b border-gray-200">
            @include('home.components.navbar')
        </nav>

        <main class="container mx-auto xl:px-32 mt-20 flex-auto">
            @yield('content')
        </main>

        <footer>
            @include('home.components.footer')
        </footer>

        <script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.js') }}"></script>
        <script src="{{ asset('js/slick.min.js') }}"></script>
        <script src="{{ asset('js/parsley.min.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script src="{{ asset('js/select2-custom.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>

        <script>
            $(window).on('load', function() {
                $('#loading-page').fadeOut(500);
            });
        </script>

        <script>
            @if(Auth::check())
            loadCart();
                function loadCart(){
                    $.ajax({
                        method: "GET",
                        url: "{{route('customer.cartCount')}}",
                        success: function (response) {
                            $('.cart-count').html('');
                            $('.cart-count').html(response.count);
                        }
                    });
                }
            @endif
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @yield('script')
        @yield('script-navbar')

    </body>

@endsection
