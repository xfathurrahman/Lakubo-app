@foreach($orders as $order)
    <tr class="intro-x order-row">
        {{--<td class="w-10">
            <input class="form-check-input" type="checkbox">
        </td>--}}
        <td class="w-40 !py-4"><a href="" class="underline decoration-dotted whitespace-nowrap">#{{ $order->id }}</a>
        </td>
        <td class="w-40">
            <a href="" class="font-medium whitespace-nowrap">{{ $order->customer_name }}</a>
            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5 capitalize_address">
                Kec.{{ $order->orderAddress->district->name }},
                {{ str_replace('KABUPATEN ', '', $order->orderAddress->district->name) }}
            </div>
        </td>
        <td class="text-center">
            @if($order->status === 'awaiting_payment')
                <div class="flex items-center justify-center whitespace-nowrap text-yellow-500">
                    <i class="fa-solid fa-money-bill-transfer mr-2"></i> Menunggu Pembayaran
                </div>
            @elseif($order->status === 'awaiting_confirm')
                <div class="flex items-center justify-center whitespace-nowrap text-blue-500">
                    <i class="fa-solid fa-hourglass mr-2"></i> Menunggu Konfirmasi
                </div>
            @elseif($order->status === 'confirmed')
                <div class="flex items-center justify-center whitespace-nowrap text-green-500">
                    <i class="fa-solid fa-check mr-2"></i> Dikonfirmasi
                </div>
            @elseif($order->status === 'packing')
                <div class="flex items-center justify-center whitespace-nowrap text-gray-500">
                    <i class="fa-solid fa-boxes-packing mr-2"></i> Dikemas
                </div>
            @elseif($order->status === 'delivered')
                <div class="flex items-center justify-center whitespace-nowrap text-yellow-500">
                    <i class="fa-solid fa-truck-fast mr-2"></i> Dikirim
                </div>
                <div class="text-slate-500 flex justify-center text-xs whitespace-nowrap mt-0.5">
                    @if($order->orderShipping->tracking_number)
                        Resi :
                        <div class="relative max-w-min bg-gray-200 items-center rounded-md px-2 ml-2">
                            <input class="text-center" disabled id="tracking_no-{{ $order->id }}" value="{{ $order->orderShipping->tracking_number }}">
                            <button id="copy-tracking-no-{{ $order->id }}" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-copy text-gray-400"></i>
                            </button>
                        </div>
                    @else
                        <span class="text-primary">Nomor resi belum di input.</span>
                    @endif
                </div>
            @elseif($order->status === 'completed')
                <div class="flex items-center justify-center whitespace-nowrap text-success">
                    <i class="fa-solid fa-check-double mr-2"></i> Selesai
                </div>
            @elseif($order->status === 'cancelled')
                <div class="flex items-center justify-center whitespace-nowrap text-danger">
                    <i class="fa-regular fa-circle-xmark mr-2"></i> Dibatalkan
                </div>
            @endif
        </td>
        <td>
            <div class="whitespace-nowrap">
                @if($order->payment_type === 'bank_transfer')
                    Bank Transfer
                @elseif($order->payment_type === 'credit_card')
                    Kartu Kredit
                @elseif($order->payment_type === 'cstore')
                    Gerai Indomaret
                @endif
            </div>
            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ Carbon\Carbon::parse($order->transaction_time)->format('d F Y (H:i)') }}</div>
        </td>
        <td class="w-40 text-right">
            <div class="pr-16 whitespace-nowrap">@currency($order->grand_total)</div>
        </td>
        <td class="table-report__action">
            <div class="flex justify-center items-center">
                <a class="flex items-center text-primary whitespace-nowrap mr-5"
                   href="{{ route('seller.order.show', $order->id) }}"><i class="fa-solid fa-file-invoice mr-2"></i>Detail</a>
            </div>
        </td>
    </tr>
@endforeach