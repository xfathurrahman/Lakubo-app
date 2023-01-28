@extends('home.main')

@section('content')
    <div id="refreshcart">
        @if ( $userCarts->count() < 1 )
            <div class="w-full mx-auto bg-gray-100 shadow-lg rounded-lg my-8">
                <div class="md:flex ">
                    <div class="w-full p-4 px-5 py-5 mb-8 mt-1">
                        <img class="mr-auto mt-16 ml-auto" style="max-width: 400px" src="{{ asset('assets/images/empty-cart.png') }}" alt="">
                        <h5 class="h-10 text-center py-12">Anda belum memasukan barang apapun ke keranjang</h5>
                        <hr>
                    </div>
                </div>
            </div>
        @else
            <div style="min-height: 34rem;">
                @foreach($userCarts as $store)
                    <div class="w-full mx-auto bg-gray-100 shadow-lg rounded-lg mt-6 my-4">
                        <div class="md:flex ">
                            <div class="w-full p-4 px-5 py-5">
                                <div class="flex justify-between border-b pb-5">
                                    <div class="font-medium text-lg">Pesanan {{ $loop -> iteration }} dari <p class="text-red-400 inline">{{ $store->stores->name }}</p></div>
                                    <div class="font-medium text-lg">{{ $store->cartItems->count() }} Item</div>
                                </div>
                                <div class="flex my-5">
                                    <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Detail Produk</h3>
                                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Kuantitas</h3>
                                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">@Harga</h3>
                                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Subtotal</h3>
                                </div>
                                @php $total = 0 @endphp
                                @foreach($store->cartItems as $cart_item)
                                    <div class="product_data flex items-center hover:bg-gray-200 px-6 py-5">
                                        <div class="flex grid grid-cols-4 w-2/5">
                                            <div class="w-20 col-span-4 lg:col-span-1 mx-auto">
                                                <img class="h-20" src="{{ asset("storage/product-image")."/".$cart_item -> products -> productImage -> image_path }}" alt="">
                                            </div>
                                            <div class="col-span-4 lg:col-span-3 flex flex-col justify-between text-center lg:text-left px-2 mt-2 lg:ml-4 lg:mt-0 flex-grow">
                                                <span class="font-bold text-xs lg:text-sm">{{ $cart_item -> products -> name }}</span>
                                                <span class="text-red-500 text-xs">{{ $cart_item -> products -> productCategories -> name }}</span>
                                                <a href="#" class="del-cart-btn rounded font-semibold text-xs text-gray-500 hover:text-red-500">Hapus</a>
                                            </div>
                                        </div>
                                        <div class="flex justify-center w-1/5">
                                            <div class="flex justify-center items-center w-full h-10 mx-auto my-0">
                                                <div class="custom-number-input h-10 w-32">
                                                    <input type="hidden" value="{{ $cart_item -> products -> id }}" class="prod_id">
                                                    <div class="flex flex-row mx-auto h-10 w-20 lg:w-full rounded-lg relative bg-transparent mt-1">
                                                        <button class="changeQuantity decrement_btn bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                        @if( $cart_item -> products -> quantity < $cart_item -> product_qty)
                                                            <input type="number" name="quantity" class="qty_input p-0 border-transparent outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700  outline-none" disabled value="0">
                                                        @else
                                                            <input type="number" name="quantity" class="qty_input p-0 border-transparent outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700  outline-none" disabled value="{{ $cart_item -> product_qty }}">
                                                        @endif
                                                        <button class="changeQuantity increment_btn bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="invisible">
                                                        <label class="inline-block p-0 m-0" for="max-qty">{{ $cart_item -> products -> quantity }}&nbsp;tersisa</label>
                                                        <input class="invisible max-qty inline-block p-0 m-0" id="max-qty" value="{{ $cart_item -> products -> quantity }}" name="max-qty">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-center w-1/5 font-semibold text-sm">@currency($cart_item->products->price)</span>
                                        @php $subtotal = 0 @endphp
                                        @php $subtotal += $cart_item->products->price * $cart_item->product_qty; @endphp
                                        <span class="text-center w-1/5 font-semibold text-sm">@currency($subtotal)</span>
                                    </div>
                                    @php $total += $cart_item->products->price * $cart_item->product_qty; @endphp
                                @endforeach
                                <div class="mb-8">
                                    <div class="w-full h-6 text-md py-4">Total Harga Produk</div>
                                    <span class="flex inline h-6 text-xl py-4">@currency($total)</span>
                                </div>
                                <a href="{{ route('customer.checkout.index',$store -> id) }}">
                                    <button class="h-12 w-full bg-red-400 rounded text-white focus:outline-none hover:bg-red-500">Check Out</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
                    $('#refreshcart').load(location.href + " #refreshcart");
                    // thisClick.closest('.product_data').find('.cart-grand-total-price').text("im here");
                }
            })
        });

        // DELETE PRODUCT FROM CART
        //     $('.del-cart-btn').click(function (e) {
        $(document).on('click','.del-cart-btn', function (e) {
            e.preventDefault();
            var prod_id = $(this).closest('.product_data').find('.prod_id').val();
            /*var img_value = $(this).closest('.product_data').find('#img_val').val();*/
            $.ajax({
                method: "POST",
                url: "{{route('customer.delete.cartItem')}}",
                data: {
                    'prod_id': prod_id,
                },
                success: function (response) {
                    // window.location.reload();
                    loadCart();
                    $('#refreshcart').load(location.href + " #refreshcart");
                }
            });
        });

    </script>
@endsection
