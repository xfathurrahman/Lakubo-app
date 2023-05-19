<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('roles') }}
    @endsection

    <div class="overflow-x-auto relative sm:rounded-lg mx-auto">
        <div class="flex justify-start py-8">
            <a href="javascript:;"
               data-tw-toggle="modal"
               data-tw-target="#add-role-modal"
               class="btn btn-primary shadow-md mr-2 add_role"
            ><i data-lucide="user-plus" class="w-4 h-4 mr-1"></i>Tambah Peran</a>
            @if(Session::has('error'))
                <div class="mr-0 ml-auto py-0 alert alert-danger alert-dismissible show flex items-center" role="alert">
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
                <div class="mr-0 ml-auto py-0 alert alert-success alert-dismissible show flex items-center" role="alert">
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
        <hr>
        <table class="w-full text-sm text-left text-gray-500 mx-auto box">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="py-3 px-6">
                    ID
                </th>
                <th scope="col" class="py-3 px-6">
                    Nama Peran
                </th>
                <th scope="col" class="py-3 px-6">
                    Hak Akses
                </th>
                <th scope="col" class="py-3 px-6">
                    <div class="flex justify-end mr-16">
                        <div class="flex space-x-2">
                            Aksi
                        </div>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($role_permission as $role)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="p-4 w-4">
                        <div class="flex items-center">
                            #{{$role->id}}
                        </div>
                    </td>
                    <th scope="row" class=" py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                        {{ $role->name }}
                    </th>
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                        @foreach($role->permissions as $permis)
                            <ol class="custom-counter">
                                <li><i class="fa-solid fa-circle-check px-2"></i>{{ $permis->name }}</li>
                            </ol>
                        @endforeach
                    </th>
                    @if($role->name === 'admin')
                        <td>
                            <div class="flex justify-end mr-4">
                                <a href="#"
                                   data-tw-toggle="modal"
                                   data-tw-target="#edit-role-modal-{{$role->id}}"
                                   data-role_id="{{$role->id}}"
                                   class="btn btn-outline-dark shadow-md edit_role" style="width: 10.8rem"
                                ><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Edit</a>
                            </div>
                        </td>
                    @else
                        <td>
                            <div class="flex justify-end mr-4">
                                <div class="flex space-x-2">
                                    <a href="#"
                                       data-tw-toggle="modal"
                                       data-tw-target="#edit-role-modal-{{$role->id}}"
                                       data-role_id="{{$role->id}}"
                                       class="btn btn-outline-dark shadow-md mr-2 edit_role"
                                    ><i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit</a>
                                    <a href="#"
                                       data-tw-toggle="modal"
                                       data-tw-target="#delete-role-modal-{{$role->id}}"
                                       data-role_id="{{$role->id}}"
                                       class="btn btn-primary shadow-md mr-2 delete_role"
                                    ><i data-lucide="trash" class="w-4 h-4 mr-1"></i>Hapus</a>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- BEGIN: Modal Add Role -->
    <div id="add-role-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Tambah Peran</h2>
                </div>
                <form method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="role_name" class="form-label">Nama Peran</label>
                            <input id="role_name" name="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                        <button type="submit" class="btn btn-primary w-20">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal Add Role -->

    <!-- BEGIN: Modal Edit Role -->
    @foreach($role_permission as $role)
    <div id="edit-role-modal-{{$role->id}}" role="dialog" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit Peran "{{ $role->name }}"</h2>
                </div>
                <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="role_name" class="form-label">Nama Peran baru</label>
                            <input id="role_name" value="{{ $role->name }}" name="name" type="text" class="form-control">
                        </div>
                        <div class="col-span-9 sm:col-span-9">
                            <label for="user_permission" class="form-label">Hak akses</label>
                            <select name="permission[]" data-placeholder="Cari hak akses..." id="user_permission" class="tom-select w-full" multiple>
                                @if($role->hasAnyPermission([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]))
                                    @foreach ($role->permissions as $role_permis)
                                        @foreach( $permissions as $permission )
                                            @if($role_permis -> name === $permission->name)
                                                <option selected value="{{ $permission->name }}">{{ $permission->name }}</option>
                                            @else
                                                <option value="{{ $permission->name }}">{{ $permission -> name }}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @else
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-span-3 sm:col-span-3 mt-auto mb-0">
                            <button type="submit" class="btn btn-primary w-full">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- END: Modal Edit Role -->

    @foreach($role_permission as $role)
    <!-- BEGIN: Modal DELETE Role -->
    <div id="delete-role-modal-{{$role->id}}" role="dialog" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Hapus Role</h2>
                </div>
                <form action="{{ route('admin.roles.delete', $role->id) }}" method="post" id="delete_role_form">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <h5>Kamu ingin menghapus Peran <b>{{$role->name}}</b> ?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                        <button type="submit" class="btn btn-primary w-20">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- END: Modal DELETE Role -->

    @section('script')
        <script>
            /*$(document).on('click','.edit_role',function(){
                let id = $(this).data('role_id');
                $('#update_role_form').attr('action', 'roles/' + id, '/update');
            });*/
            /*$(document).on('click','.delete_role',function(){
                let id = $(this).data('role_id');
                $('#delete_role_form').attr('action', 'roles/' + id, '/delete');
            });*/
        </script>
    @endsection

</x-app-layout>

