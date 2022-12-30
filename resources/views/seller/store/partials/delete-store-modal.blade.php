<section>
    <!-- BEGIN: Modal Toggle -->
    <div class="text-right py-6">
        <a href="#" data-tw-toggle="modal" data-tw-target="#delete-store"
           class="btn btn-primary"><i data-lucide="trash" class="w-4 h-4 mr-2"></i>Hapus Lapak
        </a>
    </div>
    <!-- END: Modal Toggle -->

    <!-- BEGIN: Modal Content -->
    <div id="delete-store" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('seller.store.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Apa anda yakin?</div>
                            <div class="text-slate-500 mt-2">Anda yakin ingin menghapus lapak UMKM ini? <br>Proses ini akan menghapus seluruh data dan produk lapak anda.
                            </div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-danger w-24">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->
</section>
