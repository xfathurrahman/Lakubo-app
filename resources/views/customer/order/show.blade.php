<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('my-order-detail') }}
    @endsection

    @if(isset($orders))
        <!-- BEGIN: Content -->
        <div class="content">
            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                    Detail Pesanan
                </h2>
                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Print</button>
                    <div class="dropdown ml-auto sm:ml-0">
                        <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export Word </a>
                                </li>
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export PDF </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Transaction Details -->
            <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                    <div class="box p-5 rounded-md">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Detail Transaksi</div>
                            @if($orders->transaction_status === 'pending')
                                <div class="items-center ml-auto text-primary">
                                    <a href="{{ $orders->pdf_url }}" class="inline-flex">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Unduh Tagihan
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Invoice: INV/{{ $orders->id }} </div>
                        <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Pesanan Dibuat: {{ Carbon\Carbon::parse($orders->created_at)->format('d F Y') }}</div>

                        <div class="flex items-center mt-3" id="refresh-status">
                            <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i> Status Transaksi:
                            <div class="bg-success/20 text-danger rounded px-2 ml-1 inline-flex">
                                <span>{{ $orders -> transaction_status }}</span>
                                <span>
                                    {{--Data ubah status--}}
                                    <input type="hidden" id="order_id" value="{{ $orders -> id }}">
                                    <input type="hidden" id="transaction_status" value="Sukses">
                                    <input type="hidden" id="status_code" value="200">
                                    <input type="hidden" id="gross_amount" value="{{ $orders -> gross_amount }}">
                                    {{--Data ubah status end--}}
                                    <button id="send_change_status" class="flex items-center ml-auto text-primary"><i data-lucide="refresh-ccw" class="w-4 h-4 ml-2 -mb-5"></i></button>
                                </span>
                            </div>
                        </div>

                        @if($orders->bank)
                            <div class="bg-green-100 p-2 mt-3 rounded-lg">
                                <div class="flex items-center"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Bayar sebelum: {{ $orders->transaction_time }}</div>
                                <div class="flex items-center my-3"> <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Bank: <p class="ml-1 uppercase">{{ $orders->bank }}</p> </div>
                                <div class="flex items-center">
                                    <i data-lucide="activity" class="w-4 h-4 text-slate-500 mr-2"></i> No VA: {{ $orders->va_number }}
                                    <button class="relative bg-red-400 hover:bg-red-500 text-white font-bold px-2 rounded ml-auto" id="copy-btn">Salin
                                        <span class="hidden absolute -top-10 -right-2 mt-2 py-1 px-2 bg-black opacity-50 text-white rounded" id="tooltip">Disalin!</span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="bg-green-100 p-2 mt-3 rounded-lg">
                                <div class="flex items-center"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Bayar sebelum: {{ $orders->transaction_time }}</div>
                                <div class="flex items-center my-3"> <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Pembayaran: <p class="ml-1 uppercase">Indomaret</p> </div>
                                <div class="flex items-center">
                                    <i data-lucide="activity" class="w-4 h-4 text-slate-500 mr-2"></i> Kode Pembayaran: {{ $orders->payment_code }}
                                    <button class="relative bg-red-400 hover:bg-red-500 text-white font-bold px-2 rounded ml-auto" id="copy-btn">Salin
                                        <span class="hidden absolute -top-10 -right-2 mt-2 py-1 px-2 bg-black opacity-50 text-white rounded" id="tooltip">Disalin!</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        {{--<div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">
                            @if($orders->transaction_status === 'unpaid')
                                <button id="pay-button" class="btn bg-red-500 text-white w-full">Bayar</button>
                            @elseif($orders->transaction_status === 'paid')
                                <button class="btn bg-green-700 text-white w-full" disabled>Lunas</button>
                            @elseif($orders->transaction_status === 'pending')
                                <button class="btn bg-green-700 text-white w-full" disabled>Detail</button>
                            @endif
                        </div>--}}
                    </div>
                    <div class="box p-5 rounded-md mt-5">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Detail Pembayaran</div>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Metode Pembayaran:
                            <div class="ml-auto">{{ $orders->payment_type }}</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Total Harga ({{ $orders->orderItems->count() }} Item):
                            <div class="ml-auto">@currency($orders->gross_amount)</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Biaya pengiriman:
                            <div class="ml-auto">@currency($orders->shipping)</div>
                        </div>
                        <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">
                            <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Total Tagihan:
                            <div class="ml-auto">@currency($orders->gross_amount+$orders->shipping)</div>
                        </div>
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
                                @foreach($orders->orderItems as $item)
                                    <tr>
                                        <td class="!py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <img alt="#" src="{{ asset("storage/product-image")."/".$item-> products -> productImage -> image_path }}" title="Uploaded {{ Carbon\Carbon::parse($item -> products -> created_at)->diffForHumans() }}">
                                                </div>
                                                <a href="" class="font-medium whitespace-nowrap ml-4">{{ $item -> products -> name }}</a>
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
                    <div class="grid grid-cols-12 gap-5">
                        <div class="col-span-12 lg:col-span-6">
                            <div class="box p-5 rounded-md mt-5" style="min-height: 210px">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Detail Penerima</div>
                                </div>
                                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Nama: {{ $orders->customer_name }} </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Nomor Handphone: +62{{ ltrim($orders->customer_phone, '0') }} </div>
                                <div class="flex items-center mt-3 capitalize_address">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 mr-2"></i>
                                    {{ $orders->orderAddress->detail_address }},
                                    {{ $orders->orderAddress->village->name }},
                                    {{ $orders->orderAddress->district->name }},
                                    {{ $orders->orderAddress->regency->name }},
                                    {{ $orders->orderAddress->province->name }}.
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <div class="box p-5 rounded-md lg:mt-5 ml-auto" style="min-height: 210px">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Informasi Pengiriman</div>
                                </div>
                                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Kurir: JNE </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Nomor Resi: 003005580322 <i data-lucide="copy" class="w-4 h-4 text-slate-500 ml-2"></i> </div>
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

            <script>
                $(document).ready(function(){
                    $("#send_change_status").click(function(){
                        let order_id = $("#order_id").val();
                        let transaction_status = $("#transaction_status").val();
                        let status_code = $("#status_code").val();
                        let gross_amount = $("#gross_amount").val();

                        $.ajax({
                            type: "POST",
                            url: "/api/payment-notification-handler",
                            data: {
                                order_id: order_id,
                                transaction_status: transaction_status,
                                status_code: status_code,
                                gross_amount: gross_amount
                            },
                            success: function(data) {
                                console.log(data);
                                //Tambahkan aksi setelah data berhasil dikirim ke server
                            },
                            error: function(data) {
                                console.log(data);
                                //Tambahkan aksi jika terjadi error saat mengirim data ke server
                            }
                        });
                    });
                });
            </script>

            <script>
                const copyBtn = document.getElementById('copy-btn');
                const tooltip = document.getElementById('tooltip');

                copyBtn.addEventListener('click', function() {
                    navigator.clipboard.writeText({{ $orders->va_number }}).then(function() {
                        tooltip.classList.remove('hidden');
                        setTimeout(function() {
                            tooltip.classList.add('hidden');
                        }, 1500);
                    }, function() {
                        console.error('Gagal menyalin ke clipboard');
                    });
                });
            </script>
    @endsection

</x-app-layout>
