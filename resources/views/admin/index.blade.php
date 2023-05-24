<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin_dashboard') }}
    @endsection

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
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="truck" class="report-box__icon text-success"></i>
                                                <div class="ml-auto">
                                                    <a href="{{ route('admin.confirmOrders') }}" class="report-box__indicator bg-primary cursor-pointer"> Lihat Semua
                                                        <i class="fa-solid fa-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ $totalWaitingConfirm }}</div>
                                            <div class="text-base text-slate-500 mt-1">Menunggu konfirmasi</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="home" class="report-box__icon text-primary"></i>
                                                <div class="ml-auto">
                                                    <a href="{{ route('admin.stores') }}" class="report-box__indicator bg-primary cursor-pointer"> Lihat Semua
                                                        <i class="fa-solid fa-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ $totalStores }}</div>
                                            <div class="text-base text-slate-500 mt-1">Total Pelapak</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="box" class="report-box__icon text-pending"></i>
                                                <div class="ml-auto">
                                                    <a href="{{ route('admin.products') }}" class="report-box__indicator bg-primary cursor-pointer"> Lihat Semua
                                                        <i class="fa-solid fa-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ $totalProducts }}</div>
                                            <div class="text-base text-slate-500 mt-1">Total produk</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="users" class="report-box__icon text-warning"></i>
                                                <div class="ml-auto">
                                                    <a href="{{ route('admin.users.index') }}" class="report-box__indicator bg-primary cursor-pointer"> Lihat Semua
                                                        <i class="fa-solid fa-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ $totalUser }}</div>
                                            <div class="text-base text-slate-500 mt-1">Total pengguna</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: General Report -->

                        <!-- BEGIN: END: Top Seller Sales -->
                        <div class="col-span-12 xl:col-span-8 mt-6">
                            <div class="intro-y flex items-center h-10">
                                <h2 class="text-lg font-medium truncate mr-5">
                                    Produk Terlaris
                                </h2>
                            </div>
                            <div class="mt-5">
                                @foreach($bestSellingProducts as $product)
                                    <div class="intro-y">
                                        <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                            <div class="w-40">
                                                <div class="flex">
                                                    @foreach ($product->productImages as $index => $image)
                                                        <div class="w-10 h-10 image-fit zoom-in{{ $index >= 1 ? ' -ml-3' : '' }}">
                                                            <img alt="Product-img" class="rounded-full"
                                                                src="{{ asset("storage/product-images")."/".$image->image_path }}"
                                                            >
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="ml-4 w-9/12 overflow-hidden mr-4">
                                                <div class="font-medium w-full truncate">{{ $product->name }}</div>
                                                <div class="text-slate-500 text-xs mt-0.5">{{ $product->stores->name }}</div>
                                            </div>
                                            <div class="py-1 px-2 rounded-full text-xs bg-success text-white cursor-pointer font-medium whitespace-nowrap">{{ $product->total_sold }} Terjual</div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="{{ route('admin.products') }}" class="intro-y w-full block text-center rounded-md py-4 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                            </div>
                        </div>
                        <!-- END: Top Seller Sales -->

                        <!-- BEGIN: END: Top Seller Sales -->
                        <div class="col-span-12 xl:col-span-4 sm:mt-6">
                            <div class="intro-y flex items-center h-10">
                                <h2 class="text-lg font-medium truncate mr-5">
                                    Lapak Terlaris
                                </h2>
                            </div>
                            <div class="mt-5">
                                @foreach($topStores as $seller)
                                    <div class="intro-y">
                                        <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                            <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                                <div class="owner-pp">
                                                    @isset($seller->users->profile_photo_path)
                                                        <img class="rounded-full" src="{{ asset('storage/profile-photos/'. $seller->users->profile_photo_path) }}" alt="pp-owner"/>
                                                    @else
                                                        <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $seller->name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                                                    @endisset
                                                </div>
                                            </div>
                                            <div class="ml-4 w-9/12 overflow-hidden mr-4">
                                                <div class="font-medium w-full truncate">{{ $seller->name }}</div>
                                                <div class="text-slate-500 text-xs mt-0.5">{{ $seller->users->name }}</div>
                                            </div>
                                            <div class="py-1 px-2 rounded-full text-xs bg-success text-white cursor-pointer font-medium whitespace-nowrap">{{ $seller->orders_count }} Penjualan</div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="{{ route('admin.stores') }}" class="intro-y w-full block text-center rounded-md py-4 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                            </div>
                        </div>
                        <!-- END: Top Seller Sales -->
                    </div>
                </div>
                <div class="col-span-12 2xl:col-span-3">
                    <div class="2xl:border-l sm:ml-6 -mb-10 pb-10">
                        <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                            <!-- BEGIN: Transactions -->
                            <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                                <div class="intro-x flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        Transaksi terbaru pengguna
                                    </h2>
                                </div>
                                <div class="mt-5">
                                    @foreach($userTransactions->take(5) as $transaction)
                                        <div class="intro-x">
                                            <div class="box px-5 py-3 mb-2.5 flex items-center zoom-in">
                                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                    <img alt="user-profile" src="{{ asset('assets/images/preview-1.jpg') }}">
                                                </div>
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">{{ $transaction->user->name }}</div>
                                                    <div class="text-slate-500 text-xs mt-0.5">{{ Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}</div>
                                                </div>
                                                @php
                                                    $grand_total_formatted = number_format((float)$transaction->amount/1000, 2, '.', '');
                                                @endphp
                                                @if($transaction->payment_type === 'purchase')
                                                    <div class="text-success whitespace-nowrap">+ @currency( (float) $grand_total_formatted)K</div>
                                                @else
                                                    <div class="text-danger whitespace-nowrap">- @currency( (float) $grand_total_formatted)K</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <a href="{{ route('admin.transaction.customers') }}" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                                </div>
                            </div>
                            <!-- END: Transactions -->
                        </div>
                    </div>
                    <div class="2xl:border-l sm:ml-6 -mb-10 pb-10">
                        <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                            <!-- BEGIN: Transactions -->
                            <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                                <div class="intro-x flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        Transaksi terbaru pelapak
                                    </h2>
                                </div>
                                <div class="mt-5">
                                    @foreach($storeTransactions->take(5) as $transaction)
                                        <div class="intro-x">
                                            <div class="box px-5 py-3 mb-2.5 flex items-center zoom-in">
                                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                    <img alt="user-profile" src="{{ asset('assets/images/preview-1.jpg') }}">
                                                </div>
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">{{ $transaction->store->name }}</div>
                                                    <div class="text-slate-500 text-xs mt-0.5">{{ Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}</div>
                                                </div>
                                                @php
                                                    $grand_total_formatted = number_format((float)$transaction->amount/1000, 2, '.', '');
                                                @endphp
                                                @if($transaction->payment_type === 'selling')
                                                    <div class="text-success whitespace-nowrap">+ @currency( (float) $grand_total_formatted)K</div>
                                                @else
                                                    <div class="text-danger whitespace-nowrap">- @currency( (float) $grand_total_formatted)K</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <a href="{{ route('admin.transaction.stores') }}" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat Semua</a>
                                </div>
                            </div>
                            <!-- END: Transactions -->
                        </div>
                    </div>
                </div>
            </div>
        <!-- END: Content -->

</x-app-layout>
