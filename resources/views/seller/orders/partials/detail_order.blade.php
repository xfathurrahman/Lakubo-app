@if(isset($order))
    <!-- BEGIN: Transaction Details -->
    <div class="intro-y grid grid-cols-11 gap-4 mt-5">
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
            <div class="box p-4 rounded-md text-xs sm:text-sm">
                <div class="text-start border-b border-slate-200/60 dark:border-darkmode-400 pb-2 mb-4">
                    <div class="font-medium text-base truncate">Detail Pesanan</div>
                    <div class="absolute top-2 right-2 bg-gray-200 px-1 mt-3 mr-2 rounded-sm text-gray-700">ID: {{ ($order->id) }}</div>
                    <p class="text-xs -mt-1">{{Carbon\Carbon::parse($order->transaction_time)->format('d F Y (H:i)')}}</p>
                </div>

                <div class="flex items-center mt-2">
                    <div class="inline-flex mr-2">
                        <div class="flex items-center justify-between">
                            <span class="w-32 sm:w-40 inline-flex">
                            <i class="fa-solid fa-money-bill-wheat mr-2 text-slate-500"></i>Status Pembayaran
                            </span>:
                        </div>
                    </div>
                    <div class="inline-flex w-full">
                        @if($order->transaction_status === 'awaiting_payment')
                            <span class="bg-yellow-100 text-yellow-600 px-2 w-full text-center rounded-md">Menunggu</span>
                        @elseif($order->transaction_status === 'completed')
                            <span class="bg-green-100 text-green-600 px-2 w-full text-center rounded-md">Berhasil</span>
                        @elseif($order->transaction_status === 'cancel')
                            <span class="bg-red-100 text-red-600 px-2 w-full text-center rounded-md">Gagal</span>
                        @endif
                    </div>
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
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <select id="changeStatus">
                                <option value="" disabled selected>Dikonfirmasi</option>
                                <option value="packing">Dikemas</option>
                                <option value="delivered">Dikirim</option>
                            </select>
                        </div>
                    @elseif($order->status === 'packing')
                        <div class="flex items-center mt-2">
                            <div class="inline-flex mr-2">
                                <div class="flex items-center justify-between">
                                    <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-box mt-0.5 mr-2 text-slate-500"></i>Status Pesanan</span>:
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <select id="changeStatus">
                                <option value="" disabled selected>Dikemas</option>
                                <option value="delivered">Dikirim</option>
                            </select>
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
                @endif

                @if($order->status === 'cancelled')
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
                        <textarea disabled class="mt-1 bg-gray-200 text-sm text-gray-600 w-full px-2 rounded-md">{{ $order->reject_msg }}</textarea>
                    @endif
                @endif

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
                    <textarea disabled class="mt-1 bg-gray-200 text-sm text-gray-600 w-full px-2 rounded-md">{{ $order->note }}</textarea>
                @endif

            </div>
            <div class="box p-4 rounded-md mt-5 text-xs sm:text-sm">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Detail Tagihan</div>
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
                            <div class="ml-2">QRIS</div>
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
                @if($order->transaction_status === 'awaiting_payment')
                    <div class="mt-2 rounded-lg">
                        <div class="rounded mt-4 border bg-yellow-50">
                            <div class="flex justify-between px-4 py-1 bg-yellow-200 border-b rounded-t items-center">
                                <i data-lucide="alert-triangle" class="inline-flex w-3 h-3 text-red-500"></i>
                                <div class="text-blue-500 text-center" id="countdown"><i class="fa-solid fa-spinner fa-spin"></i></div>
                                <i data-lucide="alert-triangle" class="inline-flex w-3 h-3 text-red-500"></i>
                            </div>
                            <div class="text-center p-1">Pesanan akan dibatalkan otomatis oleh sistem jika pelanggan melewati waktu pembayaran.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
            <div class="box p-4 rounded-md text-xs sm:text-sm">
                <div class="flex items-center border-b border-slate-100/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Produk yang dipesan</div>
                </div>
                @php $totalWeight = 0 @endphp
                @php $totalProduct = 0 @endphp
                @foreach($order->orderItems as $item)
                    <div class="flex items-center mb-2">
                        <a href="{{ route('product.detail', $item->products->id) }}" class="inline-flex items-center text-xs lg:text-sm w-full h-fit bg-gray-100 rounded-lg transform hover:translate-y-1 hover:shadow-xl transition duration-300 border-1">
                            <span class="absolute top-0 right-0 text-white bg-red-400 text-xs rounded-tr rounded-bl px-2">
                                <i class="fa-solid fa-tag mx-1"></i>
                                {{ $item->products->productCategories->name }}
                            </span>
                            <div class="p-2 w-2/12">
                                <img class="rounded-md mx-auto h-16 w-8 object-cover" src="{{ asset("storage/product-images")."/".$item -> products -> productImage -> image_path }}" alt="">
                                <span class="flex justify-center font-medium text-xs truncate">{{ $item -> quantity }} Item</span>
                            </div>
                            <div class="p-2 border-l w-10/12">
                                <span class="w-full truncate pt-2 flex items-center font-medium">{{ $item->products->name }}</span>
                                @php $subtotalWeight = 0 @endphp
                                @php $subtotalWeight += $item->products->weight * $item->quantity @endphp
                                <span class="text-xs my-1">{{ $item ->products->weight }} gram</span><br>
                                <span class="text-xs my-1">@ @currency($item->products->price)</span>
                            </div>
                            <span class="absolute bottom-0 right-0 text-red-400 font-medium text-lg rounded-tr rounded-bl px-2">
                                @currency($item->subtotal)
                            </span>
                        </a>
                    </div>
                    @php $totalWeight += $subtotalWeight; @endphp
                    @php $totalProduct += $item -> quantity; @endphp
                @endforeach
                <div class="text-md text-gray-400 mt-4">Berat total ({{ $totalProduct }}) produk:
                    <div class="text-md inline-block text-center ml-2 text-red-500">{{ $totalWeight }} gram</div>
                </div>
            </div>
            <div class="box p-4 rounded-md mt-5 text-xs sm:text-sm">
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
                        <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-truck-fast text-slate-500 mr-2"></i>Kurir</span>:
                    </div>
                    <span class="ml-2">JNE ({{ $order->orderShipping->service }})</span>
                </div>

                <div class="flex items-center mt-3 mb-1">
                    <div class="flex items-center justify-between">
                        <span class="w-32 sm:w-40 inline-flex">
                            <i class="fa-solid fa-hourglass-start text-slate-500 w-4 h-4 mr-2 text-center"></i>Estimasi Pengiriman
                        </span>:
                    </div>
                    @if($order->orderShipping->etd === '1-1')
                        <span class="ml-2">1 Hari</span>
                    @else
                        <span class="ml-2">{{ $order->orderShipping->etd }} Hari pengiriman</span>
                    @endif
                </div>

                @if($order->status === 'delivered' || $order->status === 'completed')
                    <div class="flex flex-col md:flex-row items-start md:items-center mt-3 lg:mt-0">
                        <div class="flex items-start justify-between">
                            <span class="w-32 sm:w-40 inline-flex"><i class="fa-solid fa-magnifying-glass-location text-slate-500 ml-0.5 mr-2"></i>Nomor Resi</span>:
                        </div>
                        <div class="mt-2 md:mt-0 md:ml-2 flex items-center">
                            <div class="relative">
                                <input type="text"
                                       id="tracking_no"
                                       class="form-control w-full md:w-32"
                                       placeholder="Masukan Resi"
                                       value="{{ $order->orderShipping->tracking_number }}"
                                       data-parsley-required
                                       data-parsley-errors-container="#parsley-input-resi-msg"
                                       data-parsley-required-message="Anda belum memasukan Nomor Resi.">
                                <button id="copy-tracking-no" class="absolute right-2 top-2 text-gray-500 hover:text-gray-600 focus:outline-none">
                                    <i class="fas fa-copy text-gray-400"></i>
                                </button>
                            </div>
                            <button id="save-resi-btn" class="btn btn-primary px-2 ml-2">
                                <i class="fa-solid fa-check-to-slot mr-2"></i> Simpan
                            </button>
                        </div>
                        <div class="text-slate-500 lg:ml-2 hidden" id="save-resi-response"></div>
                        <label class="text-red-400 lg:ml-2" id="parsley-input-resi-msg"></label>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- END: Transaction Details -->
@else
    Data tidak ditemukan
@endif

