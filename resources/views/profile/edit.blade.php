<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('profile') }}
    @endsection

    <div class="py-2">
        @include('profile.partials.update-profile-information-form')
        <div class="w-full pt-4 sm:rounded-lg sm:px-3 lg:px-5">
            @include('profile.partials.update-bank-information-form')
        </div>
        <div class="w-full pt-4 sm:rounded-lg sm:px-3 lg:px-5">
            @include('profile.partials.update-password-form')
        </div>
        <div class="w-full flex justify-end mt-3 sm:px-3 lg:px-5">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

        @section('script')

            <script>
                $('.form-navigation .simpan').click(function() {
                    Parsley.addMessage('en', 'required', 'Kolom ini wajib di isi');
                });
            </script>

            <script>

                $(document).ready(function (){
                    $("#selectProvince").select2({
                        placeholder:'Pilih Provinsi',
                        searchInputPlaceholder: 'Cari Provinsi...',
                    });
                    $("#selectRegency").select2({
                        placeholder:'Pilih Kabupaten',
                        searchInputPlaceholder: 'Cari Kabupaten...',
                    });
                    $("#selectDistrict").select2({
                        placeholder:'Pilih Kecamatan',
                        searchInputPlaceholder: 'Cari Kecamatan...',
                    });
                    $("#selectVillage").select2({
                        placeholder:'Pilih Desa',
                        searchInputPlaceholder: 'Cari Desa...',
                    });

                    $("#selectBankWd").select2({
                        placeholder:'Pilih Bank',
                        searchInputPlaceholder: 'Cari nama Bank...',
                    });
                });

                $(document).ready(function (){
                    $("#selectProvince").select2({
                        placeholder:'Pilih Provinsi',
                        searchInputPlaceholder: 'Cari Provinsi...',
                        ajax: {
                            url: "{{ route('getProvince' )}}",
                            processResults: function({data}){
                                return {
                                    results: $.map(data, function(item){
                                        return {
                                            id: item.id,
                                            text: item.name,
                                        }
                                    })
                                }
                            }
                        }
                    });

                    $("#selectProvince").change(function(){
                        $('#selectRegency').html('');
                        $('#selectDistrict').html('');
                        $('#selectVillage').html('');
                        let id = $('#selectProvince').val();
                        $("#selectRegency").select2({
                            placeholder:'Pilih Kabupaten',
                            searchInputPlaceholder: 'Cari Kabupaten...',
                            ajax: {
                                url: "{{ url('indoregion/regency')}}/" + id,
                                processResults: function({data}){
                                    return {
                                        results: $.map(data, function(item){
                                            return {
                                                id: item.id,
                                                text: item.name,
                                            }
                                        })
                                    }
                                }
                            }
                        });
                    });

                    $("#selectRegency").change(function(){
                        $('#selectDistrict').html('');
                        $('#selectVillage').html('');
                        let id = $('#selectRegency').val();
                        $("#selectDistrict").select2({
                            placeholder:'Pilih Kecamatan',
                            searchInputPlaceholder: 'Cari Kecamatan...',
                            ajax: {
                                url: "{{url('indoregion/district')}}/"+ id,
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

                    $("#selectDistrict").change(function(){
                        $('#selectVillage').html('');
                        let id = $('#selectDistrict').val();
                        $("#selectVillage").select2({
                            placeholder:'Pilih Desa',
                            searchInputPlaceholder: 'Cari Desa...',
                            ajax: {
                                url: "{{url('indoregion/village')}}/"+ id,
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
