<section>
    <!-- BEGIN: Modal -->
    <div id="create-store-form" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header pt-0 bg-primary">
                    <h2 class="font-medium font-medium text-base text-white sm:text-sm text-center mx-auto">
                        <span class="intro-y">
                            <img class="mx-auto lg:w-36" width="100px" src="{{ asset('assets/images/app/not-found-store.png') }}" alt="">
                        </span>
                        <p>Anda belum mempunyai Lapak UMKM,<br>Lengkapi data dibawah untuk mendaftar.</p>
                    </h2>
                </div>
                <div class="mt-3 relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20">
                    <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                        <button class="w-10 h-10 rounded-full btn btn-primary step0">1</button>
                        <div class="lg:w-32 font-medium lg:mt-3 ml-3 lg:mx-auto">Data Usaha</div>
                    </div>
                    <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                        <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400 step1">2</button>
                        <div class="lg:w-32 font-medium lg:mt-3 ml-3 lg:mx-auto">Alamat Usaha</div>
                    </div>
                </div>
                <form action="{{ route('customer.store.new') }}" method="POST" class="store-form">
                    @csrf
                    <div class="px-2 border-t border-slate-200/60 dark:border-darkmode-400">
                        @if(count($errors) > 0)
                            <div class="flex p-2 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Danger</span>
                                <div>
                                    <span class="font-medium">Data anda tidak valid :</span>
                                    <ul class="mt-1.5 ml-4 text-red-700 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <div class="form-section">
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="intro-y col-span-12">
                                    <label for="name" class="form-label">Nama Usaha</label>
                                    <input name="nama" id="name" type="text" class="form-control" placeholder="Lakubo Shop" required>
                                </div>
                                <div class="intro-y col-span-12">
                                    <label for="selectCateStore" class="form-label">Kategori</label>
                                    <select name="kategori" id="selectCateStore" class="w-full form-control" required></select>
                                </div>
                                <div class="intro-y col-span-12">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="description" class="form-control" placeholder="Deskripsikan usahamu secara singkat" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="intro-y col-span-12">
                                    <label for="selectDistrictStore" class="form-label">Kecamatan</label>
                                    <select name="kecamatan" id="selectDistrictStore" class="w-full form-control" required></select>
                                </div>
                                <div class="intro-y col-span-12">
                                    <label for="selectVillageStore" class="form-label">Desa</label>
                                    <select name="desa" id="selectVillageStore" class="w-full form-control" required></select>
                                </div>
                                <div class="intro-y col-span-12">
                                    <label for="detail_alamat" class="form-label">Detail Alamat</label>
                                    <textarea id="detail_alamat" name="detail_alamat" class="form-control" placeholder="Masukan detail lokasi usahamu" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer store-form-navigation">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                        <button type="button" class="previous btn btn-secondary w-24">Sebelumnya</button>
                        <button type="button" class="next btn btn-primary w-24 ml-2 hidden">Lanjut</button>
                        <button type="submit" class="btn btn-primary float-right w-24 ml-2">Mendaftar</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal -->
</section>
