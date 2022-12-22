<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-edit') }}
    @endsection

    <div class="py-12 w-full">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 lg:col-span-8 2xl:col-span-12 rounded-lg">
                    <!-- BEGIN: Display Information -->
                    <div class="intro-y box">
                        <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Informasi Pengguna
                            </h2>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-col-reverse xl:flex-row flex-col">
                                <div class="flex-1 mt-6 xl:mt-0">
                                    <div class="grid grid-cols-12 gap-x-5">
                                        <!-- BEGIN: Profile photo -->
                                        <div class="col-span-12 2xl:col-span-2">
                                            <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
                                                <div class="intro-y box">
                                                    <div class="w-full mx-auto p-0">
                                                        <div class="p-0">
                                                            <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                                                <img class="rounded-md" alt="PP user" src="{{ asset('assets/images/profile-6.jpg') }}">
                                                                <div class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </div>
                                                            </div>
                                                            <div class="mx-auto cursor-pointer relative my-5">
                                                                <button type="button" class="btn btn-primary w-full">Unggah Foto</button>
                                                                <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Profile photo -->
                                        <div class="col-span-12 2xl:col-span-5">
                                            <div>
                                                <label for="update-profile-form-1" class="form-label">Nama Pengguna</label>
                                                <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="{{ $user->name }}">
                                            </div>
                                            <div class="mt-3">
                                                <label for="update-profile-form-1" class="form-label">Email</label>
                                                <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="{{ $user->email }}">
                                            </div>
                                            <div class="mt-3">
                                                <label for="update-profile-form-1" class="form-label">Nomor Handphone</label>
                                                <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="081234567890">
                                            </div>
                                        </div>
                                        <div class="col-span-12 2xl:col-span-5">
                                            <div>
                                                <label for="update-profile-form-1" class="form-label">Nama Pengguna</label>
                                                <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="{{ $user->name }}">
                                            </div>
                                            <div class="mt-3">
                                                <label for="update-profile-form-1" class="form-label">Email</label>
                                                <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="{{ $user->email }}">
                                            </div>
                                            <div class="mt-3">
                                                <label for="update-profile-form-1" class="form-label">Nomor Handphone</label>
                                                <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="081234567890">
                                            </div>
                                        </div>
                                        <div class="col-span-12">
                                            <div class="mt-3">
                                                <label for="update-profile-form-5" class="form-label">Detail Alamat</label>
                                                <textarea id="update-profile-form-5" class="form-control" placeholder="Adress">10 Anson Road, International Plaza, #10-11, 079903 Singapore, Singapore</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="float-right btn btn-primary w-20 mt-3">Simpan</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END: Display Information -->
                </div>

                <div class="col-span-12 rounded-lg box pb-5">
                    <!-- BEGIN: Account Setting -->
                    <div class="intro-y lg:my-5">
                        <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Pengaturan Akun
                            </h2>
                        </div>
                        <div class="p-5">
                            <form method="POST" action="{{ route('admin.users.roles.update', $user->id) }}">
                                @csrf
                                @method('PUT')
                                    <label for="user_role" class="form-label">Peran</label>
                                    <select name="role[]" data-placeholder="Cari peran..." id="user_role" class="tom-select w-full" multiple>
                                        @if($user->hasAnyRole([1,2,3,4,5,6,7,8,9]))
                                            @foreach ($user->roles as $user_role)
                                                @foreach( $roles as $role )
                                                    @if($user_role -> name === $role->name)
                                                        <option selected value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @else
                                                        <option value="{{ $role->name }}">{{ $role -> name }}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>

                                @error('role')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                                <button type="submit" class="float-right btn btn-primary w-20 mt-3">Simpan</button>
                            </form>
                        </div>
                        <div class="p-5">
                            <form method="POST" action="{{ route('admin.users.permissions.update', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <label for="user_permission" class="form-label">Hak akses</label>
                                <select name="permission[]" data-placeholder="Cari hak akses..." id="user_permission" class="tom-select w-full" multiple>
                                    @foreach ($user->permissions as $user_permission)
                                        @foreach ($permissions as $permission)
                                            @if($user_permission -> name === $permission->name)
                                                <option selected value="{{ $permission->name }}">{{ $permission->name }}</option>
                                            @else
                                                <option value="{{ $permission->name }}">{{ $permission -> name }}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                                <button type="submit" class="float-right btn btn-primary w-20 mt-3">Simpan</button>
                            </form>
                        </div>
                        <div class="p-5">
                            <div>
                                <label for="update-password" class="form-label">Kata sandi baru</label>
                                <input id="update-password" type="text" class="form-control" placeholder="Masukan kata sandi baru">
                            </div>
                            <button type="submit" class="float-right btn btn-primary w-20 mt-3">Simpan</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
