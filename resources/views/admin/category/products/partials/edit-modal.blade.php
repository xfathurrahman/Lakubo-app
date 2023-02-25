<!-- BEGIN: Modal EDIT Product Category -->
<div id="edit_product_category-{{$category->id }}" class="modal create_category_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Edit kategori Produk</h2>
            </div>
            <form method="POST" action="{{ route('admin.product.category.update',  $category->id) }}" role="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="category_name" class="form-label">Nama</label>
                        <input id="category_name" value="{{$category->name}}" name="name" type="text" class="form-control" placeholder="Masukan nama kategori produk">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="kategori_produk" class="form-label">Gambar kategori</label>
                        <img id="cate_prod_preview_edit-{{$category->id}}" alt="category-prod-img" src="{{ asset('storage/product-category').'/'. $category->image_path }}" data-action="zoom" class="mb-3 w-full rounded-md w-20 h-20 border-2 border-blue-400 rounded-lg border-dotted decoration-dotted">
                        <div>
                            <input type="file" name="image" id="cate_prod_input_edit-{{$category->id}}" accept="image/*" onchange="readURLProductEdit{{$category->id}}(this)" hidden/>
                            <label for="cate_prod_input_edit-{{$category->id}}" class="actual-btn-label px-3">Pilih Foto</label>
                            <span id="chosen_file_cate_prod_edit-{{$category->id }}" class="file-chosen">Anda belum memilih foto</span>
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
<!-- END: Modal Edit Product Category -->

<script>
    // EDIT KATEGORI PRODUK
    const actualBtnCateProdEdit{{$category->id}} = document.getElementById('cate_prod_input_edit-{{$category->id }}');
    const fileChosenCateProdEdit{{$category->id}} = document.getElementById('chosen_file_cate_prod_edit-{{$category->id }}');

    actualBtnCateProdEdit{{$category->id}}.addEventListener('change', function(){
        fileChosenCateProdEdit{{$category->id}}.textContent = this.files[0].name
    });

    //Change this to your no-image file
    let noimageCateProdEdit{{$category->id}} = "http://127.0.0.1:8000/assets/images/no-image-icon.png";

    function readURLProductEdit{{$category->id}}(input) {
        console.log(input.files);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#cate_prod_preview_edit-{{$category->id}}").attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $("#cate_prod_preview_editp-{{$category->id}}").attr("src", noimageCateProdEdit{{$category->id}});
        }
    }
</script>
