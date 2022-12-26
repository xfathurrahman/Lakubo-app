@include('components.mobile-menu')
<div class="flex mt-[4.7rem] md:mt-0">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="http://127.0.0.1:8000/" class="intro-x flex items-center pl-5 pt-4">
            <img alt="Lakubo - Lapak UMKM Boyolali" class="w-6" src="{{ asset('assets/images/logo.svg') }}">
            <span class="hidden xl:block text-white text-lg ml-3 capitalize"> {{ Auth::user()->name }} </span>
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" class="side-menu {{ Request::is('dashboard') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="side-menu__title"> Dashboard </div>
                </a>
            </li>
            <li>
                <a href="#" class="side-menu {{ Request::is('profile') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                    <div class="side-menu__title"> Profile Saya</div>
                </a>
            </li>
            <li>
                <a href="{{ route('seller.index') }}" class="side-menu {{ Request::is('seller') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="side-menu__title"> Dashboard</div>
                </a>
            </li>
            <li>
                <a href="{{ route('seller.products.index') }}" class="side-menu {{ Request::is('seller/products') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                    <div class="side-menu__title">Produk Saya</div>
                </a>
            </li>
            <li>
                <a href="#" class="side-menu {{ Request::is('product-list') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                    <div class="side-menu__title">Produk UMKM</div>
                </a>
            </li>
            <li>
                <a href="#" class="side-menu {{ Request::is('categories') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                    <div class="side-menu__title"> Kategori </div>
                </a>
            </li>
            <li>
                <a href="#" class="side-menu {{ Request::is('orders') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                    <div class="side-menu__title"> Pesanan Saya </div>
                </a>
            </li>
            <li>
                <a href="#" class="side-menu {{ Request::is('transaction') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                    <div class="side-menu__title"> Transaksi </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="side-menu {{ Request::is('admin/*') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title">
                        Kelola Pengguna
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{url('admin/users')}}" class="side-menu {{ Request::is('admin/users') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title">Daftar Pengguna</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/roles')}}" class="side-menu {{ Request::is('admin/roles') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title">Daftar Peran</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/permissions')}}" class="side-menu {{ Request::is('admin/permissions') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title">Hak Akses</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu {{ Request::is('profile/*') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title">
                        Pengaturan
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{url('profile')}}" class="side-menu {{ Request::is('admin/users') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title">Profile</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu {{ Request::is('admin/roles') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title">Alamat</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu {{ Request::is('profile/password') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                            <div class="side-menu__title">Kata Sandi</div>
                        </a>
                    </li>
                </ul>
            </li>
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
