@extends('home.main')

@section('content')

    @include('home.components.breadcrumbs.bc-cart')

    <div id="refresh-cart">
        <div class="w-full bg-white rounded-lg mb-8" style="box-shadow: rgba(49,53,59,0.12) 0 1px 6px 0;">
            @if ( $userCarts->count() < 1 )
                <div class="w-full h-96 flex flex-col justify-center items-center">
                    <img class="mx-auto h-1/2" style="max-width: 100%" src="{{ asset('assets/images/empty-cart.png') }}" alt="">
                    <p class="text-center">Anda belum memasukan barang apapun ke keranjang</p>
                </div>
            @else
                @foreach($userCarts as $store)
                    <div class="mx-auto">
                        <div class="flex justify-between items-center border-b p-2 lg:p-4 font-medium">
                            <span class="text-sm lg:text-lg">Pesanan {{ $loop -> iteration }}</span>
                            <span class="text-red-400"><i class="fa-solid fa-store mr-2"></i>
                                <a href="{{ route('store.details', $store->stores->id) }}">
                                    {{ $store->stores->name }}
                                </a>
                            </span>
                        </div>
                        <div class="px-2 lg:px-4 pt-2 lg:pt-4">
                            @php $total = 0 @endphp
                            @php $totalProduct = 0 @endphp
                            @foreach($store->cartItems as $cart_item)
                                <div class="flex items-center">
                                    <img class="w-20 h-20 object-cover rounded mb-2 md:mb-0 md:mr-2" src="{{ asset("storage/product-image")."/".$cart_item -> products -> productImage -> image_path }}" alt="Gambar Produk">
                                    <div class="ml-2 flex-grow">
                                        <a href="{{ route('product.detail', $cart_item->products->id) }}" class="font-medium text-sm lg:font-bold line-clamp-2 hover:text-red-400">{{ $cart_item -> products -> name }}</a>
                                        <p class="font-bold">@currency($cart_item->products->price)</p>
                                        <div class="flex items-center">
                                            <p class="text-xs lg:text-sm text-gray-600">{{ $cart_item -> products -> productCategories -> name }}</p>
                                            <p class="text-xs lg:text-sm text-gray-600 ml-auto">{{ $cart_item -> products -> quantity }} Tersisa</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center border-b mb-2 lg:mb-4 justify-between product_data">
                                    @php $subtotal = 0 @endphp
                                    @php $subtotal += $cart_item->products->price * $cart_item->product_qty; @endphp
                                    <p class="font-bold text-xs lg:text-sm line-clamp-2 text-red-400">@currency($subtotal)</p>
                                    <div class="flex items-center h-10">
                                        <button class="del-cart-btn text-red-500 font-bold mr-5">
                                            <i class="fa-regular fa-trash-can text-xl"></i>
                                        </button>
                                        <input type="hidden" value="{{ $cart_item -> products -> id }}" class="prod_id">
                                        <input class="hidden max-qty inline-block p-0 m-0" id="max-qty" value="{{ $cart_item -> products -> quantity }}" name="max-qty">
                                        <div class="inline-flex h-10 rounded-lg bg-transparent">
                                            <button class="changeQuantity decrement_btn text-red-400 rounded-l cursor-pointer outline-none">
                                                <i class="fa-solid fa-circle-minus text-lg"></i>
                                            </button>
                                            @if( $cart_item -> products -> quantity < $cart_item -> product_qty)
                                                <input type="number" name="quantity" class="qty_input p-0 border-transparent outline-none focus:outline-none text-center w-14 font-semibold text-md focus:text-black flex items-center text-gray-700  outline-none" disabled value="0">
                                            @else
                                                <input type="number" name="quantity" class="qty_input p-0 border-transparent outline-none focus:outline-none text-center w-14 font-semibold text-md focus:text-black flex items-center text-gray-700  outline-none" disabled value="{{ $cart_item -> product_qty }}">
                                            @endif
                                            <button class="changeQuantity increment_btn text-red-400 rounded-r cursor-pointer">
                                                <i class="fa-solid fa-circle-plus text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @php $total += $cart_item->products->price * $cart_item->product_qty; @endphp
                                @php $totalProduct += $cart_item->product_qty; @endphp
                            @endforeach
                        </div>
                        <div class="flex items-center">
                            <div class="text-md text-gray-400 ml-2 lg:ml-4 -mt-2 lg:-mt-4">
                                Harga ({{ $totalProduct }}) Produk : <br> <span class="text-xl inline-block text-center text-red-500" id="totalCost">@currency($total)</span>
                            </div>
                            <a class="ml-auto" href="{{ route('customer.checkout.index',$store -> id) }}">
                                <button class="px-10 py-3 float-right bg-red-400 rounded-tl-md rounded-br-md text-white focus:outline-none hover:bg-red-500">Check Out</button>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection


@section('script')

    <script>
        @if (session('success'))
        Swal.fire({
            type: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
        });
        @elseif (session('error'))
        Swal.fire({
            type: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: true,
            className: 'my-custom-class'
        });
        @endif
    </script>

    <script>

        // SET THE VALUE OF PRODUCT - QTY
        $(document).on('click','.increment_btn', function (e) {
            e.preventDefault();
            // var inc_value = $('.qty_input').val();
            var inc_value = $(this).closest('.product_data').find('.qty_input').val();
            var max_qty = $(this).closest('.product_data').find('.max-qty').val();

            var value = parseInt(inc_value, 10);
            value = isNaN(value) ? 0 : value;
            if (value < max_qty) {
                value++;
                $(this).closest('.product_data').find('.qty_input').val(value);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Maaf, kamu hanya dapat membeli maksimal&nbsp;<span style="color: #35cb4c">'+ max_qty +'</span>&nbsp;item',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });


        $(document).on('click','.decrement_btn', function (e) {
            e.preventDefault();
            /*var dec_value = $('.qty_input').val();*/
            var dec_value = $(this).closest('.product_data').find('.qty_input').val();
            var value = parseInt(dec_value, 10);
            value = isNaN(value) ? 0 : value;
            if (value > 1) {
                value--;
                $(this).closest('.product_data').find('.qty_input').val(value);
            }
        });

        // Change Quantity
        $(document).on('click','.changeQuantity', function (e) {
            e.preventDefault();
            $(this).prop('disabled', true).removeClass('text-red-400').addClass('text-red-300');
            var prod_id = $(this).closest('.product_data').find('.prod_id').val();
            var qty = $(this).closest('.product_data').find('.qty_input').val();
            var data = {
                'prod_id' : prod_id,
                'prod_qty': qty,
            }
            $.ajax({
                method: "PUT",
                url: "{{route('customer.update.cartItem')}}",
                data: data,
                success: function (response){
                    $('#refresh-cart').load(location.href + " #refresh-cart");
                    $(this).prop('disabled', false).removeClass('text-red-300').addClass('text-red-400');
                }
            })
        });

        // DELETE PRODUCT FROM CART
        $(document).on('click','.del-cart-btn', function (e) {
            e.preventDefault();
            var prod_id = $(this).closest('.product_data').find('.prod_id').val();
            $.ajax({
                method: "POST",
                url: "{{route('customer.delete.cartItem')}}",
                data: {
                    'prod_id': prod_id,
                },
                success: function (response) {
                    // window.location.reload();
                    loadCart();
                    $('#refresh-cart').load(location.href + " #refresh-cart");
                }
            });
        });

    </script>

@endsection
