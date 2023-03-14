<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('store') }}
    @endsection

    @if(auth()->user()->stores)
            <!-- BEGIN: Profile Info -->
            <div class="intro-y box px-5 pt-5 mt-5">
                <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                    <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                            @if(auth()->user()->profile_photo_path)
                                <img class="rounded-full" alt="Profile-photo-preview" src="{{ asset('storage/profile-photos/'. auth()->user()->profile_photo_path) }}">
                            @else
                                <img class="rounded-full" alt="Profile-photo-preview" src="https://ui-avatars.com/api/?size=100&name={{ Auth::user()->name }}">
                            @endif
                        </div>
                        <div class="ml-5">
                            <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ auth()->user()->stores->name }}</div>
                            <div class="text-slate-500">{{ auth()->user()->stores->storeCategories->name }}</div>
                        </div>
                    </div>
                    <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="font-medium lg:mt-3">Kontak Lapak
                            <span class="inline-flex float-right">
                                <a href="{{ route('profile.edit') }}" class="inline-flex text-primary"><i data-lucide="edit-2" class="w-4 h-4 mr-1"></i>Edit</a>
                            </span>
                        </div>
                        <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                            <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ auth()->user()->email }} </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="instagram" class="w-4 h-4 mr-2"></i> {{ auth()->user()->phone }} </div>
                        </div>
                    </div>
                    <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-medium text-primary text-xl">{{ count(auth()->user()->stores->products) }}</div>
                            <div class="text-slate-500">Produk</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-medium text-primary text-xl">{{ count(auth()->user()->stores->orders) }}</div>
                            <div class="text-slate-500">Pesanan</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-medium text-primary text-xl">
                                {{ $countSuccessOrders }}
                            </div>
                            <div class="text-slate-500">Penjualan</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Profile Info -->

            <!-- BEGIN: Display Information -->
            <div class="intro-y mt-0 box">
                <form method="post" action="{{ route('seller.store.update', auth()->user()->stores->id) }}" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base ml-3 mr-auto">Informasi Lapak UMKM</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div>
                                            <label for="name" class="flex justify-between form-label">Nama Lapak
                                                <span class="text-slate-500">
                                                    <x-input-error :messages="$errors->get('nama_lapak')"/></span>
                                            </label>
                                            <input id="name" name="nama_lapak" type="text" class="form-control" placeholder="Masukan Nama Pengguna" value="{{ auth()->user()->stores->name }}" required="" data-parsley-error-message="Nama pengguna wajib di isi.">
                                        </div>
                                        <div class="mt-3">
                                            <div class="intro-y col-span-12">
                                                <label for="editSelectCateStore" class="form-label">Kategori</label>
                                                <select name="kategori_lapak" id="editSelectCateStore" class="w-full form-control" required>
                                                    @foreach( $storeCategories as $store_cate )
                                                        @if($store_cate -> id == auth()->user()->stores->category_id)
                                                            <option selected value="{{ $store_cate-> id }}">{{ $store_cate->name }}</option>
                                                        @else
                                                            <option value="{{ $store_cate -> id }}">{{ $store_cate -> name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label for="store_desc" class="flex justify-between form-label">Deskripsi
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('deskripsi_lapak')"/></span>
                                            </label>
                                            <textarea id="store_desc" name="deskripsi_lapak" class="form-control" placeholder="Deskripsikan lapakmu secara singkat">{{ auth()->user()->stores->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="mt-3 lg:mt-0">
                                            <label for="editSelectDistrictStore" class="flex justify-between form-label">Kecamatan
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('kecamatan')"/></span>
                                            </label>
                                            <select name="kecamatan" id="editSelectDistrictStore" class="w-full form-control" required>
                                                @foreach( $districts as $district )
                                                    @if($district -> id == $storeAddresses->district_id)
                                                        <option selected value="{{ $district-> id }}">{{ $district->name }}</option>
                                                    @else
                                                        <option value="{{ $district -> id }}">{{ $district -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="editSelectVillageStore" class="flex justify-between form-label">Desa
                                                <span class="text-slate-500"><x-input-error :messages="$errors->get('desa')"/></span>
                                            </label>
                                            <select name="desa" id="editSelectVillageStore" class="w-full form-control">
                                                @foreach( $villages as $village )
                                                    @if($village -> id == $storeAddresses->village_id)
                                                        <option selected value="{{ $village-> id }}">{{ $village->name }}</option>
                                                    @else
                                                        <option value="{{ $village -> id }}">{{ $village -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="col-span-12">
                                                <div class="mt-3">
                                                    <label for="detail-address" class="flex justify-between form-label">Detail alamat
                                                        <span class="text-slate-500"><x-input-error :messages="$errors->get('detail_alamat')"/></span>
                                                    </label>
                                                    <textarea id="detail-address" name="detail_alamat" class="form-control" placeholder="Masukan detail alamat lapak">{{ $storeAddresses->detail_address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 2xl:col-span-12">
                                        <div class="mt-3">
                                            <label for="detail-address" class="flex justify-between form-label">Lokasi di google maps</label>
                                            <textarea id="lokasi_di_map" name="lokasi_di_map" class="form-control h-72 md:h-20" placeholder="<iframe src=https://www.google.com/maps/embed></iframe>">{{ $storeAddresses->embedded_map }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-navigation flex items-center justify-start mt-3">
                                    <button type="submit" class="simpan btn btn-primary w-20">Simpan</button>
                                    @if (session('status') === 'store-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600 ml-3"
                                        >{{ __('Tersimpan.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END: Display Information -->
        @include('.seller.store.partials.delete-store-modal')
    @else
        <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       icon-name="info" data-lucide="info" class="lucide lucide-info w-4 h-4 mr-2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </span>
            <span> Anda belum membuka lapak UMKM,
                    <a data-tw-toggle="modal"
                       data-tw-target="#create-store-form"
                       href="#"
                       class="dropdown-item hover:bg-white/5 underline">klik disini
                    </a>
                </span>&nbsp;untuk mendaftar.
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x"
                     data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    @endif

        @section('script')
            <script>

                $("#editSelectCateStore").select2({
                    placeholder:'Pilih Kategori Lapak',
                    searchInputPlaceholder: 'Cari kategori...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    }
                });


                $(document).ready(function () {
                    $("#editSelectDistrictStore").select2({
                        placeholder:'Pilih Kecamatan',
                        searchInputPlaceholder: 'Cari Kecamatan...',
                        language: {
                            noResults: function () {
                                return "Tidak ditemukan.";
                            }
                        }
                    });
                    $("#editSelectVillageStore").select2({
                        placeholder:'Pilih Desa',
                        searchInputPlaceholder: 'Cari Desa...',
                        language: {
                            noResults: function () {
                                return "Tidak ditemukan.";
                            }
                        }
                    });

                    $("#editSelectDistrictStore").change(function(){
                        $('#editSelectVillageStore').html('');
                        let id = $('#editSelectDistrictStore').val();
                        $("#editSelectVillageStore").select2({
                            placeholder:'Pilih Desa',
                            searchInputPlaceholder: 'Cari Desa...',
                            language: {
                                noResults: function () {
                                    return "Tidak ditemukan.";
                                }
                            },
                            ajax: {
                                url: "{{ url('indoregion/village')}}/"+ id,
                                processResults: function({data}){
                                    return {
                                        results: $.map(data, function(item){
                                            return {
                                                id: item.id,
                                                text: item.name
                                            }
                                        })
                                    }
                                }
                            }
                        });
                    });
                });

            </script>
        @endsection

</x-app-layout>
