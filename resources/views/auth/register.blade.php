<x-guest-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @endsection
    <div class="container sm:px-10 sm:overflow-hidden" style="min-height: 90vh;">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Register Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="{{ route('home') }}" class="-intro-x flex items-center pt-5">
                    <img alt="Lakubo - Lapak UMKM Boyolali" class="h-10 lg:pl-36 rounded-2xl" src="{{ asset('assets/images/lakubo-logo copy.svg') }}">
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
            <div class="h-screen xl:h-auto xl:flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white px-5 sm:px-8 py-8 rounded-md shadow-md xl:shadow-none w-full p-10 sm:px-20">
                    @if(count($errors) > 0)
                        <div id="alert-border-2" class="flex mt-4 p-4 mb-4 bg-red-100 border-t-4 border-red-500 intro-x" role="alert">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3 text-sm font-medium text-red-700">
                                @php $counter = 1; @endphp
                                @foreach($errors->all() as $error)
                                    {{ $counter }}. {{ $error }}<br>
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#alert-border-2" aria-label="Close">
                                <span class="sr-only">Dismiss</span>
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                    <h2 class="intro-x pb-5 font-bold text-2xl xl:text-3xl text-center xl:text-left">Mendaftar</h2>
                    <form action="{{ route('register') }}" method="POST" id="register_form" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-section">
                            <div class="grid grid-cols-12 gap-4 gap-y-1 mt-3">
                                <!-- Name -->
                                <div class="intro-y col-span-12 sm:col-span-12">
                                    <label for="fullname" class="form-label w-full">
                                        <span class="font-medium">Nama Lengkap</span>
                                        <span class="float-right text-red-500" id="fullname_error"></span>
                                    </label>
                                    <input id="fullname"
                                           name="name"
                                           type="text"
                                           class="form-control"
                                           placeholder="Muhammad Fathur Rahman"
                                           required data-parsley-maxlength="50"
                                           data-parsley-required-message="Wajib di isi."
                                           data-parsley-errors-container="#fullname_error"
                                    >
                                </div>
                                <!-- Name -->
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="username" class="form-label w-full">
                                        <span class="font-medium">Nama Pengguna</span>
                                        <span class="float-right text-red-500" id="username_error"></span>
                                    </label>
                                    <input id="username"
                                           name="username"
                                           type="text"
                                           class="form-control"
                                           placeholder="fathurrahman"
                                           required data-parsley-maxlength="20"
                                           data-parsley-required-message="Wajib di isi."
                                           data-parsley-errors-container="#username_error"
                                    >
                                </div>
                                <!-- Email Address -->
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="email" class="form-label w-full">
                                        <span class="font-medium">Email</span>
                                        <span class="float-right text-red-500" id="email_error"></span>
                                    </label>
                                    <input id="email"
                                           name="email"
                                           type="email"
                                           class="form-control"
                                           placeholder="Lakubo@lakubo.com"
                                           required
                                           data-parsley-type-message="Bukan email yang valid."
                                           data-parsley-required-message="Wajib di isi."
                                           data-parsley-errors-container="#email_error"
                                    >
                                </div>
                                <!-- Phone -->
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="phone" class="form-label w-full">
                                        <span class="font-medium">Nomor Handphone</span>
                                        <span class="float-right text-red-500" id="phone_error"></span>
                                    </label>
                                    <input id="phone"
                                           type="text"
                                           name="phone"
                                           class="form-control numeric-input"
                                           placeholder="0812********"
                                           required
                                           data-parsley-minlength="8"
                                           data-parsley-maxlength="13"
                                           data-parsley-required-message="Wajib di isi."
                                           data-parsley-errors-container="#phone_error"
                                    >
                                </div>
                                <!-- Password -->
                                <div class="intro-y col-span-12 sm:col-span-6 mb-6">
                                    <label for="password" class="form-label w-full">
                                        <span class="font-medium">Kata Sandi</span>
                                        <span class="float-right text-red-500" id="password_error"></span>
                                    </label>
                                    <div class="relative">
                                        <input type="password"
                                               name="password"
                                               class="form-control pr-10"
                                               placeholder="Masukan kata sandi"
                                               id="password"
                                               required
                                               data-parsley-minlength="8"
                                               data-parsley-minlength-message="Minimal 8 karakter."
                                               data-parsley-required-message="Wajib di isi."
                                               data-parsley-errors-container="#password_error"
                                        >
                                        <button type="button" class="toggle-password absolute inset-y-0 right-0 w-10 flex items-center justify-center text-slate-400 focus:outline-none">
                                            <i class="fa-regular fa-eye-slash h-6 w-6 mx-auto"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="grid grid-cols-12 gap-4 gap-y-1 mt-3">
                                {{--Provinsi--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectProvince" class="form-label w-full">
                                        <span class="font-medium">Pilih Provinsi</span>
                                        <span class="float-right text-red-500" id="province_error"></span>
                                    </label>
                                    <select
                                        id="selectProvince"
                                        name="province"
                                        class="w-full form-control"
                                        required
                                        data-parsley-required-message="Wajib di isi."
                                        data-parsley-errors-container="#province_error">
                                        <option value="" selected disabled>-- Pilih Provinsi --</option>
                                        @foreach($provinces as $provinsi)
                                            <option value="{{$provinsi->id}}">{{ $provinsi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--Kabupaten--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectRegency" class="form-label w-full">
                                        <span class="font-medium">Pilih Kabupaten</span>
                                        <span class="float-right text-red-500" id="regency_error"></span>
                                    </label>
                                    <select id="selectRegency"
                                            name="regency"
                                            class="w-full form-control"
                                            required
                                            data-parsley-required-message="Wajib di isi."
                                            data-parsley-errors-container="#regency_error"
                                    ></select>
                                </div>
                                {{--Kecamatan--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectDistrict" class="form-label w-full">
                                        <span class="font-medium">Pilih Kecamatan</span>
                                        <span class="float-right text-red-500" id="district_error"></span>
                                    </label>
                                    <select id="selectDistrict"
                                            name="district"
                                            class="w-full form-control"
                                            required
                                            data-parsley-required-message="Wajib di isi."
                                            data-parsley-errors-container="#district_error"
                                    ></select>
                                </div>
                                {{--Desa--}}
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="selectVillage" class="form-label w-full">
                                        <span class="font-medium">Pilih Desa</span>
                                        <span class="float-right text-red-500" id="village_error"></span>
                                    </label>
                                    <select id="selectVillage"
                                            name="village"
                                            class="w-full form-control"
                                            required
                                            data-parsley-required-message="Wajib di isi."
                                            data-parsley-errors-container="#village_error"
                                    ></select>
                                </div>
                            </div>
                            {{--Alamat Lengkap--}}
                            <div class="intro-y col-span-12 sm:col-span-6 mt-3">
                                <label for="detail_address" class="form-label w-full">
                                    <span class="font-medium">Detail Alamat</span>
                                    <span class="float-right text-red-500" id="detail_address_error"></span>
                                </label>
                                <textarea id="detail_address"
                                          class="form-control"
                                          name="detail_address"
                                          placeholder="Jl.Lakubo no..."
                                          minlength="10"
                                          required=""
                                          data-parsley-required-message="Wajib di isi."
                                          data-parsley-minlength-message="Minimal 10 karakter."
                                          data-parsley-errors-container="#detail_address_error"
                                ></textarea>
                            </div>
                        </div>
                        <p style="margin-top: 30px" class="text-gray-500 ml-1 mb-1">Sudah mendaftar?</p>
                        <div class="items-center w-full flex flex-col sm:flex-row justify-between">
                            <a href="{{ route('login') }}" class="login-btn btn btn-outline-secondary w-full sm:w-auto">Masuk</a>
                            <div class="form-navigation mt-2 sm:mt-0 w-full sm:w-auto ml-auto">
                                <button type="button" class="next btn btn-primary w-full sm:w-auto">Selanjutnya</button>
                                <button type="button" class="previous btn btn-secondary w-full sm:w-auto">Sebelumnya</button>
                                <button type="submit" class="btn btn-primary mt-2 sm:mt-0 w-full sm:w-auto">Mendaftar</button>
                            </div>
                        </div>
                        <div class="intro-x mt-5 text-slate-600 dark:text-slate-500 text-center xl:text-left">
                            Dengan Mendaftar, anda telah menyetujui
                            <a class="text-primary dark:text-slate-200" href="{{ route('TAC') }}">Syarat dan Ketentuan</a> &
                            <a class="text-primary dark:text-slate-200" href="{{ route('PP') }}">Kebijakan Privasi</a> Lakubo.
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Wizard Layout -->
        </div>
    </div>
        @section('script')
            <script src="{{ asset('js/numeric-input.js') }}"></script>
            <script src="{{ asset('js/select2.min.js') }}"></script>
            <script src="{{ asset('js/select2-custom.js') }}"></script>
            <script>
                $(document).ready(function () {
                    // START SECTION FUNC
                    let $sections = $('.form-section');
                    function navigateTo(index) {
                        $sections.removeClass('current').eq(index).addClass('current');
                        $('.form-navigation .previous').toggle(index > 0);
                        var atTheEnd = index >= $sections.length - 1;
                        $('.form-navigation .next').toggle(!atTheEnd);
                        $('.form-navigation [Type=submit]').toggle(atTheEnd);
                    }
                    function curIndex() {
                        return $sections.index($sections.filter('.current'));
                    }
                    $('.form-navigation .previous').click(function () {
                        navigateTo(curIndex() - 1);
                    });
                    $('.form-navigation .next').click(function () {
                        $('#register_form').parsley().whenValidate({
                            group: 'block-' + curIndex()
                        }).done(function () {
                            navigateTo(curIndex() + 1);
                        });
                    });
                    $sections.each(function (index, section) {
                        $(section).find(':input').attr('data-parsley-group', 'block-' + index);
                    });
                    navigateTo(0);
                    // END SECTION FUNC
                });
            </script>
            <script>
                $(document).ready(function () {
                    let select_province = $("#selectProvince");
                    let select_regency = $("#selectRegency");
                    let select_district = $("#selectDistrict");
                    let select_village = $("#selectVillage");
                    // INISIALISASI SELECT2
                    select_province.select2({ placeholder:'Pilih Provinsi', searchInputPlaceholder: 'Cari Provinsi...',});
                    select_regency.select2({ placeholder:'Pilih Kabupaten', searchInputPlaceholder: 'Cari Kabupaten...',});
                    select_district.select2({ placeholder:'Pilih Kecamatan', searchInputPlaceholder: 'Cari Kecamatan...',});
                    select_village.select2({ placeholder:'Pilih Desa', searchInputPlaceholder: 'Cari Desa...',});
                    // END INISIALISASI SELECT2
                    // GET DATA
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    select_province.select2({
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
                    select_province.change(function(){
                        select_regency.html('');
                        select_district.html('');
                        select_village.html('');
                        let id = select_province.val();
                        select_regency.select2({
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
                    select_regency.change(function(){
                        select_district.html('');
                        select_village.html('');
                        let id = select_regency.val();
                        select_district.select2({
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
                    select_district.change(function(){
                        select_village.html('');
                        let id = select_district.val();
                        select_village.select2({
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
