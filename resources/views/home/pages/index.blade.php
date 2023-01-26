@extends('home.main')

@section('head')
    <title>Lakubo - Lapak UMKM Boyolali</title>
@endsection

@section('content')
    <div class="main-carousel-promo carousel mb-2">
        <div class="owl-carousel owl-theme owl-wrapper carousel-promo">
            <div class="carousel-promo-item">
                <a href="#">
                    <img class="d-block ca-img h-full"
                         src="{{ asset('assets/images/app/caro.jpg')}}"
                         alt="Carousel">
                </a>
            </div>
            <div class="carousel-promo-item">
                <a href="#">
                    <img class="d-block ca-img h-full"
                         src="{{ asset('assets/images/app/caro.jpg')}}"
                         alt="Carousel">
                </a>
            </div>
            <div class="carousel-promo-item">
                <a href="#">
                    <img class="d-block ca-img h-full"
                         src="{{ asset('assets/images/app/caro.jpg')}}"
                         alt="Carousel">
                </a>
            </div>
        </div>
    </div>

    <div class="carousel-category my-5">
        <div class="mb-2 text-center font-semibold">
            <h4>Kategori</h4>
            <hr class="mt-1.5 mx-2">
        </div>

        <div class="slick-wrapper px-4">
            <div id="sc-category-carousel" class="pb-3">
                @foreach($categories as $category)
                    <a href="#" class="flex-shrink-0 my-2 relative overflow-hidden content-box rounded-lg max-w-xs shadow-lg">
                        <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                            <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
                            <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
                        </svg>
                        <div class="relative pt-2 px-2 md:pt-5 md:px-5 flex items-center justify-center">
                            <div class="block absolute w-20 h-20 bottom-0 left-0 -mb-24 ml-3" style="background: radial-gradient(black, transparent 60%); transform: rotate3d(0, 0, 1, 20deg) scale3d(1, 0.6, 1); opacity: 0.2;"></div>
                            <img class="image-product" src="{{ asset("storage/product-category")."/".$category -> image_path }}" alt="category-image">
                        </div>
                        <div class="relative text-center text-white px-1 pb-1 mt-1 md:px-3 md:pb-3 md:mt-3">
                            <span class="block font-semibold text-xs overflow-ellipsis capitalize md:uppercase ">{{ $category -> name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="carousel-product my-4">
        <div class="mb-8 w-100 text-center ">
            <h4 class="mx-4 mb-3 font-semibold">Produk Terbaru</h4>
            <hr>
        </div>
        <div class="owl-carousel sc-products-carousel owl-theme">
            @foreach($products as $product)
                <div class="item ml-2">
                    <div class="card shadow-xl bg-gray-200">
                        <div class="date-option bg-red-400 text-center">
                        <span class="date-post">
                            <p class="mb-5">{{ $product -> created_at -> diffForHumans() }}</p>
                        </span>
                        </div>
                        @if (Auth::check())
                            @if(auth()->user()->hasRole('seller') && $product->store_id == auth()->user()->stores->id)
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="add-to-cart product_data">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            @elseif($product->quantity > 0)
                            <div class="add-to-cart product_data">
                                <button class="">
                                    <input type="hidden" class="qty_input" name="product_qty" value="1">
                                    <input type="hidden" class="prod_id" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" class="store_id" name="store_id" value="{{ $product->stores->id }}">
                                    <button type="button" class="btn addToCartBtn">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    </button>
                                </button>
                            </div>
                            @endif
                        @elseif($product->quantity > 0)
                            <div class="add-to-cart product_data">
                                <button class="">
                                    <input type="hidden" class="qty_input" name="product_qty" value="1">
                                    <input type="hidden" class="prod_id" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" class="store_id" name="store_id" value="{{ $product->stores->id }}">
                                    <button type="button" class="btn addToCartBtn">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    </button>
                                </button>
                            </div>
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
                                        <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $product -> stores -> name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                                    </div>
                                    <div class="owner-name overflow-ellipsis font-medium"
                                         data-hover-before="{{  $product -> stores -> name }}"
                                         data-hover-after="{{  $product -> stores -> users -> name }}"
                                         type="button">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-end">
            <h5 class="m-0 p-0 align-middle"><a href="#" class="btn-new-product-all font-bold text-decoration-none">Lihat Semua</a></h5>
        </div>
    </div>

    <style>
        .swal2-popup {
            font-size: 0.8rem !important;
        }
    </style>

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
            slidesToShow: 7,
            slidesToScroll: 7,
            arrows: true,
            dots: false,
            lazyLoad: 'ondemand',
            prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
            nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
            responsive: [
                {
                    breakpoint: 850,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 6,
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
                    350: {
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
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else{
                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: response.error,
                                showConfirmButton: false,
                                timer: 1500
                            });
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
                    confirmButtonText: '<a href="http://127.0.0.1:8000/login">Masuk</a>'
                });
            });

        @endif

        /*##########################################################
                     *TAMBAH PRODUCT KE KERANJANG END*
        ##########################################################*/
    </script>
@endsection
