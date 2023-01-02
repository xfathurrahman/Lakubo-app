<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('categories') }}
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

        @if(count($errors) > 0)
            <div class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Danger</span>
                <div>
                    <span class="font-medium">Data anda tidak valid :</span>
                    <ul class="mt-1.5 ml-4 text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    <div class="mt-10 w-full box">
        <div class="p-2">
            <ul class="nav nav-link-tabs" role="tablist" id="myTab">
                <li id="tab-products" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 active"
                            data-tw-toggle="pill"
                            data-tw-target="#tab-products"
                            type="button"
                            role="tab" aria-controls="example-tab-3" aria-selected="true"><i class="fa-solid fa-boxes-stacked h-4 w-4 mr-2"></i>Produk
                    </button>
                </li>
                <li id="tab-stores" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2"
                            data-tw-toggle="pill"
                            data-tw-target="#tab-stores"
                            type="button"
                            role="tab" aria-controls="example-tab-4" aria-selected="false"><i class="fa-solid fa-store h-4 w-4 mr-2"></i>Lapak
                    </button>
                </li>
            </ul>
            <div class="tab-content mt-5">
                <div id="tab-products" class="tab-pane leading-relaxed active" role="tabpanel"
                     aria-labelledby="example-3-tab">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <!-- BEGIN: Modal Toggle -->
                                <div class="text-start mb-3">
                                    <a href="#" data-tw-toggle="modal"
                                       data-tw-target="#create_product_category"
                                       class="btn btn-primary"><i class="w-4 h-4" data-lucide="plus"></i>
                                        Tambah Kategeori
                                    </a>
                                </div>
                                <!-- END: Modal Toggle -->
                            <tr>
                                <th class="whitespace-nowrap">#ID</th>
                                <th class="whitespace-nowrap text-center">Gambar</th>
                                <th class="whitespace-nowrap">Nama</th>
                                <th scope="col" class="py-3 px-6">
                                    <div class="flex justify-end mr-24">
                                        <div class="flex space-x-2">
                                            Aksi
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $productCategories as $prod_cate )
                                <tr>
                                    <td>{{ $prod_cate->id }}</td>
                                    <td>
                                        <div class="w-20 h-20 image-fit zoom-in mx-auto">
                                            @if($prod_cate->image_path)
                                                <img alt="Product-img" class="tooltip rounded-full" src="{{ asset('storage/product-category').'/'.$prod_cate->image_path }}" title="Diunggah {{ Carbon\Carbon::parse($prod_cate->created_at)->diffForHumans() }}">
                                            @else
                                                <img alt="Product-img" class="tooltip rounded-full" src="{{ asset("assets/images/umkm-boy.png") }}" title="Diunggah {{ Carbon\Carbon::parse($prod_cate->created_at)->diffForHumans() }}">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="font-medium whitespace-nowrap">{{ $prod_cate->name }}</a>
                                    </td>
                                    <td>
                                        <div class="flex justify-end mr-4">
                                            <div class="flex space-x-2">

                                                <a href="#"
                                                   data-tw-toggle="modal"
                                                   data-tw-target="#edit_product_category-{{ $prod_cate ->id }}"
                                                   class="btn btn-outline-secondary"
                                                ><i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit</a>

                                                <a href="#"
                                                   data-tw-toggle="modal"
                                                   data-tw-target="#delete-prod-cate-modal-{{$prod_cate->id}}"
                                                   class="btn btn-primary shadow-md mr-2 delete_role"
                                                ><i data-lucide="trash" class="w-4 h-4 mr-1"></i>Hapus</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tab-stores" class="tab-pane leading-relaxed" role="tabpanel"
                     aria-labelledby="example-3-tab">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                            <!-- BEGIN: Modal Toggle -->
                            <div class="text-start mb-3">
                                <a href="#" data-tw-toggle="modal"
                                   data-tw-target="#create_store_category"
                                   class="btn btn-primary"><i class="w-4 h-4" data-lucide="plus"></i>
                                    Tambah Kategeori
                                </a>
                            </div>
                            <!-- END: Modal Toggle -->
                            <tr>
                                <th class="whitespace-nowrap">#ID</th>
                                <th class="whitespace-nowrap text-center">Gambar</th>
                                <th class="whitespace-nowrap">Nama</th>
                                <th scope="col" class="py-3 px-6">
                                    <div class="flex justify-end mr-24">
                                        <div class="flex space-x-2">
                                            Aksi
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $storeCategories as $store_cate )
                                <tr>
                                    <td>{{ $store_cate->id }}</td>
                                    <td>
                                        <div class="w-20 h-20 image-fit zoom-in mx-auto">
                                            @if($store_cate->image_path)
                                                <img alt="Store-img" class="tooltip rounded-full" src="{{ asset('storage/store-category').'/'.$store_cate->image_path }}" title="Diunggah {{ Carbon\Carbon::parse($store_cate->created_at)->diffForHumans() }}">
                                            @else
                                                <img alt="Product-img" class="tooltip rounded-full" src="{{ asset("assets/images/umkm-boy.png") }}" title="Diunggah {{ Carbon\Carbon::parse($store_cate->created_at)->diffForHumans() }}">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="font-medium whitespace-nowrap">{{ $store_cate->name }}</a>
                                    </td>
                                    <td>
                                        <div class="flex justify-end mr-4">
                                            <div class="flex space-x-2">
                                                <a href="#"
                                                   data-tw-toggle="modal"
                                                   data-tw-target="#edit_store_category-{{ $store_cate->id }}"
                                                   class="btn btn-outline-secondary shadow-md mr-2 delete_role"
                                                ><i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit</a>
                                                <a href="#"
                                                   data-tw-toggle="modal"
                                                   data-tw-target="#delete-store-cate-modal-{{$store_cate->id}}"
                                                   class="btn btn-primary shadow-md mr-2 delete_role"
                                                ><i data-lucide="trash" class="w-4 h-4 mr-1"></i>Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('.admin.category.partials.create-category-modal')
        @include('.admin.category.partials.edit-category-modal')
        @include('.admin.category.partials.delete-category-modal')
    </div>
</x-app-layout>
