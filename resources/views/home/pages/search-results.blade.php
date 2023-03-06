@extends('home.main')

@section('head')
    <title>Lakubo - Lapak UMKM Boyolali</title>
@endsection

@section('content')
    <div class="carousel-product my-4 rounded-lg">
        <div class="mb-2 text-left">
            @if(isset($category))
                <h4 class="mx-4 mb-3 font-semibold">Menampilkan hasil pencarian untuk '{{ $searchTerm }}' dengan kategori '{{ $category->name }}'</h4>
            @elseif(isset($searchTerm) || $category === "undefined")
                <h4 class="mx-4 mb-3 font-semibold">Menampilkan hasil pencarian untuk '{{ $searchTerm }}' dari Semua Kategori.</h4>
            @endif
            <hr>
        </div>

        @if($error)
            <p>Produk tidak ditemukan.</p>
        @endif

        <div class="owl-carousel sc-products-carousel owl-theme">
            @foreach($products as $product)
                <div class="item ml-2">
                    <div class="card shadow-xl bg-gray-200">
                        <div class="date-option bg-red-400 text-center">
                            <span class="date-post">
                                <p class="mb-5">{{ $product -> created_at -> diffForHumans() }}</p>
                            </span>
                        </div>
                        @php
                            $isAuthenticated = auth()->check();
                            $isSeller = $isAuthenticated && auth()->user()->hasRole('seller');
                            $isProductStoreSameAsUserStore = $isSeller && $product->stores->id === auth()->user()->stores->id;
                            $canEditProduct = $isProductStoreSameAsUserStore;
                        @endphp
                        @if ($product->quantity > 0)
                            @if ($canEditProduct)
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="add-to-cart product_data">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            @else
                                @include('home.pages.partials.add-to-cart-btn', ['product' => $product])
                            @endif
                        @endif
                        <a class="a-link" href="{{ route('getProduct', $product -> id) }}">
                            <img class="image-product" src="{{ asset("storage/product-image")."/".$product -> productImage -> image_path }}" alt="Image from {{ $product->stores->name }}">
                            <div class="card-body bg-red-100">
                                <div class="relative overflow-hidden py-0.5 rounded-br-lg bg-red-400 shadow-lg">
                                    <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                                        <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
                                        <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
                                    </svg>
                                    <div class="relative px-2 text-white">
                                        <span class="block font-semibold text-xs overflow-ellipsis">@currency($product->price)</span>
                                    </div>
                                </div>
                                <div class="px-2 product-name text-left">{{ $product -> name }}</div>
                                <div class="px-2 owner-info">
                                    <div class="owner-pp">
                                        @isset($product->stores->users->profile_photo_path)
                                            <img class="rounded-full" src="{{ asset('storage/profile-photos/'. $product->stores->users->profile_photo_path) }}" alt="pp-owner"/>
                                        @else
                                            <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $product -> stores -> name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                                        @endisset
                                    </div>
                                    <div class="owner-name whitespace-nowrap font-bold"
                                         data-hover-before="{{  $product -> stores -> name }}"
                                         data-hover-after="{{  $product -> stores -> users -> name }}">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-end mt-2 -mb-3 -mr-2.5">
            <a href="#" class="text-white text-sm btn bg-red-400 rounded-tl-lg rounded-br-lg px-2 text-decoration-none">Lihat Semua</a>
        </div>
    </div>

    <!-- BEGIN: Reject Notification Content -->
    <div id="added-to-cart-notif" class="toastify-content hidden flex items-center">
        <i class="fa-solid fa-cart-plus text-xl text-green-500"></i>
        <div class="ml-4 mr-4">
            <div class="text-green-500 font-medium">Pesanan Berhasil ditambah ke Keranjang.</div>
            <div class="text-green-500 mt-1">Klik ikon keranjang pada Toolbar untuk melihat.</div>
        </div>
    </div>
    <!-- END: Reject Notification Content -->

    <!-- BEGIN: Already Notification Content -->
    <div id="already-add-notif" class="toastify-content hidden flex items-center">
        <i class="fa-solid fa-cart-arrow-down text-xl text-red-400"></i>
        <div class="ml-4 mr-4">
            <div class="text-red-500 font-medium">Pesanan sudah ada di Keranjang.</div>
            <div class="text-red-500 mt-1">Klik ikon keranjang pada Toolbar untuk melihat.</div>
        </div>
    </div>
    <!-- END: Already Notification Content -->

@endsection

@section('script')
    <script>
        /*##########################################################
                             *CAROUSEL PRODUCT*
        ##########################################################*/
        $(document).ready(function () {
            $('.sc-products-carousel').owlCarousel({
                loop: false,
                center: false,
                margin: 3,
                lazyLoad: true,
                autoWidth: true,
                nav: true,
                item: 7,
                slideBy: 7,
                navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                dots: false,
                responsive: {
                    0:{
                        items:1,
                        slideBy: 1,
                        margin: 5,
                    },
                    320: {
                        items: 2,
                        slideBy: 2,
                        margin: 5,
                    },
                    600: {
                        items: 4,
                        slideBy: 4
                    },
                    1000: {
                        items: 5,
                        slideBy: 5
                    }
                }
            })
        });
        /*##########################################################
                          *CAROUSEL PRODUCT END*
        ##########################################################*/
        /*##########################################################
                       *TAMBAH PRODUCT KE KERANJANG*
        ##########################################################*/

        @if(Auth::check())
        $(document).on('click','.addToCartBtn', function (e) {
            e.preventDefault();
            var product_id = $(this).closest('.product_data').find('.prod_id').val();
            var store_id = $(this).closest('.product_data').find('.store_id').val();
            $.ajax({
                method: "POST",
                url: "{{route('customer.addToCart')}}",
                data: {
                    'product_id': product_id,
                    'store_id': store_id,
                },
                success: function (response) {
                    // window.location.reload();
                    loadCart();
                    $('#refreshcart').load(location.href + " #refreshcart");
                    if (response.success) {
                        Toastify({
                            node: $("#added-to-cart-notif").clone().removeClass("hidden")[0],
                            duration: 2000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            closeOthers: true,
                            offset: {
                                y: 40 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();
                    } else{
                        Toastify({
                            node: $("#already-add-notif").clone().removeClass("hidden")[0],
                            duration: 2000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            closeOthers: true,
                            offset: {
                                y: 40 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();
                    }
                }
            });
        });
        @else
        $(document).on('click','.addToCartBtn', function (e) {
            Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Silahkan Masuk terlebih dahulu untuk mulai belanja.',
                showConfirmButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<a href="{{route('login')}}">Masuk</a>'
            });
        });
        @endif

        /*##########################################################
                     *TAMBAH PRODUCT KE KERANJANG END*
        ##########################################################*/
    </script>
@endsection
