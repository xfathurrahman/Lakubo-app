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
            <div class="accordion flex flex-col items-center justify-center">
                <!--  Panel 1  -->
                <div class="w-full">
                    <input type="checkbox" name="panel" id="panel-{{ $order->id }}" class="hidden">
                    <label for="panel-{{ $order->id }}" class="relative flex justify-between items-center hover:cursor-pointer bg-gray-100 p-1 rounded">
                        <span class="font-medium whitespace-nowrap">
                            <p class="underline decoration-dotted sm:hidden">
                                #{{ $order->id }}
                            </p>
                            <a href="#" class="text-primary">
                                {{ $order->customer_name }}
                            </a>
                        </span>
                    </label>
                    <div class="accordion__content overflow-hidden">
                        @foreach($order->orderItems as $item)
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
                        <div class="sm:hidden">
                            <div class="text-slate-500 flex justify-center text-xs whitespace-nowrap mt-2">
                                @if($order->orderShipping->tracking_number)
                                    <div class="flex justify-center items-center w-full bg-gray-200 rounded-md py-2">
                                        <input class="text-center text-sm truncate" disabled id="tracking_no-{{ $order->id }}" value="{{ $order->orderShipping->tracking_number }}">
                                        <button id="copy-tracking-no-{{ $order->id }}" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                                            <i class="fas fa-copy text-gray-400 text-lg"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="flex justify-center items-center w-full bg-gray-200 rounded-md py-2">
                                        <span class="text-primary text-sm">Nomor resi belum di input.</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <a href="#" class="font-medium text-sm sm:text-lg text-red-400 truncate">
                                    <i class="fa-solid fa-store text-sm mr-1 mb-0.5"></i>
                                    {{ $order->stores->name }}
                                </a>
                                <p class="text-right">
                                    {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('H.i') }} <br>
                                    {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-left mt-3 hidden sm:block">
                            <a href="{{ route('customer.order.show', $order->id) }}" class="simpan btn btn-primary p-2">Detail Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2 sm:hidden flex justify-between items-center">
                <div class="items-center w-full">
                    <a href="{{ route('customer.order.show', $order->id) }}" class="simpan btn btn-primary"><i class="fa-solid fa-circle-check mr-2"></i>Detail</a>
                </div>
                <!-- Tombol Konfirmasi -->
                <div class="items-center w-full">
                    @if ($order->orderShipping->tracking_number == null)
                        <button type="button" disabled class="btn btn-success text-white w-full mr-2 btn-confirm-order"
                                data-order-id="{{ $order->id }}">
                            <i class="fa-solid fa-circle-check mr-2"></i>Konfirmasi
                        </button>
                    @else
                        <button type="button" class="btn btn-success text-white w-full mr-2 btn-confirm-order"
                                data-order-id="{{ $order->id }}">
                            <i class="fa-solid fa-circle-check mr-2"></i>Konfirmasi
                        </button>
                    @endif
                </div>
            </div>
        </td>

        <td class="text-center whitespace-nowrap hidden">
            <div class="flex justify-center items-center">
                <a href="#" class="font-medium text-sm sm:text-lg text-red-400 truncate">
                    <i class="fa-solid fa-store text-sm mr-1 mb-0.5"></i>
                    {{ $order->stores->name }}
                </a>
            </div>
        </td>

        <td class="w-40 mt-1 sm:mt-2 hidden">
            <p class="text-right">
                {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('H.i') }} <br>
                {{ \Carbon\Carbon::parse($order->orderShipping->shipping_at)->format('d/m/Y') }}
            </p>
        </td>

        <td class="table-report__action text-center whitespace-nowrap hidden">
            <div class="text-slate-500 flex justify-center text-xs whitespace-nowrap mt-0.5">
                @if($order->orderShipping->tracking_number)
                    <div class="relative max-w-min bg-gray-200 items-center rounded-md px-2 ml-2">
                        <input class="text-center text-lg my-1 truncate" disabled id="tracking_no-{{ $order->id }}" value="{{ $order->orderShipping->tracking_number }}">
                        <button id="copy-tracking-no-{{ $order->id }}" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-copy text-gray-400 text-lg"></i>
                        </button>
                    </div>
                @else
                    <span class="text-primary text-sm">Nomor resi belum di input.</span>
                @endif
            </div>
        </td>

        <td class="table-report__action text-center whitespace-nowrap hidden">
            <div class="items-center">
                @if ($order->orderShipping->tracking_number == null)
                    <button type="button" disabled class="btn btn-success text-white w-full mr-2 btn-confirm-order"
                            data-order-id="{{ $order->id }}">
                        <i class="fa-solid fa-circle-check mr-2"></i>Konfirmasi
                    </button>
                @else
                    <button type="button" class="btn btn-success text-white w-full mr-2 btn-confirm-order"
                            data-order-id="{{ $order->id }}">
                        <i class="fa-solid fa-circle-check mr-2"></i>Konfirmasi
                    </button>
                @endif
            </div>
        </td>

    </tr>
@endforeach
