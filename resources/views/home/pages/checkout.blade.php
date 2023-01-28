@extends('home.main')

@section('content')
    <div class="md:py-5 mb-14">
        <div class="w-full mx-auto bg-gray-100 shadow-lg rounded-lg" id="refreshcart">
            <div class="md:flex ">
                <div class="w-full p-4 px-5 py-5">
                    <div class="flex justify-between border-b pb-5 mb-5">
                        <h1 class="font-semibold text-2xl">Checkout</h1>
                    </div>
                    <div class="bg-gray-200 rounded-lg p-4">
                        <div class="envelope-lines my-2"></div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-red-500 my-2 flex-grow flex-shrink flex-auto capitalize">
                                <div class="flex mr-4">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>alamat pengiriman</div>
                                <div class="text-blue-400 capitalize cursor-pointer mr-0 ml-auto">
                                    <a href="{{ route('profile.edit') }}">ubah</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div>
                                <div class="flex items-center text-lg break-words">
                                    <div class="grid grid-col-12">
                                        <div class="col-span-6 md:col-span-12">
                                            <span class="font-bold">{{ Auth::user()->name }}</span>
                                            <span>( {{ Auth::user()->phone }} )</span>
                                        </div>
                                        <div class="col-span-6 md:col-span-12 flex justify-between">
                                            <div class="break-words capitalize_address">
                                                {{ Auth::user()->address->detail_address }},
                                                {{ Auth::user()->address->village->name }},
                                                {{ Auth::user()->address->district->name }},
                                                {{ Auth::user()->address->regency->name }},
                                                {{ Auth::user()->address->province->name }}.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($cartItems->count() < 1 )
                        <div class="px-6 py-5">
                            <div>
                                <h1 class="text-center my-20">Anda belum memilih produk untuk di checkout.</h1>
                            </div>
                            <div>
                                <a href="{{ route('customer.cart.index') }}">
                                    <button class="h-12 w-full bg-red-400 rounded text-white focus:outline-none hover:bg-red-500">kembali ke Keranjang</button>
                                </a>
                            </div>
                        </div>
                    @else

                        <div class="flex border-b pb-3 pt-3">
                            <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Detail Produk</h3>
                            <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Kuantitas</h3>
                            <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">@Harga</h3>
                            <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Subtotal</h3>
                        </div>

                        @php $total = 0 @endphp
                        @php $totalWeight = 0 @endphp
                        @foreach($cartItems as $item)
                            <div class="product_data flex items-center -mx-8 px-6 py-5 border-b">
                                <div class="flex grid grid-cols-4 w-2/5">
                                    <div class="w-20 col-span-4 lg:col-span-1 mx-auto">
                                        <img class="h-20" src="{{ asset("storage/product-image")."/".$item -> products -> productImage -> image_path }}" alt="">
                                    </div>
                                    <div class="col-span-4 lg:col-span-3 flex flex-col justify-between text-center lg:text-left px-2 mt-2 lg:ml-4 lg:mt-0 flex-grow">
                                        <span class="font-bold text-xs lg:text-sm">{{ $item -> products -> name }}</span>
                                        <span class="text-xs">({{ $item -> products -> weight }} gram)</span>
                                        <span class="text-red-500 text-xs">{{ $item -> products -> productCategories -> name }}</span>
                                    </div>
                                </div>
                                <span class="text-center w-1/5 font-semibold text-sm">{{ $item -> product_qty }}</span>
                                <span class="text-center w-1/5 font-semibold text-sm">@currency($item->products->price)</span>
                                @php $subtotal = 0 @endphp
                                @php $subtotal += $item->products->price * $item->product_qty; @endphp
                                <span class="text-center w-1/5 font-semibold text-sm">@currency($subtotal)</span>
                            </div>
                            @php $total += $item->products->price * $item->product_qty; @endphp
                            @php $totalWeight += $item -> products -> weight; @endphp
                        @endforeach
                        <div class="flex justify-between items-center my-3">
                            <div class="text-md text-gray-400">Berat ({{ $cartItems->count() }}) produk:
                                <span class="text-md inline-block text-center ml-2 text-red-500">{{ $totalWeight }} gram</span>
                            </div>
                            <div class="text-md text-gray-400">Total harga produk:
                                <span class="text-xl inline-block text-center ml-2 text-red-500">@currency($total)</span>
                                <input class="hidden" type="text" name="price" id="price" value="{{ $total }}">
                                <div class="text-sm text-gray-400">+ Biaya ongkir:
                                    <span class="text-sm inline-block text-center text-red-500" id="shippingCost">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex lg:justify-between border-b pb-5 mb-5" id="center-option">
                            <div class="w-1/2 mr-auto text-center">
                                <select id="selectShipping" name="shipping" class="js-states form-control" required>
                                    <option value="0" selected disabled>Pilih Pengiriman (JNE)</option>
                                    @foreach( $services as $service )
                                        <option value="{{ $service['biaya'] }}">{{ $service['description'] }} (@currency($service['biaya'])) | {{ $service['etd'] }} Hari Pengiriman</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-md text-gray-400 min-w-fit">Total Tagihan:
                                <span class="text-xl inline-block text-center ml-2 text-red-500" id="totalCost">@currency($total)</span>
                            </div>
                        </div>
                        <a href="#">
                            <button class="h-12 w-full bg-red-400 rounded text-white focus:outline-none hover:bg-red-500">Bayar</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')

    <script>
        $("#selectShipping").change(function() {
            var price = $("#price").val();
            var shipping = $(this).val();
            var total = `Rp. ${(parseInt(price) + parseInt(shipping)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;
            var shippingCost = `Rp. ${(parseInt(shipping)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;
            $("#totalCost").text(total);
            $("#shippingCost").text(shippingCost);
        });
    </script>

    <script>
        $("#selectShipping").select2({
            minimumResultsForSearch: Infinity,
            placeholder: "Pilih opsi pengiriman",
            searchInputPlaceholder: 'Cari Pengiriman...',
        });
    </script>

@endsection
