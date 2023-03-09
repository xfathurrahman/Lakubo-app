<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('products') }}
    @endsection

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

        @if(auth()->user()->stores)
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <a class="btn btn-primary shadow-md mr-2" href="{{ route('seller.products.create') }}">
                        Tambah Produk
                    </a>
                    {{--<div class="dropdown">
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
                    </div>--}}
                    {{--<div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="w-56 relative text-slate-500">
                            <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        </div>
                    </div>--}}
                </div>
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <table class="table table-report -mt-2">
                        <thead>
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
                            <tr class="intro-x">
                                <td class="w-52">
                                    <div class="flex justify-center">
                                        @foreach($product->productImages as $image)
                                            {{--@if($loop->iteration > 3)
                                                @break
                                            @endif--}}
                                            <div class="w-10 h-10 image-fit zoom-in" style="margin-left: -0.70rem">
                                                <img data-action="zoom" alt="Product-img" class="rounded-full" src="{{ asset("storage/product-image")."/".$image -> image_path }}" title="Uploaded {{ Carbon\Carbon::parse($product->created_at)->diffForHumans() }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <a href="" class="font-medium whitespace-nowrap">{{ $product->name }}</a>
                                    @isset($product->productCategories)
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $product->productCategories->name }}</div>
                                    @else
                                        <div class="text-red-500 text-xs whitespace-nowrap mt-0.5">Belum dikategorikan</div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $product-> quantity }}</td>
                                <td class="text-center">{{ $product-> weight }} Gram</td>
                                {{--<td class="w-40">
                                    <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                </td>--}}
                                <td class="table-report__action w-56">
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
                                    <img class="max-w-3xl max-h-52 mx-auto" src="{{ asset('assets/images/app/not-found-store.png') }}" alt="iklan kosong">
                                    <p class="text-center text-dark py-5">Anda belum mengunggah produk.</p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- END: Data List -->
                <div class="flex justify-between mt-4">
                    @if($listProducts->previousPageUrl())
                        <a href="{{ $listProducts->previousPageUrl() }}"
                           class="text-gray-500 hover:text-blue-600 px-4 py-2 rounded-full hover:bg-blue-100 transition-colors duration-200">
                            Previous
                        </a>
                    @else
                        <span class="text-gray-300 px-4 py-2 rounded-full">Previous</span>
                    @endif

                    @if($simplePagination)
                        <span class="text-gray-500 px-4 py-2 rounded-full">
                                {{ $listProducts->currentPage() }}
                            </span>
                    @else
                        <div>
                            {{ $listProducts->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif

                    @if($listProducts->nextPageUrl())
                        <a href="{{ $listProducts->nextPageUrl() }}"
                           class="text-gray-500 hover:text-blue-600 px-4 py-2 rounded-full hover:bg-blue-100 transition-colors duration-200">
                            Next
                        </a>
                    @else
                        <span class="text-gray-300 px-4 py-2 rounded-full">Next</span>
                    @endif
                </div>
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
                })
            </script>

        @endsection


</x-app-layout>
