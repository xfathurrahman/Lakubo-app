<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin_products') }}
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
                {{-- <div class="dropdown" data-tw-placement="bottom-start">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">Aksi &emsp;
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i></span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
                                    Print </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    Export ke Excel </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    Export ke PDF </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <div class="w-full sm:w-52 relative text-slate-500 sm:mr-2">
                    <input type="text" class="input form-control rounded w-14 sm:w-48 box pr-10" placeholder="Cari...">
                    <i class="w-4 h-4 absolute mt-2.5 mb-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 sm:overflow-auto 2xl:overflow-visible">
                <table id="order-table" class="table table-report w-full table-fixed -mt-2">
                    <thead class="hidden">
                    @if ($products->count())
                        <tr>
                            <th class="whitespace-nowrap">GAMBAR PRODUK</th>
                            <th class="whitespace-nowrap">NAMA PRODUK</th>
                            <th class="whitespace-nowrap">LAPAK UMKM</th>
                            <th class="text-center whitespace-nowrap">HARGA</th>
                            <th class="text-center whitespace-nowrap">STOK</th>
                            <th class="text-center whitespace-nowrap">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="intro-x" id="tr-content">
                            <td class="w-52">
                                <div class="flex justify-center">
                                    @foreach($product->productImages as $image)
                                        {{--@if($loop->iteration > 3)
                                            @break
                                        @endif--}}
                                        <div class="w-10 h-10 image-fit zoom-in" style="margin-left: -0.70rem">
                                            <img alt="Product-img" class="tooltip rounded-full"
                                                 src="{{ asset("storage/product-images")."/".$image->image_path }}"
                                                 title="Uploaded {{ Carbon\Carbon::parse($product->created_at)->diffForHumans() }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="pt-2 sm:hidden">
                                    <a href="" class="font-medium text-lg text-center text-red-400 flex justify-center items-center"><i class="fa-solid fa-store text-sm mr-2"></i>{{ $product->stores->name }}</a>
                                    <a href="" class="font-medium break-words text-center line-clamp-2 my-1">{{ $product->name }}</a>
                                    @isset($product->productCategories)
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5 flex justify-between px-2">
                                            <span>{{ $product->productCategories->name }}</span>
                                            <span class="inline-flex">
                                                <i class="fa-solid fa-boxes-stacked mr-1"></i> {{ $product->quantity }}
                                                <p class="mx-2">|</p>
                                                <i class="fa-solid fa-sack-dollar mr-1"></i> @currency($product->price)
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-red-500 text-xs whitespace-nowrap mt-0.5">Belum dikategorikan</div>
                                    @endif
                                    <div class="flex justify-center px-2 pt-3">
                                        <a class="flex items-center bg-gray-50 px-4 py-1 rounded text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-{{$product->id}}"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Hapus </a>
                                    </div>
                                </div>
                            </td>
                            <td class="line-clamp-2 hidden">
                                <a href="" class="font-medium whitespace-nowrap">{{ $product->name }}</a>
                                @isset($product->productCategories)
                                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $product->productCategories->name }}</div>
                                @endif
                            </td>
                            <td class="line-clamp-2 hidden">
                                <a href="" class="font-medium whitespace-nowrap">{{ $product->stores->name }}</a>
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $product->stores->users->name }}</div>
                            </td>
                            <td class="text-center whitespace-nowrap hidden">@currency($product->price)</td>
                            <td class="text-center whitespace-nowrap hidden">{{ $product->quantity }}</td>
                            <td class="table-report__action w-56 whitespace-nowrap hidden">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-{{$product->id}}"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <img class="max-w-3xl max-h-52 mx-auto !shadow-none"
                                     src="{{ asset('assets/images/app/not-found-store.png') }}" alt="iklan kosong">
                                <p class="text-center text-dark py-5">Belum ada produk yang diunggah.</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>

    @include('.admin.product.partials.delete-product-modal')


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
