<section>
    @foreach($products as $product)
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal-{{$product->id}}" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Hapus Produk</div>
                        <div class="text-slate-500 mt-2">
                            Anda yakin ingin menghapus <b>{{$product->name}}</b> dari daftar produk anda?
                            <br>
                            Proses ini tidak dapat dibatalkan.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
    @endforeach
</section>
