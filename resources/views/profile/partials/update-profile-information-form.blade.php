<section>
    <div class="grid grid-cols-12 gap-2 sm:px-3 lg:px-5">
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12 box">
            <!-- BEGIN: Display Information -->
            @php
                $user = auth()->user();
                if (isset($user->address)) {
                    $userAddress = $user->address;
                    $userProvinceId = $userAddress->province->id;
                    $userRegencyId = $userAddress->regency->id;
                    $userDistrictId = $userAddress->district->id;
                    $userVillageId = $userAddress->village->id;
                    $userDetailAddress = $userAddress->detail_address;
                }
            @endphp
            <div class="intro-y mt-0">
                <form method="post" action="{{ route('profile.update') }}" data-parsley-validate class="space-y-3">
                    @csrf
                    @method('patch')
                        <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base ml-3 mr-auto">Informasi Akun</h2>
                        </div>
                    <div class="p-5">
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div>
                                            <label for="username" class="flex justify-between form-label">Nama Pengguna
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('username')"/></span>
                                            </label>
                                            <input id="username"
                                                   name="username"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="Masukan Nama Pengguna"
                                                   value="{{ $user->username }}"
                                                   required
                                                   data-parsley-error-message="Nama pengguna wajib di isi."
                                            >
                                        </div>
                                        <div class="mt-3">
                                            <label for="name" class="flex justify-between form-label">Nama lengkap
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('name')"/></span>
                                            </label>
                                            <input id="name"
                                                   name="name"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="Masukan Nama Lengkap"
                                                   value="{{ $user->name }}"
                                                   required
                                                   data-parsley-error-message="Nama lengkap wajib di isi."
                                            >
                                        </div>
                                        <div class="mt-3">
                                            <label for="email" class="flex justify-between form-label">Email
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('email')"/></span>
                                            </label>
                                            <input id="email"
                                                   name="email"
                                                   type="email"
                                                   class="form-control"
                                                   placeholder="Masukan Email"
                                                   value="{{ $user->email }}"
                                                   required
                                                   data-parsley-error-message="Email wajib di isi."
                                            >
                                        </div>
                                        <div class="mt-3">
                                            <label for="phone" class="flex justify-between form-label">Nomor Handphone
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('phone')"/></span>
                                            </label>
                                            <input id="phone"
                                                   type="number"
                                                   name="phone"
                                                   class="form-control"
                                                   placeholder="Masukan Nomor Handphone"
                                                   value="{{ $user->phone }}"
                                                   required
                                                   data-parsley-error-message="Nomor Handphone wajib di isi."
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="mt-3 2xl:mt-0">
                                            <label for="selectProvince" class="flex justify-between form-label">Provinsi
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('provinsi')"/></span>
                                            </label>
                                            <select id="selectProvince"
                                                    name="provinsi"
                                                    class="js-states form-control"
                                                    required
                                                    data-parsley-error-message="Provinsi wajib di isi."
                                            >
                                                @foreach( $provinces as $provinsi )
                                                    @if($provinsi -> id === $userProvinceId)
                                                        <option selected value="{{ $provinsi-> id }}">{{ $provinsi->name }}</option>
                                                    @else
                                                        <option value="{{ $provinsi -> id }}">{{ $provinsi -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="selectRegency" class="flex justify-between form-label">Kabupaten
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('kabupaten')"/></span>
                                            </label>
                                            <select id="selectRegency"
                                                    name="kabupaten"
                                                    class="w-full form-control"
                                                    required
                                                    data-parsley-error-message="Kabupaten wajib di isi."
                                            >
                                                @foreach( $regencies as $regency )
                                                    @if($regency -> id === $userRegencyId)
                                                        <option selected value="{{ $regency-> id }}">{{ $regency->name }}</option>
                                                    @else
                                                        <option value="{{ $regency -> id }}">{{ $regency -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="selectDistrict" class="flex justify-between form-label">Kecamatan
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('kecamatan')"/></span>
                                            </label>
                                            <select name="kecamatan"
                                                    id="selectDistrict"
                                                    class="w-full form-control"
                                                    required
                                                    data-parsley-error-message="Kecamatan wajib di isi."
                                            >
                                                @foreach( $districts as $district )
                                                    @if($district -> id === $userDistrictId)
                                                        <option selected value="{{ $district-> id }}">{{ $district->name }}</option>
                                                    @else
                                                        <option value="{{ $district -> id }}">{{ $district -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="selectVillage" class="flex justify-between form-label">Desa
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('desa')"/></span>
                                            </label>
                                            <select name="desa"
                                                    id="selectVillage"
                                                    class="w-full form-control"
                                                    required
                                                    data-parsley-error-message="Desa wajib di isi."
                                            >
                                                @foreach( $villages as $village )
                                                    @if($village -> id === $userVillageId)
                                                        <option selected value="{{ $village-> id }}">{{ $village->name }}</option>
                                                    @else
                                                        <option value="{{ $village -> id }}">{{ $village -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div class="mt-3">
                                            <label for="detail-address" class="flex justify-between form-label">Detail alamat
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('detail_alamat')"/></span>
                                            </label>
                                            <textarea id="detail-address"
                                                      name="detail_alamat"
                                                      class="form-control"
                                                      placeholder="Masukan detail alamat kamu"
                                                      required
                                                      data-parsley-error-message="Detail Alamat wajib di isi."
                                            >{{ $userDetailAddress }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-navigation flex items-center justify-start mt-3">
                                    <button type="submit" class="simpan btn btn-primary w-20">Simpan</button>
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
                            </div>
                            <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="h-40 relative mx-auto">
                                        <div id="loading-bg" class="absolute inset-0 bg-white/40 -mb-2 hidden"></div> <!-- layer background putih dengan opacity 20% -->
                                        @isset($user->profile_photo_path)
                                            <img id="preview-photo" class="rounded-md w-full filled-photo max-h-full" alt="Profile-photo-preview" src="{{ asset('storage/profile-photos/'. Auth::user()->profile_photo_path) }}">
                                        @else
                                            <img id="preview-photo" class="rounded-md w-full max-h-full" alt="Profile-photo-preview" src="https://ui-avatars.com/api/?size=100&name={{ Auth::user()->name }}">
                                        @endisset
                                        <div id="reset-photo" title="Remove this profile photo?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2 hidden">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </div>
                                        <span id="loading-icon" class="hidden">
                                            <i class="text-success absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8" data-loading-icon="three-dots"></i>
                                        </span>
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <button type="button" class="btn btn-primary w-full">Ubah Foto</button>
                                        <input name="profile_photo" id="profile-photo" accept="image/*" type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END: Display Information -->
        </div>
    </div>

</section>
