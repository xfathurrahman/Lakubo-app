@if(isset($order))
    <!-- BEGIN: Content -->
    <div class="content mt-6">
        <!-- BEGIN: Transaction Details -->
        <div class="intro-y grid grid-cols-11 gap-5 mt-5">
            <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                <div class="box p-5 rounded-md">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
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
                                        <i class="fa-solid fa-arrow-right-arrow-left mr-2 text-slate-500"></i>Status Transaksi
                                    </span>:
                                </div>
                            @endif
                        </div>
                        <div class="inline-flex">
                            @if($order -> transaction_status === 'awaiting_payment')
                                <span class="bg-yellow-400 text-white px-2 rounded-md">Menunggu Pembayaran</span>
                            @elseif($order -> transaction_status === 'completed')
                                <span class="bg-green-500 text-white px-2 rounded-md">Pembayaran Berhasil</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center mt-2">
                        <div class="inline-flex mr-2">
                            <div class="flex items-center justify-between">
                                <span class="w-40 inline-flex">
                                    <i class="fa-regular fa-note-sticky mr-2 text-slate-500"></i>Catatan
                                </span>:
                            </div>
                        </div>
                        @if($order->note)
                            <span class="bg-gray-200 text-gray-600 w-full h-auto px-2 rounded-md">{{ $order->note }}</span>
                        @else
                            <span class="bg-gray-200 text-gray-600 w-full px-2 rounded-md">-</span>
                        @endif
                    </div>

                    @if($order->transaction_status === 'completed')
                        @if($order->status === 'awaiting_confirm')
                            <div class="flex items-center mt-4 pt-4 border-t border-slate-200 justify-between">
                                <button type="button" class="btn btn-primary w-1/2 mr-2 mb-2"
                                        data-tw-toggle="modal"
                                        data-tw-target="#reject-confirmation-modal">
                                    <i class="fa-regular fa-circle-xmark mr-2"></i> Tolak
                                </button>
                                <button id="confirmBtn" class="btn w-1/2 mr-2 mb-2">
                                    <i class="fa-regular fa-circle-check mr-2"></i> Konfirmasi
                                </button>
                            </div>
                        @elseif($order->status === 'confirmed')
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <select id="changeStatus">
                                    <option value="" disabled selected>Dikonfirmasi</option>
                                    <option value="packing" {{ $order->status === 'packing' ? 'selected' : '' }}>Dikemas</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Dikirim</option>
                                </select>
                            </div>
                        @elseif($order->status === 'packing')
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <select id="changeStatus">
                                    <option value="" disabled selected>Dikemas</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Dikirim</option>
                                </select>
                            </div>
                        @elseif($order->status === 'delivered')
                            <div class="flex items-center mt-2">
                                <div class="inline-flex mr-2">
                                    <div class="flex items-center justify-between">
                                        <span class="w-40 inline-flex"><i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>Status Pesanan</span>:
                                    </div>
                                </div>
                                <span class="bg-blue-500 text-white px-2 rounded-md">Dikirim.</span>
                            </div>
                        @endif
                    @endif

                    @if($order->transaction_status === 'cancel')
                        <div class="flex items-center justify-between">
                            <div class="inline-flex">
                                <i class="fa-solid fa-bolt-lightning mr-2 text-slate-500"></i>
                                Status Pesanan:
                            </div>
                            @if($order->status === 'cancelled')
                                <span class="bg-red-400 text-white px-2 rounded-md">Pesanan Dibatalkan.</span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="box p-5 rounded-md mt-5">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Detail Tagihan</div>
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
                    @if($order->transaction_status !== 'completed')
                        <div class="mt-2 rounded-lg">
                            <div class="flex items-center mt-2">
                                <div class="inline-flex">
                                    <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex">
                                        <i class="fa-solid fa-stopwatch-20 w-4 h-4 text-slate-500 mr-1"></i>Waktu Pembayaran
                                    </span>:
                                    </div>
                                </div>
                                <div class="text-blue-500 ml-2" id="countdown"></div>
                            </div>
                            <div class="bg-yellow-200 rounded-md p-2 mt-2">
                                <span>Catatan: Pesanan akan dibatalkan otomatis oleh sistem jika pelanggan melewati waktu pembayaran.</span>
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
                            <span class="ml-2">{{ $order->orderShipping->etd }} Hari</span>
                        @endif
                    </div>

                    @if($order->status === 'delivered')
                        <div class="flex items-center">
                            <div class="flex items-center mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-40 inline-flex textsss"><i class="fa-solid fa-magnifying-glass-location text-slate-500 mr-2"></i>Nomor Resi</span>:
                                </div>
                            </div>
                            <div class="inline-flex intro-y items-center">
                                <input type="number" id="tracking_no" class="form-control w-full md:w-32" placeholder="Masukan Resi" value="{{ $order->orderShipping->tracking_number }}">
                            </div>
                            <button id="save-resi-btn" class="btn btn-primary px-2 ml-2">
                                <i class="fa-solid fa-check-to-slot mr-2"></i> Simpan
                            </button>
                            <div class="text-slate-500 ml-2 hidden" id="save-resi-response"></div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!-- END: Transaction Details -->
    </div>
    <!-- END: Content -->
@else
    Data tidak ditemukan
@endif

