<section>
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
                            <input id="cate_name" name="name" type="text" class="form-control" placeholder="Masukan nama kategori lapak">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="kategori_lapak" class="form-label">Gambar kategori</label>
                            <img id="cate_store_preview" alt="category-store-img" src="{{ asset('assets/images/no-image-icon.png') }}" data-action="zoom" class="mb-3 w-full rounded-md w-20 h-20 border-2 border-blue-400 rounded-lg border-dotted decoration-dotted">
                            <div>
                                <input type="file" name="image" id="cate_store_input" accept="image/*" onchange="readURLStore(this)" hidden required data-parsley-error-message="Anda belum mencantumkan foto."/>
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

    @foreach( $storeCategories as $store_cate )
        <!-- BEGIN: Edit Create store Category -->
        <div id="edit_store_category-{{ $store_cate->id }}" class="modal create_category_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Tambah kategori storeuk</h2>
                    </div>
                    <form method="POST" action="{{ route('admin.store.category.update', $store_cate->id) }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12">
                                <label for="category_name" class="form-label">Nama</label>
                                <input id="category_name" value="{{ $store_cate->name }}" name="name" type="text" class="form-control" placeholder="Masukan nama kategori storeuk">
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <label for="kategori_store" class="form-label">Gambar kategori</label>
                                <img id="cate_store_preview_edit-{{ $store_cate->id }}" alt="category-store-img" src="{{ asset('storage/store-category').'/'.$store_cate->image_path }}" data-action="zoom" class="mb-3 w-full rounded-md w-20 h-20 border-2 border-blue-400 rounded-lg border-dotted decoration-dotted">
                                <div>
                                    <input type="file" name="image" id="cate_store_input_edit-{{ $store_cate->id }}" accept="image/*" onchange="readURLStoreEdit{{$store_cate->id}}(this)" hidden/>
                                    <label for="cate_store_input_edit-{{ $store_cate->id }}" class="actual-btn-label px-3">Pilih Foto</label>
                                    <span id="chosen_file_cate_store_edit-{{ $store_cate->id }}" class="file-chosen">Anda belum memilih foto</span>
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
        <!-- END: Modal Edit store Category -->
        <script>
            const actualBtnCatestoreEdit{{$store_cate->id}} = document.getElementById('cate_store_input_edit-{{ $store_cate->id }}');
            const fileChosenCatestoreEdit{{$store_cate->id}} = document.getElementById('chosen_file_cate_store_edit-{{ $store_cate->id }}');

            actualBtnCatestoreEdit{{$store_cate->id}}.addEventListener('change', function(){
                fileChosenCatestoreEdit{{$store_cate->id}}.textContent = this.files[0].name
            });

            //Change this to your no-image file
            let noimageCatestoreEdit{{$store_cate->id}} = "http://127.0.0.1:8000/assets/images/no-image-icon.png";

            function readURLStoreEdit{{$store_cate->id}}(input) {
                console.log(input.files);
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#cate_store_preview_edit-{{ $store_cate->id }}").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $("#cate_store_preview_edit-{{ $store_cate->id }}").attr("src", noimageCatestoreEdit{{$store_cate->id}});
                }
            }
        </script>
    @endforeach

    <!-- BEGIN: Modal DELETE Lapak -->
    @foreach($storeCategories as $store_cate)
        <div id="delete-store-cate-modal-{{$store_cate->id}}" role="dialog" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Hapus Kategori Lapak</h2>
                    </div>
                    <form action="{{ route('admin.store.category.delete', $store_cate->id) }}" method="post" id="delete_cate_store_form">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <h5>Kamu ingin menghapus Kategori Lapak <b>{{$store_cate->name}}</b> ?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                            <button type="submit" class="btn btn-primary w-20">Ya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- END: Modal DELETE Lapak -->

</section>


<script>
    // BUAT KATEGORI LAPAK
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
