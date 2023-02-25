<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('categories') }}
    @endsection

        <h2 class="intro-y text-lg font-medium mt-5">
            Kategori Produk
        </h2>
        <div class="grid grid-cols-12 gap-6 my-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <button id="tambah-kategori" data-tw-toggle="modal" data-tw-target="#create_product_category"
                        class="btn btn-primary shadow-md mr-2">Tambah Kategori
                </button>
            </div>
            <!-- BEGIN: Users Layout -->
            @foreach( $productCategories as $prod_cate )
                <div class="intro-y col-span-12 md:col-span-6">
                    <div class="box">
                        <div class="flex flex-col lg:flex-row items-center p-5">
                            <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                @if($prod_cate->image_path)
                                    <img alt="Product-img" class="tooltip rounded-full"
                                         src="{{ asset('storage/product-category').'/'.$prod_cate->image_path }}"
                                         title="Diunggah {{ Carbon\Carbon::parse($prod_cate->created_at)->diffForHumans() }}">
                                @else
                                    <img alt="Product-img" class="tooltip rounded-full"
                                         src="{{ asset("assets/images/umkm-boy.png") }}"
                                         title="Diunggah {{ Carbon\Carbon::parse($prod_cate->created_at)->diffForHumans() }}">
                                @endif
                            </div>
                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                <a href="" class="font-medium">{{ $prod_cate->name }}</a>
                            </div>
                            <div class="flex mt-4 lg:mt-0">
                                <a href="#" data-tw-toggle="modal"
                                   data-tw-target="#edit_product_category-{{ $prod_cate -> id }}"
                                   class="btn btn-outline-secondary mr-2 py-1 px-2">Edit</a>
                                <a href="#" data-tw-toggle="modal"
                                   data-tw-target="#delete-prod-cate-modal-{{ $prod_cate -> id }}"
                                   class="btn btn-primary py-1 px-2 ">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- BEGIN: Users Layout -->
        </div>

        <div class="intro-y">
            {{ $productCategories->links() }}
        </div>

        @include('admin.category.partials.notification')
        @include('.admin.category.products.partials.create-modal')
        @foreach( $productCategories as $prod_cate )
            @include('.admin.category.products.partials.delete-modal', ['category' => $prod_cate])
            @include('.admin.category.products.partials.edit-modal', ['category' => $prod_cate])
        @endforeach

</x-app-layout>
