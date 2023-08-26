@foreach($orders as $order)
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

        <td class="w-40 !py-4 hidden"><a href="#" class="underline decoration-dotted whitespace-nowrap">#{{ $order->id }}</a></td>
        <td>
            <div class="flex flex-col items-center justify-center w-60 accordion">
                <!--  Panel 1  -->
                <div class="w-full">
                    <input type="checkbox" name="panel" id="panel-{{ $order->id }}" class="hidden">
                    <label for="panel-{{ $order->id }}" class="relative flex items-center justify-between p-1 bg-gray-100 rounded hover:cursor-pointer">
                        <span class="font-medium whitespace-nowrap">
                            <p class="underline decoration-dotted sm:hidden">
                                #{{ $order->id }}
                            </p>
                            <a href="#" class="text-primary">
                                {{ $order->customer_name }}
                            </a>
                        </span>
                    </label>
                    <div class="overflow-hidden accordion__content">
                        @foreach($order->orderItems as $item)
                            <div class="p-2 mt-2 bg-gray-200 rounded">
                                <div class="inline-flex items-center whitespace-nowrap">
                                    <div class="w-10 h-10 image-fit zoom-in">
                                        <img data-action="zoom" alt="Product-img" class="rounded-full tooltip" src="{{ asset("storage/product-images")."/".$item-> products -> productImage -> image_path }}" title="Uploaded {{ Carbon\Carbon::parse($item -> products -> created_at)->diffForHumans() }}">
                                    </div>
                                    <div class="ml-2">
                                        {{ $item->products->name }} ({{ $item->quantity }} Item)
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $item->products->productCategories->name }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="sm:hidden">
                            <div class="flex justify-center mt-2 text-xs text-slate-500 whitespace-nowrap">
                                @if($order->orderShipping->tracking_number)
                                    <div class="flex items-center justify-center w-full py-2 bg-gray-200 rounded-md">
                                        <input class="text-sm text-center truncate" disabled id="tracking_no-{{ $order->id }}" value="{{ $order->orderShipping->tracking_number }}">
                                        <button id="copy-tracking-no-{{ $order->id }}" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                                            <i class="text-lg text-gray-400 fas fa-copy"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center w-full py-2 bg-gray-200 rounded-md">
                                        <span class="text-sm text-primary">Nomor resi belum di input.</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <a href="#" class="text-sm font-medium text-red-400 truncate sm:text-lg">
                                    <i class="fa-solid fa-store text-sm mr-1 mb-0.5"></i>
                                    {{ $order->stores->name }}
                                </a>
                                <p class="text-right">
                                    {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('H.i') }} <br>
                                    {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="hidden mt-3 text-left sm:block">
                            <a href="{{ route('customer.order.show', $order->id) }}" class="p-2 simpan btn btn-primary">Detail Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-2 sm:hidden">
                <div class="items-center w-full">
                    <a href="{{ route('customer.order.show', $order->id) }}" class="simpan btn btn-primary"><i class="mr-2 fa-solid fa-circle-check"></i>Detail</a>
                </div>
                <!-- Tombol Konfirmasi -->
                <div class="items-center w-full">
                    @if ($order->orderShipping->tracking_number == null)
                        <button type="button" disabled class="w-full mr-2 text-white btn btn-success btn-confirm-order"
                                data-order-id="{{ $order->id }}">
                            <i class="mr-2 fa-solid fa-circle-check"></i>Konfirmasi
                        </button>
                    @else
                        <button type="button" class="w-full mr-2 text-white btn btn-success btn-confirm-order"
                                data-order-id="{{ $order->id }}">
                            <i class="mr-2 fa-solid fa-circle-check"></i>Konfirmasi
                        </button>
                    @endif
                </div>
            </div>
        </td>

        <td class="hidden text-center whitespace-nowrap">
            <div class="flex items-center justify-center">
                <a href="#" class="text-sm font-medium text-red-400 truncate sm:text-lg">
                    <i class="fa-solid fa-store text-sm mr-1 mb-0.5"></i>
                    {{ $order->stores->name }}
                </a>
            </div>
        </td>

        <td class="hidden w-40 mt-1 sm:mt-2">
            <p class="text-right">
                {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('H.i') }} <br>
                {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('d/m/Y') }}
            </p>
        </td>

        <td class="hidden text-center table-report__action whitespace-nowrap">
            <div class="text-slate-500 flex justify-center text-xs whitespace-nowrap mt-0.5">
                @if($order->orderShipping->tracking_number)
                    <div class="relative items-center px-2 ml-2 bg-gray-200 rounded-md max-w-min">
                        <input class="my-1 text-lg text-center truncate" disabled id="tracking_no-{{ $order->id }}" value="{{ $order->orderShipping->tracking_number }}">
                        <button id="copy-tracking-no-{{ $order->id }}" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                            <i class="text-lg text-gray-400 fas fa-copy"></i>
                        </button>
                    </div>
                @else
                    <span class="text-sm text-primary">Nomor resi belum di input.</span>
                @endif
            </div>
        </td>

        <td class="hidden text-center table-report__action whitespace-nowrap">
            <div class="items-center">
                @if ($order->orderShipping->tracking_number == null)
                    <button type="button" disabled class="w-full mr-2 text-white btn btn-success btn-confirm-order"
                            data-order-id="{{ $order->id }}">
                        <i class="mr-2 fa-solid fa-circle-check"></i>Konfirmasi
                    </button>
                @else
                    <button type="button" class="w-full mr-2 text-white btn btn-success btn-confirm-order"
                            data-order-id="{{ $order->id }}">
                        <i class="mr-2 fa-solid fa-circle-check"></i>Konfirmasi
                    </button>
                @endif
            </div>
        </td>

    </tr>
@endforeach
