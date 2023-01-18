<div class="sm:container xl:px-32 flex flex-wrap items-center mx-auto">

    <a href="http://127.0.0.1:8000/" class="flex items-center">
        <img src="{{ asset('assets/images/app/cowlogo.svg') }}" class="ml-3 h-6 sm:h-9" alt="Flowbite Logo">
        <span class="self-center text-xl font-semibold whitespace-nowrap">Lakubo</span>
    </a>
    @guest()
    <form>
        <div class="flex mx-auto">
            <label for="search-dropdown"
                   class="mb-2 text-sm font-medium text-gray-900 sr-only"></label>
            <button id="dropdown-button" data-dropdown-toggle="dropdown"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 ml-1 lg:ml-8 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100"
                    type="button">Semua
                <svg aria-hidden="true" class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd">
                    </path>
                </svg>
            </button>
            <div id="dropdown"
                 class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow"
                 data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom"
                 style="position: absolute; inset: 0 auto auto 0; margin: 0; transform: translate(0px, 710px);">
                <ul class="py-1 text-sm text-gray-700" aria-labelledby="dropdown-button">
                    <li>
                        <button type="button" class="inline-flex py-2 px-4 w-full hover:bg-gray-100">
                            Mockups
                        </button>
                    </li>
                </ul>
            </div>
            <div class="relative mr-2">
                <input type="search" id="search-dropdown"
                       class="search-input flex p-2.5 w-56 z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-red-200 focus:border-red-300 "
                       placeholder="Cari produk UMKM..." required="">
                <button type="submit"
                        class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-red-400 rounded-r-lg border border-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-200">
                    <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>
    <div class="flex md:order-2 mx-auto">
        <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center border-2 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-sticky" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.07692 5.92648C5.07692 4.38908 6.33971 3.14278 7.89744 3.14278H12C12.4248 3.14278 12.7692 3.48268 12.7692 3.90197C12.7692 4.32126 12.4248 4.66116 12 4.66116H7.89744C7.18938 4.66116 6.61539 5.22766 6.61539 5.92648V6.93873C6.61539 7.35802 6.27099 7.69792 5.84615 7.69792C5.42132 7.69792 5.07692 7.35802 5.07692 6.93873V5.92648ZM5.84615 16.3021C6.27099 16.3021 6.61539 16.642 6.61539 17.0613V18.0735C6.61539 18.7723 7.18938 19.3388 7.89744 19.3388H12C12.4248 19.3388 12.7692 19.6788 12.7692 20.098C12.7692 20.5173 12.4248 20.8572 12 20.8572H7.89744C6.33971 20.8572 5.07692 19.6109 5.07692 18.0735V17.0613C5.07692 16.642 5.42132 16.3021 5.84615 16.3021Z" fill="#ff5656"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7692 4.78618C12.7692 3.90491 13.6592 3.29355 14.4966 3.59962L19.6248 5.47416C20.1277 5.658 20.4615 6.13139 20.4615 6.66071V17.3393C20.4615 17.8686 20.1277 18.342 19.6248 18.5258L14.4966 20.4004C13.6592 20.7065 12.7692 20.0951 12.7692 19.2138V4.78618ZM15.0309 2.17576C13.1887 1.5024 11.2308 2.84738 11.2308 4.78618V19.2138C11.2308 21.1526 13.1887 22.4976 15.0309 21.8242L20.1591 19.9497C21.2656 19.5452 22 18.5038 22 17.3393V6.66071C22 5.4962 21.2656 4.45475 20.1591 4.0503L15.0309 2.17576Z" fill="#ff5656"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.32787 9.43867C6.62827 9.14218 7.11532 9.14218 7.41572 9.43867L9.46701 11.4632C9.76741 11.7597 9.76741 12.2403 9.46701 12.5368L7.41572 14.5613C7.11532 14.8578 6.62827 14.8578 6.32787 14.5613C6.02746 14.2649 6.02746 13.7842 6.32787 13.4877L7.06599 12.7592H2.76923C2.3444 12.7592 2 12.4193 2 12C2 11.5807 2.3444 11.2408 2.76923 11.2408H7.06599L6.32787 10.5123C6.02746 10.2158 6.02746 9.73515 6.32787 9.43867Z" fill="#ff5656"/>
            </svg>
        </button>
        <div class="flex">
            <a href="{{ route('login') }}">
                <button type="button"
                        class="login-btn ml-2 hidden text-white bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">
                    Masuk
                </button>
            </a>
            <a href="{{ route('register') }}">
                <button type="button"
                        class="login-btn ml-2 hidden text-white bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">
                    Daftar
                </button>
            </a>
        </div>
    </div>
    <div class="hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col mt-4 bg-gray-50 rounded-lg border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white md:dark:bg-gray-900">
            <li class="block">
                <hr>
                <a href="{{ route('login') }}">
                    <div class="md:hidden text-black font-medium text-sm px-5 py-2.5 text-left mr-3 md:mr-0">Masuk</div>
                </a>
                <hr>
                <a href="{{ route('register') }}">
                    <div class="md:hidden text-black font-medium text-sm px-5 py-2.5 text-left mr-3 md:mr-0">Daftar</div>
                </a>
            </li>
        </ul>
    </div>
    @endguest

    @auth()
        <form>
            <div class="flex mx-auto ml-1">
                <label for="search-dropdown"
                       class="mb-2 text-sm font-medium text-gray-900 sr-only"></label>
                <button id="dropdown-button" data-dropdown-toggle="dropdown"
                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 ml-1 lg:ml-8 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100"
                        type="button">Semua
                    <svg aria-hidden="true" class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd">
                        </path>
                    </svg>
                </button>
                <div id="dropdown"
                     class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow"
                     data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom"
                     style="position: absolute; inset: 0 auto auto 0; margin: 0; transform: translate(0px, 710px);">
                    <ul class="py-1 text-sm text-gray-700" aria-labelledby="dropdown-button">
                        <li>
                            <button type="button"
                                    class="inline-flex py-2 px-4 w-full hover:bg-gray-100">
                                Mockups
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <input type="search" id="search-dropdown"
                           class="search-input-auth flex p-2.5 w-56 z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-red-200 focus:border-red-300 "
                           placeholder="Cari produk UMKM..." required="">
                    <button type="submit"
                            class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-red-400 rounded-r-lg border border-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-200">
                        <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
        </form>
        <div class="flex md:order-2 ml-1 xs:ml-auto xs:mr-0">
            <li class="font-sans block inline-block mt-0 lg:ml-6 align-middle text-black hover:text-gray-700">
                <a href="{{ route('customer.cart.index') }}" class="relative flex">
                    <button type="button" class="cart-btn text-white bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 mr-0 lg:px-5 py-2.5 text-center lg:mr-3 md:mr-0">
                        <svg class="flex-1 w-5 h-5 fill-current" viewbox="0 0 24 24">
                            <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
                        </svg>
                        <span class="absolute left-8 top-1 rounded-full bg-red-600 w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center cart-count">0</span>
                    </button>
                </a>
            </li>
            <!-- BEGIN: Account Menu -->
            <div x-data="{ open: false }" class="w-12 px-4 lg:ml-2 ml-0 flex justify-center items-center">
                <div @click="open = !open"
                     class="relative"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100">
                    <div class="flex justify-center items-center cursor-pointer">
                        <button class="w-10 h-10 flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                            <img class="mr-1.5 rounded-full" src="{{ asset("storage/product-category/gambar-1.jpg") }}" alt="{{ Auth::user()->name }}" />
                            <div class="mr-1 my-auto"><i class="fas fa-caret-down"></i></div>
                        </button>
                    </div>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute -right-1 w-56 py-2 bg-white rounded-lg mt-5" style="background-color: #ff5656">
                        <ul class="space-y-2">
                            <li class="text-white px-3">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <div class="text-xs mt-0.5">{{ Auth::user()->email }}</div>
                            </li>
                            <hr class="m-0 p-0 opacity-50">
                            <li class="text-white px-3">
                                <a href="{{ url('profile') }}" class="flex text-sm items-center transform transition-colors duration-200 border-r-4 border-transparent hover:border-indigo-700">
                                    <div class="mr-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    Akun Saya
                                </a>
                            </li>
                            <hr class="m-0 p-0 opacity-50">
                            <li class="text-white px-3">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex text-sm items-center transform transition-colors duration-200 border-r-4 border-transparent hover:border-red-600">
                                        <div class="mr-3 text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        </div>
                                        Keluar
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    @endauth

</div>

