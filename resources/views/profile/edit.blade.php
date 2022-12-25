<x-app-layout>
    <div class="py-2">
        @include('profile.partials.update-profile-information-form')
        <div class="w-full flex justify-end mt-3 sm:px-3 lg:px-5">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
