<x-app-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('my-order-detail') }}
    @endsection
        <!-- BEGIN: Reject Confirmation Modal -->
        <div id="confirm-order-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-4 text-center">
                            <div class="text-xl mt-5">Sudah terima pesanan?</div>
                            <div class="text-slate-500 mt-2">
                                Dengan mengkonfirmasi pesanan
                                <br>
                                Dana akan diteruskan ke pihak Pelapak.
                            </div>
                        </div>
                        <form action="{{ route('customer.order.confirm', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="px-5 pb-8 text-center">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Batal</button>
                                <button type="submit" class="btn btn-primary w-24">Ya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
    @if(isset($order))
        <!-- BEGIN: Transaction Details -->
        <div class="intro-y grid grid-cols-11 gap-5 mt-5">
            <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                <div class="box p-4 rounded-md text-xs sm:text-sm">
                    <div class="text-start border-b border-slate-100/60 dark:border-darkmode-400 pb-2 mb-2">
                        <div class="font-medium text-base truncate w-full">Detail Pesanan</div>
                        <div class="absolute top-2 right-2 bg-gray-100 px-1 mt-3 mr-2 rounded-sm text-gray-700">ID: {{ ($order->id) }}</div>
                        <p class="text-xs -mt-1">{{ Carbon\Carbon::parse($order->transaction_time)->format('d F Y (H:i)') }}</p>
                    </div>
                    @isset($order->note)
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                <span class="w-32 sm:w-40 inline-flex">
                                    <i class="fa-regular fa-note-sticky mr-2 text-slate-500"></i>Catatan
                                </span>:
                                </div>
                            </div>
                        </div>
                        <textarea disabled class="mt-1 bg-gray-100 text-sm text-gray-600 w-full px-2 rounded-md">{{ $order->note }}</textarea>
                    @endif
                    <div class="flex items-center mt-2">
                        <div class="inline-flex mr-2">
                            @if($order -> transaction_status === 'awaiting_payment' || $order -> transaction_status === 'completed' || $order -> transaction_status === 'choosing_payment')
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex">
                                        <i class="fa-solid fa-money-bill-wheat mr-2 text-slate-500"></i>Status Pembayaran
                                    </span>:
                                </div>
                            @endif
                        </div>
                        <div class="inline-flex w-full">
                            @if($order->transaction_status === 'choosing_payment')
                                <span class="bg-blue-100 text-blue-600 px-2 w-full text-center rounded-md">Memilih</span>
                            @elseif($order->transaction_status === 'awaiting_payment')
                                <span class="bg-yellow-100 text-yellow-600 px-2 w-full text-center rounded-md">Menunggu</span>
                            @elseif($order->transaction_status === 'completed')
                                <span class="bg-green-100 text-green-600 px-2 w-full text-center rounded-md">Berhasil</span>
                            @elseif($order->transaction_status === 'cancel')
                                <span class="bg-red-100 text-red-600 px-2 w-full text-center rounded-md">Gagal</span>
                            @endif
                        </div>
                    </div>
                    @if($order->status === 'awaiting_confirm')
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                            <span class="bg-yellow-100 text-yellow-600 w-full text-center px-2 rounded-md">Menunggu</span>
                        </div>
                    @elseif($order->status === 'confirmed')
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-600 w-full text-center px-2 rounded-md">Dikonfirmasi.</span>
                        </div>
                    @elseif($order->status === 'packing')
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                            <span class="bg-yellow-100 text-yellow-600 w-full text-center px-2 rounded-md">Dikemas.</span>
                        </div>
                    @elseif($order->status === 'delivered')
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-600 w-full text-center px-2 rounded-md">Dikirim</span>
                        </div>
                        <div class="items-center mt-4 pt-4 border-t border-slate-100">
                            <div class="bg-yellow-100 text-yellow-600 p-2 mb-2 rounded-md text-center">
                                Silahkan konfirmasi pesanan jika pesanan anda sudah sampai.
                            </div>
                            <button type="button" class="btn btn-primary w-full mr-2"
                                    data-tw-toggle="modal"
                                    data-tw-target="#confirm-order-modal">
                                <i class="fa-regular fa-circle-xmark mr-2"></i> Konfirmasi
                            </button>
                        </div>
                    @elseif($order->status === 'cancelled')
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                            <span class="bg-red-100 text-red-600 px-2 rounded-md text-center w-full">Dibatalkan</span>
                        </div>
                        @isset($order->reject_msg)
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                <span class="w-32 sm:w-40 flex items-center mb-1 text-red-400">
                                    <i class="fa-regular fa-circle-xmark mr-1 text-red-400"></i>Alasan Pembatalan
                                </span>:
                                    </div>
                                </div>
                            </div>
                            <textarea disabled class="mt-1 bg-gray-100 text-sm text-gray-600 w-full px-2 rounded-md">{{ $order->reject_msg }}</textarea>
                        @endif
                    @elseif($order->status === 'completed')
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-600 w-full text-center px-2 rounded-md">Selesai</span>
                        </div>
                    @endif

                </div>
                <div class="box p-4 rounded-md mt-5 text-xs sm:text-sm">
                    <div class="flex items-center border-b border-slate-100/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Detail Tagihan</div>
                        @if($order->transaction_status === 'awaiting_payment')
                            <div class="items-center ml-auto text-primary">
                                <a href="{{ $order->pdf_url }}" download="invoice-lakubo.pdf" class="inline-flex">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Unduh Tagihan
                                </a>
                            </div>
                        @endif
                    </div>
                    @isset($order->payment_type)
                        <div class="flex items-center mt-3">
                            <div class="flex items-center">
                            <span class="w-32 sm:w-40 inline-flex">
                                <i class="fa-regular fa-credit-card mr-2 text-slate-500"></i>Metode Pembayaran
                            </span>:
                            </div>
                            @if($order->payment_type === 'bank_transfer')
                                <div class="ml-2">Bank Transfer</div>
                            @elseif($order->payment_type === 'qris')
                                <div class="ml-2">Barcode (QRIS)</div>
                            @endif
                        </div>
                    @endisset
                    <div class="flex items-center mt-3">
                        <div class="flex items-center justify-between">
                        <span class="w-32 sm:w-40 inline-flex">
                            <i class="fa-solid fa-dolly mr-2 text-slate-500"></i>Subtotal ({{ $order->orderItems->count() }} Item)
                        </span>:
                        </div>
                        <div class="ml-2">@currency($order->subtotal)</div>
                    </div>
                    <div class="flex items-center mt-3">
                        <div class="flex items-center justify-between">
                        <span class="w-32 sm:w-40 inline-flex">
                            <i class="fa-solid fa-truck-fast mr-2 text-slate-500"></i>Biaya Pengiriman
                        </span>:
                        </div>
                        <div class="ml-2">@currency($order->orderShipping->shipping_cost)</div>
                    </div>
                    <div class="flex items-center mt-3 font-medium">
                        <div class="flex items-center justify-between">
                        <span class="w-32 sm:w-40 inline-flex">
                            <i class="fa-solid fa-circle-dollar-to-slot mr-2 text-slate-500"></i>Total Tagihan
                        </span>:
                        </div>
                        <div class="ml-2">@currency($order->grand_total)</div>
                    </div>

                    @if($order->transaction_status === 'choosing_payment')
                        <div class="flex items-center border-y border-slate-100/60 dark:border-darkmode-400 pt-5 mt-5">
                            <form id="submit_form" method="POST" action="{{ route('customer.order.update', $order->id) }}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="json" id="json_callback">
                            </form>
                            <button id="pay-button" class="h-12 w-full bg-red-400 rounded text-white focus:outline-none hover:bg-red-500">PILIH PEMBAYARAN</button>
                        </div>
                    @elseif($order->transaction_status === 'awaiting_payment')
                        <div class="flex items-center border-y border-slate-100/60 dark:border-darkmode-400 py-5 mt-3">
                            <div class="font-medium text-base truncate">Selesaikan Pembayaran</div>
                        </div>
                        @if($order->payment_type === 'bank_transfer')
                            <div class="mt-2 rounded-lg">
                                <div class="rounded my-4 border bg-yellow-50">
                                    <div class="flex justify-between px-4 py-1 bg-yellow-100 border-b rounded-t items-center">
                                        <i data-lucide="alert-triangle" class="inline-flex w-3 h-3"></i>
                                        <div class="text-blue-500 text-center" id="countdown"><i class="fa-solid fa-spinner fa-spin"></i></div>
                                        <i data-lucide="alert-triangle" class="inline-flex w-3 h-3"></i>
                                    </div>
                                    <div class="text-center p-1">Perhatikan batas waktu pembayaran agar pesanan tidak dibatalkan otomatis oleh sistem.</div>
                                </div>
                                <div class="relative bg-gray-100 p-1 rounded mt-1">
                                    <div class="text-center">
                                        <p class="inline-flex mr-2 uppercase">{{ $order->bank }} (VA) : </p>
                                        <p class="inline-flex underline decoration-solid decoration-red-400" id="va_number">{{ $order->va_number }}</p>
                                        <button onclick="copyToClipboard('#va_number')" class="text-gray-500 hover:text-gray-600 focus:outline-none ml-2">
                                            <i class="fas fa-copy text-gray-400"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-2 rounded-lg">
                                <div class="rounded mt-6 border bg-yellow-50">
                                    <div class="flex justify-between px-4 py-1 bg-yellow-100 border-b rounded-t items-center">
                                        <i data-lucide="alert-triangle" class="inline-flex w-3 h-3"></i>
                                        <div class="text-blue-500 text-center" id="countdown"><i class="fa-solid fa-spinner fa-spin"></i></div>
                                        <i data-lucide="alert-triangle" class="inline-flex w-3 h-3"></i>
                                    </div>
                                    <div class="text-center p-1">Perhatikan batas waktu pembayaran agar pesanan tidak dibatalkan otomatis oleh sistem.</div>
                                </div>
                                <div class="w-full items-center text-center -mt-2">
                                    <div class="mt-2 flex justify-center">
                                        <img src="{{ $barcodeUrl }}" alt="barcodeUrl">
                                    </div>
                                </div>
                                <div class="flex -mt-4 justify-center items-center">
                                    <p class="font-medium"> Kode Pembayaran QRIS </p>
                                    <a href="{{ $barcodeUrl }}" download="qris.png" class="ml-2 inline-flex text-red-400 items-center underline">
                                        Unduh<i class="fa-solid fa-cloud-arrow-down ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                <div class="box p-4 rounded-md text-xs sm:text-sm">
                    <div class="flex items-center justify-between border-b border-slate-100/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Produk yang dipesan</div>
                        <span class="text-red-400 font-medium"><i class="fa-solid fa-store mr-1"></i>
                            <a href="{{ route('store.details', $order->stores->id) }}">
                                {{ $order->stores->name }}
                            </a>
                        </span>
                    </div>
                    @php $totalWeight = 0 @endphp
                    @php $totalProduct = 0 @endphp
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center mb-2">
                            <a href="{{ route('product.detail', $item->products->id) }}" class="inline-flex items-center text-xs lg:text-sm w-full h-fit bg-gray-100 rounded-lg transform hover:translate-y-1 hover:shadow-xl transition duration-300 border-1">
                                <span class="absolute top-0 right-0 text-white bg-red-400 text-xs rounded-tr rounded-bl px-2">
                                    <i class="fa-solid fa-tag mx-1"></i>
                                    {{ $item ->products->productCategories-> name }}
                                </span>
                                <div class="p-2 w-2/12">
                                    <img class="rounded-md mx-auto h-16 w-8 object-cover" src="{{ asset("storage/product-images")."/".$item -> products -> productImage -> image_path }}" alt="">
                                    <span class="flex justify-center font-medium text-xs truncate">{{ $item->quantity }} Item</span>
                                </div>
                                <div class="p-2 border-l w-10/12">
                                    <span class="w-full truncate pt-2 flex items-center font-medium">{{ $item->products->name }}</span>
                                    @php $subtotalWeight = 0 @endphp
                                    @php $subtotalWeight += $item ->products->weight * $item->quantity @endphp
                                    <span class="text-xs my-1">{{ $item->products->weight }} gram</span><br>
                                    <span class="text-xs my-1">@ @currency($item->products->price)</span>
                                </div>
                                <span class="absolute bottom-0 right-0 text-red-400 font-medium text-lg rounded-tr rounded-bl px-2">
                                    @currency($item->subtotal)
                                </span>
                            </a>
                        </div>
                        @php $totalWeight += $subtotalWeight; @endphp
                        @php $totalProduct += $item ->quantity; @endphp
                    @endforeach
                    <div class="text-md text-gray-400 mt-4">Berat total ({{ $totalProduct }}) produk:
                        <div class="text-md inline-block text-center ml-2 text-red-500">{{ $totalWeight }} gram</div>
                    </div>
                </div>
                <div class="box p-4 rounded-md mt-5 text-xs sm:text-sm mb-4">
                    <div class="flex items-center dark:border-darkmode-400">
                        <div class="font-medium text-base truncate">Detail Pengiriman</div>
                    </div>
                    <div class="envelope-lines my-5"></div>

                    <div class="flex items-center mt-3">
                        <div class="flex items-center justify-between">
                            <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-people-carry-box text-slate-500 mr-2"></i>Nama Penerima</span>:
                        </div>
                        <span class="ml-2">{{ $order->customer_name }}</span>
                    </div>

                    <div class="flex items-center mt-3">
                        <div class="flex items-center justify-between">
                            <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-phone-flip text-slate-500 mr-3"></i>No Handphone</span>:
                        </div>
                        <span class="ml-2">+62{{ ltrim($order->customer_phone, '0') }}</span>
                    </div>

                    <div class="lg:inline-flex lg:items-center">
                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-map-location-dot text-slate-500 mr-2.5"></i>Alamat Penerima</span>:
                            </div>
                        </div>
                        <div class="capitalize_address lg:-mb-3 mt-1 lg:mt-0 bg-gray-100 rounded-md p-2 lg:bg-transparent lg:p-0">
                            {{ $order->orderAddress->detail_address }},
                            {{ $order->orderAddress->village->name }},
                            {{ $order->orderAddress->district->name }},
                            {{ $order->orderAddress->regency->name }},
                            {{ $order->orderAddress->province->name }}.
                        </div>
                    </div>

                    <div class="flex items-center mt-3">
                        <div class="flex items-center justify-between">
                            <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-truck-fast text-slate-500 mr-2"></i>Kurir</span>:
                        </div>
                        <span class="ml-2">JNE ({{ $order->orderShipping->service }})</span>
                    </div>

                    <div class="flex items-center mt-3 mb-1">
                        <div class="flex items-center justify-between">
                            <span class="w-32 sm:w-40 flex items-center justify-center">
                                <i class="fa-solid fa-hourglass-start text-slate-500 w-4 h-4 mr-2 text-center"></i>Estimasi Pengiriman
                            </span>:
                        </div>
                        @if($order->orderShipping->etd === '1-1')
                            <span class="ml-2">1 Hari</span>
                        @else
                            <span class="ml-2">{{ $order->orderShipping->etd }} Hari pengiriman</span>
                        @endif
                    </div>

                    <div class="flex items-center mt-3 mb-1">
                        <div class="flex items-center justify-between">
                            <span class="w-32 sm:w-40 flex items-center justify-start">
                                <i class="fa-solid fa-magnifying-glass-location text-slate-500 ml-0.5 mr-2"></i>Nomor Resi
                            </span>:
                        </div>
                        @isset($order->orderShipping->tracking_number)
                            <div class="relative">
                                <span id="tracking_number" class="w-full ml-2">{{ $order->orderShipping->tracking_number }}</span>
                                <button onclick="copyToClipboard('#tracking_number')" class="text-gray-500 hover:text-gray-600 focus:outline-none ml-2">
                                    <i class="fas fa-copy text-gray-400"></i>
                                </button>
                            </div>
                        @else
                            <span class="ml-2 text-red-400">Belum tersedia.</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <!-- END: Transaction Details -->
    @else
        Data tidak ditemukan
    @endif

    @section('script')
        <script src="{{ config('midtrans.is_production') == 'true' ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js'}}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            $(document).ready(function () {
                let SnapToken = '{{ $order->snap_token }}'
                let payButton = $("#pay-button");
                payButton.click(function () {
                    window.snap.pay(SnapToken, {
                        onSuccess: function (result) {
                            /* You may add your own implementation here */
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: "Pembayaran Berhasil!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log(result);
                            send_response_to_form(result);
                        },
                        onPending: function (result) {
                            /* You may add your own implementation here */
                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: "Menunggu Pembayaran Anda.",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log(result);
                            send_response_to_form(result);
                        },
                        onError: function (result) {
                            /* You may add your own implementation here */
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: "Pembayaran gagal!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log(result);
                            send_response_to_form(result);
                        },
                        onClose: function () {
                            /* You may add your own implementation here */
                            alert('you closed the popup without finishing the payment');
                        }
                    })
                });

                function send_response_to_form(result) {
                    document.getElementById('json_callback').value = JSON.stringify(result);
                    document.getElementById('submit_form').submit();
                }
            });
        </script>

        <script>
            function copyToClipboard(selector) {
            var element = document.querySelector(selector);
            if (!element) {
                console.error("Error: Selector '" + selector + "' not found");
                return;
            }
            var $temp = document.createElement("input");
            document.body.appendChild($temp);
            $temp.value = element.textContent;
            $temp.select();
            document.execCommand("copy");
            document.body.removeChild($temp);

            var tooltip = document.createElement("div");
            tooltip.classList.add("tooltip-copy");
            tooltip.textContent = "Disalin!";
            element.appendChild(tooltip);

            setTimeout(function() {
                element.removeChild(tooltip);
            }, 1000);
            }
        </script>

        <script>
            $(document).ready(function () {
                @if($order->transaction_expire)
                    // hitung countdown expire transaksi
                    const transactionExpire = new Date('<?= $order->transaction_expire ?>');
                    const countDownDate = new Date(transactionExpire).getTime();
                    const countdown = $("#countdown");
                    const x = setInterval(function() {
                        const now = new Date().getTime();
                        const distance = countDownDate - now;
                        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        if (hours === 0) {
                            countdown.html(`${minutes} menit ${seconds} detik`);
                        } else {
                            countdown.html(`${hours} jam ${minutes} menit ${seconds} detik`);
                        }
                        if (distance < 0) {
                            clearInterval(x);
                            countdown.html("Waktu Habis");
                        }
                    }, 1000);
                @endif
            });
        </script>

    @endsection

</x-app-layout>
