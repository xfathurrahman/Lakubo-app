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
                            <div class="intro-y flex items-center h-10">
                                <h2 class="text-lg font-medium truncate mr-5">
                                    Laporan Umum
                                </h2>
                                <a href="" class="ml-auto flex items-center text-primary">
                                    <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                                </a>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mt-5">
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y items-center">
                                    <div class="report-box zoom-in h-full before:bg-primary/20">
                                        <div class="box p-5 h-full bg-primary">
                                            <div class="text-white text-opacity-70 dark:text-slate-300 flex items-center leading-3 mt-6">
                                                SALDO TERSEDIA
                                                <i data-lucide="alert-circle" class="tooltip w-4 h-4 ml-1.5" title="Total nilai dari seluruh penjualan: @currency(1234567)"></i>
                                            </div>
                                            <div class="text-white mt-6 relative text-2xl font-medium leading-5">
                                                @currency(1234567)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                                <div class="ml-auto">
                                                    <a class="report-box__indicator bg-primary cursor-pointer"> Lihat Semua
                                                        <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ $countSuccessOrders }}</div>
                                            <div class="text-base text-slate-500 mt-1">Transaksi Sukses</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                                <div class="ml-auto">
                                                    <a class="report-box__indicator bg-primary cursor-pointer"> Lihat Semua
                                                        <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ $countNewOrders }}</div>
                                            <div class="text-base text-slate-500 mt-1">Order Baru</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                                <div class="ml-auto">
                                                    <a class="report-box__indicator bg-primary cursor-pointer"> Lihat Semua
                                                        <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ Auth::user()->stores->products->count() }}</div>
                                            <div class="text-base text-slate-500 mt-1">Total Produk</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: General Report -->
                        <!-- BEGIN: Official Store -->
                        <div class="col-span-12 xl:col-span-8 mt-6">
                            <div class="intro-y block sm:flex items-center h-10">
                                <h2 class="text-lg font-medium truncate mr-5">
                                    Lokasi Lapak
                                </h2>
                                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-red-500">
                                    <a href="{{ route('seller.store.index') }}" class="ml-auto flex items-center text-primary">
                                        <i data-lucide="edit" class="w-4 h-4 mr-3"></i> Ubah Lokasi
                                    </a>
                                </div>
                            </div>
                            <div class="intro-y box p-5 mt-12 sm:mt-5">
                                <div class="capitalize_address lg:-mb-3 mt-1 lg:mt-0 bg-gray-200 rounded-md p-2 lg:bg-transparent lg:p-0">
                                    {{ Auth::user()->stores->storeAddresses->detail_address }},
                                    {{ Auth::user()->stores->storeAddresses->village->name }},
                                    {{ Auth::user()->stores->storeAddresses->district->name }},
                                    {{ Auth::user()->stores->storeAddresses->regency->name }},
                                    {{ Auth::user()->stores->storeAddresses->province->name }}.
                                </div>
                                <div class="mt-5 bg-slate-200 rounded-md"></div>
                            </div>
                        </div>
                        <!-- END: Official Store -->
                        <!-- BEGIN: END: Top Product Sales -->
                        <div class="col-span-12 xl:col-span-4 mt-6">
                            <div class="intro-y flex items-center h-10">
                                <h2 class="text-lg font-medium truncate mr-5">
                                    Produk Terlaris
                                </h2>
                            </div>
                            <div class="mt-5">
                                @foreach($topProductSales as $item)
                                    <div class="intro-y">
                                        <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                            <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                                <img alt="Midone - HTML Admin Template" src="{{ asset('storage/product-images/'.$item->productImage->image_path) }}">
                                            </div>
                                            <div class="ml-4 w-9/12 overflow-hidden mr-4">
                                                <div class="font-medium w-full truncate">{{ $item->name }}</div>
                                                <div class="text-slate-500 text-xs mt-0.5">{{ $item->created_at }}</div>
                                            </div>
                                            <div class="py-1 px-2 rounded-full text-xs bg-success text-white cursor-pointer font-medium whitespace-nowrap">137 Terjual</div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="{{ route('seller.products.index') }}" class="intro-y w-full block text-center rounded-md py-4 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                            </div>
                        </div>
                        <!-- END: Top Product Sales -->
                    </div>
                </div>
                <div class="col-span-12 2xl:col-span-3">
                    <div class="2xl:border-l ml-6 -mb-10 pb-10">
                        <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                            <!-- BEGIN: Transactions -->
                            <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                                <div class="intro-x flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        Transaksi Sukses Terahir
                                    </h2>
                                </div>
                                <div class="mt-5">
                                    @foreach($transactionSuccess as $transaction)
                                        <div class="intro-x">
                                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                    <img alt="user-profile" src="{{ asset('assets/images/preview-1.jpg') }}">
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
                                    <a href="" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                                </div>
                            </div>
                            <!-- END: Transactions -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Content -->
        @else
            <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="info" data-lucide="info" class="lucide lucide-info w-4 h-4 mr-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>
                <span> Anda belum membuka lapak UMKM,
                    <a data-tw-toggle="modal"
                       data-tw-target="#create-store-form"
                       href="#"
                       class="dropdown-item hover:bg-white/5 underline">klik disini
                    </a>
                </span>&nbsp;untuk mendaftar.
                <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
            </div>
        @endif

</x-app-layout>
