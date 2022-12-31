<x-app-layout>
    <div class="grid grid-cols-11 gap-x-6 mt-5 pb-20">
        <!-- BEGIN: Notification -->

        @section('breadcrumbs')
            {{ Breadcrumbs::render('product_edit') }}
        @endsection

        @if(Session::has('error'))
            <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
                <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
                <span>
                    {{ Session::get('error') }}
                    @php
                        Session::forget('error');
                    @endphp
                    <a href="https://themeforest.net/item/midone-jquery-tailwindcss-html-admin-template/26366820" class="underline ml-1" target="blank">Learn More</a>
                </span>
                <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
            </div>
        @endif

        <!-- BEGIN: Notification -->
        <div class="intro-y col-span-12 2xl:col-span-12">
            <form method="POST" action="{{ route('seller.products.update', $product->id) }}" data-parsley-validate="" role="form" enctype="multipart/form-data">
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
                                        <div class="leading-relaxed text-slate-500 text-xs mt-3"> Buat nama produk yang dapat menarik minat pembeli. Gunakan minimal 20 karakter. </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <input id="product-name"
                                           name="name"
                                           type="text"
                                           class="form-control"
                                           placeholder="Nama Produk"
                                           value="{{ $product->name }}"
                                           required=""
                                           data-parsley-maxlength="120"
                                           data-parsley-required-message="Wajib memasukan Nama Produk"
                                           data-parsley-maxlength-message="Maksimal 120 karakter..."
                                    >
                                </div>
                            </div>
                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <label for="category" class="font-medium">Kategori</label>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Wajib</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <select name="kategori"
                                            id="selectCateProd"
                                            class="w-full form-control"
                                            required
                                            data-parsley-required-message="Wajib memilih Kategori Produk"
                                    >
                                        <option selected disabled>Pilih Kategori</option>
                                        @foreach( $listCateProd as $cate_prod )
                                            @if($cate_prod -> id == $productCategories->id)
                                                <option selected value="{{ $cate_prod-> id }}">{{ $cate_prod->name }}</option>
                                            @else
                                                <option value="{{ $cate_prod -> id }}">{{ $cate_prod -> name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Harga & Kuantitas</div>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Wajib</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <div class="grid grid-cols-12 gap-x-5">
                                        <div class="col-span-12 2xl:col-span-6">
                                            <div>
                                                <input name="price"
                                                       type="number"
                                                       class="form-control"
                                                       onkeypress="return onlyNumberKey(event)"
                                                       placeholder="Masukan harga"
                                                       value="{{ $product->price }}"
                                                       required=""
                                                       data-parsley-maxlength="10"
                                                       data-parsley-required-message="Wajib memasukan data Harga"
                                                       data-parsley-maxlength-message="Maksimal 10 digit..."
                                                >
                                            </div>
                                        </div>
                                        <div class="col-span-12 2xl:col-span-6">
                                            <div>
                                                <input name="quantity"
                                                       type="number"
                                                       class="form-control mt-2 sm:mt-0"
                                                       onkeypress="return onlyNumberKey(event)"
                                                       placeholder="Stok"
                                                       value="{{ $product->quantity }}"
                                                       required=""
                                                       data-parsley-maxlength="7"
                                                       data-parsley-required-message="Wajib memasukan data Stok"
                                                       data-parsley-maxlength-message="Maksimal 7 digit..."
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
                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                            <div>Pastikan deskripsi produk memberikan penjelasan detail tentang produk Anda sehingga mudah untuk memahami dan menemukan produk Anda.</div>
                                            <div class="mt-2">Disarankan untuk tidak memasukkan info nomor ponsel, email, dll ke dalam deskripsi produk untuk melindungi data pribadi Anda.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                    <textarea name="description"
                                              class="editor"
                                              id="editor"
                                              required=""
                                              data-parsley-maxlength="1000"
                                              data-parsley-required-message="Wajib memasukan Deskripsi Produk"
                                              data-parsley-maxlength-message="Maksimal 1000 karakter..."
                                    >{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Product Detail -->
                <div class="form-navigation-product-edit flex justify-end flex-col md:flex-row gap-2 mt-5">
                    <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Batal</button>
                    <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Simpan & Tambah Baru</button>
                    <button type="submit" class="submit btn py-3 btn-primary w-full md:w-52">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @section('script')

        <script>
            $('.form-navigation-product-edit .submit').click(function(){
                Parsley.addMessage('en', 'required', 'Wajib mengunggah gambar produk.');
            });
        </script>

        <script>
            let preloaded = [
                    @foreach($product -> productImages as $image)
                {id: {{ $image->id }}, src: '{{ asset("storage/product-image")."/".$image -> image_path }}', name: 'files'},
                @endforeach
            ];

            $('.input-images-1').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'files',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 5
            });
        </script>

        <script>
            $(document).ready(function (){
                $("#selectCateProd").select2({
                    placeholder:'Pilih Kategori Produk',
                    searchInputPlaceholder: 'Cari kategori...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    }
                });
            });
        </script>

        <script>
            ClassicEditor.create( document.querySelector( '#editor' ), {
                    toolbar: { items: [
                            'heading',
                            'bold',
                            'italic',
                            'blockQuote',
                            'bulletedList',
                            'numberedList',
                            'insertTable',
                            'outdent',
                            'indent',
                            'blockQuote',
                            'undo',
                            'redo'
                        ] }
                } )
                .catch( error => {
                    console.log( error );
                } );
        </script>

    @endsection

</x-app-layout>
