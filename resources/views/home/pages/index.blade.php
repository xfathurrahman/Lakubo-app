@extends('home.main')

@section('head')
    <title>Lakubo - Lapak UMKM Boyolali (Test)</title>
@endsection

@section('content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="pb-3 bg-gray-100 rounded-lg carousel-category sm:border">
        <div class="p-4 font-semibold text-center border-b">
            @if (auth()->check() && auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.categories.products') }}">
                    <span id="arrowNav" class="flex items-center justify-center">Kategori <i class="mt-1 ml-2 text-xl text-red-400 fa-solid fa-square-pen"></i> </span>
                </a>
            @else
                <span id="arrowNav" class="flex items-center justify-center">Kategori</span>
            @endif
        </div>
        <div class="px-4 slick-wrapper">
            <div id="sc-category-carousel" class="overflow-hidden" style="max-height: 450px;" data-slick='{"lazyLoad": "ondemand"}'>
                @foreach($categories as $category)
                    <a href="{{ route('category.detail', $category->id) }}" class="relative flex-shrink-0 max-w-xs my-2 overflow-hidden rounded-lg shadow-lg content-box">
                        <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                            <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
                            <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
                        </svg>
                        <div class="relative flex items-center justify-center slider">
                            {{--<div class="absolute bottom-0 left-0 block w-20 h-20 ml-3 -mb-24" style="background: radial-gradient(black, transparent 60%); transform: rotate3d(0, 0, 1, 20deg) scale3d(1, 0.6, 1); opacity: 0.2;"></div>--}}
                            @isset($category->image_path)
                                <img class="max-w-full image-product lazy" data-lazy="{{ asset("storage/product-categories")."/".$category->image_path }}" alt="category-img" width="200" height="150">
                            @else
                                <img class="max-w-full image-product lazy" data-lazy="https://ui-avatars.com/api/?name={{ $category->name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="category-img" width="200" height="150">
                            @endisset
                        </div>
                        <div class="flex items-center justify-center h-6 p-1 md:p-3 md:h-10">
                            <span class="font-semibold text-center text-white capitalize text-2xs leading-2 md:text-xxs md:leading-3 lg:text-xs md:uppercase line-clamp-2">{{ $category -> name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    @if (count($products) > 0)
        <div class="py-4 carousel-product">
            <div class="inline-flex mb-2">
                <h4 class="mx-4 mb-4 font-semibold">Produk Terbaru</h4>
                <a href="{{ route('product.detail.new') }}" class="flex items-center h-6 px-2 text-sm text-white bg-red-400 rounded-lg text-decoration-none">Lihat Semua</a>
                <hr>
            </div>
            <div class="mb-8 owl-carousel sc-products-carousel owl-theme">
                @foreach($products as $product)
                    @php
                        $isAuthenticated = auth()->check();
                        $isSeller = $isAuthenticated && auth()->user()->hasRole('seller');
                        $isAdmin = $isAuthenticated && auth()->user()->hasRole('admin');
                        $isProductStoreSameAsUserStore = $isSeller && $product->stores->id === auth()->user()->stores->id;
                        $canEditProduct = $isProductStoreSameAsUserStore && !$isAdmin;
                    @endphp
                        <div class="ml-2 item">
                            <div class="bg-gray-200 shadow-xl card">
                                <div class="text-center bg-red-400 date-option">
                                    <span class="date-post">
                                        <p class="mb-5">{{ $product->created_at->diffForHumans() }}</p>
                                    </span>
                                </div>
                                @unless ($isAdmin)
                                    @if ($product->quantity <= 0)
                                        <div class="absolute w-full text-center text-white bg-red-400 bg-opacity-50 rounded-sm inset-y-1/4 inset-1 h-fit">HABIS</div>
                                    @else
                                        @if ($canEditProduct)
                                            <a href="{{ route('seller.products.edit', $product->id) }}" class="add-to-cart product_data">
                                                <i class="text-white fa-solid fa-pencil"></i>
                                            </a>
                                        @else
                                            <div class="add-to-cart product_data" style="background: rgb(250, 112, 112)">
                                                <button>
                                                    <input type="hidden" class="qty_input" name="product_qty" value="1">
                                                    <input type="hidden" class="prod_id" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" class="store_id" name="store_id" value="{{ $product->stores->id }}">
                                                    <button type="button" class="btn addToCartBtn" aria-label="addToCart">
                                                        <i class="text-white fa fa-cart-plus" aria-hidden="true"></i>
                                                    </button>
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                @endunless
                                <img class="image-product" src="{{ asset("storage/product-images")."/".$product -> productImage -> image_path }}" alt="Image from {{ $product->stores->name }}">
                                <div class="bg-red-100 card-body">
                                    <div class="relative overflow-hidden py-0.5 rounded-br-lg bg-red-400 shadow-lg">
                                        <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                                            <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
                                            <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
                                        </svg>
                                        <div class="relative px-2 text-white">
                                            <span class="block text-xs font-semibold overflow-ellipsis">@currency($product->price)</span>
                                        </div>
                                    </div>
                                    <a class="hover:text-red-400" href="{{ route('product.detail', $product -> id) }}">
                                        <div class="px-2 text-left text-gray-700 product-name hover:text-red-500">{{ $product -> name }}</div>
                                    </a>
                                    <div class="px-2 owner-info">
                                        <a href="{{ route('store.details', $product->stores->id) }}">
                                            <div class="owner-pp">
                                                @isset($product->stores->users->profile_photo_path)
                                                    <img class="rounded-full" src="{{ asset('storage/profile-photos/'. $product->stores->users->profile_photo_path) }}" alt="pp-owner" width="100%" height="100%"/>
                                                @else
                                                    <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $product -> stores -> name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner" width="100%" height="100%"/>
                                                @endisset
                                            </div>
                                            <div class="font-bold owner-name whitespace-nowrap"
                                                data-hover-before="{{  $product->stores->name }}"
                                                data-hover-after="{{  $product->stores->users->name }}">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @include('home.components.notifications.cart-notification')
@endsection

@section('script')

    <script>
        $('.content-box').each(function() {
            var number = 1 + Math.floor(Math.random() * 10);
            $(this).addClass("color-" + number.toString());
        });
    </script>

    <script>
        /*##########################################################
                                *CAROUSEL PROMO*
        ##########################################################*/
        $(document).ready(function () {
            $('.carousel-promo').owlCarousel({
                center: true,
                items: 2,
                loop: true,
                /*stagePadding: 70,
                margin: 10,*/
                autoplay: true,
                autoplayHoverPause: true,
                autoplayTimeout: 5000,
                delay: 1000,
                dots: true,
                smartSpeed: 1000,
                navText: ['<i class="fa-solid fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>'],
                nav: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 1,
                    },
                    1000: {
                        items: 1,
                    }
                }
            })
        });
        /*##########################################################
                             *CAROUSEL PROMO END*
        ##########################################################*/
        /*##########################################################
                              *CAROUSEL CATEGORY*
        ##########################################################*/

        $('#sc-category-carousel').slick({
            rows: 2,
            infinite: false,
            speed: 300,
            slidesToShow: 12,
            slidesToScroll: 12,
            arrows: true,
            dots: false,
            lazyLoad: 'ondemand',
            appendArrows: $('#arrowNav'),
            prevArrow: "<button type='button' class='flex items-center justify-center w-8 h-8 p-2 text-red-400 bg-white rounded-full slick-prev pull-left hover:bg-white-300 hover:shadow-sm hover:shadow-gray-400 hover:ring-gray-500'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
            nextArrow: "<button type='button' class='flex items-center justify-center w-8 h-8 p-2 text-red-400 bg-white rounded-full slick-next pull-right hover:bg-white-300 hover:shadow-sm hover:shadow-gray-400 hover:ring-gray-500'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
            responsive: [
                {
                    breakpoint: 850,
                    settings: {
                        slidesToShow: 8,
                        slidesToScroll: 8,
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5,
                    }
                }
            ]
        });
        /*##########################################################
                          *CAROUSEL CATEGORY END*
        ##########################################################*/
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
                var qty = $(this).closest('.product_data').find('.qty_input').val();
                $.ajax({
                    method: "POST",
                    url: "{{route('customer.addToCart')}}",
                    data: {
                        'product_id': product_id,
                        'store_id': store_id,
                        'qty': qty,
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
