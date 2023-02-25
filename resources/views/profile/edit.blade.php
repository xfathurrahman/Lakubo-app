<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('profile') }}
    @endsection

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

    <div class="py-2">
        @include('profile.partials.update-profile-information-form')
        <div class="w-full pt-4 sm:rounded-lg sm:px-3 lg:px-5">
            @include('profile.partials.update-bank-information-form')
        </div>
        <div class="w-full pt-4 sm:rounded-lg sm:px-3 lg:px-5">
            @include('profile.partials.update-password-form')
        </div>
        <div class="w-full flex justify-end mt-3 sm:px-3 lg:px-5">
            @include('profile.partials.delete-user-form')
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
                            $("#preview-photo-top-bar").attr("src", e.target.result);
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
                                    url: "{{ route('profile.update.photo') }}",
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


                    if ($("#preview-photo").prop('src').includes("profile-photos")) {
                        $("#reset-photo").removeClass("hidden");
                        // Ketika tombol "Reset Foto" diklik, ganti gambar di preview dengan foto default
                        $("#reset-photo").click(function () {
                            $("#reset-photo").addClass("hidden");
                            // Jika src pada elemen #preview-photo tidak kosong, kirim permintaan Ajax untuk menghapus gambar profil
                            $.ajax({
                                url: '{{ route('profile.destroy.photo') }}',
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
                                    $("#preview-photo-top-bar").attr("src", "https://ui-avatars.com/api/?size=100&name={{ Auth::user()->name }}");
                                },
                            });
                            $("#preview-photo").attr("src", "https://ui-avatars.com/api/?size=100&name={{ Auth::user()->name }}");
                        });
                    }

                    // PARSLEY.JS
                    $('.form-navigation .simpan').click(function() {
                        Parsley.addMessage('en', 'required', 'Kolom ini wajib di isi');
                    });

                    // SELECT2.JS
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

                    $("#selectBankWd").select2({
                        placeholder:'Pilih Bank',
                        searchInputPlaceholder: 'Cari nama Bank...',
                    });

                    $("#selectProvince").select2({
                        placeholder:'Pilih Provinsi',
                        searchInputPlaceholder: 'Cari Provinsi...',
                        ajax: {
                            url: "{{ route('getProvince' )}}",
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

                $("#selectProvince").change(function(){
                    $('#selectRegency').html('');
                    $('#selectDistrict').html('');
                    $('#selectVillage').html('');
                    let id = $('#selectProvince').val();
                    $("#selectRegency").select2({
                        placeholder:'Pilih Kabupaten',
                        searchInputPlaceholder: 'Cari Kabupaten...',
                        ajax: {
                            url: "{{ url('indoregion/regency')}}/" + id,
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
                            url: "{{url('indoregion/district')}}/"+ id,
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
                            url: "{{url('indoregion/village')}}/"+ id,
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

            </script>
        @endsection

</x-app-layout>
