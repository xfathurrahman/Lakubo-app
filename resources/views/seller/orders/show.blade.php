<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('my-order-detail') }}
    @endsection

        <!-- BEGIN: Reject Confirmation Modal -->
        <div id="reject-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <div class="text-3xl mt-5">Anda yakin?</div>
                            <div class="text-slate-500 mt-2">
                                Anda yakin ingin mebatalkan pesanan ini?
                                <br>
                                Proses ini tidak dapat dikembalikan.
                            </div>
                        </div>
                        <form action="{{ route('seller.order.reject', $order->id) }}" method="POST" data-parsley-validate>
                            @csrf
                            @method('PUT')
                            <div class="p-5">
                                <label for="reject-msg">Alasan pembatalan</label>
                                <span id="parsley-msg" class="inline-flex float-right text-red-400"></span>
                                <input type="text"
                                       id="reject-msg"
                                       class="form-control w-full mt-2"
                                       placeholder="Masukan alasan pembatalan"
                                       data-parsley-minlength="15"
                                       data-parsley-minlength-message="Jelaskan minimal 15 karakter."
                                       data-parsley-required
                                       data-parsley-errors-container="#parsley-msg"
                                       data-parsley-required-message="Wajib memasukan alasan.">
                            </div>
                            <div class="px-5 pb-8 text-end">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Batal</button>
                                <button type="submit" id="rejectBtn" class="btn btn-primary w-24">Yakin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->

        <!-- BEGIN: Notification Content -->
        <div id="success-notification-content" class="toastify-content hidden flex">
            <i class="text-success" data-lucide="check-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">Status Disimpan!</div>
                <div class="text-slate-500 mt-1">Status Pesanan berhasil di ubah.</div>
            </div>
        </div>
        <!-- END: Notification Content -->

        <!-- BEGIN: Notification Content -->
        <div id="success-confirm-content" class="toastify-content hidden flex">
            <i class="text-success" data-lucide="check-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">Pesanan Dikonfirmasi!</div>
                <div class="text-slate-500 mt-1">Segera siapkan produk untuk dikirim ke pelanggan.</div>
            </div>
        </div>
        <!-- END: Notification Content -->

        <div id="detail-order">
            @include('seller.orders.partials.detail_order', ['order' => $order]);
        </div>

        @section('script')
            <script>
                let transactionExpire = "{{ $order->transaction_expire }}";
                const updateResiUrl = "{{ route('seller.order.update.resi', $order->id) }}";
                const updateStatusUrl = "{{ route('seller.order.update.status', $order->id) }}";
                const updateConfirmUrl = "{{ route('seller.order.confirm', $order->id) }}";
                const scriptElement = $("<script>").attr("src", "{{ asset('js/detail-order.js') }}");
            </script>
            <script src="{{ asset('js/detail-order.js') }}"></script>
        @endsection

</x-app-layout>
