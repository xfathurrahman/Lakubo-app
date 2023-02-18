<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="bg-color">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    </head>
    <body class="pr-4 pt-2">
        @include('components.mobile-menu')
        @include('layouts.side-menu')
        <script type="text/javascript" src="{{ asset('js/midone_app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/image-uploader.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/select2-searchInputPlaceholder.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/alertify.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>
        <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        {{--<script>
            const url = window.location.pathname;
            let bgColor = "blue";
            if (url.startsWith("/customer/")) {
                bgColor = "red";
            } else if (url.startsWith("/admin/")) {
                bgColor = "green";
            }
            document.querySelector("html").style.backgroundColor = bgColor;
        </script>--}}

        <script>
            $(function(){
                var $sections=$('.form-section');
                function navigateTo(index){
                    $sections.removeClass('current').eq(index).addClass('current');
                    $('.store-form-navigation .previous').toggle(index>0);
                    var atTheEnd = index >= $sections.length - 1;
                    $('.store-form-navigation .next').toggle(!atTheEnd);
                    $('.store-form-navigation [Type=submit]').toggle(atTheEnd);

                    const step= document.querySelector('.step'+index);
                    step.style.backgroundColor="#ff5656";
                    step.style.color="white";
                }
                function curIndex(){
                    return $sections.index($sections.filter('.current'));
                }
                $('.store-form-navigation .previous').click(function(){
                    navigateTo(curIndex() - 1);
                });
                $('.store-form-navigation .next').click(function(){
                    Parsley.addMessage('en', 'required', 'Kolom ini wajib di isi');
                    Parsley.addMessage('en', 'maxlength', 'Maksimal %s digit');
                    Parsley.addMessage('en', 'minlength', 'Minimal %s digit');

                    $('.store-form').parsley().whenValidate({
                        group:'block-'+curIndex()
                    }).done(function(){
                        navigateTo(curIndex()+1);
                    });
                });
                $sections.each(function(index,section){
                    $(section).find(':input').attr('data-parsley-group','block-'+index);
                });
                navigateTo(0);
            });


            $(document).ready(function (){

                $("#selectCateStore").select2({
                    placeholder:'Pilih Kategori Lapak',
                    searchInputPlaceholder: 'Cari kategori...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    }
                });

                $("#selectDistrictStore").select2({
                    placeholder:'Pilih Kecamatan',
                    searchInputPlaceholder: 'Cari Kecamatan...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    }
                });
                $("#selectVillageStore").select2({
                    placeholder:'Pilih Desa',
                    searchInputPlaceholder: 'Cari Desa...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    }
                });

                $("#selectCateStore").select2({
                    placeholder:'Pilih Kategori Lapak',
                    searchInputPlaceholder: 'Cari kategori...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    },
                    ajax: {
                        url: "{{ url('customer/store/categories' )}}",
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

                $("#selectDistrictStore").select2({
                    placeholder:'Pilih Kecamatan',
                    searchInputPlaceholder: 'Cari Kecamatan...',
                    language: {
                        noResults: function () {
                            return "Tidak ditemukan.";
                        }
                    },
                    ajax: {
                        url: "{{ route('getBoyolali' )}}",
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

                $("#selectDistrictStore").change(function(){
                    $('#selectVillageStore').html('');
                    let id = $('#selectDistrictStore').val();
                    $("#selectVillageStore").select2({
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

        @yield('script')
    </body>
</html>
