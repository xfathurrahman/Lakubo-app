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
        {{ Breadcrumbs::render('customer-withdrawal') }}
    @endsection

    <!-- BEGIN: Reject Notification Content -->
    <div id="confirm-notification-content" class="toastify-content hidden flex">
        <i class="text-success" data-lucide="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">Lakubo</div>
            <div class="text-slate-500 mt-1">Tempatnya jual - beli UMKM boyolali.</div>
        </div>
    </div>
    <!-- END: Reject Notification Content -->

    <!-- BEGIN: Notification Content -->
    <div id="success-notification-content" class="toastify-content hidden">
        <div class="flex">
            <i class="text-success" data-lucide="check-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">Berhasil diperbarui!</div>
                <div class="text-slate-500 mt-1">Status penarikan dana berhasil diperbarui.</div>
            </div>
        </div>
    </div>
    <!-- END: Notification Content -->

    <!-- BEGIN: Content -->
    <div class="grid grid-cols-12 gap-2 mt-5">
        <div class="intro-y col-span-12 flex justify-between items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500 mr-2">
                    <input type="text" class="input form-control rounded w-14 sm:w-48 box pr-10" placeholder="Cari...">
                    <i class="w-4 h-4 absolute mt-2.5 mb-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
                <select id="filterStatus" class="form-select box ml-2">
                    <option value="">Semua</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                    <option value="processing">Tertunda</option>
                </select>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 sm:overflow-auto 2xl:overflow-visible">
            <table id="order-table" class="table table-report w-full table-fixed -mt-2">
                <thead class="hidden">
                <tr>
                    <th class="whitespace-nowrap">ID Penarikan</th>
                    <th class="whitespace-nowrap">Penarik Dana</th>
                    <th class="whitespace-nowrap">Waktu</th>
                    <th class="whitespace-nowrap text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @include('admin.withdrawal.partials.wd_customer_table', ['custWds' => $custWds])
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
    <!-- END: Content -->

    @section('script')

        <script>
            $(document).ready(function() {

                function copy(obj) {
                  try {
                    if (obj) selectContent(obj)
                    document.execCommand('copy')
                    // clears the current selection
                    window.getSelection().removeAllRanges()
                  } catch (err) {
                    console.log(err)
                  }
                }

                function selectContent(obj) {
                  if (window.getSelection && document.createRange) {
                    let sel = window.getSelection()
                    let range = document.createRange()
                    range.selectNodeContents(obj)
                    sel.removeAllRanges()
                    sel.addRange(range)
                  } else if (document.selection && document.body.createTextRange) {
                    let textRange = document.body.createTextRange()
                    textRange.moveToElementText(obj)
                    textRange.select()
                  }
                }

                $('#panel').mouseover(function(){
                    selectContent(this);
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Menggunakan event "change" pada elemen select dengan ID "changeStatus"
                $(document).on('change', '#changeStatus', function() {
                    var selectedStatus = $(this).val(); // Mendapatkan nilai yang dipilih dari select
                    var transactionId = $(this).closest('tr').data('transaction-id'); // Mendapatkan ID transaksi dari elemen terdekat dengan class "order-row"

                    // Mengirim data ke server menggunakan Ajax
                    $.ajax({
                    url: '{{ route('admin.customer.transaction.update') }}',
                    type: 'POST',
                    data: {
                        status: selectedStatus,
                        transactionId: transactionId
                    },
                    success: function(response) {

                        // Memperbarui elemen terkait
                        $('[data-transaction-id="' + transactionId + '"]').each(function() {
                            var updatedElement = $(this).find('.status');

                            // Hapus elemen select dan ganti dengan teks sesuai status
                            if (selectedStatus === 'approved') {
                                updatedElement.html('<p class="text-green-500">Disetujui</p>');
                            } else if (selectedStatus === 'rejected') {
                                updatedElement.html('<p class="text-red-500">Ditolak</p>');
                            }
                        });

                        // Tindakan yang akan diambil setelah berhasil mengupdate status transaksi
                        console.log('Status transaksi berhasil diperbarui');
                        Toastify({
                            node: $("#success-notification-content").clone().removeClass("hidden")[0],
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                        }).showToast();
                    },
                    error: function(xhr) {
                        // Tindakan yang akan diambil jika terjadi kesalahan
                        console.log('Terjadi kesalahan saat memperbarui status transaksi');
                    }
                    });
                });

            });
        </script>

        <script>
            $(document).ready(function() {

                $('#filterStatus').select2({
                    minimumResultsForSearch: Infinity,
                });

                $('#filterStatus').change(function() {
                    let selectedStatus = $(this).val();
                    $.ajax({
                        url: '{{ route('admin.withdrawal.customer.index') }}',
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
            }
        </script>

    @endsection

</x-app-layout>
