<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden px-4">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Lakubo - Lapak UMKM Boyolali" class="w-20" src="{{ asset('assets/images/lakubo-logo copy.svg') }}">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <div class="scrollable" style="margin-right: 16px">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        <ul class="scrollable__content py-2">
            @if(Request::is('seller/*'))
                @if(auth()->user()->hasRole('seller'))
                    <li>
                        <a href="{{ route('seller.dashboard') }}" class="menu {{ Request::is('seller/dashboard') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="flame"></i> </div>
                            <div class="menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li class="menu__devider my-6"></li>
                    <li>
                        <a href="{{ url('seller/store') }}" class="menu {{ Request::is('seller/store') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="menu__title"> Lapak Saya</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.products.index') }}" class="menu {{ Request::is('seller/products*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="menu__title">Produk Saya</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.orders.index') }}" class="menu {{ Request::is('seller/order*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                            <div class="menu__title"> Pesanan </div>
                        </a>
                    </li>
                    <li class="menu__devider my-6"></li>
                    <li>
                        <a href="{{ route('seller.withdraw.index') }}" class="menu {{ Request::is('seller/withdraw*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="wallet"></i> </div>
                            <div class="menu__title"> Penarikan Dana </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.transaction.index') }}" class="menu {{ Request::is('seller/transaction*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="menu__title"> Riwayat Transaksi </div>
                        </a>
                    </li>
                @endif
            @elseif(Request::is('admin/*'))
                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="menu {{ Request::is('admin/dashboard') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="flame"></i> </div>
                            <div class="menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li class="menu__devider my-6"></li>
                    <li>
                        <a href="{{ route('admin.products') }}" class="menu {{ Request::is('admin/products') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="menu__title">Produk UMKM</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stores') }}" class="menu {{ Request::is('admin/stores') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="menu__title">Pelapak UMKM</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/manage/users')}}" class="menu {{ Request::is('admin/manage/users') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="users"></i> </div>
                            <div class="menu__title">Pengguna</div>
                        </a>
                    </li>
                    <li class="menu__devider my-6"></li>
                    <li>
                        <a href="{{url('admin/confirm/orders')}}" class="menu {{ Request::is('admin/confirm/orders') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="truck"></i> </div>
                            <div class="menu__title">Konfirmasi Pesanan</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu {{ Request::is('admin/transactions/*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="slack"></i> </div>
                            <div class="menu__title">
                                Transaksi
                                <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.transaction.stores') }}" class="menu {{ Request::is('admin/transactions/stores') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title"> Pelapak </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.transaction.customers') }}" class="menu {{ Request::is('admin/transactions/customers') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title"> Pengguna </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="menu {{ Request::is('admin/withdrawal/*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="wallet"></i> </div>
                            <div class="menu__title">
                                Penarikan Dana
                                <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{url('admin/withdrawal/customers')}}" class="menu {{ Request::is('admin/withdrawal/customers') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title">Pengguna</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin/withdrawal/stores')}}" class="menu {{ Request::is('admin/withdrawal/stores') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title">Pelapak</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--<li>
                        <a href="{{ route('admin.carousels.index') }}" class="menu {{ Request::is('admin/carousels') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="menu__title">Carousel</div>
                        </a>
                    </li>--}}
                    <li>
                        <a href="#" class="menu {{ Request::is('admin/categories/*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="tag"></i> </div>
                            <div class="menu__title">
                                Kelola Kategori
                                <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.categories.products') }}" class="menu {{ Request::is('admin/categories/products') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title"> Produk </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories.stores') }}" class="menu {{ Request::is('admin/categories/stores') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title"> Lapak </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu__devider my-6"></li>
                    <li>
                        <a href="#" class="menu {{ Request::is('admin/manage/roles') || Request::is('admin/manage/permissions') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="cpu"></i> </div>
                            <div class="menu__title">
                                Pengembangan
                                <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{url('admin/manage/roles')}}" class="menu {{ Request::is('admin/manage/roles') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title">Peran</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin/manage/permissions')}}" class="menu {{ Request::is('admin/manage/permissions') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="menu__title">Hak Akses</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @else
                @if (auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ url('profile') }}" class="menu {{ Request::is('profile') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="user"></i> </div>
                            <div class="menu__title"> Akun Saya</div>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ url('profile') }}" class="menu {{ Request::is('profile') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="user"></i> </div>
                            <div class="menu__title"> Akun Saya</div>
                        </a>
                    </li>
                    <li class="menu__devider my-6"></li>
                    <li>
                        <a href="{{ route('customer.orders') }}" class="menu {{ Request::is('customer/order*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                            <div class="menu__title"> Pesanan saya </div>
                        </a>
                    </li>
                    <li class="menu__devider my-6"></li>
                    <li>
                        <a href="{{ route('customer.withdraw.index') }}" class="menu {{ Request::is('customer/withdraw*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="wallet"></i> </div>
                            <div class="menu__title"> Penarikan Dana </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.transaction.index') }}" class="menu {{ Request::is('customer/transaction*') ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="menu__title"> Riwayat Transaksi </div>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>
<!-- END: Mobile Menu -->
