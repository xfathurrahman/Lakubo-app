<section>
    @foreach($stores as $store)
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal-{{$store->id}}" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.store.delete', $store->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Hapus Pelapak</div>
                            <div class="text-slate-500 mt-2">
                                Anda yakin ingin menghapus <b>{{$store->name}}</b> dari daftar pelapak ?
                                <br>
                                Proses ini tidak dapat dibatalkan.
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
    <!-- END: Delete Confirmation Modal -->
    @endforeach
</section>
