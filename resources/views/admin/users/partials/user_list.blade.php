<div class="grid grid-cols-12 gap-x-6">
@foreach ($users as $user)
    <div class="intro-y col-span-12 md:col-span-6 mb-5">
        <div class="box">
            <div class="flex flex-col lg:flex-row items-center p-5">
                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="http://rubick.left4code.com/dist/images/profile-8.jpg">
                </div>
                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                    <a href="" class="font-medium">{{ $user->name }}</a>
                    <div class="text-slate-500 text-xs mt-0.5">{{ $user->email }}</div>
                    @foreach ($user->roles as $user_role)
                        <span class="bg-green-400 text-xs px-1 rounded text-gray-50">{{$user_role->name}}</span>
                    @endforeach
                </div>
                @if(!$user->hasRole('admin'))
                    <div class="flex mt-4 lg:mt-0">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                        class="btn btn-outline-secondary mr-2">Edit</a>
                        <div class="text-center">
                            <a href="#"
                            data-tw-toggle="modal"
                            data-tw-target="#deleteUserModal-{{ $user->id }}"
                            class="btn btn-primary delete"
                            data-user_id="{{ $user->id }}"
                            >Hapus</a>
                        </div>
                    </div>
                @else
                    <div class="flex mt-4 lg:mt-0 sm:mr-2">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                        class="btn btn-outline-secondary w-28">Edit</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
</div>
