@php use App\Models\ProductCategory; @endphp
<div class="sm:container xl:px-32 mx-auto">
    <div class="flex justify-between">
        <div class="flex items-center w-full">
            <a href="{{ route('home') }}" class="flex items-center xs:mx-3 w-24 lg:w-28 h-8">
                <img src="{{ asset('assets/images/logo-app.svg') }}">
            </a>
            <button data-search class="p-2 ml-4 sm:hidden focus:outline-none bg-red-300 hover:bg-red-300 rounded-md"
                    type="button">
                <i class="fa-solid fa-magnifying-glass text-lg text-white"></i>
            </button>
            <div data-search-form
                 class="absolute top-full left-0 w-full sm:w-fit sm:top-auto sm:left-auto sm:inline-block sm:relative mr-14 flex-grow">
                <div class="relative">
                    <div class="flex items-center bg-red-400 xs:rounded-md">
                        <div class="text-left dropdown">
                            <button type="button" class="py-2 px-4 rounded inline-flex items-center dropdown-toggle text-white hover:text-red-500">
                                @if($category !== "undefined" && $category)
                                    <span class="dropdown-text w-24 truncate font-semibold text-xs xs:text-sm">{{ $category->name }}</span>
                                @else
                                    <span class="dropdown-text w-24 truncate font-semibold text-xs xs:text-sm">Semua</span>
                                @endif
                                <i class="fa-solid fa-caret-down mt-0.5 text-md"></i>
                            </button>
                            <div class="absolute z-10 mt-0 sm:mt-3 w-full bg-red-400 text-white sm:rounded-md shadow-md shadow-gray-600">
                                <div class="dropdown-menu space-y-2 p-2">
                                    <div class="grid grid-cols-12 gap-2">
                                        <div class="col-span-6 lg:col-span-4 text-left text-sm xl:text-lg lg:font-normal">
                                            <a href="#" class="w-full dropdown-item px-4 hover:text-red-600" data-category="undefined">Semua</a>
                                        </div>
                                        @foreach ($productCategories->chunk(1) as $chunk)
                                            <div class="col-span-6 lg:col-span-4 text-left text-sm xl:text-lg lg:font-normal">
                                                @foreach ($chunk as $category)
                                                    <a href="#" class="w-full dropdown-item px-4 hover:text-red-600" data-category="{{ $category->id }}">{{ $category->name }}</a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" placeholder="Cari..." name="search" id="search" class="h-auto w-full my-1 mr-12 text-sm border-0 rounded-md focus:bg-white focus:ring-0">
                        <button type="button" id="search-btn" class="absolute inset-y-1 right-0 z-10 p-2 bg-white rounded-md hover:bg-gray-200 mr-2">
                            <i class="fa-solid fa-magnifying-glass text-lg text-red-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @auth()
            <div class="flex items-center">
                <a href="{{ route('customer.cart.index') }}" class="relative flex">
                    <button class="p-2 mr-2 focus:outline-none bg-red-400 hover:bg-red-300 rounded-md">
                        <i class="fa-solid fa-cart-shopping text-lg text-white"></i>
                        <span class="absolute right-3 top-0 rounded-full bg-red-600 bg-opacity-50 w-4 h-4 p-0 m-0 text-white font-mono text-sm  leading-tight text-center cart-count">0</span>
                    </button>
                </a>
                <div id="toggle-profile" class="relative md:w-48">
                    <button id="toggle-btn"
                            class="flex items-center focus:outline-none bg-red-400 hover:bg-red-300 rounded-md hover:rounded-md py-1 px-2 w-full"
                            type="button">
                        @auth()
                            @if(isset(auth()->user()->profile_photo_path))
                                <img class="h-8 w-8 rounded-full" alt="Profile-photo-preview"
                                     src="{{ asset('storage/profile-photos/'. auth()->user()->profile_photo_path) }}">
                            @else
                                <img class="h-8 w-8 rounded-full" alt="Profile-photo-preview"
                                     src="https://ui-avatars.com/api/?size=100&name={{ Auth::user()->name }}">
                            @endif
                            <span
                                class="ml-4 text-sm hidden md:inline-block max-w-full w-24 truncate text-white">{{ Auth::user()->name }}</span>
                            <svg class="fill-current w-3 ml-2" viewBox="0 0 407.437 407.437">
                                <path
                                    d="M386.258 91.567l-182.54 181.945L21.179 91.567 0 112.815 203.718 315.87l203.719-203.055z"/>
                            </svg>
                        @endauth
                    </button>
                    <div id="toggle-menu-profile"
                         class="absolute hidden -right-3 xs:right-0 top-full mt-3 w-48 shadow-lg z-10">
                        <ul class="rounded-md dropdown-content bg-red-400 text-white">
                            <li class="px-2 flex items-center">
                                <div class="p-2">
                                    <div class="font-medium">{{ Auth::user()->name }}</div>
                                    <div
                                        class="text-xs text-white text-opacity-70 mt-0.5">{{ Auth::user()->email }}</div>
                                </div>
                            </li>
                            <li>
                                <hr class="border-white opacity-50 mb-2">
                            </li>
                            @if(Auth::user()->stores)
                                <li class="px-2 flex items-center">
                                    <a href="{{ route('seller.dashboard') }}"
                                       class="rounded-md px-2 py-1 w-full hover:bg-white hover:bg-opacity-20">
                                        <i class="fa-solid fa-store mr-2"></i>
                                        Lapak Saya
                                    </a>
                                <li>
                            @else
                                <li class="px-2 flex items-center">
                                    <a href="#" class="rounded-md px-2 py-1 w-full hover:bg-white hover:bg-opacity-20">
                                        <i class="fa-solid fa-store mr-2"></i>
                                        Buka Lapak
                                    </a>
                                <li>
                            @endif
                            <li class="px-2 flex items-center">
                                <a href="{{ route('profile.edit') }}"
                                   class="rounded-md px-2 py-1 w-full hover:bg-white hover:bg-opacity-20">
                                    <i class="fa-solid fa-id-badge mr-3 ml-0.5"></i>
                                    Akun Saya
                                </a>
                            <li>
                                <hr class="border-white opacity-50 my-2">
                            </li>
                            <li class="px-2 text-right pb-2">
                                <form method="POST" action="{{ route('logout') }}"
                                      class="w-full rounded-md px-2 py-1 hover:bg-white hover:bg-opacity-20">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-start">
                                        <i class="fa-solid fa-toggle-off ml-0.5 mr-3"></i>
                                        Keluar
                                    </button>
                                </form>
                            <li>
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center">
                <a href="{{ route('login') }}"
                   class="login-btn text-white bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 md:px-5 py-2.5 text-center md:mr-0">Masuk</a>
                <a href="{{ route('register') }}"
                   class="login-btn ml-2 text-white bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 md:px-5 py-2.5 text-center md:mr-0">Daftar</a>
            </div>
        @endauth
    </div>
</div>

