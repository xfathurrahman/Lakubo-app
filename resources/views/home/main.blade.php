@extends('home.base')

@section('body')
    <body id="main-app" class="font-sans leading-normal tracking-normal">

    <nav class="px-4 py-2 shadow bg-white fixed w-full z-20 top-0 left-0 border-b border-gray-200">
            @include('home.components.navbar')
        </nav>

        <div class="container mx-auto mt-20 xl:px-32">
            @yield('content')
        </div>

        <footer class="bg-white w-full">
            @include('home.components.footer')
        </footer>

        <script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.js') }}"></script>
        <script src="{{ asset('js/slick.min.js') }}"></script>
        <script src="{{ asset('js/parsley.min.js') }}"></script>
        <script src="{{ asset('js/easyzoom.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script src="{{ asset('js/select2-searchInputPlaceholder.js') }}"></script>
        <script src="{{ asset('js/loading-page.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.8/lottie.min.js"></script>

    <script>
        @if(Auth::check())
            loadCart();
        @endif

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        $(document).ready(function() {
            // saat tombol toggle-profile diklik
            $("#dropdown-button").click(function() {
                // toggle kelas 'hidden' pada toggle-menu-profile
                $("#dropdown").toggleClass("hidden");
            });

            // saat pengguna mengklik di luar menu toggle-menu-profile
            $(document).click(function(event) {
                // jika yang diklik bukan di dalam toggle-profile atau toggle-menu-profile
                if(!$(event.target).closest("#dropdown-button").length && !$(event.target).closest("#dropdown").length) {
                    // tambahkan kelas 'hidden' pada toggle-menu-profile
                    $("#dropdown").addClass("hidden");
                }
            });

            // saat tombol toggle-profile diklik
            $("#toggle-profile button").click(function() {
                $("#toggle-menu-profile").toggleClass("hidden");
                $("#toggle-btn").toggleClass("bg-gray-200");
            });
            // saat pengguna mengklik di luar menu toggle-menu-profile
            $(document).click(function(event) {
                if(!$(event.target).closest("#toggle-profile").length && !$(event.target).closest("#toggle-menu-profile").length) {
                    $("#toggle-menu-profile").addClass("hidden");
                    $("#toggle-btn").removeClass("bg-gray-200")
                }
            });

            // Mengambil elemen tombol dan elemen pencarian
            const button = document.querySelector('[data-search]');
            const search = document.querySelector('[data-search-form]');

            // Menambahkan event listener pada tombol
            button.addEventListener('click', () => {
                // Toggle class 'hidden' pada elemen pencarian
                search.classList.toggle('hidden');
                search.classList.toggle('ml-4');
            });

        });

    </script>
        @yield('script')
    </body>

@endsection
