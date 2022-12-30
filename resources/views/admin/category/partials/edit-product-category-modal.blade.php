<section>
@foreach( $productCategories as $prod_cate )
    <!-- BEGIN: Modal Create Product Category -->
    <div id="edit_product_category-{{ $prod_cate->id }}" class="modal create_category_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Tambah kategori Produk</h2>
                </div>
                <form method="POST" action="#" role="form" enctype="multipart/form-data">
                    @csrf
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="category_name" class="form-label">Nama</label>
                            <input id="category_name" value="{{ $prod_cate->name }}" name="name" type="text" class="form-control" placeholder="Masukan nama kategori produk">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="kategori_produk" class="form-label">Gambar kategori</label>
                            <img id="cate_prod_preview_edit-{{ $prod_cate->id }}" alt="category-prod-img" src="{{ asset('storage/product-category').'/'.$prod_cate->image_path }}" data-action="zoom" class="mb-3 w-full rounded-md w-20 h-20 border-2 border-blue-400 rounded-lg border-dotted decoration-dotted">
                            <div>
                                <input type="file" name="image[]" id="cate_prod_input_edit-{{ $prod_cate->id }}" accept="image/*" onchange="readURLProductEdit{{$prod_cate->id}}(this)" hidden required data-parsley-error-message="Anda belum mencantumkan foto."/>
                                <label for="cate_prod_input_edit-{{ $prod_cate->id }}" class="actual-btn-label px-3">Pilih Foto</label>
                                <span id="chosen_file_cate_prod_edit-{{ $prod_cate->id }}" class="file-chosen">Anda belum memilih foto</span>
                            </div>
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal
                        </button>
                        <button type="submit" class="btn btn-primary w-20">Simpan</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal Create Product Category -->

        <script>
            const actualBtnCateProdEdit{{$prod_cate->id}} = document.getElementById('cate_prod_input_edit-{{ $prod_cate->id }}');
            const fileChosenCateProdEdit{{$prod_cate->id}} = document.getElementById('chosen_file_cate_prod_edit-{{ $prod_cate->id }}');

            actualBtnCateProdEdit{{$prod_cate->id}}.addEventListener('change', function(){
                fileChosenCateProdEdit{{$prod_cate->id}}.textContent = this.files[0].name
            });

            //Change this to your no-image file
            let noimageCateProdEdit{{$prod_cate->id}} = "http://127.0.0.1:8000/assets/images/no-image-icon.png";

            function readURLProductEdit{{$prod_cate->id}}(input) {
                console.log(input.files);
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#cate_prod_preview_edit-{{ $prod_cate->id }}").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $("#cate_prod_preview_editp-{{ $prod_cate->id }}").attr("src", noimageCateProdEdit{{$prod_cate->id}});
                }
            }
        </script>

@endforeach
</section>
