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

    <div class="md:pb-5 mb-14">
        <div class="w-full mx-auto bg-white shadow-lg rounded-lg">
            <div class="md:flex ">
                <div class="w-full p-4 px-5 pt-5 pb-12">
                    <div class="flex justify-between border-b pb-5 mb-5">
                        <h1 class="font-semibold text-2xl">Checkout</h1>
                        <div class="my-2 inline-flex">
                            <a href="{{ route('store.details', $cart->stores->id) }}" class="text-red-400 font-medium"><i class="fa-solid fa-store mr-2"></i>{{ $cart->stores->name }}</a>
                        </div>
                    </div>
                    <div class="bg-gray-200 rounded-lg p-4">
                        <div class="envelope-lines my-2"></div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-red-500 my-2 flex-grow flex-shrink flex-auto capitalize">
                                <div class="flex mr-4">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>Alamat pengiriman</div>
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
                        <div class="flex flex-wrap lg:justify-between pt-6 min-h-checkout">
                            <div class="w-full lg:w-1/2 lg:pr-5">
                                @php $total = 0 @endphp
                                @php $totalWeight = 0 @endphp
                                @php $totalProduct = 0 @endphp
                                @foreach($cart->cartItems as $item)
                                    <div class="flex items-center mb-2">
                                        <a class="w-full" href="{{ route('product.detail', $item->products->id) }}">
                                            <div class="inline-flex items-center text-xs lg:text-sm w-full h-fit bg-gray-100 rounded-lg transform hover:translate-y-1 hover:shadow-xl transition duration-300 border-1">
                                                <span class="absolute top-0 right-0 text-white bg-red-400 text-xs rounded-tr rounded-bl px-2">
                                                    <i class="fa-solid fa-tag mx-1"></i>
                                                    {{ $item -> products -> productCategories -> name }}
                                                </span>
                                                <div class="p-2 w-2/12">
                                                    <img class="rounded-md mx-auto h-16 w-8 object-cover" src="{{ asset("storage/product-images")."/".$item -> products -> productImage -> image_path }}" alt="">
                                                    <span class="flex justify-center font-medium text-xs truncate">{{ $item -> product_qty }} Item</span>
                                                </div>
                                                <div class="p-2 border-l w-10/12">
                                                    <span class="w-full line-clamp-2 pt-2 flex items-center font-medium">
                                                        {{ $item->products->name }}
                                                    </span>
                                                    @php $subtotalWeight = 0 @endphp
                                                    @php $subtotalWeight += $item -> products -> weight * $item->product_qty @endphp
                                                    <span class="text-xs my-1">{{ $item -> products -> weight }} gram</span><br>
                                                    <span class="text-xs my-1">@ @currency($item->products->price)</span>
                                                </div>
                                                <span class="absolute bottom-0 right-0 text-red-400 font-medium text-lg rounded-tr rounded-bl px-2">
                                                    @php $subtotal = 0 @endphp
                                                    @php $subtotal += $item->products->price * $item->product_qty; @endphp
                                                    @currency($subtotal)
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                    @php $total += $item->products->price * $item->product_qty; @endphp
                                    @php $totalWeight += $subtotalWeight; @endphp
                                    @php $totalProduct += $item -> product_qty; @endphp
                                @endforeach
                                <div class="text-md text-gray-400 mt-4">Berat total ({{ $totalProduct }}):
                                    <div class="text-md inline-block text-center ml-2 text-red-500">{{ $totalWeight }} gram</div>
                                </div>
                            </div>
                            <div class="w-full lg:w-1/2 mt-6 lg:mt-0 text-white" style="min-height: 450px">
                                <div class="main-floating-div h-25rem lg:h-full w-full relative flex justify-center">
                                    <div class="floating-div floating-div-top relative w-full bg-red-300 rounded-lg p-4 flex justify-center">
                                        <form class="w-full" id="submit_form"
                                              method="POST"
                                              action="{{ route('customer.checkout.store', $cart->id) }}"
                                              data-parsley-validate=""
                                              role="form"
                                        >
                                        @csrf
                                        <input type="hidden" name="price" id="price" value="{{ $total }}">
                                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                                        <input type="hidden" name="etd" id="etd" value="0">

                                        <div class="text-md text-gray-400">
                                            <div class="shipment" id="center-option">
                                                <label for="select_courier" class="text-white">Pilih Kurir<span class="text-yellow-300 inline-block float-right" id="parsley_error_courier"></span></label>
                                                <select style="max-height: 33px;" id="select_courier" name="couriers" class="w-full py-3" required data-parsley-required-message="Anda belum memilih jasa pengiriman!" data-parsley-errors-container="#parsley_error_courier">
                                                    <option value="" selected disabled>Pilih Kurir Pengiriman</option>
                                                    <option value="jne">Jalur Nugraha Ekakurir (JNE)</option>
                                                    <option value="tiki">Citra Van Titipan Kilat (TIKI)</option>
                                                    <option value="pos">Pos Indonesia (POS)</option>
                                                </select>
                                            </div>
                                            <div class="shipment" id="center-option">
                                                <label for="select_service" class="text-white">Pilih Pengiriman<span class="text-yellow-300 inline-block float-right" id="parsley_error_service"></span></label>
                                                <select style="max-height: 33px;" id="select_service" name="service" class="w-full py-3" required data-parsley-required-message="Anda belum memilih layanan pengiriman!" data-parsley-errors-container="#parsley_error_service">
                                                    {{--<option value="0">free</option>--}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="pt-3">
                                            <label for="note" class="text-md text-gray-400"></label>
                                            <textarea id="note" name="note" class="resize-none border border-gray-400 rounded w-full py-2 px-3 focus:outline-none focus:ring-gray-100 text-black" placeholder="Tambah catatan (opsional)"></textarea>
                                        </div>
                                        <div class="flex justify-between border-b-2 py-3">
                                            <span class="text-grey-400">Total Belanja:</span>
                                            <span class="inline-block text-right">@currency($total)</span>
                                        </div>
                                        <div class="flex justify-between border-b-2 py-3">
                                            <span class="text-grey-400">Biaya Pengiriman:</span>
                                            <span class="inline-block text-right" id="shippingCost">0</span>
                                        </div>
                                        <div class="flex justify-between py-3 text-xl">
                                            <span class="text-grey-400">Total Tagihan:</span>
                                            <span class="inline-block text-right" id="grand_total">@currency($total)</span>
                                        </div>
                                            <button type="submit" class="h-12 mt-6 w-full float-right bg-red-500 rounded text-white focus:outline-none hover:bg-red-600">Konfirmasi Pesanan</button>
                                        </form>
                                    </div>
                                </div>
                            </div >
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <style>
        .min-h-checkout {
            min-height: 425px;
        }

        @media (min-width: 1024px) {
            .floating-div {
                height: fit-content;
                position: absolute!important;
            }
            .floating-div-fixed {
                position: fixed!important;
                top: 10%;
            }
            .floating-div-top {
                position: absolute;
                top: 0;
            }
            .floating-div-bottom {
                position: absolute;
                bottom: 0;
            }
        }
    </style>

@endsection


@section('script')

    <script>
        // Function to set the width of floating-div-fixed
        function setWidth() {
            const parentWidth = $('.main-floating-div').width();
            $('.floating-div-fixed').width(parentWidth - 33);
        }
        // Set the width of floating-div-fixed on page load
        $(document).ready(function() {
            setWidth();
        });
        // Set the width of floating-div-fixed whenever the window is resized
        $(window).resize(function() {
            setWidth();
        });
        const floatPosStart = $('.floating-div').offset().top - (parseFloat($('.floating-div').css('paddingTop').replace(/auto/, 0)) + 60);
        const floatPosEnd = $('.main-floating-div').offset().top + $('.main-floating-div').innerHeight() - $('.floating-div').outerHeight(true) - 89 - 20;
        $(window).scroll(function () {
            setWidth();
            const y = $(this).scrollTop();
            if (y >= floatPosStart && y <= floatPosEnd) {
                $('.floating-div').removeClass('floating-div-top').addClass('floating-div-fixed');
                setWidth();
            } else if ( y >= floatPosEnd){
                $('.floating-div').removeClass('floating-div-fixed').addClass('floating-div-bottom');
                setWidth();
            } else {
                $('.floating-div').removeClass('floating-div-fixed').addClass('floating-div-top');
                setWidth();
            }
            setWidth();
        });
    </script>

    <script>
        $(document).ready(function() {

            let select_courier = $("#select_courier");
            let selectService = $("#select_service");
            let price = $("#price").val();

            selectService.prop('disabled', true);
            select_courier.select2({
                minimumResultsForSearch: Infinity,
                placeholder: "Pilih Kurir",
                searchInputPlaceholder: 'Cari Kurir...',
            });
            selectService.select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Pilih Layanan',
                searchInputPlaceholder: 'Cari Layanan...',
            });
            select_courier.change(function() {
                let shippingAgent = $(this).val();
                selectService.html("");
                $("#shippingCost").text("0");
                $("#grand_total").text(`Rp. ${(parseInt({{$total}})).toLocaleString("id-ID", {minimumFractionDigits: 0})}`);

                $.ajax({
                    url: '{{ route('customer.shipping.cost') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        shipping_agent: shippingAgent,
                        cart_id: {{ $cart->id }},
                    },
                    beforeSend: function() {
                        selectService.prop('disabled', true);
                        selectService.select2({
                            minimumResultsForSearch: Infinity,
                            placeholder: 'Memuat...',
                            escapeMarkup: function(markup) {
                                return markup;
                            },
                        });
                        selectService.data('select2').$container.find('.select2-selection--single .select2-selection__rendered').prepend($('<span>', {class: 'select2-spinner'}).append($('<i>', {class: 'fa-solid fa-fan fa-spin text-slate-400 mr-2'})));
                    },
                    success: function(data) {
                        selectService.prop('disabled', false);
                        selectService.empty().append('<option value=""></option>');
                        selectService.select2({
                            minimumResultsForSearch: Infinity,
                            placeholder: 'Pilihian Layanan Tersedia',
                        });
                        $.each(data, function(index, service) {
                            let option = $('<option>')
                                .val(service.description)
                                .text(service.description + ' (' + service.etd + ' Hari) - ' + 'Rp.' + service.shipping_cost.toLocaleString("id-ID"))
                                .data('shipping-cost', service.shipping_cost)
                                .data('service', service.description)
                                .data('etd', service.etd);
                            selectService.append(option);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        selectService.prop('disabled', false);
                        selectService.select2({
                            minimumResultsForSearch: Infinity,
                            placeholder: 'Layanan Pengiriman Tidak tersedia',
                        });
                    }
                });

                selectService.change(function() {
                    // get selected shipping data
                    let shipping_cost = $(this).find(":selected").data("shipping-cost");
                    let service = $(this).find(":selected").data("service");
                    let etd = $(this).find(":selected").data("etd");

                    // menjumlahkan data harga
                    let shippingCost = `Rp. ${(parseInt(shipping_cost)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;
                    let grand_total = `Rp. ${(parseInt(price) + parseInt(shipping_cost)).toLocaleString("id-ID", {minimumFractionDigits: 0})}`;

                    // ubah value element
                    $("#shippingCost").text(shippingCost);
                    $("#grand_total").text(grand_total);

                    // Tanpa format uang
                    $("#shipping_cost").val(shipping_cost);
                    $("#service").val(service);
                    $("#etd").val(etd);
                });

            });
        });
    </script>

@endsection
