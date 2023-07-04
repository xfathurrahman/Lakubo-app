<a href="{{ route('home')}}" class="flex flex-col items-center relative w-12">
    <i class="fa-solid fa-house mb-1"></i>
    <span class="{{ Request::is('/') ? 'block' : 'hidden' }} text-xs font-medium">Beranda</span>
</a>
<a href="{{ route('seller.orders.index')}}" class="flex flex-col items-center w-12 mr-6">
    <i class="fa-solid fa-boxes-stacked mb-1"></i>
    <span class="{{ Request::is('seller/orders') ? 'block' : 'hidden' }} text-xs font-medium">Pesanan</span>
</a>
<a href="{{ route('seller.products.create')}}" class="absolute -top-3 left-1/2 -translate-x-1/2 h-14 w-14 bg-red-700 rounded-full border-[10px] border-red-700">
    <button class="rounded-full w-full h-full bg-gradient-to-br from-red-500 to-red-700 hover:from-red-500 hover:to-red-700 hover:-translate-y-1 transition duration-300" title="add">
        <div class="text-white group-hover:-translate-y-1 transition duration-300 flex items-center justify-center group">
            <svg class="w-6 h-6" viewBox="0 0 512 512">
                <path d="M448 224H288V64h-64v160H64v64h160v160h64V288h160z" fill="currentColor"></path>
            </svg>
        </div>
    </button>
</a>
<a href="{{ route('seller.transaction.index')}}" class="flex flex-col items-center w-12 ml-6">
    <i class="fa-solid fa-arrow-right-arrow-left mb-1"></i>
    <span class="{{ Request::is('seller/transaction') ? 'block' : 'hidden' }} text-xs font-medium">Transaksi</span>
</a>
<button class="flex flex-col items-center w-12 relative" onclick="toggleDropdown()">
    <i class="fa-solid fa-user mb-1"></i>
    <span class="{{ Request::is('profile') || Request::is('seller/dashboard') ? 'block' : 'hidden' }} text-xs font-medium">Akun</span>
    <div id="dropdown" class="absolute hidden w-28 mt-2 mb-5 bg-red-400 rounded-md shadow-lg z-10 right-0 bottom-full">
        <ul class="py-2 space-y-2">
            <li class="flex items-center">
                <a href="{{ route('seller.dashboard') }}"
                   class="rounded-md p-1 w-full hover:bg-white hover:bg-opacity-20">
                    <i class="fa-solid fa-store mr-1"></i>
                    Lapak Saya
                </a>
            <li>
            <li class="flex items-center">
                <a href="{{ route('profile.edit') }}"
                    class="rounded-md p-1 w-full hover:bg-white hover:bg-opacity-20">
                    <i class="fa-solid fa-id-badge mr-1.5"></i>
                    Profil Saya
                </a>
            </li>
        </ul>
        <span class="absolute right-4 -bottom-1.5 w-4 h-4 transform rotate-45 bg-red-400"></span>
    </div>
</button>
