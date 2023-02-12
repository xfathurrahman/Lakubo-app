@extends('home.main')

@section('content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .select2.select2-container {
            margin-top: 5px;
            width: 100% !important;
        }
    </style>

    <div class="md:py-5 mb-14">
        <div class="w-full mx-auto bg-gray-100 shadow-lg rounded-lg">
            <div class="md:flex ">
                <div class="w-full p-4 px-5 py-5">
                    <div class="flex justify-between border-b pb-5 mb-5">
                        <h1 class="font-semibold text-2xl">Checkout</h1>
                        <div class="my-2 inline-flex">
                            <div class="text-red-400 font-medium">{{ $cart->stores->name }}</div>
                            <a href="#" class="btn ml-2 h-6"><i class="fa-solid fa-store mr-2"></i>Kunjungi</a>
                        </div>
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
                    @if($cart->cartItems->count() < 1 )
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
                        <div class="flex flex-wrap lg:justify-between">
                            <div class="w-full lg:w-1/2 lg:pr-5">
                                <div class="flex border-b pb-3 pt-3">
                                    <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Detail Produk</h3>
                                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Kuantitas</h3>
                                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">@Harga</h3>
                                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Subtotal</h3>
                                </div>
                                @php $total = 0 @endphp
                                @php $totalWeight = 0 @endphp
                                @php $totalProduct = 0 @endphp
                                @foreach($cart->cartItems as $item)
                                    <div class="flex items-center px-6 py-5 border-b">
                                        <div class="flex grid grid-cols-4 w-2/5">
                                            <div class="w-20 col-span-4 lg:col-span-1 mx-auto">
                                                <img class="h-20" src="{{ asset("storage/product-image")."/".$item -> products -> productImage -> image_path }}" alt="">
                                            </div>
                                            <div class="col-span-4 lg:col-span-3 flex flex-col justify-between text-center lg:text-left px-2 mt-2 lg:ml-4 lg:mt-0 flex-grow">
                                                <span class="font-bold text-xs lg:text-sm">{{ $item -> products -> name }}</span>
                                                @php $subtotalWeight = 0 @endphp
                                                @php $subtotalWeight += $item -> products -> weight * $item->product_qty @endphp
                                                <span class="text-xs">({{ $subtotalWeight }} gram)</span>
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
                                    @php $totalWeight += $subtotalWeight; @endphp
                                    @php $totalProduct += $item -> product_qty; @endphp
                                @endforeach
                            </div>
                            <div class="w-full lg:w-1/2 p-2 bg-red-400 rounded-lg lg:p-6 text-white">
                                <form id="submit_form" method="POST" action="{{ route('customer.checkout.store', $cart->id) }}" data-parsley-validate="" role="form">
                                    @csrf
                                    <input type="hidden" name="price" id="price" value="{{ $total }}">
                                    <input type="hidden" name="gross_amount" id="gross_amount" value="0">
                                    <div class="text-md text-gray-400 pt-3">
                                        <div class="shipment" id="center-option">
                                            <label for="select_shipping" class="text-white">Pengiriman<span class="text-grey-400 inline-block float-right" id="parsley_error"></span></label>
                                            <select id="select_shipping" name="shipping" class="js-states py-3" required data-parsley-required-message="Pilih Jasa Pengiriman." data-parsley-errors-container="#parsley_error">
                                                <option value="0" selected disabled>Layanan Pengiriman JNE</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label for="note" class="text-md text-gray-400"></label>
                                        <textarea id="note" name="note" class="resize-none border border-gray-400 rounded w-full py-2 px-3 focus:outline-none focus:ring-gray-100 text-black" placeholder="Tambah catatan (opsional)"></textarea>
                                    </div>
                                    <div class="flex justify-between border-b-2 py-3">
                                        <span class="text-grey-400">Subtotal:</span>
                                        <span class="inline-block text-right">@currency($total)</span>
                                    </div>
                                    <div class="flex justify-between border-b-2 py-3">
                                        <span class="text-grey-400">Biaya Pengiriman:</span>
                                        <span class="inline-block text-right" id="shippingCost">0</span>
                                    </div>
                                    <div class="flex justify-between py-3 text-xl">
                                        <span class="text-grey-400">Total:</span>
                                        <span class="inline-block text-right" id="totalCost">@currency($total)</span>
                                    </div>
                                    <button type="submit" id="pay-button" class="h-12 w-full float-right bg-red-500 rounded text-white focus:outline-none hover:bg-red-600">Konfirmasi Pesanan</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script>
        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            return !(ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57));
        }
    </script>

    <script>
        $(document).ready(function() {
            let select_shipping = $("#select_shipping");
            select_shipping.select2({
                minimumResultsForSearch: Infinity,
                placeholder: "Pilih pengiriman",
                searchInputPlaceholder: 'Cari Pengiriman...',
            });
            select_shipping.change(function() {
                let price = $("#price").val();
                let shipping = $(this).val();
                // untuk ditampilkan ke blade
                let total = `Rp. ${(parseInt(price) + parseInt(shipping)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;
                let shippingCost = `Rp. ${(parseInt(shipping)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;
                // untuk dibawah ke controller
                let gross_amount = (parseInt(price) + parseInt(shipping)).toString();

                $("#totalCost").text(total);
                $("#shippingCost").text(shippingCost);
                $("#gross_amount").val(gross_amount);
            });
        });
    </script>

@endsection
