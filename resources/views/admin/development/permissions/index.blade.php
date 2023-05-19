<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('permissions') }}
    @endsection

    <div class="overflow-x-auto relative sm:rounded-lg mx-auto">
        <div class="flex justify-start py-8">
            <a href="#"
               data-tw-toggle="modal"
               data-tw-target="#add-permission-modal"
               class="btn btn-primary shadow-md mr-2 add_role"
            ><i data-lucide="user-plus" class="w-4 h-4 mr-1"></i>Tambah Hak Akses</a>

{{--            @error('name')
            <div class="mr-0 ml-auto py-0 alert alert-danger alert-dismissible show flex items-center" role="alert">
                <i data-lucide="alert-octagon" class="w-4 h-4 mr-2"></i> Hak akses tersebut sudah ada.
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            @enderror--}}

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
        <table class="w-full text-sm text-left text-gray-50 mx-auto box">
            <thead class="text-xs text-gray-700 uppercase bg-gray-5">
            <tr>
                <th scope="col" class="py-3 px-6">
                    ID
                </th>
                <th scope="col" class="py-3 px-6">
                    Nama Hak Akses
                </th>
                <th scope="col" class="py-3 px-6">
                    Nama Peran
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
            @foreach($role_permission as $permission)
                <tr class="border-b">
                    <td class="p-4 w-4">
                        <div class="flex items-center text-red-600">
                            #{{$permission->id}}
                        </div>
                    </td>
                    <th scope="row" class=" py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                        {{ $permission->name }}
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                        @foreach($permission->roles as $role)
                            <ol class="custom-counter">
                                <li><i class="fa-solid fa-circle-check px-2"></i>{{ $role->name }}</li>
                            </ol>
                        @endforeach
                    </th>
                    <td>
                        <div class="flex justify-end mr-4">
                            <div class="flex space-x-2">
                                <a href="#"
                                   data-tw-toggle="modal"
                                   data-tw-target="#edit-permission-modal-{{$permission->id}}"
                                   data-role_id="{{$permission->id}}"
                                   class="btn btn-outline-dark shadow-md mr-2 edit_role"
                                ><i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit</a>
                                <a href="#"
                                   data-tw-toggle="modal"
                                   data-tw-target="#delete-permission-modal-{{$permission->id}}"
                                   data-role_id="{{$permission->id}}"
                                   class="btn btn-primary shadow-md mr-2 delete_role"
                                ><i data-lucide="trash" class="w-4 h-4 mr-1"></i>Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- BEGIN: Modal Add Permission -->
    <div id="add-permission-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Tambah Hak Akses</h2>
                </div>
                <form method="POST" action="{{ route('admin.permissions.store') }}">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="role_name" class="form-label">Nama Hak Akses</label>
                            <input id="role_name" name="name" type="text" class="form-control" required>
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
    <!-- END: Modal Add Permission -->

    <!-- BEGIN: Modal Edit Role -->
    @foreach($role_permission as $permission)
        <div id="edit-permission-modal-{{$permission->id}}" role="dialog" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content"><a data-tw-dismiss="modal" href="#"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Edit Hak akses "{{ $permission->name }}"</h2>
                    </div>
                    <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12">
                                <label for="permission_name" class="form-label">Nama Hak akses baru</label>
                                <input id="permission_name" placeholder="Masukan nama hak akses baru" name="name" type="text" class="form-control">
                            </div>
                            <div class="col-span-9 sm:col-span-9">
                                <label for="user_role" class="form-label">Peran</label>
                                <select name="role[]" data-placeholder="Cari peran..." id="user_role" class="tom-select w-full" multiple>
                                    @if($permission->hasAnyRole(\Spatie\Permission\Models\Role::all()))
                                        @foreach ($permission->roles as $role_permis)
                                            @foreach( $roles as $role )
                                                @if($role_permis -> name === $role->name)
                                                    <option selected value="{{ $role->name }}">{{ $role->name }}</option>
                                                @else
                                                    <option value="{{ $role->name }}">{{ $role -> name }}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
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

    <!-- BEGIN: Modal DELETE Role -->
    @foreach($role_permission as $permission)
        <div id="delete-permission-modal-{{$permission->id}}" role="dialog" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Hapus Hak Akses</h2>
                    </div>
                    <form action="{{ route('admin.permissions.delete', $permission->id) }}" method="post" id="delete_permission_form">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <h5>Kamu ingin menghapus Hak Akses <b>{{$permission->name}}</b> ?</h5>
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

</x-app-layout>
