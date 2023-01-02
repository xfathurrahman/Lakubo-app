<section>

    <!-- BEGIN: Modal DELETE Produk -->
    @foreach($productCategories as $prod_cate)
        <div id="delete-prod-cate-modal-{{$prod_cate->id}}" role="dialog" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Hapus Kategori Produk</h2>
                    </div>
                    <form action="{{ route('admin.product.category.delete', $prod_cate->id) }}" method="post" id="delete_cate_prod_form">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <h5>Kamu ingin menghapus Kategori Produk <b>{{$prod_cate->name}}</b> ?</h5>
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
    <!-- END: Modal DELETE Produk -->

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
