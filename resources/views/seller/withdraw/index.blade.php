<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('store-withdrawals') }}
    @endsection

        @if(Session::has('error'))
            <div class="alert text-center alert-danger">
                {{ Session::get('error') }}
                @php
                    Session::forget('error');
                @endphp
            </div>
        @endif

    <!-- BEGIN: Succcess Notification Content -->
    <div id="confirm-notification-content" class="toastify-content hidden flex">
        <i class="text-success" data-lucide="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">Terimakasih Telah Berlapak di Lakubo!</div>
            <div class="text-slate-500 mt-1">Tempatnya jual - beli UMKM boyolali.</div>
        </div>
    </div>
    <!-- END: Succcess Notification Content -->

        <!-- BEGIN: Display Information -->
        <div class="intro-y mt-0">
            <form method="post" action="{{ route('seller.withdraw.store') }}" class="space-y-3">
                @csrf
                @method('post')
                <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                    <span class="text-2xl font-medium text-primary mx-auto">Penarikan dana Lapak</span>
                </div>
                <div class="flex justify-center">
                    <div class="p-5 box w-fit lg:w-1/4">
                        <div class="h-24 w-full">
                            <div class="report-box zoom-in h-full before:bg-primary/20">
                                <div class="box p-5 h-full bg-primary">
                                    <div class="text-white text-opacity-70 dark:text-slate-300 flex items-center leading-3">
                                        SALDO TERSEDIA
                                        <i data-lucide="alert-circle" class="w-4 h-4 ml-1.5"></i>
                                    </div>
                                    <div class="text-white relative text-2xl font-medium leading-5 mt-5">
                                        @currency($balance)
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->stores->bank_account_number)
                            <div class="bg-gray-200 mt-8 p-2 rounded">
                                <div class="flex justify-between">
                                    <div class="flex justify-between">
                                        <span class="w-20">Tujuan</span>
                                        <span class="ml-2 truncate text-ellipsis">: {{ Auth::user()->stores->bank_account_number }}</span>
                                    </div>
                                </div>
                                <div class="inline-flex">
                                    <span class="w-20">Atas nama</span>
                                    <span class="ml-2">: {{ Auth::user()->stores->bank_account_name }}</span>
                                </div>
                                <div class="inline-flex w-full">
                                    <span class="w-20">Nama Bank</span>
                                    <span class="ml-2">: {{ Auth::user()->stores->bank_name }}</span>
                                    <a class="ml-auto mr-0 text-blue-400" href="{{ route('seller.store.index') }}">Ubah</a>
                                </div>
                            </div>
                            <div class="mt-6">
                                <label for="amount" class="flex justify-between form-label">Jumlah penarikan
                                    <span class="text-slate-500"><x-input-error :messages="$errors->get('amount')"/></span>
                                </label>
                                <div class="input-group mt-2">
                                    <div class="input-group-text">Rp</div>
                                    <input name="amount"
                                           id="amount"
                                           required
                                           type="text"
                                           class="form-control numeric-input"
                                           placeholder="Masukan Jumlah penarikan"
                                           aria-label="Amount (to the nearest Rp)"
                                           data-parsley-error-message="Jumlah penarikan wajib di isi">
                                    <div class="input-group-text">,00</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-3">
                                <button type="submit" class="simpan btn btn-primary px-2">Minta Penarikan</button>
                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 ml-3"
                                    >{{ __('Tersimpan.') }}</p>
                                @endif
                            </div>
                        @else
                            <div class="bg-gray-200 mt-8 p-2 rounded">
                                <div class="flex justify-between">
                                    <div>Anda belum mengisi informasi rekening</div>
                                    <a class="text-blue-400" href="{{ route('seller.store.index') }}">Tambah</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <!-- END: Display Information -->

        @section('script')
            <script>
                $(document).ready(function () {
                    $('.numeric-input').on('input', function (event) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                });
            </script>
        @endsection

</x-app-layout>
