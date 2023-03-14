<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin_products') }}
    @endsection

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <div class="dropdown" data-tw-placement="bottom-start">
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
                </div>
                <div class="hidden md:block mx-auto text-slate-500">
                    <div class="float-left" style="vertical-align: center;">
                        Menampilkan
                        {{ $products->firstItem() }}
                        {{---
                        {{ $products->lastItem() }}--}}
                        dari
                        {{ $products->total() }}
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
                    @if ($products->count())
                        <tr>
                            <th class="whitespace-nowrap">GAMBAR PRODUK</th>
                            <th class="whitespace-nowrap">NAMA PRODUK</th>
                            <th class="whitespace-nowrap">LAPAK UMKM</th>
                            <th class="text-center whitespace-nowrap">HARGA</th>
                            <th class="text-center whitespace-nowrap">STOK</th>
                            <th class="text-center whitespace-nowrap">STATUS</th>
                            <th class="text-center whitespace-nowrap">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="intro-x">
                            <td class="w-52">
                                <div class="flex justify-center">
                                    @foreach($product->productImages as $image)
                                        {{--@if($loop->iteration > 3)
                                            @break
                                        @endif--}}
                                        <div class="w-10 h-10 image-fit zoom-in" style="margin-left: -0.70rem">
                                            <img alt="Product-img" class="tooltip rounded-full"
                                                 src="{{ asset("storage/product-images")."/".$image -> image_path }}"
                                                 title="Uploaded {{ Carbon\Carbon::parse($product->created_at)->diffForHumans() }}">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <a href="" class="font-medium whitespace-nowrap">{{ $product->name }}</a>
                                @isset($product->productCategories)
                                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $product->productCategories->name }}</div>
                                @endif
                            </td>
                            <td>
                                <a href="" class="font-medium whitespace-nowrap">{{ $product->stores->name }}</a>
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $product->stores->users->name }}</div>
                            </td>
                            <td class="text-center">{{ $product-> price }}</td>
                            <td class="text-center">{{ $product-> quantity }}</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-success"><i data-lucide="check-square"
                                                                                              class="w-4 h-4 mr-2"></i>
                                    Active
                                </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3"
                                       href="{{ route('seller.products.edit', $product->id) }}"
                                    ><i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a class="flex items-center text-danger" href="#"
                                       data-tw-toggle="modal"
                                       data-tw-target="#delete-confirmation-modal-{{$product->id}}"
                                    ><i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <img class="max-w-3xl max-h-52 mx-auto"
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

</x-app-layout>
