@extends('home.main')

@section('head')
    <title>Lakubo - Lapak UMKM Boyolali</title>
@endsection

@section('content')

    @include('home.components.breadcrumbs.bc-store-details')

    <!-- BEGIN: Profile Info -->
    <div class="carousel-detail-product relative block shadow-lg rounded-lg py-2.5 mb-6" style="box-shadow: rgba(49,53,59,0.12) 0 1px 6px 0;">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 relative">
                    @if($store->users->profile_photo_path)
                        <img class="rounded-full h-full" alt="Profile-photo-preview" src="{{ asset('storage/profile-photos/'. $store->users->profile_photo_path) }}">
                    @else
                        <img class="rounded-full h-full" alt="Profile-photo-preview" src="https://ui-avatars.com/api/?size=100&name={{ $store->name }}">
                    @endif
                </div>
                <div class="ml-5">
                    <div class="w-full sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $store->name }}</div>
                    <div class="text-gray-500 text-sm">{{ $store->storeCategories->name }}</div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium lg:mt-3 flex justify-center lg:justify-between">Kontak Lapak
                    @auth()
                        @if(Auth::user()->stores && Auth::user()->stores->id === $store->id)
                            <span class="inline-flex">
                            <a href="{{ route('profile.edit') }}" class="inline-flex text-red-400"><i class="fa-regular fa-pen-to-square mr-2 my-auto"></i>Edit</a>
                        </span>
                        @endif
                    @endauth
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4 text-gray-700">
                    <div class="truncate sm:whitespace-normal flex items-center"> <i class="fa-regular fa-envelope mr-2"></i> {{ $store->users->email }} </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2"> <i class="fa-solid fa-mobile-screen ml-0.5 mr-2"></i> {{ $store->users->phone }} </div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-medium text-red-400 text-xl">{{ count($storeProducts) }}</div>
                    <div class="text-slate-500">Produk</div>
                </div>
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-medium text-red-400 text-xl">{{ count($store->orders) }}</div>
                    <div class="text-slate-500">Pesanan</div>
                </div>
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-medium text-red-400 text-xl">
                        {{ $countSuccessOrders }}
                    </div>
                    <div class="text-slate-500">Penjualan</div>
                </div>
            </div>
        </div>

        <div class="py-4 pl-4 text-left">
            <h4 class="font-medium">Produk</h4>
        </div>

        @if($storeProducts -> count() < 1)
            <div class="w-full h-96 flex flex-col justify-center items-center">
                <img class="mx-auto h-3/4" style="max-width: 100%" src="{{ asset('assets/images/empty-box.svg') }}" alt="">
                <p class="text-center">Produk tidak ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-x-2 gap-y-4 md:gap-x-4 px-4 py-2">
                @foreach ($storeProducts as $product)
                    <div class="card-detail mb-2 lg:mb-0 overflow-hidden relative shadow-lg shadow-gray-200 rounded-lg transform hover:translate-y-1 hover:shadow-xl transition duration-300">
                        <img class="h-40 w-full object-cover rounded-t-lg" src="{{ asset("storage/product-image")."/".$product -> productImage -> image_path }}" alt="{{ $product->name }}">
                        @php
                            $isAuthenticated = auth()->check();
                            $isSeller = $isAuthenticated && auth()->user()->hasRole('seller');
                            $isProductStoreSameAsUserStore = $isSeller && $product->stores->id === auth()->user()->stores->id;
                            $canEditProduct = $isProductStoreSameAsUserStore;
                        @endphp
                        @if ($product->quantity > 0)
                            @if ($canEditProduct)
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="absolute top-0 right-0 product_data bg-red-400 text-lg text-white px-1 rounded-tr-lg rounded-bl-lg">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            @else
                                <div class="absolute top-0 right-0 product_data bg-red-400 text-lg text-white px-1 rounded-tr-lg rounded-bl-lg">
                                    <button>
                                        <input type="hidden" class="qty_input" name="product_qty" value="1">
                                        <input type="hidden" class="prod_id" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" class="store_id" name="store_id" value="{{ $product->stores->id }}">
                                        <button type="button" class="btn addToCartBtn">
                                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                        </button>
                                    </button>
                                </div>
                            @endif
                        @endif
                        <div class="rounded-lg shadow-lg bg-red-100">
                            <div class="relative overflow-hidden py-0.5 rounded-br-lg bg-red-400 shadow-lg">
                                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
                                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
                                </svg>
                                <div class="relative px-2 text-white">
                                    <span class="block font-semibold text-xs overflow-ellipsis">@currency($product->price)</span>
                                </div>
                            </div>
                            <a class="a-link" href="{{ route('product.detail', $product -> id) }}">
                                <div class="px-2 line-clamp-2 text-xs py-1 text-gray-700 hover:text-red-400 text-left">{{ $product -> name }}</div>
                            </a>
                            <div class="px-2 owner-info">
                                <a href="{{ route('store.details', $product->stores->id) }}">
                                    <div class="owner-pp">
                                        @isset($product->stores->users->profile_photo_path)
                                            <img class="rounded-full" src="{{ asset('storage/profile-photos/'. $product->stores->users->profile_photo_path) }}" alt="pp-owner"/>
                                        @else
                                            <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $product -> stores -> name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                                        @endisset
                                    </div>
                                    <div class="owner-name truncate whitespace-nowrap font-bold mt-1"
                                         data-hover-before="{{  $product -> stores -> name }}"
                                         data-hover-after="{{  $product -> stores -> users -> name }}">
                                    </div>
                                </a>
                            </div>
                            <div class="bg-red-400 text-center rounded-b-lg">
                                <span class="text-sm text-white">
                                    {{ $product -> created_at -> diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($storeProducts->count() > 16)
            <div class="px-4 py-2">
                {{ $storeProducts->links() }}
            </div>
        @endif

    </div>
    <!-- END: Profile Info -->

    @include('home.components.notifications.cart-notification')

@endsection

@section('script')
    <script>
        /*##########################################################
                       *TAMBAH PRODUCT KE KERANJANG*
        ##########################################################*/

        @if(Auth::check())
        $(document).on('click','.addToCartBtn', function (e) {
            e.preventDefault();
            let product_id = $(this).closest('.product_data').find('.prod_id').val();
            let store_id = $(this).closest('.product_data').find('.store_id').val();
            let qty = $(this).closest('.product_data').find('.qty_input').val();
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
