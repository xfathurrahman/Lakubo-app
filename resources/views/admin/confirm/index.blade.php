<x-app-layout>

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

    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin-confirmOrders') }}
    @endsection

    <!-- BEGIN: confirm Notification Content -->
    <div id="confirm-notification-content" class="toastify-content hidden flex">
        <i class="text-success" data-lucide="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">Dikonfirmasi.</div>
            <div class="text-slate-500 mt-1">Behasil di konfirmasi.</div>
        </div>
    </div>
    <!-- END: confirm Notification Content -->

    <!-- BEGIN: Content -->
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex justify-between items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500 mr-2">
                    <input type="text" class="input form-control rounded w-14 sm:w-48 box pr-10" placeholder="Cari...">
                    <i class="w-4 h-4 absolute mt-2.5 mb-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 sm:overflow-auto 2xl:overflow-visible">
            <table id="order-table" class="table table-report w-full table-fixed -mt-2">
                <thead class="hidden">
                <tr>
                    <th class="whitespace-nowrap">ID Pesanan</th>
                    <th class="whitespace-nowrap">Pelanggan</th>
                    <th class="whitespace-nowrap text-center">Pelapak</th>
                    <th class="whitespace-nowrap text-center">Waktu Pengiriman</th>
                    <th class="whitespace-nowrap text-center">Resi</th>
                    <th class="whitespace-nowrap text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @if (empty($orders))
                        <tr>
                            <td colspan="6" class="text-center h-40">Tidak ada order yang menunggu konfirmasi.</td>
                        </tr>
                    @else
                        @include('admin.confirm.partials.confirm_order_table', ['orders' => $orders])
                    @endif
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

                $('.btn-confirm-order').click(function() {
                    var confirmButton = $(this);

                    // Menonaktifkan tombol saat proses loading
                    confirmButton.prop('disabled', true);

                    var order_id = confirmButton.data('order-id');
                    var row = confirmButton.closest('.order-row');
                    var url = '{{ route("admin.confirm.order", ":order_id") }}';
                    url = url.replace(':order_id', order_id);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                            } else {
                                // Handle error response
                                console.log(response.message);
                            }
                            Toastify({
                                node: $("#confirm-notification-content").clone().removeClass("hidden")[0],
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "center",
                                stopOnFocus: true,
                            }).showToast();
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX error
                            console.log(error);
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
