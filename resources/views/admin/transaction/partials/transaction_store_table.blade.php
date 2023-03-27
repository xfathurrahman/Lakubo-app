@foreach($transactions as $transaction)
    <tr class="intro-x order-row">
        <style>
            label:after {
                content: '\f103';
                font-family: "Font Awesome 5 Free", serif;
                font-weight: 900;
                color: #000000;
                position: absolute;
                right: 1em;
            }

            input:checked + label:after {
                content: "\f102";
                font-family: "Font Awesome 5 Free", serif;
                font-weight: 900;
                color: #000000;
                line-height: .8em;
            }

            .accordion__content{
                max-height: 0;
                transition: all 0.4s cubic-bezier(0.865, 0.14, 0.095, 0.87);
            }
            input[name='panel']:checked ~ .accordion__content {
                /* Get this as close to what height you expect */
                max-height: 50em;
            }
        </style>
        <td class="w-20 !py-4"><a href="" class="underline decoration-dotted whitespace-nowrap">#{{ $transaction->id }}</a></td>
        <td>
            @if($transaction->payment_type === 'selling')
                <div class="accordion flex flex-col items-center justify-center">
                    <!--  Panel 1  -->
                    <div class="w-full">
                        <input type="checkbox" name="panel" id="panel-{{ $transaction->id }}" class="hidden">
                        <label for="panel-{{ $transaction->id }}" class="relative block">
                            <span class="font-medium whitespace-nowrap">
                                Penjualan sukses dari produk
                                <a href="{{ route('seller.order.show', $transaction->order->id) }}" class="text-primary">
                                    {{ $transaction->order->orderItems->first()->products->stores->name }}
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
                            <label for="panel-{{ $transaction->id }}" class="relative block">
                                <span class="font-medium whitespace-nowrap">Penarikan Dana</span>
                            </label>
                            <div class="accordion__content overflow-hidden">
                                <div class="bg-gray-200 p-2 mt-2 rounded">
                                    <div class="flex items-center mb-2">
                                        <span class="w-36 font-medium"><i class="fa-regular fa-credit-card mr-2"></i>Nomor Rekening</span>
                                        <span>: {{ $transaction->storeWithdrawal->bank_account_number }}</span>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <span class="w-36 font-medium"><i class="fa-solid fa-signature mr-2"></i>Atas Nama</span>
                                        <span>: {{ $transaction->storeWithdrawal->bank_account_name }}</span>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <span class="w-36 font-medium"><i class="fa-solid fa-building-columns mr-2"></i>Nama Bank</span>
                                        <span>: {{ $transaction->storeWithdrawal->bank_name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-36 font-medium">
                                            <i class="fa-solid fa-money-bill-transfer mr-2"></i>Status Penarikan</span>
                                        @if($transaction->storeWithdrawal->status === 'processing')
                                            <span>:</span>
                                            <span class="text-yellow-600 bg-yellow-200 rounded px-2 ml-1">Diproses</span>
                                        @elseif($transaction->storeWithdrawal->status === 'approved')
                                            <span>:</span>
                                            <span class="text-green-600 bg-green-200 rounded px-2 ml-1"> Selesai</span>
                                        @elseif($transaction->storeWithdrawal->status === 'rejected')
                                            <span>:</span>
                                            <span class="text-red-600 bg-red-200 rounded px-2 ml-1"> Ditolak</span>
                                        @endif
                                    </div>
                                    @isset($transaction->storeWithdrawal->note)
                                        <div class="flex items-center mt-2">
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
        </td>

        <td class="w-40">
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

        <td class="w-40">
            <div class="text-center">
                @if($transaction->payment_type === 'purchase')
                    <div class="whitespace-nowrap">Pembayaran</div>
                @elseif($transaction->payment_type === 'withdrawal')
                    <div class="whitespace-nowrap">Penarikan Dana</div>
                @elseif($transaction->payment_type === 'refund')
                    <div class="whitespace-nowrap">Pengembalian Dana</div>
                @endif
            </div>
        </td>

        <td class="text-center w-40">
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

        <td class="w-40">
            <div class="text-right">
                @if($transaction->payment_type === 'purchase')
                    <div class="whitespace-nowrap text-primary"> - @currency($transaction->amount)</div>
                @elseif($transaction->payment_type === 'withdrawal')
                    <div class="whitespace-nowrap text-primary"> - @currency($transaction->amount)</div>
                @elseif($transaction->payment_type === 'refund')
                    <div class="whitespace-nowrap text-green-500"> + @currency($transaction->amount)</div>
                @endif
            </div>
        </td>
    </tr>
@endforeach
