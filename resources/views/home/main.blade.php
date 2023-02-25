@extends('home.base')

@section('body')
    <body id="main-app">

    {{--<nav class="px-4 py-2 shadow bg-white fixed w-full z-20 top-0 left-0 border-b border-gray-200">
        <div class="sm:container xl:px-32 mx-auto">
            <div class="flex justify-between">
                <div class="flex items-center">

                    <a href="{{ route('home') }}" class="flex items-center mx-3">
                        <img src="{{ asset('assets/images/app/cowlogo.svg') }}" class="h-6 sm:h-9">
                        <span class="self-center text-xl font-semibold whitespace-nowrap">Lakubo</span>
                    </a>

                    <button data-search class="p-4 md:hidden focus:outline-none" type="button">
                        <svg data-search-icon class="fill-current w-4" viewBox="0 0 512 512" style="top: 0.7rem; left: 1rem;">
                            <path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z" />
                            <path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z" /></svg>
                    </button>

                    <div data-search-form class="relative mr-3 hidden md:inline-block">
                        <div class="text-gray-500">
                            <svg data-search-icon class="absolute fill-current w-4" viewBox="0 0 512 512" style="top: 0.7rem; left: 1rem;">
                                <path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z" />
                                <path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z" /></svg>
                        </div>
                        <input type="text" placeholder="Search" name="search" id="search" class="h-auto pl-10 py-2 bg-gray-200 text-sm border border-gray-500 rounded-full focus:outline-none focus:bg-white">
                    </div>

                </div>

                <div class="flex items-center">
                    <a href="{{ route('customer.cart.index') }}" class="relative flex">
                        <button class="p-3 mr-3 focus:outline-none hover:bg-gray-200 hover:rounded-md">
                            <svg class="flex-1 w-5 h-5 fill-current" viewbox="0 0 24 24">
                                <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
                            </svg>
                            <span class="absolute left-6 top-1 rounded-full bg-red-600 w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center cart-count">0</span>
                        </button>
                    </a>

                    <div id="toggle-profile" class="relative">
                        <button class="flex items-center px-3 py-2 focus:outline-none hover:bg-gray-200 hover:rounded-md" type="button">
                            @if(auth()->user()->profile_photo_path)
                                <img class="h-8 w-8 rounded-full" alt="Profile-photo-preview" src="{{ asset('storage/profile-photos/'. auth()->user()->profile_photo_path) }}">
                            @else
                                <img class="h-8 w-8 rounded-full" alt="Profile-photo-preview" src="https://ui-avatars.com/api/?size=100&name={{ Auth::user()->name }}">
                            @endif
                            <span class="ml-4 text-sm hidden md:inline-block max-w-full w-24 truncate">{{ auth()->user()->name }}</span>
                            <svg class="fill-current w-3 ml-4" viewBox="0 0 407.437 407.437"><path d="M386.258 91.567l-182.54 181.945L21.179 91.567 0 112.815 203.718 315.87l203.719-203.055z" /></svg>
                        </button>
                        <div id="toggle-menu-profile" class="absolute hidden right-0 top-full mt-2 w-48 shadow-lg z-10">
                            <ul class="rounded-md dropdown-content bg-red-400 text-white">
                                <li class="px-2 flex items-center">
                                    <div class="p-2">
                                        <div class="font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-white text-opacity-70 mt-0.5">{{ auth()->user()->email }}</div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="border-white opacity-50 mb-2">
                                </li>
                                <li class="px-2 flex items-center">
                                    <a href="{{ route('seller.dashboard') }}" class="rounded-md px-2 py-1 w-full hover:bg-white hover:bg-opacity-20">
                                        <i class="fa-solid fa-store mr-2"></i>
                                        Lapak Saya
                                    </a>
                                <li>
                                <li class="px-2 flex items-center">
                                    <a href="{{ route('profile.edit') }}" class="rounded-md px-2 py-1 w-full hover:bg-white hover:bg-opacity-20">
                                        <i class="fa-solid fa-id-badge mr-2.5 ml-1"></i>
                                        Akun Saya
                                    </a>
                                <li>
                                    <hr class="border-white opacity-50 my-2">
                                </li>
                                <li class="px-2 flex items-center pb-2">
                                    <form method="POST" action="{{ route('logout') }}" class="w-full rounded-md px-2 py-1 hover:bg-white hover:bg-opacity-20">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="w-full">
                                            <i class="fa-solid fa-toggle-off mr-2"></i>
                                            Keluar
                                        </a>
                                    </form>
                                <li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>--}}
    <nav class="bg-white shadow py-2.5 fixed w-full z-20 top-0 left-0 border-b border-gray-200">
        @include('home.components.navbar')
    </nav>


    <div class="container mx-auto mt-16 xl:mt-20 xl:px-32">
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
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            /*LOAD CART COUNT*/

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
            });

            $(document).ready(function() {
                // saat tombol toggle-profile diklik
                $("#toggle-profile button").click(function() {
                    // toggle kelas 'hidden' pada toggle-menu-profile
                    $("#toggle-menu-profile").toggleClass("hidden");
                });

                // saat pengguna mengklik di luar menu toggle-menu-profile
                $(document).click(function(event) {
                    // jika yang diklik bukan di dalam toggle-profile atau toggle-menu-profile
                    if(!$(event.target).closest("#toggle-profile").length && !$(event.target).closest("#toggle-menu-profile").length) {
                        // tambahkan kelas 'hidden' pada toggle-menu-profile
                        $("#toggle-menu-profile").addClass("hidden");
                    }
                });
            });

            $(document).ready(function() {
                // saat tombol filter diklik, tampilkan atau sembunyikan opsi filter
                $('#toggle-filter-search').click(function() {
                    $('#toggle-menu-filter').toggle();
                });

                // saat tombol cari diklik, cari sesuatu di input pencarian
                $('button.absolute.left-2.top-1/2.transform.-translate-y-1/2').click(function() {
                    var query = $('input[type="text"]').val();
                    // lakukan pencarian dengan menggunakan query yang diinputkan
                    // misalnya, redirect ke halaman pencarian atau lakukan AJAX request untuk menampilkan hasil pencarian di halaman saat ini
                });
            });

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
