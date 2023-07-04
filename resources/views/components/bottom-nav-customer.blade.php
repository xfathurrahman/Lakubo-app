<a href="{{ route('home')}}" class="flex flex-col items-center relative w-12">
    <i class="fa-solid fa-house mb-1"></i>
    <span class="{{ Request::is('/') ? 'block' : 'hidden' }} text-xs font-medium">Beranda</span>
</a>
<a href="{{ route('customer.orders')}}" class="flex flex-col items-center w-12">
    <i class="fa-solid fa-boxes-stacked mb-1"></i>
    <span class="{{ Request::is('customer/orders') ? 'block' : 'hidden' }} text-xs font-medium">Pesanan</span>
</a>
<a href="{{ route('customer.transaction.index')}}" class="flex flex-col items-center w-12">
    <i class="fa-solid fa-arrow-right-arrow-left mb-1"></i>
    <span class="{{ Request::is('customer/transaction') ? 'block' : 'hidden' }} text-xs font-medium">Transaksi</span>
</a>
<a href="{{ route('profile.edit')}}" class="flex flex-col items-center w-12 relative">
    <i class="fa-solid fa-user mb-1"></i>
    <span class="{{ Request::is('profile') ? 'block' : 'hidden' }} text-xs font-medium">Akun</span>
</a>
