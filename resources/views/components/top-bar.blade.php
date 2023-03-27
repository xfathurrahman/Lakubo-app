<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    @yield('breadcrumbs')
    <!-- END: Breadcrumb -->

    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown md:w-8 h-8 ml-auto">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-auto" role="button"
             aria-expanded="false" data-tw-toggle="dropdown">
            @if(auth()->user()->profile_photo_path)
                <img id="preview-photo-top-bar" alt="Profile-photo-preview" src="{{ asset('storage/profile-photos/'. auth()->user()->profile_photo_path) }}">
            @else
                <img id="preview-photo-top-bar" alt="Profile-photo-preview" src="https://ui-avatars.com/api/?size=100&name={{ Auth::user()->name }}">
            @endif
        </div>
        <div class="dropdown-menu dropdown-menu-main-top w-56" style="z-index: 999!important;">
            <ul class="dropdown-content bg-primary text-white">
                <li class="p-2">
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-white/70 mt-0.5">{{ Auth::user()->email }}</div>
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item hover:bg-white/5">
                            <i class="fa-solid fa-key mr-2"></i>
                            Admin Dashboard </a>
                    </li>
                @endif
                <li>
                    @if(auth()->user()->hasRole('seller'))
                        {{--jika seller punya Lapak--}}
                        @if(auth()->user()->stores)
                            <a href="{{ route('seller.dashboard') }}" class="dropdown-item hover:bg-white/5">
                                <i class="fa-solid fa-store mr-2"></i>
                                Lapak Saya </a>
                        @else
                            <a  data-tw-toggle="modal" data-tw-target="#create-store-form"
                                href="#" class="dropdown-item hover:bg-white/5">
                                <i class="fa-solid fa-store mr-2"></i>
                                Lapak Saya </a>
                        @endif
                    @elseif(auth()->user()->hasRole('customer'))
                        {{--jika customer punya Lapak--}}
                        @if(auth()->user()->stores)
                            <a href="{{ route('seller.dashboard') }}" class="dropdown-item hover:bg-white/5">
                                <i class="fa-solid fa-store mr-2"></i>
                                Lapak Saya </a>
                        @else
                            <a  data-tw-toggle="modal" data-tw-target="#create-store-form"
                                href="#" class="dropdown-item hover:bg-white/5">
                                <i class="fa-solid fa-store mr-2"></i>
                                Lapak Saya </a>
                        @endif
                    @endif
                </li>
                <li>
                    <a href="{{ url('profile') }}" class="dropdown-item hover:bg-white/5">
                        <i class="fa-solid fa-id-badge mr-3"></i>
                        Akun Saya </a>
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item hover:bg-white/5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 icon-name="toggle-right" data-lucide="toggle-right"
                                 class="lucide lucide-toggle-right w-4 h-4 mr-2">
                                <rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect>
                                <circle cx="16" cy="12" r="3"></circle>
                            </svg>
                            Logout </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->
    @include('.layouts.partials.create-store-form-modal')
</div>
