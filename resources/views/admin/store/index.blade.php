<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin_stores') }}
    @endsection

    <style>
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

        <!-- BEGIN: error Notification Content -->
        <div id="error-notification-content" class="toastify-content hidden flex"> <i class="fa-regular fa-circle-exclamation text-primary text-lg"></i>
            <div class="ml-4 mr-4 w-72">
                <div class="font-medium truncate">Tidak dapat dihapus.</div>
                <div class="text-slate-500 mt-1 space-y">
                    {{ Session::get('error') }}
                </div>
            </div>
        </div>
        <!-- END: error Notification Content -->

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <div class="w-full sm:w-52 relative text-slate-500 sm:mr-2">
                    <input type="text" class="input form-control rounded w-14 sm:w-48 box pr-10" placeholder="Cari...">
                    <i class="w-4 h-4 absolute mt-2.5 mb-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 sm:overflow-auto 2xl:overflow-visible">
                <table id="order-table" class="table table-report w-full table-fixed -mt-2">
                    <thead class="hidden">
                    <tr>
                        <th class="whitespace-nowrap">
                            #ID
                        </th>
                        <th class="whitespace-nowrap">PELAPAK</th>
                        <th class="text-center whitespace-nowrap">NAMA LAPAK</th>
                        <th class="text-center whitespace-nowrap">KATEGORI LAPAK</th>
                        <th class="text-center whitespace-nowrap">TOTAL PRODUK</th>
                        <th class="text-center whitespace-nowrap">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stores as $store)
                    <tr class="intro-x" id="tr-content">
                        <td class="w-10 hidden">
                            {{ $store -> id }}
                        </td>
                        <td class="!py-3.5">
                            <div class="sm:hidden flex items-center">
                                <div class="w-9 h-9 image-fit zoom-in sm:hidden">
                                    @isset($store->users->profile_photo_path)
                                        <img class="rounded-full" src="{{ asset('storage/profile-photos/'. $store->users->profile_photo_path) }}" alt="pp-owner"/>
                                    @else
                                        <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $store->name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                                    @endisset                                </div>
                                <a href="" class="flex flex-col ml-2 w-44">
                                    <span class="font-medium text-lg text-red-400 truncate">
                                        <i class="fa-solid fa-store text-sm mr-2"></i>{{ $store->name }}
                                    </span>
                                    <span class="text-xxs text-gray-400 -mt-1 truncate">
                                        <i class="fa-solid fa-tags mr-1"></i>{{ $store->storeCategories->name }}
                                    </span>
                                </a>
                            </div>
                            <div class="flex items-center my-2 sm:my-0">
                                <div class="w-9 h-9 image-fit zoom-in hidden sm:block">
                                    @isset($store->users->profile_photo_path)
                                        <img class="rounded-full" src="{{ asset('storage/profile-photos/'. $store->users->profile_photo_path) }}" alt="pp-owner"/>
                                    @else
                                        <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $store->name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                                    @endisset
                                </div>
                                <div class="sm:ml-4">
                                    <a href="" class="font-medium whitespace-nowrap">{{ $store->users->name }}</a>
                                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $store->users->email }}</div>
                                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5 sm:hidden">{{ count($store->products) }} Produk</div>
                                </div>
                            </div>
                            <div class="flex justify-end px-2 sm:hidden">
                                <a class="flex items-center bg-gray-50 px-4 py-1 rounded text-danger" href="#" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-{{$store->id}}"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Hapus </a>
                            </div>
                        </td>
                        <td class="text-center whitespace-nowrap hidden"> <a class="flex items-center justify-center underline decoration-dotted" href="#">{{ $store->name }}</a> </td>
                        <td class="text-center capitalize whitespace-nowrap hidden">{{ $store->storeCategories->name }}</td>
                        <td class="text-center whitespace-nowrap hidden">{{ count($store->products) }} item</td>
                        <td class="table-report__action w-56 whitespace-nowrap hidden">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-{{$store->id}}"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>

        @include('.admin.store.partials.delete-store-modal')

        @section('script')
            <script>
                $(document).ready(function () {
                    $('input[type="text"]').on('keyup', searchTable);
                })

                function searchTable() {
                    var input = $(this).val().toLowerCase();
                    $('#order-table tbody tr').filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(input) > -1);
                    });
                }

                <!-- BEGIN: Notification Error-->
                    @if(Session::has('error'))
                    Toastify({
                        node: $("#error-notification-content").clone().removeClass("hidden")[0],
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        offset: {
                            y: 80
                        },
                    }).showToast();
                    @php
                        Session::forget('error');
                    @endphp
                    @endif
                <!-- END: Notification -->

            </script>
        @endsection

</x-app-layout>
