@include('components.mobile-menu')
<div class="flex mt-[4.7rem] md:mt-0">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">

        @if(Request::is('admin/*'))
            <a href="http://127.0.0.1:8000/admin/dashboard" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Lakubo - Lapak UMKM Boyolali" class="w-6" src="{{ asset('assets/images/logo.svg') }}">
                <span class="hidden xl:block text-white text-lg ml-3 capitalize"> Lakubo Admin </span>
            </a>
        @elseif(Request::is('seller/*'))
            <a href="http://127.0.0.1:8000/seller/dashboard" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Lakubo - Lapak UMKM Boyolali" class="w-6" src="{{ asset('assets/images/logo.svg') }}">
                @if(auth()->user()->stores)
                    <span class="hidden xl:block text-white text-lg ml-3 capitalize"> {{ auth()->user()->stores->name }} </span>
                @else
                    <span class="hidden xl:block text-white text-lg ml-3 capitalize"> Belum buka lapak </span>
                @endif
            </a>
        @else
            <a href="http://127.0.0.1:8000/profile" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Lakubo - Lapak UMKM Boyolali" class="w-6" src="{{ asset('assets/images/logo.svg') }}">
                <span class="hidden xl:block text-white text-lg ml-3 capitalize"> {{ Auth::user()->name }} </span>
            </a>
        @endif

        <div class="side-nav__devider my-6"></div>
        <ul>
            @if(Request::is('seller/*'))
                @if(auth()->user()->hasRole('seller'))
                    <li>
                        <a href="{{ route('seller.dashboard') }}" class="side-menu {{ Request::is('seller/dashboard') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('seller/store') }}" class="side-menu {{ Request::is('seller/store') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i class="fa-solid fa-store w-5 h-5"></i> </div>
                            <div class="side-menu__title"> Lapak Saya</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.products.index') }}" class="side-menu {{ Request::is('seller/products') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title">Produk Saya</div>
                        </a>
                    </li>
                @endif
            @elseif(Request::is('admin/*'))
                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="side-menu {{ Request::is('admin/dashboard') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
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
                        <a href="#" class="side-menu {{ Request::is('transaction') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                            <div class="side-menu__title"> Transaksi </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stores') }}" class="side-menu {{ Request::is('admin/stores') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title">Pelapak UMKM</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu {{ Request::is('admin/') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title">Carousel</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories') }}" class="side-menu {{ Request::is('admin/categories') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title">Kategori</div>
                        </a>
                    </li>
                    {{--<li>
                        <a href="#" class="side-menu {{ Request::is('admin/categories/*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                            <div class="side-menu__title">
                                Kelola Kategori
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.product.categories') }}" class="side-menu {{ Request::is('admin/categories/products') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title"> Produk </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.store.categories') }}" class="side-menu {{ Request::is('admin/categories/stores') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title"> Lapak </div>
                                </a>
                            </li>
                        </ul>
                    </li>--}}
                    <li>
                        <a href="#" class="side-menu {{ Request::is('admin/manage/*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                            <div class="side-menu__title">
                                Kelola Pengguna
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{url('admin/manage/users')}}" class="side-menu {{ Request::is('admin/manage/users') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title">Daftar Pengguna</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin/manage/roles')}}" class="side-menu {{ Request::is('admin/manage/roles') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                    <div class="side-menu__title">Daftar Peran</div>
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
                <li>
                    <a href="{{ url('profile') }}" class="side-menu {{ Request::is('profile') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                        <div class="side-menu__title"> Akun Saya</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.orders') }}" class="side-menu {{ Request::is('customer/order*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                        <div class="side-menu__title"> Pesanan Saya </div>
                    </a>
                </li>
            @endif
        </ul>

    </nav>
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content" style="min-height: 97.5vh;">
        @include('components.top-bar')
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <!-- END: Content -->
</div>
