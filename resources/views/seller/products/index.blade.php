<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('products') }}
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

        <!-- BEGIN: Success Notification Content -->
        <div id="success-notification-content" class="toastify-content hidden flex"> <i class="fa-regular fa-circle-check text-success text-lg"></i>
            <div class="ml-4 mr-4 w-72">
                <div class="font-medium truncate">Postingan di simpan.</div>
                <div class="text-slate-500 mt-1 space-y">
                    {{ Session::get('success') }}
                </div>
            </div>
        </div>
        <!-- END: Success Notification Content -->

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

        @if(auth()->user()->stores)
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <div class="w-48 relative text-slate-500 mr-2">
                        <input type="text" class="input form-control rounded w-14 sm:w-48 box pr-10" placeholder="Cari...">
                        <i class="w-4 h-4 absolute mt-2.5 mb-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>
                    <a class="btn btn-primary shadow-md mr-0 ml-auto" href="{{ route('seller.products.create') }}">
                        <div class="flex items-center">
                            <span class="text-sm hidden sm:block">Tambah Produk</span>
                            <span class="fa fa-plus mx-2 my-0.5 sm:hidden"></span>
                        </div>
                    </a>
                    {{-- <div class="dropdown">
                        <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </a>
                                </li>
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export ke Excel </a>
                                </li>
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export ke PDF </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="w-56 relative text-slate-500">
                            <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        </div>
                    </div> --}}
                </div>
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 sm:overflow-auto 2xl:overflow-visible">
                    <table id="order-table" class="table table-report w-full table-fixed -mt-2">
                      <thead class="hidden">
                        @if ($listProducts->count())
                            <tr>
                                <th class="whitespace-nowrap">GAMBAR PRODUK</th>
                                <th class="whitespace-nowrap">NAMA PRODUK</th>
                                <th class="text-center whitespace-nowrap">STOK</th>
                                <th class="text-center whitespace-nowrap">BERAT</th>
                                <th class="text-center whitespace-nowrap">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($listProducts as $product)
                            <tr class="intro-x" id="tr-content">
                                <td class="w-52">
                                    <div class="flex justify-center">
                                        @foreach($product->productImages as $image)
                                            {{--@if($loop->iteration > 3)
                                                @break
                                            @endif--}}
                                            <div class="w-10 h-10 image-fit zoom-in" style="margin-left: -0.70rem">
                                                <img data-action="zoom" alt="Product-img" class="rounded-full" src="{{ asset("storage/product-images")."/".$image ->image_path }}" title="Uploaded {{ Carbon\Carbon::parse($product->created_at)->diffForHumans() }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="pt-2 sm:hidden">
                                        <a href="" class="font-medium break-words text-center sm:text-left line-clamp-2">{{ $product->name }}</a>
                                        @isset($product->productCategories)
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5 flex justify-between px-2">
                                                <span>{{ $product->productCategories->name }}</span>
                                                <span class="inline-flex">
                                                    <i class="fa-solid fa-boxes-stacked mr-1"></i> {{ $product->quantity }}
                                                    <p class="mx-2">|</p>
                                                    <i class="fa-solid fa-weight-scale mr-1"></i> {{ $product->weight }} Gram
                                                </span>
                                            </div>
                                        @else
                                            <div class="text-red-500 text-xs whitespace-nowrap mt-0.5">Belum dikategorikan</div>
                                        @endif
                                        <div class="flex flex-wrap justify-between px-2 pt-3">
                                            <a class="flex items-center bg-gray-50 px-4 py-1 rounded text-blue-300" href="{{ route('seller.products.edit', $product->id) }}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                            <a class="flex items-center bg-gray-50 px-4 py-1 rounded text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-{{$product->id}}"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="line-clamp-2 hidden">
                                    <a href="" class="font-medium break-words">{{ $product->name }}</a>
                                    @isset($product->productCategories)
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $product->productCategories->name }}</div>
                                    @else
                                        <div class="text-red-500 text-xs whitespace-nowrap mt-0.5">Belum dikategorikan</div>
                                    @endif
                                </td>
                                <td class="text-center whitespace-nowrap hidden">{{ $product->quantity }}</td>
                                <td class="text-center whitespace-nowrap hidden">{{ $product->weight }} Gram</td>
                                {{--<td class="w-40">
                                    <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                </td>--}}
                                <td class="table-report__action w-56 whitespace-nowrap hidden">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3" href="{{ route('seller.products.edit', $product->id) }}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-{{$product->id}}"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <img class="max-w-3xl max-h-52 mx-auto !shadow-none" src="{{ asset('assets/images/app/not-found-store.png') }}" alt="iklan kosong">
                                    <p class="text-center text-dark py-5">Anda belum mengunggah produk.</p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- END: Data List -->
            </div>
            @include('.seller.products.partials.delete-product-modal')
        @else
            <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="info" data-lucide="info" class="lucide lucide-info w-4 h-4 mr-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>
                <span> Anda belum membuka lapak UMKM,
                    <a
                        data-tw-toggle="modal"
                        data-tw-target="#create-store-form"
                        href="#"
                        class="dropdown-item hover:bg-white/5 underline">klik disini
                    </a>
                </span>&nbsp;untuk mendaftar.
                <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
            </div>
        @endif

        @section('script')

            <script>
                $(document).ready(function () {
                    <!-- BEGIN: Notification Success-->
                    @if(Session::has('success'))
                    Toastify({
                        node: $("#success-notification-content").clone().removeClass("hidden")[0],
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
                        Session::forget('success');
                    @endphp
                    @endif
                    <!-- END: Notification -->

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

                    $('input[type="text"]').on('keyup', searchTable);

                })

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
