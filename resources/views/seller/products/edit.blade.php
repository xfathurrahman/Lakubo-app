<x-app-layout>

    <!-- BEGIN: Error Notification Content -->
    <div id="error-notification-list" class="toastify-content hidden flex"> <i class="fa-solid fa-circle-exclamation text-primary text-lg"></i>
        <div class="ml-4 mr-4 w-72">
            <div class="font-medium truncate">Data anda tidak valid !</div>
            <div class="text-slate-500 mt-1 space-y">
                @foreach($errors->all() as $error)
                    <span class="flex flex-col">{{ $loop->iteration }}. {{ $error }}&nbsp;</span>
                @endforeach
            </div>
        </div>
    </div>
    <!-- END: Error Notification Content -->

    <div class="grid grid-cols-11 gap-x-6 mt-5 pb-20">

        @section('breadcrumbs')
            {{ Breadcrumbs::render('product_edit') }}
        @endsection

        <div class="intro-y col-span-12 2xl:col-span-12">
            <form method="POST" action="{{ route('seller.products.update', $product->id) }}" data-parsley-validate role="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- BEGIN: Uplaod Product -->
                <div class="intro-y box p-5">
                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Unggah Produk </div>
                        <div class="mt-5">
                            {{--<div class="flex items-center text-slate-500">
                                <span><i data-lucide="lightbulb" class="w-5 h-5 text-warning"></i></span>
                                <div class="ml-2"> <span class="mr-1">Hindari posting barang yang melanggar peraturan Lakubo, agar produkmu tidak di hapus.</span> <a href="https://themeforest.net/item/midone-jquery-tailwindcss-html-admin-template/26366820" class="text-primary font-medium" target="blank">Pelajari</a> </div>
                            </div>--}}
                            <div class="form-inline items-start flex-col xl:flex-row mt-10">
                                <div class="form-label w-full xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Foto Produk</div>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Wajib</div>
                                        </div>
                                        <p class="mt-2" id="parsley_error_image"></p>
                                        <div class="leading-relaxed text-slate-500 text-xs mt-3 mb-3">
                                            <div>Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran minimum 700 x 700 px).</div>
                                            <div class="mt-2">Pilih foto produk atau tarik dan letakkan hingga maksimal 5 foto sekaligus di sini.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <div class="input-field text-center">
                                        <div class="input-images-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Uplaod Product -->
                <!-- BEGIN: Product Information -->
                <div class="intro-y box p-5 mt-5">
                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Informasi Produk </div>
                        <div class="mt-5">
                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <label for="product-name" class="font-medium">Nama Produk</label>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Wajib</div>
                                        </div>
                                        <p class="mt-2" id="parsley_error_product_name"></p>
                                        <div class="leading-relaxed text-slate-500 text-xs mt-3"> Buat nama produk yang dapat menarik minat pembeli. Gunakan minimal 20 karakter. </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <input id="product-name"
                                           name="nama_produk"
                                           type="text"
                                           class="form-control"
                                           placeholder="Nama Produk"
                                           value="{{ $product->name }}"
                                           required
                                           data-parsley-maxlength="120"
                                           data-parsley-minlength="20"
                                           data-parsley-required-message="- Wajib memasukan Nama Produk"
                                           data-parsley-maxlength-message="- Maksimal 120 karakter..."
                                           data-parsley-minlength-message="- Minimal 20 karakter..."
                                           data-parsley-errors-container="#parsley_error_product_name"
                                    >
                                </div>
                            </div>
                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <label for="selectCateProd" class="font-medium">Harga & Kategori</label>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Wajib</div>
                                        </div>
                                        <p class="mt-2" id="parsley_error_price"></p>
                                        <p class="mt-2" id="parsley_error_category"></p>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <div class="grid grid-cols-12 gap-x-5">
                                        <div class="col-span-12 2xl:col-span-6">
                                            <div class="input-group">
                                                <div class="input-group-text">Rp.</div>
                                                <input name="harga"
                                                       type="text"
                                                       class="form-control numeric-input"
                                                       placeholder="Masukan harga"
                                                       value="{{ $product->price }}"
                                                       required
                                                       data-parsley-errors-container="#parsley_error_price"
                                                       data-parsley-maxlength="10"
                                                       data-parsley-required-message="- Wajib memasukan Harga produk"
                                                       data-parsley-maxlength-message="- Maksimal 10 digit..."
                                                       data-parsley-group="block1"
                                                >
                                            </div>
                                        </div>
                                        <div class="selectCateProd col-span-12 2xl:col-span-6 mt-2 2xl:mt-0">
                                            <select name="kategori"
                                                    id="selectCateProd"
                                                    class="w-full form-control"
                                                    required
                                                    data-parsley-required-message="- Wajib memilih Kategori Produk"
                                                    data-parsley-errors-container="#parsley_error_category">
                                                <option selected disabled>Pilih Kategori</option>
                                                @foreach($listCateProd as $category)
                                                    @if($product->productCategories)
                                                        @php
                                                            $selected = (old('kategori') === $category->id || $category->id === $product->productCategories->id) ? 'selected="selected"' : '';
                                                        @endphp
                                                        <option {{ $selected }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @else
                                                        <option value="{{ $category->id }}" {{ old('kategori') === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Berat & Kuantitas</div>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Wajib</div>
                                        </div>
                                        <p class="mt-2" id="parsley_error_weight"></p>
                                        <p class="mt-2" id="parsley_error_stock"></p>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <div class="grid grid-cols-12 gap-x-5">
                                        <div class="col-span-12 2xl:col-span-6">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="fa-solid fa-scale-unbalanced"></i></div>
                                                <input name="berat"
                                                       type="text"
                                                       class="form-control numeric-input"
                                                       placeholder="Masukan Berat Produk Anda dalam satuan Gram"
                                                       value="{{ $product->weight }}"
                                                       required=""
                                                       data-parsley-errors-container="#parsley_error_weight"
                                                       data-parsley-maxlength="7"
                                                       data-parsley-required-message="- Wajib memasukan Berat produk"
                                                       data-parsley-maxlength-message="- Maksimal 7 digit..."
                                                >
                                                <div class="input-group-text">Gram</div>
                                            </div>
                                        </div>

                                        <div class="col-span-12 2xl:col-span-6 mt-2 2xl:mt-0">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="fa-solid fa-cubes-stacked"></i></div>
                                                    <input name="stok"
                                                           type="text"
                                                           class="form-control numeric-input"
                                                           placeholder="Masukan Stok Produk Anda"
                                                           value="{{ $product->quantity }}"
                                                           required=""
                                                           data-parsley-maxlength="7"
                                                           data-parsley-errors-container="#parsley_error_stock"
                                                           data-parsley-required-message="- Wajib memasukan Stok produk"
                                                           data-parsley-maxlength-message="- Maksimal 7 digit..."
                                                    >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Product Information -->
                <!-- BEGIN: Product Detail -->
                <div class="intro-y box p-5 mt-5">
                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Product Detail </div>
                        <div class="mt-5">
                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Product Description</div>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Wajib</div>
                                        </div>
                                        <p class="mt-2" id="parsley_error_description"></p>
                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                            <div>Pastikan deskripsi produk memberikan penjelasan detail tentang produk Anda sehingga mudah untuk memahami dan menemukan produk Anda.</div>
                                            <div class="mt-2">Disarankan untuk tidak memasukkan info nomor ponsel, email, dll ke dalam deskripsi produk untuk melindungi data pribadi Anda.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <textarea name="deskripsi"
                                              class="editor"
                                              id="editor"
                                              maxlength="1000"
                                              placeholder="Deskripsikan produkmu..."
                                              required
                                              data-parsley-maxlength="1000"
                                              data-parsley-minlength="50"
                                              data-parsley-required-message="Wajib memasukan Deskripsi Produk"
                                              data-parsley-maxlength-message="Maksimal 1000 karakter..."
                                              data-parsley-minlength-message="Masukan minimal 50 karakter..."
                                              data-parsley-errors-container="#parsley_error_description"
                                    >{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Product Detail -->
                <div class="form-navigation-product-edit flex justify-end flex-col md:flex-row gap-2 mt-5">
                    <a href="{{ url('/seller/products') }}" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Batal</a>
                    <button type="submit" class="btn py-3 btn-primary w-full md:w-52">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .ck-content .table {
            width: auto;
        }
    </style>

    @section('script')

        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

        <script>
            @if(count($errors) > 0)
                Toastify({
                    node: $("#error-notification-list").clone().removeClass("hidden")[0],
                    duration: -1,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    closeOthers: true,
                    offset: {
                        y: 80
                    },
                }).showToast();
            @endif
        </script>

        <script>
            $(document).ready(function (){

                // define select2
                $("#selectCateProd").select2({
                    placeholder:'Pilih Kategori Produk',
                    searchInputPlaceholder: 'Cari kategori...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    }
                });

                // wajib angka
                const numericInputs = document.querySelectorAll('.numeric-input');
                numericInputs.forEach(function(input) {
                    input.addEventListener('input', function(e) {
                        e.target.value = e.target.value.replace(/[^0-9]/g, '');
                    });
                });

                // Mendapatkan data gambar lama
                let preloaded = [
                    @foreach($product -> productImages as $image)
                        {id: {{ $image->id }}, src: '{{ asset("storage/product-image")."/".$image -> image_path }}'},
                    @endforeach
                ];

                // define ImageUploader
                $('.input-images-1').imageUploader({
                    preloaded: preloaded,
                    imagesInputName: 'files',
                    preloadedInputName: 'old',
                    maxSize: 2 * 1024 * 1024,
                    maxFiles: 5,
                    required: false,
                    label: "Tarik & Letakkan disini atau klik untuk mencari gambar produk",
                });

                // define CKEDITOR
                ClassicEditor
                    .create(document.querySelector('#editor'), {
                        toolbar: {
                            items: [
                                'heading',
                                'bold',
                                'italic',
                                'bulletedList',
                                'numberedList',
                                'undo',
                                'redo'
                            ]
                        }
                    })
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            const editorData = editor.getData();
                            $('#editor').val(editorData).trigger('input');
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });

            });
        </script>

    @endsection

</x-app-layout>
