<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection

    <!-- BEGIN: Reject Notification Content -->
    <div id="reject-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">Pesanan Berhasil Diperbarui.</div>
            <div class="text-slate-500 mt-1">Pesanan dengan id #<b>{{ session('success') }}</b> Berhasil di tolak.</div>
        </div>
    </div>
    <!-- END: Reject Notification Content -->

    <!-- BEGIN: Content -->
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex justify-between items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500 mr-2">
                    <input type="text" class="input form-control rounded w-48 box pr-10" placeholder="Cari...">
                    <i class="w-4 h-4 absolute mt-2.5 mb-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
                <select id="filterStatus">
                    <option value="">Semua</option>
                    <option value="awaiting_payment">Menunggu Pembayaran</option>
                    <option value="awaiting_confirm">Menunggu Konfirmasi</option>
                    <option value="confirmed">Dikonfirmasi</option>
                    <option value="packing">Dikemas</option>
                    <option value="delivered">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
            <div class="dropdown ml-2 md:ml-auto">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                      <span class="w-5 h-5 flex items-center justify-center">
                        <i class="w-4 h-4" data-lucide="plus"></i>
                      </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="" class="dropdown-item">
                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <table id="order-table" class="table table-report -mt-2">
                <thead>
                <tr>
                    {{--<th class="whitespace-nowrap">
                        <input class="form-check-input" type="checkbox">
                    </th>--}}
                    <th class="whitespace-nowrap">ID Pesanan</th>
                    <th class="whitespace-nowrap">Pelanggan</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Pembayaran</th>
                    <th class="text-right whitespace-nowrap">
                        <div class="pr-16">Tagihan</div>
                    </th>
                    <th class="text-center whitespace-nowrap">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @include('seller.orders.partials.orders_table', ['orders' => $orders])
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
    <!-- END: Content -->

        @section('script')

            <script>
                $(document).ready(function() {

                    @foreach($orders as $order)
                        $("#copy-tracking-no-" + {{ $order->id }}).click(function() {
                            var copyText = document.getElementById("tracking_no-{{ $order->id }}");
                            copyText.setSelectionRange(0, 99999); // mengatur range seleksi dari karakter 0 hingga 99999
                            var button = this; // simpan referensi ke tombol yang diklik
                            navigator.clipboard.writeText(copyText.value).then(function() {
                                var tooltip = document.createElement("div");
                                tooltip.innerHTML = "Disalin!";
                                tooltip.classList.add("tooltip-copy");
                                $(button).closest('div').append(tooltip);// gunakan referensi tombol untuk menambahkan tooltip
                                setTimeout(function() {
                                    $(tooltip).fadeOut("fast", function() {
                                        $(this).remove();
                                    });
                                }, 1000);
                            }, function() {
                                console.error("Tidak dapat menyalin teks");
                            });
                        });
                    @endforeach

                    @if(session('success'))
                    // Success notification
                    Toastify({
                        node: $("#reject-notification-content").clone().removeClass("hidden")[0],
                        duration: 4000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "center",
                        stopOnFocus: true,
                    }).showToast();
                    @endif

                    $('#filterStatus').select2({
                        minimumResultsForSearch: Infinity,
                    });

                    $('#filterStatus').change(function() {
                        let selectedStatus = $(this).val();
                        $.ajax({
                            url: '{{ route('seller.orders.index') }}',
                            data: {status: selectedStatus},
                            success: function(result) {
                                $('#order-table tbody').html(result);
                            },
                        });
                    });
                    $('input[type="text"]').on('keyup', searchTable);
                });

                function searchTable() {
                    // Ambil nilai input pencarian
                    var input = $(this).val().toLowerCase();
                    // Iterasi setiap baris pada tbody tabel
                    $('#order-table tr').filter(function () {
                        // Jika nilai pencarian tidak ditemukan pada baris ini, sembunyikan baris ini
                        $(this).toggle($(this).text().toLowerCase().indexOf(input) > -1);
                    });
                }

            </script>

        @endsection

</x-app-layout>
