@foreach($orders as $order)
    <tr class="intro-x order-row">
        <style>
            label:after {
                content: '\f103';
                font-family: "Font Awesome 5 Free", serif;
                font-weight: 900;
                color: #000000;
                position: absolute;
                top: 0.5rem;
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
        {{--<td class="w-10">
            <input class="form-check-input" type="checkbox">
        </td>--}}
        <td class="w-40 !py-4"><a href="{{ route('customer.order.show', $order->id) }}" class="underline decoration-dotted whitespace-nowrap">#{{ $order->id }}</a></td>
        <td>
            <div class="accordion flex flex-col items-center justify-center">
                <!--  Panel 1  -->
                <div class="w-full">
                    <input type="checkbox" name="panel" id="panel-{{ $order->id }}" class="hidden">
                    <label for="panel-{{ $order->id }}" class="relative block">
                        <span class="font-medium whitespace-nowrap">
                            <a href="#" class="text-primary">
                                {{ $order->orderItems->first()->products->stores->name }}
                            </a>
                        </span>
                        <p class="text-slate-500 text-xs whitespace-nowrap mt-0.5 capitalize_address">
                            Kec.{{ $order->orderItems->first()->products->stores->storeAddresses->district->name }},
                            {{ str_replace('KABUPATEN ', '', $order->orderItems->first()->products->stores->storeAddresses->district->name) }}
                        </p>
                    </label>
                    <div class="accordion__content overflow-hidden">
                        @foreach($order->orderItems as $item)
                            <div class="bg-gray-200 p-2 rounded my-1">
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
                    </div>
                </div>
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
            @else
                <div class="flex items-center justify-center whitespace-nowrap text-yellow-500">
                    <i class="fa-solid fa-money-bill-transfer mr-2"></i> Menunggu Pembayaran
                </div>
            @endif
        </td>
        <td class="w-40 text-right">
            <div class="pr-16 whitespace-nowrap">@currency($order->grand_total)</div>
        </td>
        <td class="table-report__action">
            <div class="flex justify-center items-center">
                <a class="flex items-center text-primary whitespace-nowrap mr-5"
                   href="{{ route('customer.order.show', $order->id) }}"><i class="fa-solid fa-file-invoice mr-2"></i>Detail</a>
            </div>
        </td>
    </tr>
@endforeach
