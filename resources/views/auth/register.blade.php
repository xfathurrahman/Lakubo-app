<x-guest-layout>
    <div class="container sm:px-10" style="min-height: 90vh;">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Register Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="http://127.0.0.1:8000/" class="-intro-x flex items-center pt-5">
                    <img alt="Lakubo - Lapak UMKM Boyolali" class="w-6" src="{{ asset('assets/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3"> Lakubo </span>
                </a>
                <div class="my-auto">
                    <img alt="Lakubo - Lapak UMKM Boyolali" class="-intro-x w-1/2 -mt-16" src="{{ asset('assets/images/umkm-boy.png') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        Beberapa step untuk menjadi
                        <br>
                        bagian dari UMKM Boyolali.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70">
                        Jual beli produk UMKM lebih mudah!
                    </div>
                </div>
            </div>
            <!-- END: Register Info -->

            <!-- BEGIN: Register Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white px-5 sm:px-8 py-8 rounded-md shadow-md xl:shadow-none w-full p-10 sm:px-20">
                    @if(count($errors) > 0)
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                            <span class="font-medium">Data anda tidak valid ! lengkapi lalu coba lagi.<br></span>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    <h2 class="intro-x pb-5 font-bold text-2xl xl:text-3xl text-center xl:text-left">Mendaftar</h2>
                    <form action="{{ route('register') }}" method="POST" class="seller-form" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-section">
                            <div class="grid grid-cols-12 gap-4 gap-y-1 mt-3">
                                <!-- Name -->
                                <div class="intro-y col-span-12 sm:col-span-12">
                                    <label for="fullname" class="form-label">Nama Lengkap</label>
                                    <input id="fullname" name="name" type="text" class="form-control" placeholder="Muhammad Fathur Rahman" required data-parsley-maxlength="50">
                                </div>
                                <!-- Name -->
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="username" class="form-label">Nama Pengguna</label>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="fathurrahman" required data-parsley-maxlength="20">
                                </div>
                                <!-- Email Address -->
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Lakubo@lakubo.com" required data-parsley-type-message="Email tidak valid">
                                </div>
                                <!-- Phone -->
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="phone" class="form-label">Nomor Handphone</label>
                                    <input id="phone" type="text" name="phone" class="form-control numeric-input" placeholder="0812********" required data-parsley-minlength="8" data-parsley-maxlength="13">
                                </div>
                                <!-- Password -->
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <div class="relative">
                                        <input type="password" name="password" class="form-control pr-10" placeholder="Masukan kata sandi" id="password" autocomplete="off" required data-parsley-minlength="8">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-4 mr-2 flex items-center text-slate-400 focus:outline-none">
                                            <i class="fa-regular fa-eye-slash h-6 w-6"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="grid grid-cols-12 gap-4 gap-y-1 mt-5">
                                {{--Provinsi--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectProvince" class="form-label">Provinsi</label>
                                    <select id="selectProvince" name="province" class="w-full form-control" required>
                                        <option value="" selected disabled>-- Pilih Provinsi --</option>
                                        @foreach($provinces as $provinsi)
                                            <option value="{{$provinsi->id}}">{{ $provinsi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--Kabupaten--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectRegency" class="form-label">Kabupaten</label>
                                    <select id="selectRegency" name="regency" class="w-full form-control" required></select>
                                </div>
                                {{--Kecamatan--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectDistrict" class="form-label">Kecamatan</label>
                                    <select id="selectDistrict" name="district" class="w-full form-select" required=""></select>
                                </div>
                                {{--Desa--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectVillage" class="form-label">Desa</label>
                                    <select id="selectVillage" name="village" class="w-full form-select" required=""></select>
                                </div>
                            </div>
                            {{--Alamat Lengkap--}}
                            <div class="intro-y col-span-12 sm:col-span-6 mt-5">
                                <label for="detail_address" class="form-label w-full flex flex-col sm:flex-row">
                                    Detail Alamat
                                </label>
                                <textarea id="detail_address" class="form-control" name="detail_address" placeholder="Jl.Lakubo no..." minlength="10" required=""></textarea>
                            </div>
                        </div>
                        <p style="margin-top: 30px" class="text-gray-500 ml-1 mb-1">Sudah mendaftar?</p>
                        <div class="items-center w-full flex flex-col sm:flex-row justify-between">
                            <a href="http://127.0.0.1:8000/login" class="login-btn btn btn-outline-secondary w-full sm:w-auto">Masuk</a>
                            <div class="form-navigation mt-2 sm:mt-0 w-full sm:w-auto ml-auto">
                                <button type="button" class="next btn btn-primary w-full sm:w-auto">Selanjutnya</button>
                                <button type="button" class="previous btn btn-secondary w-full sm:w-auto">Sebelumnya</button>
                                <button type="submit" class="btn btn-primary mt-2 sm:mt-0 w-full sm:w-auto">Mendaftar</button>
                            </div>
                        </div>
                        <div class="intro-x pt-5 text-slate-600 dark:text-slate-500 text-center xl:text-left">
                            Dengan Mendaftar, anda telah menyetujui
                            <a class="text-primary dark:text-slate-200" href="">Terms and Conditions</a> &
                            <a class="text-primary dark:text-slate-200" href="">Privacy Policy</a> Lakubo.
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Wizard Layout -->
        </div>
    </div>

    @section('script')

        <script>

            $(document).ready(function () {
                // Disable text input
                const numericInputs = document.querySelectorAll('.numeric-input');
                numericInputs.forEach(function (input) {
                    input.addEventListener('input', function (e) {
                        e.target.value = e.target.value.replace(/[^0-9]/g, '');
                    });
                });

                // Atur Section
                var $sections = $('.form-section');

                function navigateTo(index) {
                    $sections.removeClass('current').eq(index).addClass('current');
                    $('.form-navigation .previous').toggle(index > 0);
                    var atTheEnd = index >= $sections.length - 1;
                    $('.form-navigation .next').toggle(!atTheEnd);
                    $('.form-navigation [Type=submit]').toggle(atTheEnd);

                    const step = document.querySelector('.step' + index);
                    step.style.backgroundColor = "#ff5656";
                    step.style.color = "white";
                }

                function curIndex() {
                    return $sections.index($sections.filter('.current'));
                }

                $('.form-navigation .previous').click(function () {
                    navigateTo(curIndex() - 1);
                });
                $('.form-navigation .next').click(function () {
                    Parsley.addMessage('en', 'required', 'Kolom ini wajib di isi');
                    Parsley.addMessage('en', 'maxlength', 'Maksimal %s digit');
                    Parsley.addMessage('en', 'minlength', 'Minimal %s digit');
                    $('.seller-form').parsley().whenValidate({
                        group: 'block-' + curIndex()
                    }).done(function () {
                        navigateTo(curIndex() + 1);
                    });
                });
                $sections.each(function (index, section) {
                    $(section).find(':input').attr('data-parsley-group', 'block-' + index);
                });
                navigateTo(0);
            });


            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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
            });
        </script>

    @endsection

</x-guest-layout>
