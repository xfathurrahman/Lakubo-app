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
                <div class="my-auto bg-white shadow-lg p-10 sm:px-20 rounded-md shadow-md w-full">
                    <div class="relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20">
                        <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                            <button class="w-10 h-10 rounded-full btn btn-primary step0">1</button>
                            <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">Identitas</div>
                        </div>
                        <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                            <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400 step1">2</button>
                            <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Alamat</div>
                        </div>
                    </div>
                    @if(count($errors) > 0)
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                            <span class="font-medium">Data anda tidak valid ! lengkapi lalu coba lagi.<br></span>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    <h2 class="intro-x pb-5 mt-10 font-bold text-2xl xl:text-3xl text-center xl:text-left">Mendaftar</h2>
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
                                    <input id="phone" type="tel" name="phone" class="form-control" onkeypress="return onlyNumberKey(event)" placeholder="0812********" required data-parsley-minlength="8" data-parsley-maxlength="13">
                                </div>
                                <!-- Password -->
                                <div class="relative intro-y col-span-12 sm:col-span-6">
                                    <div class="absolute mr-1 right-0 flex items-center" style="margin-top: 1.95rem;">
                                        <input class="hidden js-password-toggle" id="toggle" type="checkbox" />
                                        <label class="bg-gray-300 hover:bg-gray-400 rounded px-2 py-1 text-sm text-gray-600 font-mono cursor-pointer js-password-label" for="toggle">
                                            <i data-lucide="eye-off"></i>
                                        </label>
                                    </div>
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <input type="password" name="password" class="form-control js-password" placeholder="Masukan kata sandi" id="password" autocomplete="off" required data-parsley-minlength="8">
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

                        <p style="margin-top: 30px" class="text-gray-500 ml-1">Sudah mendaftar?</p>
                        <a href="http://127.0.0.1:8000/login" class="w-24 text-center float-left btn btn-outline-secondary intro-y col-span-12 flex items-center" style="margin-top: 20px">Masuk</a>

                        <div class="form-navigation intro-y col-span-12 flex items-center justify-end mt-5">
                            <button type="button" class="previous btn btn-secondary w-24">Sebelumnya</button>
                            <button type="button" class="next btn btn-primary w-24 ml-2">Selanjutnya</button>
                            <button type="submit" class="btn btn-primary float-right w-24 ml-2">Mendaftar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Wizard Layout -->
        </div>
    </div>

    @section('script')

        <script>
            // Password Toggler
            const passwordToggle = document.querySelector('.js-password-toggle')

            passwordToggle.addEventListener('change', function() {
                const password = document.querySelector('.js-password'),
                    passwordLabel = document.querySelector('.js-password-label')

                if (password.type === 'password') {
                    password.type = 'text'
                    passwordLabel.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="eye-off" data-lucide="eye-off" class="lucide lucide-eye-off block mx-auto"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>'
                } else {
                    password.type = 'password'
                    passwordLabel.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="eye" data-lucide="eye" class="lucide lucide-eye block mx-auto"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>'
                }

                password.focus()
            })
        </script>

        <script>

            $(document).ready(function (){

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

        <script>

            $(function(){
                var $sections=$('.form-section');
                function navigateTo(index){
                    $sections.removeClass('current').eq(index).addClass('current');
                    $('.form-navigation .previous').toggle(index>0);
                    var atTheEnd = index >= $sections.length - 1;
                    $('.form-navigation .next').toggle(!atTheEnd);
                    $('.form-navigation [Type=submit]').toggle(atTheEnd);

                    const step= document.querySelector('.step'+index);
                    step.style.backgroundColor="#ff5656";
                    step.style.color="white";
                }
                function curIndex(){
                    return $sections.index($sections.filter('.current'));
                }
                $('.form-navigation .previous').click(function(){
                    navigateTo(curIndex() - 1);
                });
                $('.form-navigation .next').click(function(){
                    Parsley.addMessage('en', 'required', 'Kolom ini wajib di isi');
                    Parsley.addMessage('en', 'maxlength', 'Maksimal %s digit');
                    Parsley.addMessage('en', 'minlength', 'Minimal %s digit');
                    $('.seller-form').parsley().whenValidate({
                        group:'block-'+curIndex()
                    }).done(function(){
                        navigateTo(curIndex()+1);
                    });
                });
                $sections.each(function(index,section){
                    $(section).find(':input').attr('data-parsley-group','block-'+index);
                });
                navigateTo(0);
            });

        </script>

    @endsection

</x-guest-layout>
