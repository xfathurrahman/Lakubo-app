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
    </style>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('transaction') }}
    @endsection

    <!-- BEGIN: Reject Notification Content -->
    <div id="confirm-notification-content" class="toastify-content hidden flex">
        <i class="text-success" data-lucide="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">Terimakasih Telah Berbelanja di Lakubo!</div>
            <div class="text-slate-500 mt-1">Tempatnya jual - beli UMKM boyolali.</div>
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
                <select id="filterStatus" class="form-select box ml-2">
                    <option value="">Semua</option>
                    <option value="purchase">Pembayaran</option>
                    <option value="withdrawal">Penarikan</option>
                    <option value="refund">Pengembalian</option>
                </select>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <table id="order-table" class="table table-report -mt-2">
                <thead>
                <tr>
                    <th class="whitespace-nowrap">ID Transaksi</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap text-center">Metode Pembayaran</th>
                    <th class="whitespace-nowrap text-center">Jenis Transaksi</th>
                    <th class="whitespace-nowrap text-center">Status</th>
                    <th class="whitespace-nowrap text-center">Jumlah</th>
                </tr>
                </thead>
                <tbody>
                @include('customer.transaction.partials.transaction_table', ['transactions' => $transactions])
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
                };

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
                };
                $('#panel1').mouseover(function(){
                 selectContent(this);
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
                        url: '{{ route('customer.transaction.index') }}',
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
