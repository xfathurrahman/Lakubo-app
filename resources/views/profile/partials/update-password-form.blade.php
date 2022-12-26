<section>
    <div class="col-span-12 lg:col-span-12 2xl:col-span-12 box">
        <div class="intro-y">
            <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base ml-3 mr-auto">
                    Kata Sandi
                </h2>
            </div>
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 2xl:col-span-4">
                            <div class="mt-3 lg:mt-0">
                                <label for="current_password" class="form-label">Kata sandi saat ini</label>
                                <input name="current_password" id="current_password" type="password" class="form-control" placeholder="Masukan sandi saat ini">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-4">
                            <div class="mt-3 lg:mt-0">
                                <label for="new_password" class="form-label">Kata sandi baru</label>
                                <input name="password" id="new_password" type="password" class="form-control" placeholder="Masukan sandi baru">
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-4">
                            <div class="mt-3 lg:mt-0">
                                <label for="password_confirmation" class="form-label">Konfirmasi kata sandi</label>
                                <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="Masukan konfirmasi sandi baru">
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-start mt-3">
                        <button type="submit" class="btn btn-primary w-20">Simpan</button>
                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Tersmipan.') }}</p>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
