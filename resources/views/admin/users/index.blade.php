<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection

    <h2 class="intro-y text-lg font-medium mt-5">
        Daftar Pengguna
    </h2>

    <div class="pb-10 w-full">
        <div class="mx-auto">
            <div class="my-5">
                <div class="intro-y flex flex-wrap sm:flex-nowrap items-center mt-2">

                    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="w-full relative text-slate-500 border-2 rounded-lg">
                            <input type="text" id="searchInput" class="form-control w-56 box pr-10" placeholder="Cari pengguna...">
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

                <div id="userList" class="mt-5">
                    @include('admin.users.partials.user_list')
                </div>

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
    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                var searchQuery = $(this).val();

                $.ajax({
                    url: '{{ route('admin.users.search') }}',
                    method: 'GET',
                    data: { search: searchQuery },
                    beforeSend: function() {
                        // Tambahkan tindakan sebelum permintaan dikirim, seperti menampilkan ikon loading.
                    },
                    success: function(response) {
                        // Tangani respons yang diterima dari server.
                        $('#userList').html(response);
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika permintaan gagal.
                    }
                });
            });
        });
    </script>

    @endsection



</x-app-layout>
