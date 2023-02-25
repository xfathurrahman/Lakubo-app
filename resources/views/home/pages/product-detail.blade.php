@extends('home.main')
@section('content')

    @include('home.components.bc-product')

    <style>
        .ck .ck .ck-content {
            min-height: 238px !important;
        }
        .ck .ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
            border-top: none !important;
        }
    </style>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white pb-6 mb-16 rounded-b-md">
        <div class="font-medium text-xl ml-4 pb-4 flex items-center border-b">Informasi Produk</div>
        <div class="flex flex-wrap justify-center">
            <div class="w-full lg:w-2/5 p-4">
                <div class="relative h-28rem">
                    @php $first = true; @endphp
                    @foreach($images as $image)
                        <img class="slide rounded-2xl md:mt-0 h-full w-full {{ $first ? ' block' : ' hidden' }}" src="{{ asset('storage/product-image').'/'.$image->image_path }}" alt="product">
                        @php $first = false; @endphp
                    @endforeach
                </div>
                <div class="flex justify-center mt-4">
                    @foreach($images as $image)
                        <div class="w-1/5 flex justify-center">
                            <button aria-label="product-thumbnail" data-image-path="{{ asset('storage/product-image').'/'.$image->image_path }}" class="thumbnail-button rounded-2xl{{ $loop->first ? ' ring-2 opacity-50' : '' }}">
                                <img class="rounded-2xl hover:opacity-50 w-20 h-20" src="{{ asset('storage/product-image').'/'.$image->image_path }}" alt="image-product">
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-full lg:w-3/5 p-4">
                <div class="h-14 flex items-center">
                    <span class="text-xl text-red-400 font-bold line-clamp-2 text-justify lg:text-left">{{ $product -> name }}</span>
                </div>
                <div class="h-10 flex items-center">
                    <div class="flex justify-between w-full items-center">
                        <span class="text-red-400 text-2xl md:text-3xl font-semibold tracking-wide">@currency( $product -> price )</span>
                        <a href="#" class="w-40 h-12 inline-flex bg-red-100 p-1 rounded mt-6">
                            @isset($product -> stores -> users -> profile_photo_path)
                                <img class="rounded-full" src="{{ asset('storage/profile-photos/'. $product -> stores -> users -> profile_photo_path) }}" alt="pp-owner"/>
                            @else
                                <img class="rounded-full" src="https://ui-avatars.com/api/?name={{ $product -> stores -> name }}&amp;color=7F9CF5&amp;background=EBF4FF" alt="pp-owner"/>
                            @endisset
                            <span class="ml-2 capitalize text-sm font-medium text-red-400 line-clamp-2 text-justify">{{ $product -> stores -> name }}</span>
                        </a>
                    </div>
                </div>
                <div class="rounded-lg w-full">
                    <!-- Tabs -->
                    <ul id="tabs" class="inline-flex pt-2 w-full border-b-white justify-start">
                        <li class="bg-white px-4 text-gray-800 font-semibold py-2 rounded-t border-t border-r border-l border-b-white -mb-px">
                            <a id="default-tab" href="#first">Deskripsi</a>
                        </li>
                        <li class="px-4 text-gray-800 font-semibold py-2 rounded-t">
                            <a href="#second">Lokasi</a>
                        </li>
                    </ul>
                    <!-- Tab Contents -->
                    <div id="tab-contents" class="border-t" style="height: 304px">
                        <div id="first" class="overflow-y-scroll max-h-full">
                            <div class="px-4 border-l w-full border-r">
                                <div class="flex items-center pt-4">
                                    <div class="inline-flex mr-2">
                                        <div class="flex items-center justify-between text-green-500 font-medium">
                                            <span class="w-20 inline-flex">
                                                <i class="fa-solid fa-cubes-stacked ml-1 mr-2.5 mt-1 text-green-500"></i>
                                                Stok
                                            </span>:
                                        </div>
                                    </div>
                                    {{ $product -> quantity}}
                                </div>
                                <div class="flex items-center">
                                    <div class="inline-flex mr-2">
                                        <div class="flex items-center justify-between text-green-500 font-medium">
                                            <span class="w-20 inline-flex">
                                                <i class="fa-solid fa-scale-unbalanced mt-1 mr-2 text-green-500"></i>
                                                Berat
                                            </span>:
                                        </div>
                                    </div>
                                    {{ $product -> weight}} Gram
                                </div>
                            </div>
                            <div id="editor">{!! $product->description !!}</div>
                        </div>
                        <div id="second" class="hidden border-x border-b h-full overflow-y-hidden">
                            <div class="w-full capitalize p-2 font-medium rounded-b-lg line-clamp-2">
                                {{ $product->stores->storeAddresses->detail_address }}, Desa {{ $village }}, Kecamatan {{ $district }}, {{ $regency }}, {{ $province }}.
                            </div>
                            @if($product->stores->storeAddresses->embedded_map)
                                <div class="google-maps w-full">{!! $product->stores->storeAddresses->embedded_map !!}</div>
                            @else
                                <div class="w-full text-center h-full pt-32 bg-gray-100">Pelapak tidak menyematkan Lokasi UMKM</div>
                            @endif
                        </div>
                    </div>
                </div>
                    @php
                        $isAuthenticated = auth()->check();
                        $isSeller = $isAuthenticated && auth()->user()->hasRole('seller');
                        $isProductStoreSameAsUserStore = $isSeller && $product->stores->id === auth()->user()->stores->id;
                        $canEditProduct = $isProductStoreSameAsUserStore;
                    @endphp
                    @if ($product->quantity > 0)
                        @if ($canEditProduct)
                            <a href="{{ route('seller.products.edit', $product -> id ) }}">
                                <button class="w-full mt-8 py-3 bg-red-400 rounded text-white text-lg focus:outline-none hover:bg-red-500">
                                    <i class="fa-solid fa-pencil text-lg mr-2"></i>Edit Produk
                                </button>
                            </a>
                        @else
                        <div class="mt-5 lg:grid lg:grid-cols-3 lg:justify-items-center lg:gap-5 lg:mt-8 lg:px-5">
                            <div class="mt-3 px-5 w-full lg:mt-0 lg:px-0">
                                <h3 class="sr-only">increase or decrease items</h3>
                                <div class="flex justify-between h-full items-center bg-gray-100 py-2 px-4 rounded-xl" >
                                    <button class="w-6 h-6" id="minus-btn" aria-label="icon-minus">
                                        <img src="{{ asset('assets/images/ecommerce/icon-minus.svg') }}" alt="minus">
                                    </button>
                                    <p id="count">1</p>
                                    <button class="w-6 h-6" id="plus-btn" aria-label="icon-plus">
                                        <img src="{{ asset('assets/images/ecommerce/icon-plus.svg') }}" alt="plus">
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $product->id }}" id="product_id">
                            <input type="hidden" value="{{ $product->stores->id }}" id="store_id">
                            <div class="w-full mt-3 px-5 md:col-span-2 lg:mt-0 lg:px-0">
                                <button id="add-to-cart" class="flex justify-center items-center w-full rounded-lg py-4 md:py-[14px] shadow-orange-200 shadow-2xl hover:bg-red-500 text-sm gap-3 font-semibold bg-red-400 text-white">
                                    <i class="fa-solid fa-cart-plus text-xl"></i>Tambah ke Keranjang
                                </button>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Reject Notification Content -->
    <div id="added-to-cart-notif" class="toastify-content hidden flex items-center">
        <i class="fa-solid fa-cart-plus text-xl text-green-500"></i>
        <div class="ml-4 mr-4">
            <div class="text-green-500 font-medium">Pesanan Berhasil ditambah ke Keranjang.</div>
            <div class="text-green-500 mt-1">Klik ikon keranjang pada Toolbar untuk melihat.</div>
        </div>
    </div>
    <!-- END: Reject Notification Content -->

    <!-- BEGIN: Already Notification Content -->
    <div id="already-add-notif" class="toastify-content hidden flex items-center">
        <i class="fa-solid fa-cart-arrow-down text-xl text-red-400"></i>
        <div class="ml-4 mr-4">
            <div class="text-red-500 font-medium">Pesanan sudah ada di Keranjang.</div>
            <div class="text-red-500 mt-1">Klik ikon keranjang pada Toolbar untuk melihat.</div>
        </div>
    </div>
    <!-- END: Already Notification Content -->

@endsection

@section('script')

    <script>
        $(document).ready(function() {
            @if(Auth::check())
                $("#add-to-cart").click( function (e) {
                    e.preventDefault(e);
                    let product_id = $("#product_id").val();
                    let store_id = $("#store_id").val();
                    $.ajax({
                        method: "POST",
                        url: "{{ route('customer.addToCart') }}",
                        data: {
                            'product_id': product_id,
                            'store_id': store_id,
                        },
                        success: function (response) {
                            loadCart();
                            $('#refreshcart').load(location.href + " #refreshcart");
                            if (response.success) {
                                Toastify({
                                    node: $("#added-to-cart-notif").clone().removeClass("hidden")[0],
                                    duration: 2000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    closeOthers: true,
                                    offset: {
                                        y: 50 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();
                            } else{
                                Toastify({
                                    node: $("#already-add-notif").clone().removeClass("hidden")[0],
                                    duration: 2000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    closeOthers: true,
                                    offset: {
                                        y: 50 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();
                            }
                        }
                    });
                });
            @else
                $("#add-to-cart").click( function (e) {
                e.preventDefault(e);
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Silahkan Masuk terlebih dahulu untuk mulai belanja.',
                        showConfirmButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: '<a href="{{ route('login') }}">Masuk</a>'
                    });
                });
            @endif

            // Mengubah gambar utama ketika thumbnail di klik
            $('.thumb-image').click(function() {
                var mainImage = $('.main-image');
                var newImage = $(this).attr('src');
                mainImage.attr('src', newImage);
            });
            // GAMBAR & NAVIGASI
            $(function() {
                var $slides = $('.slide');
                var $thumbnailButtons = $('.thumbnail-button');

                $thumbnailButtons.on('click', function() {
                    var $this = $(this);
                    var imagePath = $this.data('image-path');

                    // Hide all slides except the one with the selected image path
                    $slides.not('[src="' + imagePath + '"]').hide();
                    $slides.filter('[src="' + imagePath + '"]').show();

                    // Update the selected thumbnail button styling
                    $thumbnailButtons.removeClass('ring-2 opacity-50');
                    $this.addClass('ring-2 opacity-50');
                });
            });

            var count = 1;
            var addCart = false;
            var maxValue = {{ $product->quantity }};

            // increase or decrease items
            $('#minus-btn').click(function() {
                if (count > 1) {
                    count--;
                    $('#count').text(count);
                }
            });

            $('#plus-btn').click(function() {
                if (count < maxValue) {
                    count++;
                    $('#count').text(count);
                }
            });

            // add to cart
            $('#add-to-cart').click(function() {
                addCart = true;
            });

            // TEXT EDITOR
            ClassicEditor.create(document.querySelector('#editor'),{})
                .then(editor => {
                    const toolbarElement = editor.ui.view.toolbar.element;
                    toolbarElement.style.display = 'none';
                    editor.enableReadOnlyMode('feature-id');
                })
                .catch(error => {
                    console.log(error);
                });

            // TAB
            let tabsContainer = document.querySelector("#tabs");
            let tabTogglers = tabsContainer.querySelectorAll("#tabs a");
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
        });

    </script>
@endsection
