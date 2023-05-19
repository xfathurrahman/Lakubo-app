@foreach($transactions as $transaction)
    <tr class="intro-x order-row" id="tr-content">
        <style>
            label:after {
                content: "tampil \f107";
                font-family: "Font Awesome 5 Free", serif;
                font-weight: 900;
                color: rgb(248 113 113 / var(--tw-bg-opacity));
                position: absolute;
                right: 0.5em;
                letter-spacing: 1px;
                font-size: 10px;
                line-height: 1;
            }

            input:checked + label:after {
                content: "sembunyikan \f106";
                font-size: 10px;
                font-family: "Font Awesome 5 Free", serif;
                font-weight: 900;
                color: rgb(252 165 165 / var(--tw-bg-opacity));
                line-height: .8em;
                letter-spacing: 2px;
                margin-top: -17px;
            }
            .accordion__content{
                max-height: 0;
                transition: all 0.4s cubic-bezier(0.865, 0.20 md:w-32, 0.095, 0.87);
            }
            input[name='panel']:checked ~ .accordion__content {
                /* Get this as close to what height you expect */
                max-height: 50em;
            }
            input[name='panel']:checked ~ label {
                background-color: transparent;
            }
        </style>

        <td class="w-40 !py-4 hidden"><a href="#" class="underline decoration-dotted whitespace-nowrap">#{{ $transaction->id }}</a></td>
        <td>
            @if($transaction->payment_type === 'selling')
                <div class="accordion flex flex-col items-center justify-center">
                    <!--  Panel 1  -->
                    <div class="w-full">
                        <input type="checkbox" name="panel" id="panel-{{ $transaction->id }}" class="hidden">
                        <label for="panel-{{ $transaction->id }}" class="relative flex justify-between items-center hover:cursor-pointer bg-gray-100 p-1 rounded">
                            <span class="font-medium whitespace-nowrap">
                                <p class="underline decoration-dotted sm:hidden">
                                    #{{ $transaction->id }}
                                </p>
                                <a href="#" class="text-primary">
                                    Penjualan Produk
                                </a>
                            </span>
                        </label>
                        <div class="accordion__content overflow-hidden">
                            @foreach($transaction->order->orderItems as $item)
                                <div class="bg-gray-200 p-2 rounded mt-2">
                                    <div class="whitespace-nowrap inline-flex items-center">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <img data-action="zoom" alt="Product-img" class="tooltip rounded-full" src="{{ asset("storage/product-images")."/".$item-> products -> productImage -> image_path }}" title="Uploaded {{ Carbon\Carbon::parse($item -> products -> created_at)->diffForHumans() }}">
                                        </div>
                                        <div class="ml-2">
                                            {{ $item->products->name }} ({{ $item->quantity }} Item)
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $item->products->productCategories->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="flex items-center justify-end mt-3">
                                <a href="{{ route('customer.order.show', $transaction->order->id) }}" class="simpan btn h-2 btn-primary px-2">Detail Pesanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($transaction->payment_type === 'withdrawal')
                @if($transaction->storeWithdrawal)
                    <div class="accordion flex flex-col items-center justify-center">
                        <!--  Panel 1  -->
                        <div class="w-full">
                            <input type="checkbox" name="panel" id="panel-{{ $transaction->id }}" class="hidden">
                            <label for="panel-{{ $transaction->id }}" class="relative flex justify-between items-center hover:cursor-pointer bg-gray-100 p-1 rounded">
                                <span class="font-medium whitespace-nowrap">
                                    <p class="underline decoration-dotted sm:hidden">
                                        #{{ $transaction->id }}
                                    </p>
                                    <a href="#" class="text-primary">
                                        Penarikan Dana
                                    </a>
                                </span>
                            </label>
                            <div class="accordion__content overflow-hidden">
                                <div class="bg-gray-200 p-2 mt-2 rounded">
                                    <div class="sm:flex items-center mb-2">
                                        <span class="w-36 font-medium"><i class="fa-regular fa-credit-card mr-2"></i>Rek</span>
                                        <span>: {{ $transaction->storeWithdrawal->bank_account_number }}</span>
                                    </div>
                                    <div class="sm:flex items-center mb-2">
                                        <span class="w-36 font-medium"><i class="fa-solid fa-signature mr-2"></i>Atas Nama</span>
                                        <span>: {{ $transaction->storeWithdrawal->bank_account_name }}</span>
                                    </div>
                                    <div class="sm:flex items-center">
                                        <span class="w-36 font-medium"><i class="fa-solid fa-building-columns mr-2"></i>Nama Bank</span>
                                        <span>: {{ $transaction->storeWithdrawal->bank_name }}</span>
                                    </div>
                                    @isset($transaction->storeWithdrawal->note)
                                        <div class="sm:flex items-center mt-2">
                                            <span class="w-36 font-medium"><i class="fa-regular fa-note-sticky mr-2"></i>Alasan Penolakan</span>
                                            <span>: {{ $transaction->storeWithdrawal->note }}</span>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="mt-2 sm:hidden flex justify-between items-center">
                <div class="bg-gray-100 p-1 rounded">
                    @if($transaction->order)
                        @if($transaction->order->transaction_status === 'awaiting_payment')
                            <div class="flex items-center justify-start whitespace-nowrap text-yellow-500">
                                <i class="fa-solid fa-money-bill-transfer mr-2"></i> Tertunda
                            </div>
                        @elseif($transaction->order->transaction_status === 'completed')
                            <div class="flex items-center justify-start whitespace-nowrap text-green-500">
                                <i class="fa-solid fa-check-double mr-2"></i> Berhasil
                            </div>
                        @elseif($transaction->order->transaction_status === 'cancel')
                            <div class="flex items-center justify-start whitespace-nowrap text-red-500">
                                <i class="fa-regular fa-circle-xmark mr-2"></i> Dibatalkan
                            </div>
                        @endif
                    @elseif($transaction->storeWithdrawal)
                        @if($transaction->storeWithdrawal->status === 'processing')
                            <div class="flex items-center justify-start whitespace-nowrap text-yellow-500">
                                <i class="fa-regular fa-clock mr-2"></i> Tertunda
                            </div>
                        @elseif($transaction->storeWithdrawal->status === 'approved')
                            <div class="flex items-center justify-start whitespace-nowrap text-green-500">
                                <i class="fa-solid fa-check-double mr-2"></i> Disetujui
                            </div>
                        @elseif($transaction->storeWithdrawal->status === 'rejected')
                            <div class="flex items-center justify-start whitespace-nowrap text-red-500">
                                <i class="fa-regular fa-hand mr-2"></i> Ditolak
                            </div>
                        @endif
                    @endif
                </div>
                <div class="whitespace-nowrap bg-green-100 p-1 rounded"> @currency($transaction->amount)</div>
            </div>
        </td>

        <td class="text-center whitespace-nowrap hidden">
            <div class="text-center">
                @if($transaction->payment_method === 'bank_transfer')
                    <div class="whitespace-nowrap">Bank Transfer</div>
                @elseif($transaction->payment_method === 'cstore')
                    <div class="whitespace-nowrap">Indomaret</div>
                @else
                    <div class="whitespace-nowrap">{{ $transaction->payment_method }}</div>
                @endif
            </div>
        </td>

        <td class="w-40 text-center whitespace-nowrap hidden">
            @if($transaction->order)
                @if($transaction->order->transaction_status === 'awaiting_payment')
                    <div class="flex items-center justify-center whitespace-nowrap text-yellow-500">
                        <i class="fa-solid fa-money-bill-transfer mr-2"></i> Tertunda
                    </div>
                @elseif($transaction->order->transaction_status === 'completed')
                    <div class="flex items-center justify-center whitespace-nowrap text-green-500">
                        <i class="fa-solid fa-check-double mr-2"></i> Berhasil
                    </div>
                @elseif($transaction->order->transaction_status === 'cancel')
                    <div class="flex items-center justify-center whitespace-nowrap text-red-500">
                        <i class="fa-regular fa-circle-xmark mr-2"></i> Dibatalkan
                    </div>
                @endif
            @elseif($transaction->storeWithdrawal)
                @if($transaction->storeWithdrawal->status === 'processing')
                    <div class="flex items-center justify-center whitespace-nowrap text-yellow-500">
                        <i class="fa-regular fa-clock mr-2"></i> Tertunda
                    </div>
                @elseif($transaction->storeWithdrawal->status === 'approved')
                    <div class="flex items-center justify-center whitespace-nowrap text-green-500">
                        <i class="fa-solid fa-check-double mr-2"></i> Disetujui
                    </div>
                @elseif($transaction->storeWithdrawal->status === 'rejected')
                    <div class="flex items-center justify-center whitespace-nowrap text-red-500">
                        <i class="fa-regular fa-hand mr-2"></i> Ditolak
                    </div>
                @endif
            @endif
        </td>
        <td class="table-report__action text-center whitespace-nowrap hidden">
            <div class="whitespace-nowrap"> @currency($transaction->amount)</div>
        </td>
    </tr>
@endforeach
