<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-edit') }}
    @endsection
            <div class="grid grid-cols-12 gap-2 sm:px-3 lg:px-5">
                <div class="col-span-12 lg:col-span-12 2xl:col-span-12 mt-2 box pb-2">
                    <!-- BEGIN: Display Information -->
                    <div class="intro-y lg:mt-0 xl:mt-2">
                        <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">Informasi Akun</h2>
                        </div>
                        <form method="POST" action="{{ route('admin.users.account.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="p-5">
                                <div class="flex flex-col-reverse xl:flex-row flex-col">
                                    <div class="flex-1 mt-6 xl:mt-0">
                                        <div class="grid grid-cols-12 gap-x-5">
                                            <div class="col-span-12 2xl:col-span-6">
                                                <div>
                                                    <label for="fullname" class="form-label">Nama</label>
                                                    <input id="fullname" name="new_fullname" type="text" class="form-control" placeholder="Input text" value="{{ $user->name }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input id="email" name="new_mail" type="email" class="form-control" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="col-span-12 2xl:col-span-6">
                                                <div>
                                                    <label for="update-profile-form-4" class="form-label">Phone Number</label>
                                                    <input id="update-profile-form-4" type="text" class="form-control" placeholder="Input text" value="65570828">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="update-profile-form-4" class="form-label">Phone Number</label>
                                                    <input id="update-profile-form-4" type="text" class="form-control" placeholder="Input text" value="65570828">
                                                </div>
                                            </div>
                                            <div class="col-span-12">
                                                <div class="mt-3">
                                                    <label for="update-profile-form-5" class="form-label">Address</label>
                                                    <textarea id="update-profile-form-5" class="form-control" placeholder="Adress">10 Anson Road, International Plaza, #10-11, 079903 Singapore, Singapore</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                        <div class="border-2 border-dashed shadow-sm border-blue-500 border-opacity-20 dark:border-darkmode-400 rounded-md p-5">
                                            <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                                <img class="rounded-md" alt="Midone - HTML Admin Template" src="http://rubick.left4code.com/dist/images/profile-15.jpg">
                                                <div class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </div>
                                            </div>
                                            <div class="mx-auto cursor-pointer relative mt-5">
                                                <button type="button" class="btn btn-primary w-full">Change Photo</button>
                                                <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="float-right btn btn-primary w-20 mt-3">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- END: Display Information -->
                </div>

                <div class="lg:col-span-6 col-span-12 rounded-lg box pb-2">
                    <div class="intro-y">
                        <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Peran & Hak Akses
                            </h2>
                        </div>
                        <form method="POST" action="{{ route('admin.users.access.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="p-5">
                                <div class="mt-3 lg:mt-0">
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

                                    <div class="mt-3">
                                        <label for="user_permission" class="form-label">Hak akses</label>
                                        <select name="permission[]" data-placeholder="Cari hak akses..." id="user_permission" class="tom-select w-full" multiple>
                                            @if($user->hasAnyPermission([1,2,3,4,5,6,7,8,9]))
                                                @foreach ($user->permissions as $user_permission)
                                                    @foreach( $permissions as $permission )
                                                        @if($user_permission -> name === $permission->name)
                                                            <option selected value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                        @else
                                                            <option value="{{ $permission->name }}">{{ $permission -> name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <button type="submit" class="float-right btn btn-primary w-20 mt-3">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-6 col-span-12 rounded-lg box pb-2">
                    <div class="intro-y">
                        <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Kata Sandi
                            </h2>
                        </div>
                        <form method="POST" action="{{ route('admin.users.password.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="p-5">
                                <div class="mt-3 lg:mt-0">
                                    <label for="update-password" class="form-label">Kata sandi baru</label>
                                    <input name="new_pass" id="update-password" type="text" class="form-control" placeholder="Kata sandi baru">
                                </div>
                                <div class="mt-3">
                                    <label for="update-password" class="form-label">Konfirmasi sandi baru</label>
                                    <input name="new_pass_confirm" id="update-password" type="text" class="form-control" placeholder="Konfirmasi sandi baru">
                                </div>
                                <button type="submit" class="float-right btn btn-primary w-20 mt-3">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

</x-app-layout>
