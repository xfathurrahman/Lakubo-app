<div class="container xl:px-32 flex flex-wrap items-center mx-auto">
    <a href="http://127.0.0.1:8000/" class="flex items-center">
        <img src="{{ asset('assets/images/app/cowlogo.svg') }}" class="mx-3 h-6 sm:h-9" alt="Flowbite Logo">
        <span class="self-center text-xl font-semibold whitespace-nowrap">Lakubo</span>
    </a>

    <form>
        <div class="flex mx-auto">
            <label for="search-dropdown"
                   class="mb-2 text-sm font-medium text-gray-900 sr-only"></label>
            <button id="dropdown-button" data-dropdown-toggle="dropdown"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 ml-8 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100"
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
            <div class="relative mr-2">
                <input type="search" id="search-dropdown"
                       class="search-input flex p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-red-200 focus:border-red-300 "
                       placeholder="Cari..." required="">
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

    <div class="flex md:order-2 mr-0 ml-auto">
        <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-sticky" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                      clip-rule="evenodd"></path>
            </svg>
        </button>

        <div class="flex">
            <button type="button"
                    class="login-btn hidden text-white bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">
                <i class="fa-solid fa-cart-shopping"></i></button>
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
                <div class="md:hidden text-black font-medium text-sm px-5 py-2.5 text-left mr-3 md:mr-0">
                    <button type="button">Keranjang</button>
                </div>
                <hr>
                <div class="md:hidden text-black font-medium text-sm px-5 py-2.5 text-left mr-3 md:mr-0">Masuk</div>
                <hr>
                <div class="md:hidden text-black font-medium text-sm px-5 py-2.5 text-left mr-3 md:mr-0">Daftar
                </div>
            </li>
        </ul>
    </div>
</div>

