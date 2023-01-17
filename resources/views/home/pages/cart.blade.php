@extends('home.main')

@section('content')
    <div class="md:py-5 mb-14">
        <div class="w-full mx-auto bg-gray-100 shadow-lg rounded-lg" id="refreshcart">
            <div class="md:flex ">
                <div class="w-full p-4 px-5 py-5">
                    <div class="md:grid md:grid-cols-3 gap-2 ">
                        <div class="col-span-2 md:p-5">
                            <div class="flex justify-between border-b pb-5">
                                <h1 class="font-semibold text-2xl">Keranjang Pesanan</h1>
                                <h2 class="font-semibold text-2xl">{{ $cartitems->count() }} Item</h2>
                            </div>
                            @if ( $cartitems->count() > 0 )
                            <div class="flex my-5">
                                <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Detail Produk</h3>
                                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Kuantitas</h3>
                                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">@Harga</h3>
                                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Total</h3>
                            </div>
                                @php $total = 0 @endphp
                                @foreach($cartitems as $cart_item)
                                    <div class="product_data flex items-center hover:bg-gray-200 -mx-8 px-6 py-5">
                                        <div class="flex grid grid-cols-4 w-2/5">
                                            <div class="w-20 col-span-4 lg:col-span-1 mx-auto">
                                                <img class="h-20" src="{{ asset("storage/product-image")."/".$cart_item -> products -> productImage -> image_path }}" alt="">
                                            </div>
                                            <div class="col-span-4 lg:col-span-3 flex flex-col justify-between text-center lg:text-left px-2 mt-2 lg:ml-4 lg:mt-0 flex-grow">
                                                <span class="font-bold text-xs lg:text-sm">{{ $cart_item -> products -> name }}</span>
                                                <span class="text-red-500 text-xs">{{ $cart_item -> products -> productCategories -> name }}</span>
                                                <a href="#" class="del-cart-btn font-semibold hover:text-red-500 text-gray-500 text-xs">Hapus</a>
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
                                                        <input type="number" name="quantity" class="qty_input border-transparent outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700  outline-none" disabled value="0">
                                                        @else
                                                        <input type="number" name="quantity" class="qty_input border-transparent outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700  outline-none" disabled value="{{ $cart_item -> product_qty }}">
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
                            @else
                                <img class="mr-auto mt-16 ml-auto" style="max-width: 400px" src="{{ asset('assets/images/empty-cart.png') }}" alt="">
                                <h5 class="h-10 text-center">Anda belum memasukan barang apapun ke keranjang</h5>
                            @endif
                            <a href="{{ url('/') }}" class="flex font-semibold text-indigo-600 text-sm my-10 lg:my-0 lg:mt-10">
                                <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512"><path d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/></svg>
                                Lanjutkan Belanja
                            </a>
                        </div>
                        <div class="relative p-5 bg-gray-800 rounded overflow-visible">
                            <span class="text-xl font-medium text-gray-100 block pb-3">Ringkasan Pesanan</span>
                            <div class="flex justify-center flex-col pt-3">
                                <label class="text-xs text-gray-400 ">Name on Card</label>
                                <input type="text" class="focus:outline-none w-full h-6 bg-gray-800 text-white placeholder-gray-300 text-sm border-b border-gray-600 py-4" placeholder="Giga Tamarashvili">
                            </div>
                            <div class="flex justify-center flex-col pt-3">
                                <label class="text-xs text-gray-400 ">Card Number</label>
                                <input type="text" class="focus:outline-none w-full h-6 bg-gray-800 text-white placeholder-gray-300 text-sm border-b border-gray-600 py-4" placeholder="****     ****      ****      ****">
                            </div>
                            <div class="grid grid-cols-3 gap-2 pt-2 mb-12">
                                <div class="col-span-2 ">
                                    <label class="text-xs text-gray-400">Expiration Date</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" class="focus:outline-none w-full h-6 bg-gray-800 text-white placeholder-gray-300 text-sm border-b border-gray-600 py-4" placeholder="mm">
                                        <input type="text" class="focus:outline-none w-full h-6 bg-gray-800 text-white placeholder-gray-300 text-sm border-b border-gray-600 py-4" placeholder="yyyy">
                                    </div>
                                </div>
                                <div class="">
                                    <label class="text-xs text-gray-400">CVV</label>
                                    <input type="text" class="focus:outline-none w-full h-6 bg-gray-800 text-white placeholder-gray-300 text-sm border-b border-gray-600 py-4" placeholder="XXX">
                                </div>
                            </div>
                            @if ( $cartitems->count() > 0 )
                                <div class="mb-12">
                                    <div class="w-full h-6 text-white text-md py-4">Total Pembayaran :</div>
                                    <span class="flex inline h-6 text-white text-xl py-4">@currency($total)</span>
                                </div>
                            @endif
                            <button class="absolute bottom-0 right-0 h-12 w-full bg-red-400 rounded-b focus:outline-none text-white hover:bg-red-500">Check Out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
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
    </script>
@endsection
