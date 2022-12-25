<section>
    <div class="grid grid-cols-12 gap-2 sm:px-3 lg:px-5">
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12 box">
            <!-- BEGIN: Display Information -->
            <div class="intro-y mt-0">
                <form method="post" action="{{ route('profile.update') }}" class="space-y-3">
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
                                            <label for="username" class="form-label">Nama Pengguna</label>
                                            <input id="username" name="username" type="text" class="form-control" placeholder="Masukan Nama Pengguna" value="{{ $user->username }}">
                                            <x-input-error class="mt-2" :messages="$errors->get('username')" />
                                        </div>
                                        <div class="mt-3">
                                            <label for="fullname" class="form-label">Nama</label>
                                            <input id="fullname" name="name" type="text" class="form-control" placeholder="Masukan Nama Lengkap" value="{{ $user->name }}">
                                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                        </div>
                                        <div class="mt-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input id="email" name="email" type="email" class="form-control" placeholder="Masukan Email" value="{{ $user->email }}">
                                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                        </div>
                                        <div class="mt-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input id="phone" type="number" name="phone" class="form-control" placeholder="Masukan Nomor Handphone" value="{{ $user->phone }}">
                                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                        </div>
                                    </div>
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="mt-3 2xl:mt-0">
                                            <label for="selectProvince" class="form-label">Provinsi</label>
                                            <select id="selectProvince" name="province" class="js-states form-control" required>
                                                @foreach( $provinces as $provinsi )
                                                    @if($provinsi -> id == $userAddresses->province_id)
                                                        <option selected value="{{ $provinsi-> id }}">{{ $provinsi->name }}</option>
                                                    @else
                                                        <option value="{{ $provinsi -> id }}">{{ $provinsi -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-1">
                                            <label for="selectRegency" class="form-label">Kabupaten</label>
                                            <select id="selectRegency" name="regency" class="w-full form-control" required>
                                                @foreach( $regencies as $regency )
                                                    @if($regency -> id == $userAddresses->regency_id)
                                                        <option selected value="{{ $regency-> id }}">{{ $regency->name }}</option>
                                                    @else
                                                        <option value="{{ $regency -> id }}">{{ $regency -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-1">
                                            <label for="selectDistrict" class="form-label">Kecamatan</label>
                                            <select name="district" id="selectDistrict" class="w-full form-control" required>
                                                @foreach( $districts as $district )
                                                    @if($district -> id == $userAddresses->district_id)
                                                        <option selected value="{{ $district-> id }}">{{ $district->name }}</option>
                                                    @else
                                                        <option value="{{ $district -> id }}">{{ $district -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-1">
                                            <label for="selectVillage" class="form-label">Desa</label>
                                            <select name="village" id="selectVillage" class="w-full form-control" required>
                                                @foreach( $villages as $village )
                                                    @if($village -> id == $userAddresses->village_id)
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
                                            <label for="detail-address" class="form-label">Detail alamat</label>
                                            <textarea id="detail-address" name="detail_address" class="form-control" placeholder="Masukan detail alamat kamu">{{ $userAddresses->detail_address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-start mt-3">
                                    <button type="submit" class="btn btn-primary w-20">Simpan</button>
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
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <img class="rounded-md" alt="Midone - HTML Admin Template" src="{{ asset('assets/images/profile-13.jpg') }}">
                                        <div title="Remove this profile photo?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2"> <i data-lucide="x" class="w-4 h-4"></i> </div>
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <button type="button" class="btn btn-primary w-full">Change Photo</button>
                                        <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END: Display Information -->
        </div>

        <div class="lg:col-span-12 col-span-12 rounded-lg box pb-2">
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

    </div>

</section>

@section('script')
    <script>

        $(document).ready(function (){
            $("#selectProvince").select2({
                placeholder:'Pilih Provinsi',
                searchInputPlaceholder: 'Cari Provinsi...',
            });
            $("#selectRegency").select2({
                placeholder:'Pilih Kabupaten',
                searchInputPlaceholder: 'Cari Kabupaten...',
            });
            $("#selectDistrict").select2({
                placeholder:'Pilih Kecamatan',
                searchInputPlaceholder: 'Cari Kecamatan...',
            });
            $("#selectVillage").select2({
                placeholder:'Pilih Desa',
                searchInputPlaceholder: 'Cari Desa...',
            });
        });

        $(document).ready(function (){
            $("#selectProvince").select2({
                placeholder:'Pilih Provinsi',
                searchInputPlaceholder: 'Cari Provinsi...',
                ajax: {
                    url: "{{route('profile.getProvince')}}",
                    processResults: function({data}){
                        return {
                            results: $.map(data, function(item){
                                return {
                                    id: item.id,
                                    text: item.name,
                                }
                            })
                        }
                    }
                }
            });

            $("#selectProvince").change(function(){
                $('#selectRegency').html('');
                $('#selectDistrict').html('');
                $('#selectVillage').html('');
                let id = $('#selectProvince').val();
                $("#selectRegency").select2({
                    placeholder:'Pilih Kabupaten',
                    searchInputPlaceholder: 'Cari Kabupaten...',
                    ajax: {
                        url: "{{ url('profile/regency')}}/" + id,
                        processResults: function({data}){
                            return {
                                results: $.map(data, function(item){
                                    return {
                                        id: item.id,
                                        text: item.name,
                                    }
                                })
                            }
                        }
                    }
                });
            });

            $("#selectRegency").change(function(){
                $('#selectDistrict').html('');
                $('#selectVillage').html('');
                let id = $('#selectRegency').val();
                $("#selectDistrict").select2({
                    placeholder:'Pilih Kecamatan',
                    searchInputPlaceholder: 'Cari Kecamatan...',
                    ajax: {
                        url: "{{url('profile/district')}}/"+ id,
                        processResults: function({data}){
                            return {
                                results: $.map(data, function(item){
                                    return {
                                        id: item.id,
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                });
            });

            $("#selectDistrict").change(function(){
                $('#selectVillage').html('');
                let id = $('#selectDistrict').val();
                $("#selectVillage").select2({
                    placeholder:'Pilih Desa',
                    searchInputPlaceholder: 'Cari Desa...',
                    ajax: {
                        url: "{{url('profile/village')}}/"+ id,
                        processResults: function({data}){
                            return {
                                results: $.map(data, function(item){
                                    return {
                                        id: item.id,
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                });
            });

        });
    </script>
@endsection
