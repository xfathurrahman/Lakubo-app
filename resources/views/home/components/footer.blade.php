<!--Info-->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
    <div class="h-32 p-2 bg-red-400 border border-white lg:p-3">
        <div class="w-full h-full p-2 text-center text-white border border-white">
            <i class="text-lg fa-solid fa-box-open sm:-mt-4"></i>
            <div class="ml-2">
                <h4 class="font-medium">PENGEMBALIAN</h4>
                <p class="leading-4">Barang yang sudah dibeli tidak bisa dikembalikan.</p>
            </div>
        </div>
    </div>
    <div class="h-32 p-2 bg-red-400 border border-white lg:p-3">
        <div class="w-full h-full p-2 text-center text-white border border-white">
            <i class="-mt-4 fas fa-route tesm:xt-lg"></i>
            <div class="ml-2">
                <h4 class="font-medium">PENGIRIMAN</h4>
                <p class="leading-4">Pastikan menulis alamat dengan benar.</p>
            </div>
        </div>
    </div>
    <div class="h-32 p-2 bg-red-400 border border-white lg:p-3">
        <div class="w-full h-full p-2 text-center text-white border border-white">
            <i class="text-lg fas fa-search-dollar sm:-mt-4"></i>
            <div class="ml-2">
                <h4 class="font-medium">PEMBAYARAN</h4>
                <p class="leading-4">Teliti sebelum melakukan pembayaran.</p>
            </div>
        </div>
    </div>
    <div class="h-32 p-2 bg-red-400 border border-white lg:p-3">
        <div class="w-full h-full p-2 text-center text-white border border-white">
            <i class="text-lg fa-solid fa-truck-fast sm:-mt-4"></i>
            <div class="ml-2">
                <h4 class="font-medium">PEMBELIAN</h4>
                <p class="leading-4">Barang akan dikirim setelah pesanan dikonfirmasi.</p>
            </div>
        </div>
    </div>
</div>

<div class="w-full p-4 mb-8 bg-white md:flex md:justify-between sm:mb-0">
    <a href="https://goo.gl/maps/f7nPofSVnBwH4TC28" class="w-full mr-4 overflow-hidden rounded-lg h-28 lg:w-8/12 xl:w-9/12">
        <img class="object-cover w-full transform hover:scale-150 cursor-zoom-in h-28" src="{{ asset('assets/images/maps.png') }}" alt="maps" width="100%" height="100%">
    </a>
    <div class="flex items-center justify-center w-full lg:w-4/12 xl:w-3/12">

        <div class="flex flex-col w-1/2 h-full mx-2">
            <span class="w-full my-2 text-sm font-semibold text-center text-gray-900 uppercase sm:my-2 md:my-0">Kebijakan</span>
            <div class="flex flex-col items-center justify-center h-full text-gray-600">
                <a href="{{ route('PP') }}" class="flex justify-center w-full mb-3 text-xs sm:text-sm hover:underline">Kebijakan Privasi</a>
                <a href="{{ route('TAC') }}" class="flex justify-center w-full text-xs sm:text-sm hover:underline">Syarat dan Ketentuan</a>
            </div>
        </div>

        <div class="flex flex-col w-1/2 h-full mx-2">
            <span class="w-full my-2 text-sm font-semibold text-center text-gray-900 uppercase sm:my-2 md:my-0">Kontak Kami</span>
            <div class="flex flex-col items-center justify-center h-full text-gray-600">
                <a href="{{ route('TAC') }}" class="flex justify-center w-full mb-3 text-xs sm:text-sm hover:underline">087785523796</a>
                <a href="{{ route('PP') }}" class="flex justify-center w-full text-xs sm:text-sm hover:underline">contact@lakubo.shop</a>
            </div>
        </div>

    </div>
</div>

<hr class="m-0 border-t-4 border-gray-200 sm:mx-auto">

<div class="flex items-center justify-center h-10">©2023
    <a href="#" class="mx-1 hover:underline">Lakubo™</a>All Rights Reserved.
    <a href="https://drive.google.com/file/d/1ROYYcWhFNLVSdAJJKxxO39OJCiArU2QV/view?usp=sharing" class="ml-2 text-blue-400">Unduh Aplikasi Android</a>
</div>
