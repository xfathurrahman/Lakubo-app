<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin_stores') }}
    @endsection

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                {{-- <div class="dropdown" data-tw-placement="bottom-start">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">Aksi &emsp;
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i></span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
                                    Print </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    Export ke Excel </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    Export ke PDF </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <div class="hidden md:block mr-auto text-slate-500">
                    <div class="float-left" style="vertical-align: center;">
                        Menampilkan
                        {{ $stores->firstItem() }}
                        {{---
                        {{ $stores->lastItem() }}--}}
                        dari
                        {{ $stores->total() }}
                        total produk.
                    </div>
                </div>
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <input type="text" class="form-control w-56 box pr-10" placeholder="Carti lapak...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">
                            #ID
                        </th>
                        <th class="whitespace-nowrap">PELAPAK</th>
                        <th class="text-center whitespace-nowrap">NAMA LAPAK</th>
                        <th class="text-center whitespace-nowrap">KATEGORI LAPAK</th>
                        <th class="text-center whitespace-nowrap">TOTAL PRODUK</th>
                        <th class="text-center whitespace-nowrap">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stores as $store)
                    <tr class="intro-x">
                        <td class="w-10">
                            {{ $store -> id }}
                        </td>
                        <td class="!py-3.5">
                            <div class="flex items-center">
                                <div class="w-9 h-9 image-fit zoom-in">
                                    <img alt="Midone - HTML Admin Template" class="rounded-lg border-white shadow-md tooltip" src="{{ asset('storage/profile-photos/'. $store->users->profile_photo_path) }}" title="Uploaded at 29 May 2022">
                                </div>
                                <div class="ml-4">
                                    <a href="" class="font-medium whitespace-nowrap">{{ $store -> users -> name }}</a>
                                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $store -> users -> email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center"> <a class="flex items-center justify-center underline decoration-dotted" href="#">{{ $store -> name }}</a> </td>
                        <td class="text-center capitalize">{{ $store->storeCategories->name }}</td>
                        <td class="text-center">{{ count($store->products) }} item</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Hapus </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>

        <!-- BEGIN: Delete Confirmation Modal -->
        <div id="delete-seller-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Are you sure?</div>
                            <div class="text-slate-500 mt-2">
                                Do you really want to delete these records?
                                <br>
                                This process cannot be undone.
                            </div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-danger w-24">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->

</x-app-layout>
