<!-- BEGIN: Added Notification Content -->
<div id="added-to-cart-notif" class="toastify-content hidden flex items-center">
    <div class="ml-4 mr-4">
        <div class="text-gray-700 font-medium mb-2">Pesanan Berhasil ditambah ke Keranjang.</div>
        <a class="px-2 py-1 rounded bg-green-500 flex justify-center items-center" href="{{ route('customer.cart.index') }}">
            <i class="fa-solid fa-cart-plus text-sm text-white mr-2"></i>Cek Keranjang
        </a>
    </div>
</div>
<!-- END: Added Notification Content -->

<!-- BEGIN: Already Notification Content -->
<div id="already-add-notif" class="toastify-content hidden flex items-center">
    <div class="ml-4 mr-4">
        <div class="text-gray-700 font-medium mb-2">Pesanan sudah ada di Keranjang.</div>
        <a class="px-2 py-1 rounded bg-red-500 flex justify-center items-center" href="{{ route('customer.cart.index') }}">
            <i class="fa-solid fa-cart-plus text-sm text-white mr-2"></i>Cek Keranjang
        </a>
    </div>
</div>
<!-- END: Already Notification Content -->
