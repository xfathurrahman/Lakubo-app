@extends('home.main')

@section('content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="md:py-5 mb-14">
        <div class="w-full mx-auto bg-gray-100 shadow-lg rounded-lg">
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
                        <div id="refresh">
                            <div class="my-3">Produk dari Lapak <p class="text-red-400">{{ $cart->stores->name }}</p></div>
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
                                <div class="product_data flex items-center -mx-8 px-6 py-5 border-b">
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

                            <form id="submit_form" method="POST" action="{{ route('customer.checkout.store', $cart->id) }}" role="form">
                                @csrf
                                <input type="text" class="shadow-sm w-full border-gray-300 rounded-lg mt-3" placeholder="Tambah Catatan (Opsional)">
                                <div class="flex justify-between items-center my-3">
                                    <div class="text-md text-gray-400">Berat total ({{ $totalProduct }}):
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
                                <div class="flex lg:justify-between border-b pb-5 mb-5 product_data" id="center-option">
                                    <input type="hidden" class="cart_id" value="{{ $cart->id }}">
                                    <div class="w-1/2 mr-auto text-center">
                                        <select id="select_shipping" name="shipping" class="js-states form-control" required>
                                            <option value="0" selected disabled>Pilih Jasa Pengiriman (JNE)</option>
                                            @foreach( $services as $service )
                                                <option value="{{ $service['biaya'] }}">{{ $service['description'] }} (@currency($service['biaya'])) | {{ $service['etd'] }} Hari Pengiriman</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-md text-gray-400 min-w-fit">Total Tagihan:
                                        <span class="text-xl inline-block text-center ml-2 text-red-500" id="totalCost">@currency($total)</span>
                                    </div>
                                </div>
                                <input type="hidden" name="json" id="json_callback">
                            </form>
                            <button id="pay-button" class="h-12 w-full bg-gray-400 rounded text-white focus:outline-none hover:bg-red-500">
                                <i class="fa-solid fa-circle-info mr-2 text-sm"></i>Anda Belum Memilih Jasa Pengiriman
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="config('midtrans.client_key')"></script>
    <script>
        $(document).ready(function() {

            let SnapToken;
            let select_shipping = $("#select_shipping");
            let payButton = $("#pay-button");
            payButton.prop("disabled", true).removeClass("hover:bg-red-500");

            select_shipping.select2({
                minimumResultsForSearch: Infinity,
                placeholder: "Pilih pengiriman",
                searchInputPlaceholder: 'Cari Pengiriman...',
            });
            select_shipping.change(function() {

                let price = $("#price").val();
                let shipping = $(this).val();
                let total = `Rp. ${(parseInt(price) + parseInt(shipping)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;
                let gross_amount = (parseInt(price) + parseInt(shipping)).toString();
                let shippingCost = `Rp. ${(parseInt(shipping)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;

                $("#totalCost").text(total);
                $("#shippingCost").text(shippingCost);

                $.ajax({
                    type: "POST",
                    url: "{{route('customer.snap.token')}}",
                    data: { grossAmount: gross_amount },
                    beforeSend: function() {
                        payButton.prop("disabled", true).html("Memuat <i class='fas fa-spinner fa-spin'></i>");
                    },
                    success: function(gross_amount) {
                        SnapToken = gross_amount;
                    },
                    complete: function() {
                        setTimeout(function() {
                            payButton.prop("disabled", false).addClass("hover:bg-red-500 bg-red-400").text("Bayar").removeClass("bg-gray-400");
                        }, 1300);  // 1000 milliseconds = 1 second
                    }
                });

                payButton.click(function() {
                    window.snap.pay(SnapToken, {
                        onSuccess: function(result){
                            /* You may add your own implementation here */
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: "Pembayaran Berhasil!",
                                showConfirmButton: false,
                                timer: 1500
                            }); console.log(result);
                            send_response_to_form(result);
                        },
                        onPending: function(result){
                            /* You may add your own implementation here */
                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: "Menunggu Pembayaran Anda.",
                                showConfirmButton: false,
                                timer: 1500
                            }); console.log(result);
                            send_response_to_form(result);
                        },
                        onError: function(result){
                            /* You may add your own implementation here */
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: "Pembayaran gagal!",
                                showConfirmButton: false,
                                timer: 1500
                            }); console.log(result);
                            send_response_to_form(result);
                        },
                        onClose: function(){
                            /* You may add your own implementation here */
                            alert('you closed the popup without finishing the payment');
                        }
                    })
                });
                function send_response_to_form(result){
                    document.getElementById('json_callback').value = JSON.stringify(result);
                    document.getElementById('submit_form').submit();
                }
            });
        });
    </script>

@endsection
