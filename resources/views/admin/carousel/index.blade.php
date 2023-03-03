<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('categories') }}
    @endsection

    <h2 class="intro-y text-lg font-medium mt-5">
        Carousel
    </h2>
    <div class="grid grid-cols-12 gap-6 my-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button id="tambah-kategori" data-tw-toggle="modal" data-tw-target="#create_carousel"
                    class="btn btn-primary shadow-md mr-2">Tambah Carousel
            </button>
        </div>
        <!-- BEGIN: Users Layout -->
        @foreach( $carousels as $carousel )
            <div class="intro-y col-span-12 md:col-span-6">
                <div class="box">
                    <div class="flex flex-col lg:flex-row items-center p-5">
                        <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                            @if($carousel->image_path)
                                <img alt="Product-img" class="tooltip rounded-full"
                                     src="{{ asset('storage/carousel').'/'.$carousel->image_path }}"
                                     title="Diunggah {{ Carbon\Carbon::parse($carousel->created_at)->diffForHumans() }}">
                            @else
                                <img alt="Product-img" class="tooltip rounded-full"
                                     src="{{ asset("assets/images/umkm-boy.png") }}"
                                     title="Diunggah {{ Carbon\Carbon::parse($carousel->created_at)->diffForHumans() }}">
                            @endif
                        </div>
                        <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                            <a href="" class="font-medium">{{ $carousel->name }}</a>
                        </div>
                        <div class="flex mt-4 lg:mt-0">
                            <a href="#" data-tw-toggle="modal"
                               data-tw-target="#edit_product_category-{{ $carousel -> id }}"
                               class="btn btn-outline-secondary mr-2 py-1 px-2">Edit</a>
                            <a href="#" data-tw-toggle="modal"
                               data-tw-target="#delete-prod-cate-modal-{{ $carousel -> id }}"
                               class="btn btn-primary py-1 px-2 ">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- BEGIN: Users Layout -->
    </div>

    <div class="intro-y">
        {{ $carousels->links() }}
    </div>

    @include('.admin.carousel.partials.create-modal')
    {{--@foreach( $carousels as $carousel )
        @include('.admin.carousel.partials.delete-modal', ['carousel' => $carousel])
        @include('.admin.carousel.partials.edit-modal', ['carousel' => $carousel])
    @endforeach--}}

</x-app-layout>
