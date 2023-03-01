<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection

    <div class="py-12 w-full">
        <div class="mx-auto sm:px-3 lg:px-5">
            <div class="grid grid-cols-12 gap-6 mt-10">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="w-full relative text-slate-500 border-2 rounded-lg">
                            <input type="text" class="form-control w-56 box pr-10" placeholder="Cari pengguna...">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="search" class="lucide lucide-search w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                    </div>

                    @if(Session::has('error'))
                        <div class="mr-0 ml-auto py-2 alert alert-danger alert-dismissible show flex items-center" role="alert">
                            <i data-lucide="thumbs-down" class="w-4 h-4 mr-2"></i>
                            {{ Session::get('error') }}
                            @php
                                Session::forget('error');
                            @endphp
                            <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="mr-0 ml-auto py-2 alert alert-success alert-dismissible show flex items-center" role="alert">
                            <i data-lucide="thumbs-up" class="w-4 h-4 mr-2"></i>
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                            <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                    @endif

                </div>

                <!-- BEGIN: Users Layout -->
                @foreach ($users as $user)
                    <div class="intro-y col-span-12 md:col-span-6">
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
                                    <!-- END: Modal Toggle -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- BEGIN: Users Layout -->
            </div>

            @foreach($users as $user)
            <div id="deleteUserModal-{{ $user->id }}" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Hapus pengguna</h2>
                        </div>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="delete_user">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <h5>Yakin, Kamu ingin menghapus <b>{{ $user->name }}</b> ?</h5>
                            </div>
                            <div class="modal-footer bg-whitesmoke">
                                <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal"> Batal</button>
                                <button type="submit" class="btn btn-primary"> Ya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

        @section('script')
            {{--<script>
                $(document).on('click','.delete',function(){
                    let id = $(this).data('user_id');
                    $('#delete_user').attr('action', 'users/' + id);
                });
            </script>--}}
        @endsection

</x-app-layout>
