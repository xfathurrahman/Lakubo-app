<nav class="fixed z-[99] bottom-0 left-0 w-full bg-gradient-to-b from-red-600 to-red-400 p-4 text-white text-center sm:hidden flex justify-between items-center">
    @if (Request::is('seller/*'))
        @include('components.bottom-nav-seller')
    @elseif (Request::is('admin/*') || Auth::check() && auth()->user()->hasRole('admin'))
        @include('components.bottom-nav-admin')
    @else
        @include('components.bottom-nav-customer')
    @endif
</nav>

<script>
    function toggleDropdown() {
        var dropdown = document.getElementById('dropdown');
        dropdown.classList.toggle('hidden');
    }
</script>
