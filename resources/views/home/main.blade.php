@extends('home.base')

@section('body')
    <body id="main-app" class="font-sans flex flex-col min-h-screen">

    <div id="loading-background">
        <img class="absolute w-52 h-24 lg:w-80 lg:h-40 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" src="{{ asset('assets/images/loading-lakubo-cow.gif') }}"></img>
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
        <script src="{{ asset('js/easyzoom.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script src="{{ asset('js/select2-custom.js') }}"></script>
        <script src="{{ asset('js/loading-page.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.8/lottie.min.js"></script>


    <script>

        /*$(document).ready(function() {
            // Tampilkan modal saat tombol dibuka diklik
            $("#open-modal-btn").click(function() {
                $("#modal-background").show();
                $("#modal").show();
            });

            // Sembunyikan modal saat tombol tutup atau latar belakang diklik
            $("#modal-close-btn, #modal-background").click(function() {
                $("#modal-background").hide();
                $("#modal").hide();
            });
        });*/


        $(document).ready(function() {
            $(".dropdown-menu").hide();

            $(".dropdown-toggle").on("click", function() {
                $(".dropdown-menu").toggle();
            });

            $(".dropdown-item").on("click", function() {
                const selectedOption = $(this).text();
                const category = $(this).data('category');
                $(".dropdown-text").text(selectedOption);
                $(".dropdown-menu").hide();
                $("#search").data('category', category);
            });

            $("#search-btn").on("click", function() {
                let query = $("#search").val();
                let category = $("#search").data('category');

                if(!query) {
                    $("#search").attr('required', true);
                    $("#search").focus();
                    return false;
                }

                $.ajax({
                    url: "{{ route('product.search') }}",
                    type: 'GET',
                    data: {query: query, category: category},
                    success: function(response) {
                        if (response.length > 0) {
                            window.location.href = "{{ route('product.search.result') }}?query="+query+"&category="+category;
                        } else {
                            window.location.href = "{{ route('product.search.result') }}?query="+query+"&category="+category+"&error=1";
                        }
                    },
                    error: function(xhr) {
                        /*console.log(xhr.responseText);*/
                    }
                });
            });

            $(document).on("click", function(event) {
                if (!$(event.target).closest(".dropdown").length) {
                    $(".dropdown-menu").hide();
                }
            });
        });
    </script>


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
