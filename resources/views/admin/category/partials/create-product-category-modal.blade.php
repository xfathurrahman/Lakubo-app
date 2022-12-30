<section>
    <!-- BEGIN: Modal Create Product Category -->
    <div id="create_product_category" class="modal create_category_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Tambah kategori Produk</h2>
                </div>
                <form method="POST" action="{{ route('admin.product.category.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="category_name" class="form-label">Nama</label>
                            <input id="category_name" name="name" type="text" class="form-control" placeholder="Masukan nama kategori produk">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="kategori_produk" class="form-label">Gambar kategori</label>
                            <img id="cate_prod_preview" alt="category-prod-img" src="{{ asset('assets/images/no-image-icon.png') }}" data-action="zoom" class="mb-3 w-full rounded-md w-20 h-20 border-2 border-blue-400 rounded-lg border-dotted decoration-dotted">
                            <div>
                                <input type="file" name="image[]" id="cate_prod_input" accept="image/*" onchange="readURLProduct(this)" hidden required data-parsley-error-message="Anda belum mencantumkan foto."/>
                                <label for="cate_prod_input" class="actual-btn-label px-3">Pilih Foto</label>
                                <span id="chosen_file_cate_prod" class="file-chosen">Anda belum memilih foto</span>
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
</section>

@section('script')
    <script>
        const actualBtnCateProd = document.getElementById('cate_prod_input');
        const fileChosenCateProd = document.getElementById('chosen_file_cate_prod');

        actualBtnCateProd.addEventListener('change', function(){
            fileChosenCateProd.textContent = this.files[0].name
        });

        //Change this to your no-image file
        let noimageCateProd = "http://127.0.0.1:8000/assets/images/no-image-icon.png";

        function readURLProduct(input) {
            console.log(input.files);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#cate_prod_preview").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $("#cate_prod_preview").attr("src", noimageCateProd);
            }
        }
    </script>
@endsection
