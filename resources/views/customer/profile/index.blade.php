<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }} {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <h1>Update Profile</h1>

</x-app-layout>
