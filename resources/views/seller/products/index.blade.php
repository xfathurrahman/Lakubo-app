<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('products') }}
    @endsection

    @if(Session::has('error'))
        <div class="alert text-center alert-danger">
            {{ Session::get('error') }}
            @php
                Session::forget('error');
            @endphp
        </div>
    @endif

    @if(Session::has('success'))
        <div class="alert text-center alert-success">
            {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
    @endif

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a class="btn btn-primary shadow-md mr-2" href="{{ route('seller.products.create') }}">
                Tambah Produk
            </a>
            <div class="dropdown">
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
            <div class="hidden md:block mx-auto text-slate-500">
                <div class="float-left" style="vertical-align: center;">
                    Menampilkan
                    {{ $listProducts->firstItem() }}
                    {{---
                    {{ $listProducts->lastItem() }}--}}
                    dari
                    {{ $listProducts->total() }}
                    total produk.
                </div>
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
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
                        <th class="text-center whitespace-nowrap">STATUS</th>
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
                                            <img alt="Product-img" class="tooltip rounded-full" src="{{ asset("storage/product-image")."/".$image -> image_path }}" title="Uploaded {{ Carbon\Carbon::parse($product->created_at)->diffForHumans() }}">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <a href="" class="font-medium whitespace-nowrap">{{ $product->name }}</a>
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">ini kategori</div>
                            </td>
                            <td class="text-center">{{ $product-> quantity }}</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3" href="{{ route('seller.products.edit', $product->id) }}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <img class="max-w-3xl max-h-52 mx-auto" src="{{ asset('storage/assets/empty-box.jpg') }}" alt="iklan kosong">
                                <p class="text-center text-dark">Anda belum mengunggah produk.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <div class=float-right>
                    {{ $listProducts->links() }}
                </div>
            </nav>
            <select class="w-20 form-select box mt-3 sm:mt-0">
                <option>10</option>
                <option>25</option>
                <option>35</option>
                <option>50</option>
            </select>
        </div>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">
                            Do you really want to delete these records?
                            <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

</x-app-layout>
