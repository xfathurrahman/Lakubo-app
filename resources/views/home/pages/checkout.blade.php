@extends('home.main')

@section('content')
    <div class="md:py-5 mb-14">
        <div class="w-full mx-auto bg-gray-100 shadow-lg rounded-lg" id="refreshcart">
            <div class="md:flex ">
                <div class="w-full p-4 px-5 py-5">
                    <div class="flex justify-between border-b pb-5 mb-5">
                        <h1 class="font-semibold text-2xl">Checkout</h1>
                    </div>
                    <div class="bg-gray-200 rounded-lg p-4">
                        <div class="envelope-lines my-2"></div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-red-500 my-2 flex-grow flex-shrink flex-auto capitalize">
                                <div class="flex mr-4">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>alamat pengiriman</div>
                                <div class="text-blue-400 capitalize cursor-pointer mr-0 ml-auto">
                                    <a href="{{ route('profile.edit') }}">ubah</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div>
                                <div class="flex items-center text-lg break-words">
                                    <div class="grid grid-col-12">
                                        <div class="col-span-6 md:col-span-12">
                                            <span class="font-bold">{{ Auth::user()->name }}</span>
                                            <span>( {{ Auth::user()->phone }} )</span>
                                        </div>
                                        <div class="col-span-6 md:col-span-12 flex justify-between">
                                            <div class="break-words capitalize_address">
                                                {{ Auth::user()->address->detail_address }},
                                                {{ Auth::user()->address->village->name }},
                                                {{ Auth::user()->address->district->name }},
                                                {{ Auth::user()->address->regency->name }},
                                                {{ Auth::user()->address->province->name }}.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between border-b pb-5 my-5">
                        <span class="font-normal text-lg">Produk yang dipesan dari <p class="text-red-400 inline font-medium">{{ $cartName->stores->name }}</p></span>
                    </div>
                    {{--@foreach($)
                        <div class="font-semibold px-2" scope="row">Pesanan {{ $loop->iteration }}</div>
                    @endforeach--}}

                    <div class="flex my-5">
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Detail Produk</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Kuantitas</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">@Harga</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Subtotal</h3>
                    </div>
                    @php $total = 0 @endphp
                    @foreach($cartItems as $item)
                        <div class="product_data flex items-center -mx-8 px-6 py-5">
                            <div class="flex grid grid-cols-4 w-2/5">
                                <div class="w-20 col-span-4 lg:col-span-1 mx-auto">
                                    <img class="h-20" src="{{ asset("storage/product-image")."/".$item -> products -> productImage -> image_path }}" alt="">
                                </div>
                                <div class="col-span-4 lg:col-span-3 flex flex-col justify-between text-center lg:text-left px-2 mt-2 lg:ml-4 lg:mt-0 flex-grow">
                                    <span class="font-bold text-xs lg:text-sm">{{ $item -> products -> name }}</span>
                                    <span class="text-red-500 text-xs">{{ $item -> products -> productCategories -> name }}</span>
                                </div>
                            </div>
                            <span class="text-center w-1/5 font-semibold text-sm">{{ $item -> product_qty }}</span>
                            <span class="text-center w-1/5 font-semibold text-sm">@currency($item->products->price)</span>
                            @php $subtotal = 0 @endphp
                            @php $subtotal += $item->products->price * $item->product_qty; @endphp
                            <span class="text-center w-1/5 font-semibold text-sm">@currency($subtotal)</span>
                        </div>
                        @php $total += $item->products->price * $item->product_qty; @endphp
                    @endforeach
                    <hr class="my-6">
                    <div class="flex justify-end items-center my-3">
                        <div class="text-md text-gray-400">Total harga produk: </div>
                        <span class="text-xl inline-block text-center ml-2 text-red-500">@currency($total)</span>
                    </div>
                    <hr class="my-6">
                    <div class="flex justify-between border-b pb-5 mb-5">
                        <span class="font-normal text-lg">Pengiriman</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')

@endsection
