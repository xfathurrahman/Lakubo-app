@extends('home.base')

@section('body')
    <body id="main-app">

        <nav class="bg-white shadow py-2.5 fixed w-full z-20 top-0 left-0 border-b border-gray-200">
            @include('home.components.navbar')
        </nav>

        <div class="container mx-auto mt-20 xl:px-32">
            @yield('content')
        </div>

        <footer class="bg-white w-full">
            @include('home.components.footer')
        </footer>

        <script type="text/javascript" src="{{ asset('js/flowbite.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/slick.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/easyzoom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/select2-searchInputPlaceholder.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
        <script>
            /*LOAD CART COUNT*/

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            @if(Auth::check())
                loadCart();
            @endif

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
            /*LOAD CART COUNT END*/
        </script>
        @yield('script')
    </body>

@endsection
