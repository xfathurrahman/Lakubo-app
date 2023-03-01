<x-guest-layout>
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="http://127.0.0.1:8000/" class="-intro-x flex items-center pt-5">
                    <img alt="Lakubo - Lapak UMKM Boyolali" class="w-6" src="{{ asset('assets/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3">Lakubo</span>
                </a>
                <div class="my-auto">
                    <img alt="Lakubo - Lapak UMKM Boyolali" class="-intro-x w-1/2 -mt-16"
                         src="{{ asset('assets/images/umkm-boy.png') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        Selamat datang di
                        <br>
                        Lapak UMKM Boyolali.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70">
                        Jual beli produk UMKM lebih mudah!
                    </div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white px-5 sm:px-8 py-8 rounded-md shadow-md xl:shadow-none w-full p-10 sm:px-20">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Masuk
                    </h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">
                        Selamat datang di Lapak UMKM Boyolali.
                        Jual beli produk UMKM lebih mudah!
                    </div>
                    @if(Session::has('error'))
                        <div id="alert-border-2" class="flex mt-4 p-4 mb-4 bg-red-100 border-t-4 border-red-500"
                             role="alert">
                            <svg class="flex-shrink-0 w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3 text-sm font-medium text-red-700">
                                {{ session::get('error') }}
                            </div>
                            <button type="button"
                                    class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8"
                                    data-dismiss-target="#alert-border-2" aria-label="Close">
                                <span class="sr-only">Dismiss</span>
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- Email Address -->
                        <div class="intro-y mt-5">
                            <label for="email" class="form-label">Email</label>
                            <input id="email"
                                   name="email"
                                   type="email"
                                   class="intro-x login__input form-control py-3 px-4 block"
                                   placeholder="Lakubo@lakubo.com" required
                                   data-parsley-type-message="Email tidak valid">
                        </div>
                        <!-- Password -->
                        <div class="relative intro-y mt-2">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="relative">
                                <input type="password"
                                       name="password"
                                       class="login__input form-control py-3 px-4 pr-10"
                                       placeholder="Masukan kata sandi" id="password" autocomplete="off" required
                                       data-parsley-minlength="8"
                                >
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-4 mr-2 flex items-center text-slate-400 focus:outline-none">
                                    <i class="fa-regular fa-eye-slash h-6 w-6"></i>
                                </button>
                            </div>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Masuk</button>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Mendaftar</a>
                        </div>
                        <div class="intro-x mt-5 text-slate-600 dark:text-slate-500 text-center xl:text-left">
                            Dengan masuk, anda telah menyetujui
                            <a class="text-primary dark:text-slate-200" href="">Terms and Conditions</a> &
                            <a class="text-primary dark:text-slate-200" href="">Privacy Policy</a> Lakubo.
                        </div>
                    </form>

                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>

    @section('script')

        <script>
            $('.form-navigation .masuk').click(function () {
                Parsley.addMessage('en', 'required', 'Kolom ini wajib di isi');
            });
        </script>

    @endsection

</x-guest-layout>
