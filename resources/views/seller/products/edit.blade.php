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
            <form method="POST" action="{{ route('seller.products.update', $product->id) }}" class="dropzone" role="form" enctype="multipart/form-data">
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
                                        <div class="flex items-center">
                                            <div class="font-medium">Foto Produk</div>
                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Saat ini</div>
                                        </div>
                                        <div class="w-full mt-3">
                                            <div class="flex justify-center">
                                                @foreach($product -> productImages as $image)
                                                    <div class="w-12 h-12 image-fit zoom-in">
                                                        <img data-action="zoom" alt="Product-img" class="tooltip rounded-full" src="{{ asset("storage/product-image")."/".$image -> image_path }}" title="Uploaded {{ Carbon\Carbon::parse($product->created_at)->diffForHumans() }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-3 xl:mt-0 flex-1">

                                    @foreach ($product -> productImages as $attach)
                                        <?php $path =  base64_encode(asset($attach->url)); ?>

                                        <script>
                                            $("document").ready(()=>{
                                                var path = "{{ $path }}";
                                                var file = new File([path], "{{ $attach->name }}", {type: "{{ $attach->mime_type }}", lastModified: {{ $attach->updated_at}}})
                                                file['status'] = "queued";
                                                file['status'] = "queued";
                                                file['previewElement'] = "div.dz-preview.dz-image-preview";
                                                file['previewTemplate'] = "div.dz-preview.dz-image-preview";
                                                file['_removeLink'] = "a.dz-remove";
                                                file['webkitRelativePath'] = "";
                                                file['width'] = 500;
                                                file['height'] = 500;
                                                file['accepted'] = true;
                                                file['dataURL'] = path;
                                                file['upload'] = {
                                                    bytesSent: 0 ,
                                                    filename: "{{ $attach->file_name }}" ,
                                                    progress: 0 ,
                                                    total: {{ $attach->file_size }} ,
                                                    uuid: "{{ md5($attach->id) }}" ,
                                                };

                                                myDropzone.emit("addedfile", file , path);
                                                myDropzone.emit("thumbnail", file , path);
                                                // myDropzone.emit("complete", itemInfo);
                                                // myDropzone.options.maxFiles = myDropzone.options.maxFiles - 1;
                                                myDropzone.files.push(file);
                                                console.log(file);
                                            });
                                        </script>
                                    @endforeach

                                    {{--<div class="input-field">
                                        <div class="input-images-1"></div>
                                    </div>--}}
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
                                    <input id="product-name" name="name" type="text" class="form-control" value="{{ $product->name }}" placeholder="Nama Produk">
                                    <div class="form-help text-right">Maximum character 0/50</div>
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
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div class="input-group">
                                            <div class="input-group-text">Rp</div>
                                            <input name="price" value="{{ $product->price }}" type="text" class="form-control" placeholder="Harga">
                                        </div>
                                        <input name="quantity" value="{{ $product->quantity }}" type="text" class="form-control mt-2 sm:mt-0" placeholder="Stok">
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
                                    <textarea name="description" class="editor" id="editor">
                                        {{ $product->description }}
                                    </textarea>
                                    <div class="form-help text-right">Maximum character 0/2000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Product Detail -->
                <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                    <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Batal</button>
                    <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Simpan & Tambah Baru</button>
                    <button type="submit" class="btn py-3 btn-primary w-full md:w-52">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @section('script')
        {{--<script>

            let preloaded = [
                {id: 1, src: 'https://picsum.photos/500/500?random=1'},
                {id: 2, src: 'https://picsum.photos/500/500?random=2'},
                {id: 3, src: 'https://picsum.photos/500/500?random=3'},
                {id: 4, src: 'https://picsum.photos/500/500?random=4'},
                {id: 5, src: 'https://picsum.photos/500/500?random=5'},
            ];

            $('.input-images-1').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'files',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 5
            });
        </script>--}}

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
                            'alignment',
                            'bold',
                            'italic',
                            'blockQuote',
                            'underline',
                            'subscript',
                            'superscript',
                            'bulletedList',
                            'numberedList',
                            'todoList',
                            'fontfamily',
                            'fontsize',
                            'fontColor',
                            'fontBackgroundColor',
                            'code',
                            'codeBlock',
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
