<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <h1>Content</h1>

</x-app-layout>
