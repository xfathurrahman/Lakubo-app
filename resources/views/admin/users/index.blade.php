<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection

    <div class="py-12 w-full">
        <div class="mx-auto sm:px-3 lg:px-5">
            <div class="grid grid-cols-12 gap-6 mt-10">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <div class="w-full sm:w-auto mt-3 sm:mt-0 mx-auto">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="table-search-users" class="block p-2 pl-10 w-50 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari pengguna...">
                        </div>
                    </div>
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
                                           data-tw-target="#deleteUserModal"
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
                <!-- END: Pagination -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                    <nav class="w-full sm:w-auto sm:mr-auto">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-left" class="lucide lucide-chevrons-left w-4 h-4" data-lucide="chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-left" class="lucide lucide-chevron-left w-4 h-4" data-lucide="chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">...</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">...</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right" class="lucide lucide-chevron-right w-4 h-4" data-lucide="chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-right" class="lucide lucide-chevrons-right w-4 h-4" data-lucide="chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <select class="w-20 form-select box mt-3 sm:mt-0">
                        <option>10</option>
                        <option>25</option>
                        <option>35</option>
                        <option>50</option>
                    </select>
                </div>
                <!-- END: Pagination -->
            </div>

            <div id="deleteUserModal" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Hapus pengguna</h2>
                        </div>
                        <form action="#" method="post" id="delete_user">
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
        </div>
    </div>
@section('script')
        <script>
            $(document).on('click','.delete',function(){
                let id = $(this).data('user_id');
                $('#delete_user').attr('action', 'users/' + id);
            });
        </script>
    @endsection

</x-app-layout>
