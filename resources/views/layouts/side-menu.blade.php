@include('components.mobile-menu')
<div class="flex mt-[4.7rem] md:mt-0">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">

        @if(Request::is('admin/*'))
            <a href="{{ route('admin.dashboard') }}" class="intro-x flex items-center mb-10">
                <img alt="Lakubo - Lapak UMKM Boyolali" class="w-40" src="{{ asset('assets/images/lakubo-logo copy.svg') }}">
                <span class="hidden xl:block font-medium text-white text-lg absolute mt-24 ml-10 truncate capitalize w-40"> {{ auth()->user()->name }} </span>
            </a>
        @elseif(Request::is('seller/*'))
            <a href="{{ route('seller.dashboard') }}" class="intro-x flex items-center mb-10">
                <img alt="Lakubo - Lapak UMKM Boyolali" class="w-40" src="{{ asset('assets/images/lakubo-logo copy.svg') }}">
                @if(auth()->user()->stores)
                    <span class="hidden xl:block font-medium text-white text-lg absolute mt-24 ml-10 truncate capitalize w-40"> {{ auth()->user()->stores->name }} </span>
                @else
                    <span class="hidden xl:block text-white text-lg ml-3 capitalize"> Belum buka lapak </span>
                @endif
            </a>
        @else
            <a href="{{ route('profile.edit') }}" class="intro-x flex items-center mb-10">
                <img alt="Lakubo - Lapak UMKM Boyolali" class="w-40" src="{{ asset('assets/images/lakubo-logo copy.svg') }}">
                <span class="hidden xl:block font-medium text-white text-lg absolute mt-24 ml-10 truncate capitalize w-40"> {{ auth()->user()->name }} </span>
            </a>
        @endif

        <div class="side-nav__devider my-6"></div>
        <ul>
            @if(Request::is('seller/*'))
                @if(auth()->user()->hasRole('seller'))
                    <li>
                        <a href="{{ route('seller.dashboard') }}" class="side-menu {{ Request::is('seller/dashboard') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="flame"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <hr class="opacity-30 my-6 intro-x">
                    <li>
                        <a href="{{ url('seller/store') }}" class="side-menu {{ Request::is('seller/store') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="side-menu__title"> Lapak Saya</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.products.index') }}" class="side-menu {{ Request::is('seller/products*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title">Produk Saya</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.orders.index') }}" class="side-menu {{ Request::is('seller/order*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                            <div class="side-menu__title"> Pesanan </div>
                        </a>
                    </li>
                    <hr class="opacity-30 my-6 intro-x">
                    <li>
                        <a href="{{ route('seller.withdraw.index') }}" class="side-menu {{ Request::is('seller/withdraw*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="wallet"></i> </div>
                            <div class="side-menu__title"> Penarikan Dana </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.transaction.index') }}" class="side-menu {{ Request::is('seller/transaction*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title"> Riwayat Transaksi </div>
                        </a>
                    </li>
                @endif
            @elseif(Request::is('admin/*'))
                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="side-menu {{ Request::is('admin/dashboard') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="flame"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products') }}" class="side-menu {{ Request::is('admin/products') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title">Produk UMKM</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stores') }}" class="side-menu {{ Request::is('admin/stores') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="side-menu__title">Pelapak UMKM</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/manage/users')}}" class="side-menu {{ Request::is('admin/manage/users') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                            <div class="side-menu__title">Pengguna</div>
                        </a>
                    </li>
                    <hr class="opacity-30 my-6 intro-x">
                    <li>
                        <a href="{{url('admin/confirm/orders')}}" class="side-menu {{ Request::is('admin/confirm/orders') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="truck"></i> </div>
                            <div class="side-menu__title">Konfirmasi Pesanan</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu {{ Request::is('admin/transactions/*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="slack"></i> </div>
                            <div class="side-menu__title">
                                Transaksi
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.transaction.stores') }}" class="side-menu {{ Request::is('admin/transactions/stores') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title"> Pelapak </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.transaction.customers') }}" class="side-menu {{ Request::is('admin/transactions/customers') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title"> Pengguna </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="side-menu {{ Request::is('admin/withdrawal/*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="wallet"></i> </div>
                            <div class="side-menu__title">
                                Penarikan Dana
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{url('admin/withdrawal/customers')}}" class="side-menu {{ Request::is('admin/withdrawal/customers') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title">Pengguna</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin/withdrawal/stores')}}" class="side-menu {{ Request::is('admin/withdrawal/stores') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title">Pelapak</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--<li>
                        <a href="{{ route('admin.carousels.index') }}" class="side-menu {{ Request::is('admin/carousels') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title">Carousel</div>
                        </a>
                    </li>--}}
                    <li>
                        <a href="#" class="side-menu {{ Request::is('admin/categories/*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                            <div class="side-menu__title">
                                Kelola Kategori
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.categories.products') }}" class="side-menu {{ Request::is('admin/categories/products') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title"> Produk </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories.stores') }}" class="side-menu {{ Request::is('admin/categories/stores') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title"> Lapak </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <hr class="opacity-30 my-6 intro-x">
                    <li>
                        <a href="#" class="side-menu {{ Request::is('admin/manage/roles') || Request::is('admin/manage/permissions') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="cpu"></i> </div>
                            <div class="side-menu__title">
                                Pengembangan
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{url('admin/manage/roles')}}" class="side-menu {{ Request::is('admin/manage/roles') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title">Peran</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin/manage/permissions')}}" class="side-menu {{ Request::is('admin/manage/permissions') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title">Hak Akses</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @else
                @if (auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ url('profile') }}" class="side-menu {{ Request::is('profile') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                            <div class="side-menu__title"> Akun Saya</div>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ url('profile') }}" class="side-menu {{ Request::is('profile') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                            <div class="side-menu__title"> Akun Saya</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.orders') }}" class="side-menu {{ Request::is('customer/order*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                            <div class="side-menu__title"> Pesanan saya </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.withdraw.index') }}" class="side-menu {{ Request::is('customer/withdraw*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="wallet"></i> </div>
                            <div class="side-menu__title"> Penarikan Dana </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.transaction.index') }}" class="side-menu {{ Request::is('customer/transaction*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title"> Riwayat Transaksi </div>
                        </a>
                    </li>
                @endif
            @endif
        </ul>

    </nav>
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content mb-16 sm:mb-0">
        @include('components.top-bar')
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <!-- END: Content -->
</div>

