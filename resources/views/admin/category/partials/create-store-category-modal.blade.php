<!-- BEGIN: Modal Create Store Category -->
<div id="create_store_category" class="modal create_category_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Tambah kategori Lapak</h2>
            </div>
            <form method="POST" action="{{ route('admin.store.category.store') }}" role="form" enctype="multipart/form-data">
                @csrf
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="cate_name" class="form-label">Nama</label>
                        <input id="cate_name" name="nama_kategori" type="text" class="form-control" placeholder="Masukan nama kategori lapak">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="kategori_lapak" class="form-label">Gambar kategori</label>
                        <img id="cate_store_preview" alt="category-store-img" src="{{ asset('assets/images/no-image-icon.png') }}" data-action="zoom" class="mb-3 w-full rounded-md w-20 h-20 border-2 border-blue-400 rounded-lg border-dotted decoration-dotted">
                        <div>
                            <input type="file" name="gambar_kategori_lapak[]" id="cate_store_input" accept="image/*" onchange="readURLStore(this)" hidden required data-parsley-error-message="Anda belum mencantumkan foto."/>
                            <label for="cate_store_input" class="actual-btn-label px-3">Pilih Foto</label>
                            <span id="chosen_file_cate_store" class="file-chosen">Anda belum memilih foto</span>
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
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Modal Create Store Category -->

@section('script')
    <script>
        const actualBtnCateStore = document.getElementById('cate_store_input');
        const fileChosenCateStore = document.getElementById('chosen_file_cate_store');

        actualBtnCateStore.addEventListener('change', function(){
            fileChosenCateStore.textContent = this.files[0].name
        });

        //Change this to your no-image file
        let noimageCateStore = "http://127.0.0.1:8000/assets/images/no-image-icon.png";

        function readURLStore(input) {
            console.log(input.files);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#cate_store_preview").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $("#cate_store_preview").attr("src", noimageCateStore);
            }
        }
    </script>
@endsection
