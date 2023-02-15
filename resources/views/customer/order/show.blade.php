<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('my-order-detail') }}
    @endsection

    @if(isset($order))
        <!-- BEGIN: Content -->
        <div class="content mt-6">
            {{--@if($order->transaction_status === 'completed')
                <div class="alert bg-green-500 alert-dismissible show flex justify-center my-2" role="alert">
                    <span class="font-medium text-lg text-white">Pembayaran anda telah kami terima, menunggu konfirmasi pelapak.</span>
                    <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                        <i data-lucide="x" class="w-4 h-4 text-white"></i>
                    </button>
                </div>
            @endif--}}
            <div class="intro-y flex flex-col sm:flex-row items-center">
                {{--<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Print</button>
                    <div class="dropdown ml-auto sm:ml-0">
                        <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"
                                                                                       data-lucide="plus"></i> </span>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i>
                                        Export Word </a>
                                </li>
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i>
                                        Export PDF </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>--}}
            </div>
            <!-- BEGIN: Transaction Details -->
            <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                    <div class="box p-5 rounded-md">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Detail Pesanan</div>
                        </div>
                        @if($order->transaction_status === 'completed')
                        <div class="flex items-center justify-between">
                            <div class="inline-flex">
                                <i data-lucide="archive" class="w-4 h-4 text-slate-500 mr-2"></i>
                                Status Pesanan:
                            </div>
                            @if($order->status === 'pending')
                                <span class="bg-blue-400 text-white px-2 rounded-md">Menunggu Konfirmasi Pelapak.</span>
                            @elseif($order->status === 'processing')
                                <span class="bg-blue-400 text-white px-2 rounded-md">Diproses.</span>
                            @elseif($order->status === 'completed')
                                <span class="bg-blue-400 text-white px-2 rounded-md">Selesai.</span>
                            @elseif($order->status === 'shipped')
                                <span class="bg-blue-400 text-white px-2 rounded-md">Dikirim.</span>
                            @endif
                        </div>
                        @endif
                        @if($order->transaction_status === 'cancel')
                            <div class="flex items-center justify-between">
                                <div class="inline-flex">
                                    <i data-lucide="archive" class="w-4 h-4 text-slate-500 mr-2"></i>
                                    Status Pesanan:
                                </div>
                                @if($order->status === 'cancelled')
                                    <span class="bg-red-400 text-white px-2 rounded-md">Pesanan Dibatalkan.</span>
                                @endif
                            </div>
                        @endif
                        <div class="flex items-center mt-3">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex"><i data-lucide="file-text" class="w-4 h-4 text-slate-500 mr-2"></i>ID Pesanan</span>:
                                </div>
                            </div>
                            {{ ($order->id) }}
                        </div>
                        <div class="flex items-center mt-3">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex"><i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>Pesanan Dibuat</span>:
                                </div>
                            </div>
                            {{ Carbon\Carbon::parse($order->transaction_time)->format('d F Y (H:i)') }}
                        </div>
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                @if($order -> transaction_status === 'pending' || $order -> transaction_status === 'completed')
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Status Transaksi</span>:
                                    </div>
                                @endif
                            </div>
                            <div class="inline-flex">
                                @if($order -> transaction_status === 'pending')
                                    <span class="bg-yellow-400 text-white px-2 rounded-md">Menunggu Pembayaran.</span>
                                @elseif($order -> transaction_status === 'completed')
                                    <span class="bg-green-500 text-white px-2 rounded-md">Pembayaran Berhasil.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box p-5 rounded-md mt-5">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Detail Tagihan</div>
                            @if($order->transaction_status === 'pending')
                                <div class="items-center ml-auto text-primary">
                                    <a href="{{ $order->pdf_url }}" class="inline-flex">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Unduh Tagihan
                                    </a>
                                </div>
                            @endif
                        </div>
                        {{--<div class="flex items-center">
                            <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Metode Pembayaran:
                            <div class="ml-auto">{{ $order->payment_type }}</div>
                        </div>--}}
                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Subtotal ({{ $order->orderItems->count() }} Item)</span>:
                            </div>
                            <div class="ml-auto">@currency($order->subtotal)</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Biaya Pengiriman</span>:
                            </div>
                            <div class="ml-auto">@currency($order->orderShipping->shipping_cost)</div>
                        </div>
                        <div class="flex items-center mt-3 font-medium">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Total Tagihan</span>:
                            </div>
                            <div class="ml-auto">@currency($order->grand_total)</div>
                        </div>
                        <div class="flex items-center border-y border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5">
                            @if($order->transaction_status === 'unpaid')
                                <form id="submit_form" method="POST" action="{{ route('customer.order.update', $order->id) }}">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="json" id="json_callback">
                                </form>
                                <button id="pay-button" class="h-12 w-full bg-red-400 rounded text-white focus:outline-none hover:bg-red-500">PILIH PEMBAYARAN</button>
                            @else
                                <div class="font-medium text-base truncate pb-5">Selesaikan Pembayaran</div>
                            @endif
                        </div>
                        @if($order->transaction_status === 'pending' && $order->bank)
                            <div class="mt-2 rounded-lg">
                                <div class="flex items-center">
                                    <div class="inline-flex">
                                        <div class="flex items-center justify-between">
                                            <span class="w-40 inline-flex"><i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Bank Tujuan</span>:
                                        </div>
                                    </div>
                                    <p class="ml-2 uppercase text-blue-500">{{ $order->bank }}</p>
                                </div>
                                <div class="flex items-center mt-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Nomor VA</span>:
                                    </div>
                                    <span class="ml-2 underline decoration-solid decoration-red-400"> {{ $order->va_number }}</span>
                                    <button class="relative font-bold px-2 rounded" id="copy-btn">
                                        <i data-lucide="copy" class="w-4 h-4 text-slate-500 -mb-0.5"></i>
                                        <span class="hidden absolute -top-10 -right-2 mt-2 py-1 px-2 bg-black opacity-50 text-white rounded" id="tooltip">Disalin!</span>
                                    </button>
                                </div>
                                <div class="flex items-center mt-2">
                                    <div class="inline-flex">
                                        <div class="flex items-center justify-between">
                                            <span class="w-40 inline-flex"><i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i>Bayar Dalam</span>:
                                        </div>
                                    </div>
                                    <div class="text-blue-500 ml-2" id="countdown"></div>
                                </div>
                                <div class="bg-yellow-200 rounded-md p-2 mt-2">
                                    <span>Catatan: Perhatikan batas waktu pembayaran agar pesanan tidak dibatalkan otomatis oleh sistem.</span>
                                </div>
                            </div>
                        @elseif($order->transaction_status === 'pending' && $order->payment_code)
                            <div class="bg-green-100 p-2 mt-3 rounded-lg">
                                <div class="flex items-center justify-between mt-2">
                                    <div class="inline-flex">
                                        <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Gerai Pembayaran :
                                    </div>
                                    <p class="ml-1 uppercase text-blue-500">Indomaret</p>
                                </div>
                                <div class="flex items-center mt-2">
                                    <i data-lucide="activity" class="w-4 h-4 text-slate-500 mr-2"></i> Kode Pembayaran:
                                </div>
                                <div class="flex justify-center mt-2">{!! DNS2D::getBarcodeHTML($order->payment_code, 'QRCODE',6,6) !!}</div>
                                <div class="flex justify-center mt-1">{{ $order->payment_code }}</div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="inline-flex">
                                        <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>
                                        Bayar dalam :
                                    </div>
                                    <div class="text-blue-500" id="countdown"></div>
                                </div>
                                <div class="bg-yellow-200 rounded-md p-2 mt-2">
                                    <span>Catatan : Perhatikan batas waktu pembayaran agar pesanan tidak dibatalkan otomatis oleh sistem.</span>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                    <div class="box p-5 rounded-md">
                        <div class="overflow-auto lg:overflow-visible -mt-3">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap !py-5">Produk</th>
                                    <th class="whitespace-nowrap text-right">@Harga</th>
                                    <th class="whitespace-nowrap text-right">Kuantitas</th>
                                    <th class="whitespace-nowrap text-right">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="!py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <img alt="#"
                                                         src="{{ asset("storage/product-image")."/".$item-> products -> productImage -> image_path }}"
                                                         title="Uploaded {{ Carbon\Carbon::parse($item -> products -> created_at)->diffForHumans() }}">
                                                </div>
                                                <a href=""
                                                   class="font-medium whitespace-nowrap ml-4">{{ $item -> products -> name }}</a>
                                            </div>
                                        </td>
                                        <td class="text-right">@currency($item->products->price)</td>
                                        <td class="text-right">{{ $item -> quantity }}</td>
                                        <td class="text-right">@currency($item->subtotal)</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box p-5 rounded-md mt-5">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Detail Pengiriman</div>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i data-lucide="user" class="w-4 h-4 text-slate-500 mr-2"></i>Nama Penerima</span>:
                            </div>
                            <span class="ml-2">{{ $order->customer_name }}</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i data-lucide="smartphone" class="w-4 h-4 text-slate-500 mr-2"></i>No Handphone</span>:
                            </div>
                            <span class="ml-2">+62{{ ltrim($order->customer_phone, '0') }}</span>
                        </div>

                        <div class="lg:inline-flex lg:items-center">
                            <div class="flex items-center mt-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex"><i data-lucide="map" class="w-4 h-4 text-slate-500 mr-2"></i>Alamat Penerima</span>:
                                </div>
                            </div>
                            <div class="capitalize_address lg:-mb-3 bg-gray-200 rounded-md p-2 lg:bg-transparent lg:p-0">
                                {{ $order->orderAddress->detail_address }},
                                {{ $order->orderAddress->village->name }},
                                {{ $order->orderAddress->district->name }},
                                {{ $order->orderAddress->regency->name }},
                                {{ $order->orderAddress->province->name }}.
                            </div>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i data-lucide="zap" class="w-4 h-4 text-slate-500 mr-2"></i>Kurir</span>:
                            </div>
                            <span class="ml-2">JNE ({{ $order->orderShipping->service }})</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex"><i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>Estimasi Pengiriman</span>:
                            </div>
                            <span class="ml-2">{{ $order->orderShipping->etd }} Hari</span>
                        </div>

                        @isset($order->orderShipping->tracking_number)
                            <div class="flex items-center mt-3">
                                <div class="flex items-center mt-3">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i data-lucide="search" class="w-4 h-4 text-slate-500 mr-2"></i>Nomor Resi</span>:
                                    </div>
                                </div>
                                <div class="inline-flex items-center">
                                    <span class="w-32">{{ $order->orderShipping->tracking_number }}</span>
                                    <i data-lucide="copy" class="w-4 h-4 text-slate-500 ml-2"></i>
                                </div>
                            </div>
                        @endisset

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
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
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
                const copyBtn = $('#copy-btn');
                const tooltip = $('#tooltip');

                copyBtn.click(function () {
                    navigator.clipboard.writeText('{{ $order->va_number }}').then(function () {
                        tooltip.removeClass('hidden');
                        setTimeout(function () {
                            tooltip.addClass('hidden');
                        }, 1500);
                    }, function () {
                        console.error('Gagal menyalin ke clipboard');
                    });
                });
                @isset($order->transaction_expire)
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
                @endisset
            });
        </script>

    @endsection

</x-app-layout>
