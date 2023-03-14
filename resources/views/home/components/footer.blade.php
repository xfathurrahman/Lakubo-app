<!--Info-->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
    <div class="h-32 bg-red-400 border border-white p-2 lg:p-3">
        <div class="text-center text-white border-white border w-full h-full p-2">
            <i class="fa-solid fa-box-open sm:-mt-4 text-lg"></i>
            <div class="ml-2">
                <h4 class="font-medium">PENGEMBALIAN</h4>
                <p class="leading-4">Barang yang sudah dibeli tidak bisa dikembalikan.</p>
            </div>
        </div>
    </div>
    <div class="h-32 bg-red-400 border border-white p-2 lg:p-3">
        <div class="text-center text-white border-white border w-full h-full p-2">
            <i class="fas fa-route -mt-4 tesm:xt-lg"></i>
            <div class="ml-2">
                <h4 class="font-medium">PENGIRIMAN</h4>
                <p class="leading-4">Pastikan menulis alamat dengan benar.</p>
            </div>
        </div>
    </div>
    <div class="h-32 bg-red-400 border border-white p-2 lg:p-3">
        <div class="text-center text-white border-white border w-full h-full p-2">
            <i class="fas fa-search-dollar sm:-mt-4 text-lg"></i>
            <div class="ml-2">
                <h4 class="font-medium">PEMBAYARAN</h4>
                <p class="leading-4">Teliti sebelum melakukan pembayaran.</p>
            </div>
        </div>
    </div>
    <div class="h-32 bg-red-400 border border-white p-2 lg:p-3">
        <div class="text-center text-white border-white border w-full h-full p-2">
            <i class="fa-solid fa-truck-fast sm:-mt-4 text-lg"></i>
            <div class="ml-2">
                <h4 class="font-medium">PEMBELIAN</h4>
                <p class="leading-4">Barang akan dikirim setelah pesanan dikonfirmasi.</p>
            </div>
        </div>
    </div>
</div>

<div class="md:flex md:justify-between p-4 bg-white w-full">
    <a href="https://goo.gl/maps/f7nPofSVnBwH4TC28" class="mr-4 h-28 w-full lg:w-8/12 rounded-lg xl:w-9/12 overflow-hidden">
        <img class="object-cover transform hover:scale-150 cursor-zoom-in h-28 w-full" src="{{ asset('assets/images/maps.png') }}" alt="maps">
    </a>
    <div class="w-full flex lg:w-4/12 xl:w-3/12 justify-center items-center">

        <div class="mx-2 flex flex-col w-1/2 h-full">
            <span class="my-2 sm:my-2 md:my-0 text-sm text-center font-semibold text-gray-900 uppercase w-full">Kebijakan</span>
            <div class="flex flex-col text-gray-600 h-full items-center justify-center">
                <a href="{{ route('PP') }}" class="text-xs sm:text-sm hover:underline w-full flex justify-center mb-3">Kebijakan Privasi</a>
                <a href="{{ route('TAC') }}" class="text-xs sm:text-sm hover:underline w-full flex justify-center">Syarat dan Ketentuan</a>
            </div>
        </div>

        <div class="mx-2 flex flex-col w-1/2 h-full">
            <span class="my-2 sm:my-2 md:my-0 text-sm text-center font-semibold text-gray-900 uppercase w-full">Kontak Kami</span>
            <div class="flex flex-col text-gray-600 h-full items-center justify-center">
                <a href="{{ route('TAC') }}" class="text-xs sm:text-sm hover:underline w-full flex justify-center mb-3">087785523796</a>
                <a href="{{ route('PP') }}" class="text-xs sm:text-sm hover:underline w-full flex justify-center">contact@lakubo.shop</a>
            </div>
        </div>

    </div>
</div>

<hr class="border-t-4 m-0 border-gray-200 sm:mx-auto">

<div class="h-10 flex items-center justify-center">©2023<a href="#" class="mx-1 hover:underline">Lakubo™</a>All Rights Reserved.</div>
