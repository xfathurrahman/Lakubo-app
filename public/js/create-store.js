$(document).ready(function (){
    let $sections = $('.form-section');
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
            url: categoriesUrl,
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
            url: getBoyolaliUrl,
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
                url: getDesaUrl + id,
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
