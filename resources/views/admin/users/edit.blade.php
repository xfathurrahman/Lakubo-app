<x-app-layout>

        <!-- BEGIN: Change Profile Notification Content -->
        <div id="change-profile-notification-content" class="toastify-content hidden flex">
            <i class="text-success" data-lucide="check-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium mt-1">Foto Profile Berhasil di ubah!</div>
            </div>
        </div>
        <!-- END: Change Profile Notification Content -->

        <!-- BEGIN: Delete Profile Notification Content -->
        <div id="delete-profile-notification-content" class="toastify-content hidden flex">
            <i class="text-danger" data-lucide="trash-2"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium mt-1">Foto Profile Berhasil di hapus!</div>
            </div>
        </div>
        <!-- END: Change Profile Notification Content -->

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-edit') }}
    @endsection
        <div class="py-2">
            <div class="grid grid-cols-12 gap-2 mt-5 sm:px-3">
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
                                                    <input id="fullname" name="new_fullname" type="text" class="form-control" placeholder="Masukan Nama Lengkap" value="{{ $user->name }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input id="email" name="new_mail" type="email" class="form-control" placeholder="Masukan Email" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="col-span-12 2xl:col-span-6">
                                                <div>
                                                    <label for="username" class="form-label">Username</label>
                                                    <input id="username" name="new_username" type="text" class="form-control" placeholder="Masukan username" value="{{ $user->username }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input id="phone" type="number" name="new_phone" class="form-control" placeholder="Masukan Nomor Handphone" value="{{ $user->phone }}">
                                                </div>
                                            </div>
                                            <div class="col-span-12">
                                                <div class="mt-3">
                                                    <label for="update-profile-form-5" class="form-label">Alamat</label>
                                                    <textarea disabled id="update-profile-form-5" class="form-control h-20" placeholder="Adress">{{ $user->address->detail_address }}, {{ $user->address->village->name }}, {{ $user->address->district->name }}, {{ $user->address->regency->name }}, {{ $user->address->province->name }}.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                        <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                            <div class="h-40 relative mx-auto">
                                                <div id="loading-bg" class="absolute inset-0 bg-white/40 -mb-2 hidden"></div> <!-- layer background putih dengan opacity 20% -->
                                                @isset($user->profile_photo_path)
                                                    <img id="preview-photo" class="rounded-md w-full filled-photo max-h-full" alt="Profile-photo-preview" src="{{ asset('storage/profile-photos/'. $user->profile_photo_path) }}">
                                                @else
                                                    <img id="preview-photo" class="rounded-md w-full max-h-full" alt="Profile-photo-preview" src="https://ui-avatars.com/api/?size=100&name={{ $user->name }}">
                                                @endisset
                                                <div id="reset-photo" title="Hapus foto profil ini?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2 hidden">
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
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                            
                                    <div class="mt-3">
                                        <label for="user_permission" class="form-label">Hak akses</label>
                                        <select name="permission[]" data-placeholder="Cari hak akses..." id="user_permission" class="tom-select w-full" multiple>
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->name }}" {{ $user->hasPermissionTo($permission->name) ? 'selected' : '' }}>{{ $permission->name }}</option>
                                            @endforeach
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
        </div>

    @section('script')
        <script>
            $(document).ready(function (){

                // Set CSRF token untuk setiap request jQuery
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // Ketika tombol "Ubah Foto" diklik, tampilkan jendela dialog untuk memilih file gambar
                $("#change-photo").click(function() {
                    $("#profile-photo").click();
                });
                // Ketika file gambar dipilih, tampilkan gambar di preview
                $("#profile-photo").change(function() {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#preview-photo").attr("src", e.target.result);
                        $("#reset-photo").removeClass("hidden");
                        // Tampilkan icon loading selama 3 detik sebelum memulai permintaan Ajax
                        $("#loading-bg").removeClass("hidden");
                        $("#loading-icon").removeClass("hidden");
                        setTimeout(function() {
                            // Kirim permintaan Ajax untuk memperbarui gambar profil setelah 3 detik
                            var formData = new FormData();
                            formData.append("profile_photo", $("#profile-photo")[0].files[0]);
                            $.ajax({
                                url: '{{ route('admin.profile.update.photo', $user->id) }}',
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function () {
                                    // code yang akan dijalankan sebelum permintaan dikirim
                                },
                                complete: function() {
                                    $("#loading-bg").addClass("hidden");
                                    $("#loading-icon").addClass("hidden");
                                },
                                success: function(response) {
                                    Toastify({
                                        node: $("#change-profile-notification-content").clone().removeClass("hidden")[0],
                                        duration: 3000,
                                        newWindow: true,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        stopOnFocus: true,
                                    }).showToast();
                                },
                                error: function() {
                                    // code yang akan dijalankan jika permintaan gagal
                                },
                                complete: function() {
                                    // Sembunyikan icon loading setelah permintaan selesai
                                    $("#loading-bg").addClass("hidden");
                                    $("#loading-icon").addClass("hidden");
                                }
                            });
                        }, 2000);
                    }
                    reader.readAsDataURL(this.files[0]);
                });

                if ($("#preview-photo").prop('class').includes("filled-photo")) {
                    $("#reset-photo").removeClass("hidden");
                    // Ketika tombol "Reset Foto" diklik, ganti gambar di preview dengan foto default
                    $("#reset-photo").click(function () {
                        $("#reset-photo").addClass("hidden");
                        // Jika src pada elemen #preview-photo tidak kosong, kirim permintaan Ajax untuk menghapus gambar profil
                        $.ajax({
                            url: '{{ route('admin.profile.destroy.photo', $user->id) }}',
                            method: 'POST',
                            success: function () {
                                Toastify({
                                    node: $("#delete-profile-notification-content").clone().removeClass("hidden")[0],
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                }).showToast();
                            },
                        });
                        $("#preview-photo").attr("src", "https://ui-avatars.com/api/?size=100&name={{ $user->name }}");
                    });
                }
            });

        </script>
    @endsection


</x-app-layout>
