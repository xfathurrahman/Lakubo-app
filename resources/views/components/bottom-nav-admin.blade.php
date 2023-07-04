<a href="{{ route('home')}}" class="flex flex-col items-center relative w-12">
    <i class="fa-solid fa-house mb-1"></i>
    <span class="{{ Request::is('/') ? 'block' : 'hidden' }} text-xs font-medium">Beranda</span>
</a>
<a href="{{ route('admin.products')}}" class="flex flex-col items-center w-12">
    <i class="fa-solid fa-boxes-stacked mb-1"></i>
    <span class="{{ Request::is('admin/products') ? 'block' : 'hidden' }} text-xs font-medium">Produk</span>
</a>

<button class="flex flex-col items-center w-12" onclick="toggleDropdown()">
    <i class="fa-solid fa-arrow-right-arrow-left mb-1"></i>
    <span class="{{ Request::is('admin/transactions/*') ? 'block' : 'hidden' }} text-xs font-medium">Transaksi</span>
    <div id="dropdown" class="absolute hidden w-28 mt-2 mb-5 bg-red-400 rounded-md shadow-lg z-10 right-16 bottom-full">
        <ul class="py-2 space-y-2">
            <li class="flex items-center text-left pl-2">
                <a href="{{ route('admin.transaction.customers') }}"
                   class="rounded-md p-1 w-full hover:bg-white hover:bg-opacity-20">
                    <i class="fa-solid fa-store mr-1"></i>
                    Pelanggan
                </a>
            <li>
            <li class="flex items-center text-left pl-3">
                <a href="{{ route('admin.transaction.stores') }}"
                    class="rounded-md p-1 w-full hover:bg-white hover:bg-opacity-20">
                    <i class="fa-solid fa-id-badge mr-1.5"></i>
                    Penjual
                </a>
            </li>
        </ul>
        <span class="absolute right-12 -bottom-1.5 w-4 h-4 transform rotate-45 bg-red-400"></span>
    </div>
</button>

<a href="{{ route('profile.edit')}}" class="flex flex-col items-center w-12 relative">
    <i class="fa-solid fa-user mb-1"></i>
    <span class="{{ Request::is('profile') ? 'block' : 'hidden' }} text-xs font-medium">Akun</span>
</a>
