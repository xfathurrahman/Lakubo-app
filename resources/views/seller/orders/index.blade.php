<x-app-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection

    <style>
        .select2.select2-container {
            width: 200px !important;
        }
        .select2.select2-container .select2-selection {
            box-shadow: 0 3px 20px #0000000b;
            position: relative;
            border-radius: 0.375rem;
            border-color: transparent;
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            height: 38px;
            margin-bottom: 5px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__arrow {
            background: #f8f8f8;
            border-left: 1px solid #ccc;
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
            height: 38px;
            width: 33px;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            color: #333;
            line-height: 38px;
            padding-right: 33px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: -1px;
            right: -1px;
            width: 20px;
        }
        .select2-container .select2-dropdown .select2-results ul {
            background: #fff;
            border: 1px solid #cecece;
        }
        @media (min-width: 640px) {
            #order-table thead {
                display: table-header-group;
            }

            #order-table {
                table-layout: auto;
            }

            #tr-content td {
                display: table-cell;
            }
        }
    </style>

    <!-- BEGIN: Reject Notification Content -->
    <div id="reject-notification-content" class="toastify-content hidden">
        <div class="flex">
            <i class="text-success" data-lucide="check-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">Pesanan Berhasil Diperbarui.</div>
                <div class="text-slate-500 mt-1">Pesanan dengan id #<b>{{ session('success') }}</b> Berhasil di tolak.</div>
            </div>
        </div>
    </div>
    <!-- END: Reject Notification Content -->

    <!-- BEGIN: Content -->
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex justify-between items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500 mr-2">
                    <input type="text" class="input form-control rounded w-14 sm:w-48 box pr-10" placeholder="Cari...">
                    <i class="w-4 h-4 absolute mt-2.5 mb-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
                <select id="filterStatus" class="form-select box ml-2">
                    <option value="">Semua</option>
                    <option value="awaiting_confirm">Menunggu Konfirmasi</option>
                    <option value="confirmed">Dikonfirmasi</option>
                    <option value="packing">Dikemas</option>
                    <option value="delivered">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="intro-y col-span-12 sm:overflow-auto 2xl:overflow-visible">
            <table id="order-table" class="table table-report w-full table-fixed -mt-2">
              <thead class="hidden">
                <tr>
                    <th class="whitespace-nowrap">ID Pesanan</th>
                    <th class="whitespace-nowrap">Pesanan</th>
                    <th class="text-center whitespace-nowrap">Status</th>
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
    </div>

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
                var input = $(this).val().toLowerCase();
                $('#order-table tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(input) > -1);
                });

                // Tampilkan kembali thead jika ada baris yang ditampilkan pada tbody
                if ($('#order-table tbody tr:visible').length > 0) {
                    $('#order-table thead').show();
                } else {
                    $('#order-table thead').hide();
                }
            }
        </script>
    @endsection

</x-app-layout>
