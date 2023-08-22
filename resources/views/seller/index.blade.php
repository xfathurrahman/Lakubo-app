<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('seller_dashboard') }}
    @endsection

        @if(auth()->user()->stores)
            <!-- BEGIN: Content -->
            <div class="grid grid-cols-12">
                <div class="col-span-12 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <!-- BEGIN: General Report -->
                        <div class="col-span-12 lg:mt-8">
                            <div class="flex items-center h-10 intro-y">
                                <h2 class="mr-5 text-lg font-medium truncate">
                                    Laporan Umum
                                </h2>
                                <a href="" class="flex items-center ml-auto text-primary">
                                    <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                                </a>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mt-5">
                                <div class="items-center col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="h-full report-box zoom-in before:bg-primary/20">
                                        <div class="h-full p-5 box bg-primary">
                                            <div class="flex items-center mt-6 leading-3 text-white text-opacity-70 dark:text-slate-300">
                                                SALDO TERSEDIA
                                                <i data-lucide="alert-circle" class="tooltip w-4 h-4 ml-1.5" title="Total dari seluruh penjualan: @currency($totalSales)"></i>
                                            </div>
                                            <div class="relative mt-6 text-2xl font-medium leading-5 text-white">
                                                @currency(auth()->user()->stores->balance)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="p-5 box">
                                            <div class="flex">
                                                <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                                <div class="ml-auto">
                                                    <a class="cursor-pointer report-box__indicator bg-primary"> Lihat Semua
                                                        <i class="ml-1 fa-solid fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mt-6 text-3xl font-medium leading-8">{{ $countSuccessOrders }}</div>
                                            <div class="mt-1 text-base text-slate-500">Transaksi Sukses</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="p-5 box">
                                            <div class="flex">
                                                <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                                <div class="ml-auto">
                                                    <a class="cursor-pointer report-box__indicator bg-primary"> Lihat Semua
                                                        <i class="ml-1 fa-solid fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mt-6 text-3xl font-medium leading-8">{{ $countNewOrders }}</div>
                                            <div class="mt-1 text-base text-slate-500">Order Baru</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="p-5 box">
                                            <div class="flex">
                                                <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                                <div class="ml-auto">
                                                    <a class="cursor-pointer report-box__indicator bg-primary"> Lihat Semua
                                                        <i class="ml-1 fa-solid fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mt-6 text-3xl font-medium leading-8">{{ Auth::user()->stores->products->count() }}</div>
                                            <div class="mt-1 text-base text-slate-500">Total Produk</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: General Report -->
                        <!-- BEGIN: Official Store -->
                        <div class="col-span-12 mt-6 xl:col-span-8">
                            <div class="items-center block h-10 intro-y sm:flex">
                                <h2 class="mr-5 text-lg font-medium truncate">
                                    Lokasi Lapak
                                </h2>
                                <div class="relative mt-3 text-red-500 sm:ml-auto sm:mt-0">
                                    <a href="{{ route('seller.store.index') }}" class="flex items-center ml-auto text-primary">
                                        <i data-lucide="edit" class="w-4 h-4 mr-3"></i> Ubah Lokasi
                                    </a>
                                </div>
                            </div>
                            <div class="p-3 mt-12 intro-y box sm:mt-5">
                                <div class="px-2 pb-3 mt-1 bg-gray-200 rounded-md capitalize_address lg:-mb-3 lg:mt-0 lg:bg-transparent lg:p-0">
                                    {{ Auth::user()->stores->storeAddresses->detail_address }},
                                    {{ Auth::user()->stores->storeAddresses->village->name }},
                                    {{ Auth::user()->stores->storeAddresses->district->name }},
                                    {{ Auth::user()->stores->storeAddresses->regency->name }},
                                    {{ Auth::user()->stores->storeAddresses->province->name }}.
                                </div>
                                @if(Auth::user()->stores->storeAddresses->embedded_map)
                                    <div class="w-full overflow-hidden h-60">{!! Auth::user()->stores->storeAddresses->embedded_map !!}</div>
                                @else
                                    <div class="flex items-center justify-center w-full h-64 mt-2 overflow-hidden text-center text-gray-400 bg-gray-100 rounded-sm">
                                        <div class="sm:flex sm:items-center">
                                            <i class="mr-2 text-3xl fa-solid fa-map-location-dot"></i>
                                            <p class="mt-1">Anda tidak menyematkan Lokasi UMKM, <a class="text-blue-500" href="{{ route('seller.store.index') }}">Klik disini</a> untuk menyematkan.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- END: Official Store -->
                        <!-- BEGIN: END: Top Product Sales -->
                        <div class="col-span-12 mt-6 xl:col-span-4">
                            <div class="flex items-center h-10 intro-y">
                                <h2 class="mr-5 text-lg font-medium truncate">
                                    Produk Terlaris
                                </h2>
                            </div>
                            <div class="mt-5">
                                @foreach($topProductSales->take(3) as $item)
                                    <div class="intro-y">
                                        <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                            <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                                                <img alt="Lakubo - Lapak UMKM Boyolali" src="{{ asset('storage/product-images/'.$item->productImage->image_path) }}">
                                            </div>
                                            <div class="w-9/12 ml-4 mr-4 overflow-hidden">
                                                <div class="w-full font-medium truncate">{{ $item->name }}</div>
                                                <div class="text-slate-500 text-xs mt-0.5">{{ $item->created_at }}</div>
                                            </div>
                                            <div class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success whitespace-nowrap">
                                                {{ $item->total_sold }} Terjual
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="{{ route('seller.products.index') }}" class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                            </div>
                        </div>
                        <!-- END: Top Product Sales -->
                    </div>
                </div>
                <div class="col-span-12 2xl:col-span-3">
                    <div class="pb-10 ml-6 -mb-10 2xl:border-l">
                        <div class="grid grid-cols-12 2xl:pl-6 gap-x-6 2xl:gap-x-0 gap-y-6">
                            <!-- BEGIN: Transactions -->
                            <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:col-span-12 2xl:mt-8">
                                <div class="flex items-center h-10 intro-x">
                                    <h2 class="mr-5 text-lg font-medium truncate">
                                        Transaksi Sukses Terahir
                                    </h2>
                                </div>
                                <div class="mt-5">
                                    @foreach($transactionSuccess->take(7) as $transaction)
                                        <div class="intro-x">
                                            <div class="box px-5 py-3 mb-2.5 flex items-center zoom-in">
                                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                                @isset($transaction->users->profile_photo_path)
                                                    <img alt="Lakubo - Lapak UMKM Boyolali" class="rounded-full" src="{{ asset('storage/profile-photos/'. $transaction->users->profile_photo_path) }}">
                                                @else
                                                    <img alt="Lakubo - Lapak UMKM Boyolali" class="rounded-full" src="https://ui-avatars.com/api/?size=100&name={{ $transaction->customer_name }}">
                                                @endisset
                                                </div>
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">{{ $transaction->customer_name }}</div>
                                                    <div class="text-slate-500 text-xs mt-0.5">{{ Carbon\Carbon::parse($transaction->updated_at)->format('d/m/Y') }}</div>
                                                </div>
                                                @php
                                                    $grand_total_formatted = number_format((float)$transaction->grand_total/1000, 2, '.', '');
                                                @endphp
                                                <div class="text-success whitespace-nowrap">+ @currency( (float) $grand_total_formatted)K</div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <a href="{{ route('seller.transaction.index') }}" class="block w-full py-3 text-center border border-dotted rounded-md intro-x border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                                </div>
                            </div>
                            <!-- END: Transactions -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Content -->
        @else
            <div class="flex items-center col-span-11 mb-6 intro-y alert alert-primary alert-dismissible show" role="alert">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="info" data-lucide="info" class="w-4 h-4 mr-2 lucide lucide-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>
                <span> Anda belum membuka lapak UMKM,
                    <a data-tw-toggle="modal"
                       data-tw-target="#create-store-form"
                       href="#"
                       class="underline dropdown-item hover:bg-white/5">klik disini
                    </a>
                </span>&nbsp;untuk mendaftar.
                <button type="button" class="text-white btn-close" data-tw-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="w-4 h-4 lucide lucide-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
            </div>
        @endif

</x-app-layout>
