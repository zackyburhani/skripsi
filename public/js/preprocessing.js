$(document).on('click', '.btn-preprocessing', function (e) {
    parameter = $(this).val();
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr(
                    'content'));
            }
        },
    });
    e.preventDefault();
    var url = $('#url_root').val();
    $('.btn-preprocessing').attr('disabled',true);
    $('.btn-preprocessing i.fa-gear').addClass('fa-spin');
    var button = '<button class="btn btn-success btn-latih" value="data-latih"><i class="fa fa-file-text"></i> Simpan Sebagai Data Latih</button> <button class="btn btn-info btn-uji" value="data-uji"><i class="fa fa-file-text"></i> Simpan Sebagai Data Uji</button>';
    var klasifikasi = $('.btn-simpan');
    $.ajax({
        type: 'POST',
        url: url + "/preprocessing",
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if(data == 0){
                new PNotify({
                    title: 'Warning !',
                    text: 'Data Tidak Ditemukan',
                    type: 'warning'
                });
                $('.btn-preprocessing').attr('disabled',false);
                $('.btn-preprocessing i.fa-gear').removeClass('fa-spin');
                return false;    
            } else {
                casefolding_table(data);
                cleansing_table(data);
                stopword_table(data);
                tokenizing_table(data);
                stemming_table(data);
                $('.btn-preprocessing').attr('disabled',true);
                $('.btn-preprocessing i.fa-gear').removeClass('fa-spin');
                
                if (!klasifikasi.length){
                    $('.panel-heading').append(button);
                }
                
                new PNotify({
                    title: 'Sukses !',
                    text: data.length+' Data Berhasil Diproses',
                    type: 'success'
                });
            }
        },
        error: function (data) {
            console.log('Error:', data);
            $('.btn-preprocessing').attr('disabled',false);
            $('.btn-preprocessing i.fa-gear').removeClass('fa-spin');
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });
});

//simpan data latih
$(document).on('click', '.btn-latih', function (e) {
    parameter = $(this).val();
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr(
                    'content'));
            }
        },
    });
    e.preventDefault();
    var url = $('#url_root').val();
    
    swal({
        title: "Anda Yakin Ingin Memproses Data Latih ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: url + '/data-latih',
                success: function (data) {
                    new PNotify({
                        title: 'Sukses !',
                        text: 'Data Berhasi Dihapus',
                        type: 'success'
                    });
                    // window.location.href = "{{URL::to('restaurants/20')}}"
                },
                error: function (data) {
                    console.log('Error:', data);
                    new PNotify({
                        title: 'Error !',
                        text: 'Terdapat Kesalahan Sistem',
                        type: 'error'
                    });
                }
            });
        } else {
            swal.close();
        }
      });
});

//simpan data uji
$(document).on('click', '.btn-uji', function (e) {
    parameter = $(this).val();
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr(
                    'content'));
            }
        },
    });
    e.preventDefault();
    var url = $('#url_root').val();
    
    swal({
        title: "Anda Yakin Ingin Memproses Data Uji ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: url + '/data-uji',
                success: function (data) {
                    // new PNotify({
                    //     title: 'Sukses !',
                    //     text: 'Data Berhasi Dihapus',
                    //     type: 'success'
                    // });
                    window.location.href = "/analisa";
                },
                error: function (data) {
                    console.log('Error:', data);
                    new PNotify({
                        title: 'Error !',
                        text: 'Terdapat Kesalahan Sistem',
                        type: 'error'
                    });
                }
            });
        } else {
            swal.close();
        }
      });
});

function casefolding_table(data) {
    var html = '';
    var i;
    var no = 1;
    $.each( data, function( key1, value1 ) {
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td >'+value1.case_folding.screen_name+'</td>';
        html = html + '<td >'+ value1.case_folding.full_text +'</td>';
        html = html + '</tr>';
    });
    $('#casefolding-tbody').html(html);
}

function cleansing_table(data) {
    var html = '';
    var no = 1;
    $.each( data, function( key1, value1 ) {
            html = html + '<tr>';
            html = html + '<td align="center">'+ no++ +'.' +'</td>';
            html = html + '<td >'+value1.cleansing.screen_name+'</td>';
            html = html + '<td >'+ value1.cleansing.full_text +'</td>';
            html = html + '</tr>';
    });
    $('#cleansing-tbody').html(html);
}

function tokenizing_table(data) {
    var html = '';
    var no = 1;
    var rows = '';
    $.each( data, function( key1, value1 ) {
        rows = value1.tokenizing.full_text;
        $.each( rows, function( key2, value2 ) {
            html = html + '<tr>';
            if(key2 == 0){
                html = html + '<td align="center" rowspan="'+ value1.tokenizing.full_text.length +'">'+ no++ +'.' +'</td>';
                html = html + '<td rowspan="'+ value1.tokenizing.full_text.length +'">'+value1.tokenizing.screen_name+'</td>';
            }
            html = html + '<td align="center">'+value2+'</td>';
            html = html + '</tr>';
        });
    });
    $('#tokenizing-tbody').html(html);
}

function stopword_table(data) {
    var html = '';
    var no = 1;
    var rows = '';
    console.log(data)
    $.each( data, function( key1, value1 ) {
        rows = value1.stopword.full_text;
        $.each( rows, function( key2, value2 ) {
            html = html + '<tr>';
            if(key2 == 0){
                html = html + '<td align="center" rowspan="'+ value1.stopword.full_text.length +'">'+ no++ +'.' +'</td>';
                html = html + '<td rowspan="'+ value1.stopword.full_text.length +'">'+value1.stopword.screen_name+'</td>';
            }
            html = html + '<td align="center">'+value2+'</td>';
            html = html + '</tr>';
        });
    });
    $('#stopword-tbody').html(html);
}

function stemming_table(data) {
    var html = '';
    var no = 1;
    var rows = '';
    $.each( data, function( key1, value1 ) {
        rows = value1.stemming.full_text;
        $.each( rows, function( key2, value2 ) {
            html = html + '<tr>';
            if(key2 == 0){
                html = html + '<td align="center" rowspan="'+ value1.stemming.full_text.length +'">'+ no++ +'.' +'</td>';
                html = html + '<td rowspan="'+ value1.stemming.full_text.length +'">'+value1.stemming.screen_name+'</td>';
            }
            html = html + '<td align="center">'+value2+'</td>';
            html = html + '</tr>';
        });
    });
    $('#stemming-tbody').html(html);
}