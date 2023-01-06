@extends('home.main')
@section('content')

    @include('home.components.bc-product')

    <div class="text-center font-semibold bg-white md:mt-4 py-5 rounded-t-2xl">
        <h4 class="md:mb-4">Informasi Produk</h4>
        <hr class="mx-2">
    </div>

    <!-- main content  -->
    <main class="pb-16 md:pt-4 md:grid md:grid-cols-2 justify-items-center md:items-center md:px-16 md:gap-16 bg-white rounded-lg">
        <!-- image section  -->
        <section
            @foreach($images as $image)
            x-data = "{selected : '{{ asset('storage/product-image').'/'.$image -> image_path }}'}"
            @endforeach
            class="relative md:grid md:grid-cols-4 md:gap-7 md:justify-items-center md:px-5">
            <h2 class="sr-only">Images of the products</h2>

            <div class="flex justify-center mx-auto md:col-span-5 w-full md:mx-auto bg-white rounded-2xl" style="height: 30rem;">
                @foreach($images as $image)
                    <img
                        x-show = "selected == '{{ asset('storage/product-image').'/'.$image -> image_path }}' "
                        class="slide rounded-2xl md:mt-0 max-h-full"
                        src="{{ asset('storage/product-image').'/'.$image -> image_path }}"
                        alt="product"
                    >
                @endforeach
            </div>

            <!-- product thumbnails  -->
            <div class="flex justify-center mt-2 ml-2 md:m-0 gap-5 md:show md:grid md:grid-cols-5 md:gap-5 md:col-span-5">
                @foreach($images as $image)
                    <button
                        aria-label="product-thumbnail"
                        @click = "selected = '{{ asset('storage/product-image').'/'.$image -> image_path }}' "
                        :class = " selected == '{{ asset('storage/product-image').'/'.$image -> image_path }}' ? 'rounded-2xl ; ring-2 ; ring-ec-customOrange ; opacity-50' : '' ">
                        <img
                            class="rounded-2xl hover:opacity-50 w-20 h-20"
                            src="{{ asset('storage/product-image').'/'.$image -> image_path }}"
                            alt="image-product">
                    </button>
                @endforeach
            </div>
        </section>

        <section class="px-3 md:px-0">
            <h1 class="sr-only">product details</h1>
            <section class="py-5">
                <h3 class="sr-only">store and product description</h3>
                <a href="#" class="w-full h-20 inline-flex bg-blue-200 p-2 rounded-lg">
                    <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $product -> stores -> name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                    <h3 class="h-20 mt-4 ml-2 uppercase text-2xl font-semibold text-red-400">{{ $product -> stores -> name }}</h3>
                </a>
                <h3 class="mt-3 md:mt-5 text-3xl font-semibold text-ec-veryDarkBlue md:text-4xl">{{ $product -> name }}</h3>
            </section>

            <section class="mt-3">
                <h3 class="sr-only">price details</h3>
                <div class="flex justify-between items-center md:flex-col md:items-start md:gap-2">
                    <div class="flex justify-center items-center">
                        <h2 class="text-ec-veryDarkBlue text-2xl md:text-3xl font-semibold tracking-wide">@currency( $product -> price )</h2>
                        {{--<p class="text-ec-customOrange text-sm ml-3 font-semibold bg-ec-paleOrange px-2 rounded">50%</p>--}}
                    </div>
                    {{--<p class="text-ec-grayishBlue font-semibold line-through">$250.00</p>--}}
                </div>
            </section>

            <!-- buttons  -->
            <div class="mt-5 lg:grid lg:grid-cols-3 lg:justify-items-center lg:gap-5 lg:mt-8 lg:px-5">
                <section class="mt-3 px-5 w-full lg:mt-0 lg:px-0">
                    <h3 class="sr-only">increase or decrease items</h3>
                    <div
                        class="flex justify-between items-center bg-gray-100 py-3 px-5 rounded-xl" >

                        <button @click = "if(count > 0) count = count - 1; " aria-label="icon-minus">
                            <img src="{{ asset('assets/images/ecommerce/icon-plus.svg') }}" alt="minus">
                        </button>
                        <p
                            x-text = "count">
                        </p>
                        <button @click = "count = count + 1" aria-label="icon-plus">
                            <img src="{{ asset('assets/images/ecommerce/icon-minus.svg') }}" alt="plus">
                        </button>

                    </div>
                </section>

                <section class="w-full mt-3 px-5 md:col-span-2 lg:mt-0 lg:px-0">
                    <h3 class="sr-only">add to cart</h3>
                    <button
                        @click = "addCart = true " aria-label="add-cart"
                        class="flex justify-center items-center w-full rounded-lg py-4 md:py-[14px] shadow-orange-200 shadow-2xl hover:bg-red-500 text-sm gap-3 font-semibold bg-red-400 text-white">
                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg"><path d="M20.925 3.641H3.863L3.61.816A.896.896 0 0 0 2.717 0H.897a.896.896 0 1 0 0 1.792h1l1.031 11.483c.073.828.52 1.726 1.291 2.336C2.83 17.385 4.099 20 6.359 20c1.875 0 3.197-1.87 2.554-3.642h4.905c-.642 1.77.677 3.642 2.555 3.642a2.72 2.72 0 0 0 2.717-2.717 2.72 2.72 0 0 0-2.717-2.717H6.365c-.681 0-1.274-.41-1.53-1.009l14.321-.842a.896.896 0 0 0 .817-.677l1.821-7.283a.897.897 0 0 0-.87-1.114ZM6.358 18.208a.926.926 0 0 1 0-1.85.926.926 0 0 1 0 1.85Zm10.015 0a.926.926 0 0 1 0-1.85.926.926 0 0 1 0 1.85Zm2.021-7.243-13.8.81-.57-6.341h15.753l-1.383 5.53Z" fill="hsl(25, 100%, 94%)" fill-rule="nonzero"/></svg>
                        Tambah ke Keranjang
                    </button>
                </section>
            </div>
        </section>
    </main>


    <div class="rounded-2xl w-full mx-auto mt-4 bg-white my-12 h-28rem">
        <!-- Tabs -->
        <ul id="tabs" class="inline-flex pt-2 px-1 w-full border-b justify-center">
            <li class="bg-white px-4 text-gray-800 font-semibold py-2 rounded-t border-t border-r border-l -mb-px">
                <a id="default-tab" href="#first">Deskripsi</a>
            </li>
            <li class="px-4 text-gray-800 font-semibold py-2 rounded-t">
                <a href="#second">Lokasi</a>
            </li>
        </ul>
        <!-- Tab Contents -->
        <div id="tab-contents" class="h-96">
            <div id="first" class="p-4 h-full overflow-y-scroll">
                <div id="editor">{!! $product->description !!}</div>
            </div>
            <div id="second" class="hidden p-4 capitalize h-full overflow-y-hidden">
                <span class="bg-gray-200 capitalize_address w-full px-5 py-5 rounded-t-2xl">
                    <i class="fa-solid fa-store text-gray-500"></i>
                    {{  $product->stores->storeAddresses->detail_address }},
                    Desa {{ $village->name }},
                    Kecamatan{{ $district->name }},
                    {{ $regency->name }},
                    {{ $province -> name }}.
                </span>
                @if($product->stores->storeAddresses->embedded_map)
                    <div class="capitalize_address google-maps w-full -mt-3">{!! $product->stores->storeAddresses->embedded_map !!}</div>
                @else
                    <div class="capitalize_address google-maps w-full text-center h-full pt-32 bg-gray-100">Pelapak tidak menyematkan Lokasi UMKM</div>
                @endif
            </div>
        </div>
    </div>

@endsection


@section('script')

    <script>
        ClassicEditor.create( document.querySelector( '#editor' ), {
            //
        } )
            .then( editor => {
                const toolbarElement = editor.ui.view.toolbar.element;
                    toolbarElement.style.display = 'none'
                    editor.enableReadOnlyMode( 'feature-id' )
            } )
            .catch( error => {
                console.log( error );
            } );
    </script>

    <script>
        let tabsContainer = document.querySelector("#tabs");

        let tabTogglers = tabsContainer.querySelectorAll("#tabs a");

        console.log(tabTogglers);

        tabTogglers.forEach(function(toggler) {
            toggler.addEventListener("click", function(e) {
                e.preventDefault();

                let tabName = this.getAttribute("href");

                let tabContents = document.querySelector("#tab-contents");

                for (let i = 0; i < tabContents.children.length; i++) {

                    tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l", "-mb-px", "bg-white");  tabContents.children[i].classList.remove("hidden");
                    if ("#" + tabContents.children[i].id === tabName) {
                        continue;
                    }
                    tabContents.children[i].classList.add("hidden");

                }
                e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px", "bg-white");
            });
        });

    </script>
@endsection
