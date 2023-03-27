<section>
    <div class="col-span-12 lg:col-span-12 2xl:col-span-12 box">
        <div class="intro-y">
            <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base ml-3 mr-auto">
                    Informasi Rekening Lapak
                </h2>
            </div>
            <form method="post" action="{{ route('seller.store.update.bank') }}">
                @csrf
                @method('patch')
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 2xl:col-span-4">
                            <div class="mt-3 lg:mt-0">
                                <label for="bank_acc_name" class="form-label">Nama akun rekening Bank</label>
                                <input name="bank_acc_name"
                                       id="bank_acc_name"
                                       type="text"
                                       class="form-control"
                                       placeholder="Masukan nama sesuai yang terdaftar di rekening anda."
                                       value="{{ Auth::user()->stores->bank_account_name }}"
                                >
                                <span class="text-slate-500"><x-input-error :messages="$errors->get('bank_acc_name')"/></span>
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-4">
                            <div class="mt-3 lg:mt-0">
                                <label for="bank_acc_number" class="form-label">Nomor rekening Bank</label>
                                <input name="bank_acc_number"
                                       id="bank_acc_number"
                                       type="text"
                                       class="form-control numeric-input"
                                       placeholder="Masukan Nomor Rekening"
                                       value="{{ Auth::user()->stores->bank_account_number }}"
                                >
                                <span class="text-slate-500"><x-input-error :messages="$errors->get('bank_acc_number')"/></span>
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-4">
                            <div class="mt-3 lg:mt-0">
                                <label for="bank_name" class="flex justify-between form-label">Pilih nama Bank
                                    <span class="text-slate-500"><x-input-error :messages="$errors->get('bank_name')"/></span>
                                </label>
                                <select id="selectBankWd" name="bank_name" class="w-full form-control">
                                    <option value=" " selected>Pilih Bank</option>
                                    <option value="BRI" {{ Auth::user()->stores->bank_name === 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                                    <option value="BCA" {{ Auth::user()->stores->bank_name === 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                    <option value="MANDIRI" {{ Auth::user()->stores->bank_name === 'MANDIRI' ? 'selected' : '' }}>Bank Mandiri</option>
                                    <option value="BNI" {{ Auth::user()->stores->bank_name === 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                                    <option value="PERMATA" {{ Auth::user()->stores->bank_name === 'PERMATA' ? 'selected' : '' }}>Bank Permata</option>
                                    <option value=" " disabled>E-Wallet</option>
                                    <option value="GOPAY" {{ Auth::user()->stores->bank_name === 'GOPAY' ? 'selected' : '' }}>Gopay</option>
                                    <option value="DANA" {{ Auth::user()->stores->bank_name === 'DANA' ? 'selected' : '' }}>Dana</option>
                                    <option value="SHOPPE-PAY" {{ Auth::user()->stores->bank_name === 'SHOPPE-PAY' ? 'selected' : '' }}>Shoppe Pay</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-start mt-3">
                        <button type="submit" class="btn btn-primary w-20">Simpan</button>
                        @if (session('status') === 'bank-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 ml-3"
                            >{{ __('Tersimpan.') }}</p>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
