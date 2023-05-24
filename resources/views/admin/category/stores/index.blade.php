<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('categories') }}
    @endsection

        @include('admin.category.partials.notification')

        <h2 class="text-lg font-medium mt-5">
            Kategori Lapak
        </h2>
        <div class="grid grid-cols-12 gap-6 my-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <button data-tw-toggle="modal" data-tw-target="#create_store_category" class="btn btn-primary shadow-md mr-2">Tambah Kategori</button>
            </div>
            <!-- BEGIN: Users Layout -->
            @foreach( $storeCategories as $store_cate )
            <div class="intro-y col-span-12 md:col-span-6">
                <div class="box">
                    <div class="flex flex-col lg:flex-row items-center p-5">
                        <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                            @if($store_cate->image_path)
                                <img alt="Store-img" class="tooltip rounded-full"
                                     src="{{ asset('storage/store-categories').'/'.$store_cate->image_path }}"
                                     title="Diunggah {{ Carbon\Carbon::parse($store_cate->created_at)->diffForHumans() }}">
                            @else
                                <img alt="Product-img" class="tooltip rounded-full"
                                     src="https://ui-avatars.com/api/?name={{ $store_cate->name }}&amp;color=7F9CF5&amp;background=EBF4FF"
                                     title="Diunggah {{ Carbon\Carbon::parse($store_cate->created_at)->diffForHumans() }}">
                            @endif
                        </div>
                        <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                            <a href="" class="font-medium">{{ $store_cate->name }}</a>
                        </div>
                        <div class="flex mt-4 lg:mt-0">
                            <a href="#" data-tw-toggle="modal" data-tw-target="#edit_store_category-{{ $store_cate -> id }}" class="btn btn-outline-secondary mr-2 py-1 px-2">Edit</a>
                            <a href="#" data-tw-toggle="modal" data-tw-target="#delete-store-cate-modal-{{ $store_cate -> id }}" class="btn btn-primary py-1 px-2 ">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- BEGIN: Users Layout -->
        </div>

        <div class="intro-y">
            {{ $storeCategories->links() }}
        </div>

    @include('.admin.category.stores.partials.action')
</x-app-layout>
