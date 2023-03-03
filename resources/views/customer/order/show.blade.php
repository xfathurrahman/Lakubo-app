<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('my-order-detail') }}
    @endsection

        <!-- BEGIN: Reject Confirmation Modal -->
        <div id="confirm-order-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
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
        <!-- BEGIN: Content -->
        <div class="content mt-6">
            <!-- BEGIN: Transaction Details -->
            <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                    <div class="box p-5 rounded-md">
                        <div class="flex items-center tool border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Detail Pesanan</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex">
                                    <i class="fa-solid fa-passport mr-2 text-slate-500"></i>ID Pesanan
                                </span>:
                                </div>
                            </div>
                            {{ ($order->id) }}
                        </div>
                        @isset($order->note)
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex">
                                        <i class="fa-regular fa-note-sticky mr-2 text-slate-500"></i>Catatan
                                    </span>:
                                    </div>
                                </div>
                            </div>
                            <textarea disabled class="mt-1 bg-gray-200 text-sm text-gray-600 w-full px-2 rounded-md">{{ $order->note }}</textarea>
                        @endif
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex">
                                    <i class="fa-regular fa-calendar mr-2 text-slate-500"></i>
                                    Pesanan Dibuat
                                </span>:
                                </div>
                            </div>
                            {{ Carbon\Carbon::parse($order->transaction_time)->format('d F Y (H:i)') }}
                        </div>
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                @if($order -> transaction_status === 'awaiting_payment' || $order -> transaction_status === 'completed')
                                    <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex">
                                        <i class="fa-solid fa-arrow-right-arrow-left mr-2 text-slate-500"></i>Status Pembayaran
                                    </span>:
                                    </div>
                                @endif
                            </div>
                            <div class="inline-flex w-full">
                                @if($order -> transaction_status === 'awaiting_payment')
                                    <span class="bg-yellow-200 text-yellow-600 px-2 rounded-md">Menunggu Pembayaran</span>
                                @elseif($order -> transaction_status === 'completed')
                                    <span class="bg-green-200 text-green-600 px-2 rounded-md">Berhasil</span>
                                @endif
                            </div>
                        </div>

                        @if($order->status === 'awaiting_confirm')
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                                <span class="bg-blue-500 text-white px-2 rounded-md">Menunggu Konfirmasi.</span>
                            </div>
                        @elseif($order->status === 'confirmed')
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                                <span class="bg-green-200 text-green-600 px-2 rounded-md">Dikonfirmasi.</span>
                            </div>
                        @elseif($order->status === 'packing')
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                                <span class="bg-yellow-200 text-yellow-600 px-2 rounded-md">Dikemas.</span>
                            </div>
                        @elseif($order->status === 'delivered')
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                                <span class="bg-yellow-200 text-yellow-600 px-2 rounded-md">Dikirim</span>
                            </div>
                            <div class="items-center mt-4 pt-4 border-t border-slate-200">
                                <div class="bg-yellow-200 text-yellow-600 p-2 mb-2 rounded-md text-center">
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
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                                <span class="bg-red-200 text-red-600 px-2 rounded-md">Dibatalkan.</span>
                            </div>
                            @isset($order->reject_msg)
                                <div class="flex items-center mt-2">
                                    <div class="inline-flex mr-2">
                                        <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex text-red-400">
                                        <i class="fa-regular fa-circle-xmark mr-1 text-red-400"></i>Alasan Pembatalan
                                    </span>:
                                        </div>
                                    </div>
                                </div>
                                <textarea disabled class="mt-1 bg-gray-200 text-sm text-gray-600 w-full px-2 rounded-md">{{ $order->reject_msg }}</textarea>
                            @endif
                        @endif
                    </div>
                    <div class="box p-5 rounded-md mt-5">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Detail Tagihan</div>
                            @if($order->transaction_status === 'awaiting_payment')
                                <div class="items-center ml-auto text-primary">
                                    <a href="{{ $order->pdf_url }}" class="inline-flex">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Unduh Tagihan
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center mt-3">
                            <div class="flex items-center">
                            <span class="w-40 inline-flex">
                                <i class="fa-regular fa-credit-card mr-2 text-slate-500"></i>Metode Pembayaran
                            </span>:
                            </div>
                            @if($order->payment_type === 'bank_transfer')
                                <div class="ml-2">Bank Transfer</div>
                            @elseif($order->payment_type === 'cstore')
                                <div class="ml-2">Indomaret</div>
                            @endif
                        </div>
                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                            <span class="w-40 inline-flex">
                                <i class="fa-solid fa-dolly mr-2 text-slate-500"></i>Subtotal ({{ $order->orderItems->count() }} Item)
                            </span>:
                            </div>
                            <div class="ml-2">@currency($order->subtotal)</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                            <span class="w-40 inline-flex">
                                <i class="fa-solid fa-truck-fast mr-2 text-slate-500"></i>Biaya Pengiriman
                            </span>:
                            </div>
                            <div class="ml-2">@currency($order->orderShipping->shipping_cost)</div>
                        </div>
                        <div class="flex items-center mt-3 font-medium">
                            <div class="flex items-center justify-between">
                            <span class="w-40 inline-flex">
                                <i class="fa-solid fa-circle-dollar-to-slot mr-2 text-slate-500"></i>Total Tagihan
                            </span>:
                            </div>
                            <div class="ml-2">@currency($order->grand_total)</div>
                        </div>

                        @if($order->transaction_status === 'unpaid')
                            <div class="flex items-center border-y border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5">
                                <form id="submit_form" method="POST" action="{{ route('customer.order.update', $order->id) }}">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="json" id="json_callback">
                                </form>
                                <button id="pay-button" class="h-12 w-full bg-red-400 rounded text-white focus:outline-none hover:bg-red-500">PILIH PEMBAYARAN</button>
                            </div>
                        @elseif($order->transaction_status === 'awaiting_payment')
                            <div class="flex items-center border-y border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5">
                                <div class="font-medium text-base truncate pb-5">Selesaikan Pembayaran</div>
                            </div>
                            @isset($order->bank)
                                <div class="mt-2 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="inline-flex">
                                            <div class="flex items-center justify-between">
                                                <span class="w-40 inline-flex">
                                                    <i class="fa-solid fa-building-columns mr-2 text-slate-500"></i>Bank Tujuan
                                                </span>:
                                            </div>
                                        </div>
                                        <p class="ml-2 uppercase text-blue-500">{{ $order->bank }}</p>
                                    </div>
                                    <div class="lg:flex flex-col lg:flex-row items-center mt-2">
                                        <div class="lg:flex items-center justify-between mr-2">
                                            <span class="w-40 inline-flex">
                                                <i class="fa-solid fa-hashtag text-slate-500 mr-2"></i>Nomor VA
                                            </span>:
                                        </div>
                                        <div class="relative bg-gray-200 p-2 rounded flex justify-between">
                                            <input id="va_number" class="hidden" value="{{ $order->va_number }}">
                                            <span class="underline decoration-solid decoration-red-400"> {{ $order->va_number }}</span>
                                            <button id="copy-va-number" class="text-gray-500 hover:text-gray-600 focus:outline-none ml-2">
                                                <i class="fas fa-copy text-gray-400"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex items-center mt-2">
                                        <div class="inline-flex">
                                            <div class="flex items-center justify-between">
                                                <span class="w-40 inline-flex">
                                                    <i class="fa-solid fa-hourglass-half text-slate-500 mr-2"></i>Bayar Dalam
                                                </span>:
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-yellow-200 rounded-md p-2 mt-2">
                                        <div class="text-blue-500 mb-2 text-center" id="countdown"></div>
                                        <span>Catatan: Perhatikan batas waktu pembayaran agar pesanan tidak dibatalkan otomatis oleh sistem.</span>
                                    </div>
                                </div>
                            @endisset
                            @isset($order->payment_code)
                                <div class="mt-2 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="inline-flex">
                                            <div class="flex items-center justify-between">
                                                <span class="w-40 inline-flex">
                                                    <i class="fa-solid fa-store text-slate-500 mr-2"></i>Gerai Pembayaran
                                                </span>:
                                            </div>
                                        </div>
                                        <p class="ml-2 uppercase text-blue-500">Indomaret</p>
                                    </div>

                                    <div class="flex items-center mt-2">
                                        <div class="flex items-center justify-between">
                                            <span class="w-40 inline-flex">
                                                <i class="fa-solid fa-hashtag text-slate-500 mr-2"></i>Kode Pembayaran
                                            </span>:
                                        </div>
                                    </div>

                                    <div class="w-full items-center text-center">
                                        <div class="mt-2 flex justify-center">{!! DNS2D::getBarcodeHTML($order->payment_code, 'QRCODE',6,6) !!}</div>
                                        <div class="relative inline-flex">
                                            <div class="mt-1">{{ $order->payment_code }}</div>
                                            <input id="payment_code" class="hidden" value="{{ $order->payment_code }}">
                                            <button id="copy-payment-code" class="text-gray-500 hover:text-gray-600 focus:outline-none ml-2">
                                                <i class="fas fa-copy text-gray-400"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between mt-2">
                                        <div class="inline-flex">
                                            <i class="fa-solid fa-hourglass-half text-slate-500 mr-2"></i>
                                            Bayar dalam :
                                        </div>
                                        <div class="text-blue-500" id="countdown"></div>
                                    </div>
                                    <div class="bg-yellow-200 rounded-md p-2 mt-2">
                                        <span>Catatan : Perhatikan batas waktu pembayaran agar pesanan tidak dibatalkan otomatis oleh sistem.</span>
                                    </div>
                                </div>
                            @endisset
                        @endif
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                    <div class="box p-5 rounded-md">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Produk yang dipesan</div>
                        </div>
                        @php $totalWeight = 0 @endphp
                        @php $totalProduct = 0 @endphp
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center mb-2">
                                <div class="inline-flex items-center text-xs lg:text-sm w-full h-fit bg-gray-100 rounded-lg transform hover:translate-y-1 hover:shadow-xl transition duration-300 border-1">
                                    <span class="absolute top-0 right-0 text-white bg-red-400 text-xs rounded-tr rounded-bl px-2">
                                        <i class="fa-solid fa-tag mx-1"></i>
                                        {{ $item -> products -> productCategories -> name }}
                                    </span>
                                    <div class="p-2 w-2/12">
                                        <img class="rounded-md mx-auto h-16 w-8 object-cover" src="{{ asset("storage/product-image")."/".$item -> products -> productImage -> image_path }}" alt="">
                                        <span class="flex justify-center font-medium text-xs truncate">{{ $item -> quantity }} Item</span>
                                    </div>
                                    <div class="p-2 border-l w-10/12">
                                        <span class="w-full truncate pt-2 flex items-center font-medium">{{ $item->products->name }}</span>
                                        @php $subtotalWeight = 0 @endphp
                                        @php $subtotalWeight += $item -> products -> weight * $item->quantity @endphp
                                        <span class="text-xs my-1">{{ $item -> products -> weight }} gram</span><br>
                                        <span class="text-xs my-1">@ @currency($item->products->price)</span>
                                    </div>
                                    <span class="absolute bottom-0 right-0 text-red-400 font-medium text-lg rounded-tr rounded-bl px-2">
                                        @currency($item->subtotal)
                                    </span>
                                </div>
                            </div>
                            @php $totalWeight += $subtotalWeight; @endphp
                            @php $totalProduct += $item -> quantity; @endphp
                        @endforeach
                        <div class="text-md text-gray-400 mt-4">Berat total ({{ $totalProduct }}) produk:
                            <div class="text-md inline-block text-center ml-2 text-red-500">{{ $totalWeight }} gram</div>
                        </div>
                    </div>
                    <div class="box p-5 rounded-md mt-5 mb-4">
                        <div class="flex items-center dark:border-darkmode-400">
                            <div class="font-medium text-base truncate">Detail Pengiriman</div>
                        </div>
                        <div class="envelope-lines my-5"></div>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i class="fa-solid fa-people-carry-box text-slate-500 mr-2"></i>Nama Penerima</span>:
                            </div>
                            <span class="ml-2">{{ $order->customer_name }}</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i class="fa-solid fa-phone-flip text-slate-500 mr-3"></i>No Handphone</span>:
                            </div>
                            <span class="ml-2">+62{{ ltrim($order->customer_phone, '0') }}</span>
                        </div>

                        <div class="lg:inline-flex lg:items-center">
                            <div class="flex items-center mt-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex"><i class="fa-solid fa-map-location-dot text-slate-500 mr-2.5"></i>Alamat Penerima</span>:
                                </div>
                            </div>
                            <div class="capitalize_address lg:-mb-3 mt-1 lg:mt-0 bg-gray-200 rounded-md p-2 lg:bg-transparent lg:p-0">
                                {{ $order->orderAddress->detail_address }},
                                {{ $order->orderAddress->village->name }},
                                {{ $order->orderAddress->district->name }},
                                {{ $order->orderAddress->regency->name }},
                                {{ $order->orderAddress->province->name }}.
                            </div>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i class="fa-solid fa-truck-fast text-slate-500 mr-2"></i>Kurir</span>:
                            </div>
                            <span class="ml-2">JNE ({{ $order->orderShipping->service }})</span>
                        </div>

                        <div class="flex items-center mt-3 mb-1">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex">
                                    <i class="fa-solid fa-hourglass-start text-slate-500 w-4 h-4 mr-2 text-center"></i>Estimasi Pengiriman
                                </span>:
                            </div>
                            @if($order->orderShipping->etd === '1-1')
                                <span class="ml-2">1 Hari</span>
                            @else
                                <span class="ml-2">{{ $order->orderShipping->etd }} Hari pengiriman</span>
                            @endif
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center mt-3">
                            <div class="flex items-start justify-between">
                                <span class="w-40 inline-flex">
                                    <i class="fa-solid fa-magnifying-glass-location text-slate-500 ml-0.5 mr-2"></i>Nomor Resi
                                </span>:
                            </div>
                            <div class="mt-2 sm:mt-0 xs:ml-2 flex items-center">
                                @isset($order->orderShipping->tracking_number)
                                    <div class="relative">
                                        <input id="tracking_no" class="hidden" value="{{ $order->orderShipping->tracking_number }}">
                                        <span class="w-full">{{ $order->orderShipping->tracking_number }}</span>
                                        <button id="copy-tracking-no" class="text-gray-500 hover:text-gray-600 focus:outline-none ml-2">
                                            <i class="fas fa-copy text-gray-400"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="w-full text-primary">Belum tersedia.</span>
                                @endisset
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END: Transaction Details -->
        </div>
        <!-- END: Content -->
    @else
        Data tidak ditemukan
    @endif

    @section('script')
        <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js"
                data-client-key="config('midtrans.client_key')"></script>

        <script type="text/javascript">
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
            $(document).ready(function () {
                $("#copy-tracking-no").click(function() {
                    let copyText = document.getElementById("tracking_no");
                    copyText.setSelectionRange(0, 99999); // mengatur range seleksi dari karakter 0 hingga 99999
                    let button = this; // simpan referensi ke tombol yang diklik
                    navigator.clipboard.writeText(copyText.value).then(function() {
                        let tooltip = document.createElement("div");
                        tooltip.innerHTML = "Disalin!";
                        tooltip.classList.add("tooltip-copy");
                        $(button).closest('div').append(tooltip);// gunakan referensi tombol untuk menambahkan tooltip
                        setTimeout(function() {
                            $(tooltip).fadeOut("fast", function() {
                                $(this).remove();
                            });
                        }, 1000);
                    }, function() {
                        console.error("Tidak dapat menyalin teks");
                    });
                });

                $("#copy-payment-code").click(function() {
                    let copyText = document.getElementById("payment_code");
                    copyText.setSelectionRange(0, 99999); // mengatur range seleksi dari karakter 0 hingga 99999
                    let button = this; // simpan referensi ke tombol yang diklik
                    navigator.clipboard.writeText(copyText.value).then(function() {
                        let tooltip = document.createElement("div");
                        tooltip.innerHTML = "Disalin!";
                        tooltip.classList.add("tooltip-copy");
                        $(button).closest('div').append(tooltip);// gunakan referensi tombol untuk menambahkan tooltip
                        setTimeout(function() {
                            $(tooltip).fadeOut("fast", function() {
                                $(this).remove();
                            });
                        }, 1000);
                    }, function() {
                        console.error("Tidak dapat menyalin teks");
                    });
                });

                $("#copy-va-number").click(function() {
                    let copyText = document.getElementById("va_number");
                    copyText.setSelectionRange(0, 99999); // mengatur range seleksi dari karakter 0 hingga 99999
                    let button = this; // simpan referensi ke tombol yang diklik
                    navigator.clipboard.writeText(copyText.value).then(function() {
                        let tooltip = document.createElement("div");
                        tooltip.innerHTML = "Disalin!";
                        tooltip.classList.add("tooltip-copy");
                        $(button).closest('div').append(tooltip);// gunakan referensi tombol untuk menambahkan tooltip
                        setTimeout(function() {
                            $(tooltip).fadeOut("fast", function() {
                                $(this).remove();
                            });
                        }, 1000);
                    }, function() {
                        console.error("Tidak dapat menyalin teks");
                    });
                });

                @if($order->transaction_expire)
                // hitung countdown expire transaksi
                const transactionExpire = new Date('<?= $order->transaction_expire ?>');
                const countDownDate = new Date(transactionExpire).getTime();
                const countdown = $("#countdown");
                const x = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;
                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    countdown.html(`${days > 0 ? days + ' hari ' : ''}${hours} jam ${minutes} menit ${seconds} detik`);
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
