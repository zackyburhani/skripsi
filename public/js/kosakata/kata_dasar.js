var url = $('#url').val();
var url_root = $('#url_root').val();
kata_dasar_table();
$('#table-kata-dasar').DataTable();

//display data edit
$(document).on('click','.edit-kata-dasar',function(){
    var katadasar_id = $(this).val();
       
    $.get(url + '/' + katadasar_id, function (data) {
        //success data
        if( $('#button-update').length ){
            $('[name="katadasar"]').val(data.katadasar);
            $('[name="tipe_katadasar"]').val(data.tipe_katadasar);
            $('.btn-update').val(data.id_ktdasar);
        } else {
            $('[name="katadasar"]').val(data.katadasar);
            $('[name="tipe_katadasar"]').val(data.tipe_katadasar);
            var button = '<div id="button-update"><button type="button" class="btn btn-warning btn-update" value="' + data.id_ktdasar + '"><i class="fa fa-edit"></i> Ubah</button> '+' <button type="button" class="btn btn-danger btn-close"><i class="fa fa-close"></i> Batal</button></div>';
            $('#addition_button').append(button);
        }
        $('.btn-save').hide();
    }) 
});

//close
$(document).on('click','.btn-close',function(){
    $('#frmKtDasar').trigger("reset");
    $('#button-update').remove();
    $('.btn-save').show();
});

//delete item
$(document).on('click','.delete-kata-dasar',function(){
    var id = $(this).val();
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });


    swal({
        title: "Anda Yakin Ingin Menghapus Data?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "DELETE",
                url: url + '/' + id,
                success: function (data) {
                    kata_dasar_table();
                    new PNotify({
                        title: 'Sukses !',
                        text: 'Data Berhasi Dihapus',
                        type: 'success'
                    });
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

//create new item
$(".btn-save").click(function (e) {

    if($('[name="katadasar"]').val() == "" || $('[name="tipe_katadasar"]').val() == ""){
        new PNotify({
            title: 'Gagal !',
            text: 'Form Tidak Boleh Kosong',
            type: 'warning'
        });
        return false;
    }

    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    e.preventDefault(); 
    var formData = {
        katadasar: $('[name="katadasar"]').val(),
        tipe_katadasar: $('[name="tipe_katadasar"]').val(),
    }
    var type = "POST"; //for creating new resource
    var my_url = url;
    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function (data) {
            new PNotify({
                title: 'Sukses !',
                text: 'Data Berhasi Dimasukkan',
                type: 'success'
            });
            kata_dasar_table();
            $('#frmKtDasar').trigger("reset");
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
});

//update new item
$(document).on('click','.btn-update',function(e) {

    if($('[name="katadasar"]').val() == "" || $('[name="tipe_katadasar"]').val() == ""){
        new PNotify({
            title: 'Gagal !',
            text: 'Form Tidak Boleh Kosong',
            type: 'warning'
        });
        return false;
    }

    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    e.preventDefault(); 
    var formData = {
        katadasar: $('[name="katadasar"]').val(),
        tipe_katadasar: $('[name="tipe_katadasar"]').val(),
    }

    var type = "PUT";
    var id = $(this).val();
    $.ajax({
        type: type,
        url: url + '/' + id,
        data: formData,
        dataType: 'json',
        success: function (data) {
            new PNotify({
                title: 'Sukses !',
                text: 'Data Berhasi Diubah',
                type: 'success'
            });
            kata_dasar_table();
            $('#frmKtDasar').trigger("reset");
            $('#button-update').remove();
            $('.btn-save').show();
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
});

function kata_dasar_table()
{
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    $.ajax({
        type  : 'get',
        url   : url_root + "/kata-dasar-all",
        async : false,
        dataType : 'json',
        success : function(data){
            var html = '';
            var i;
            no = 1;
            for(i=0; i<data.length; i++){
                html += 
                '<tr>'+
                    '<td align="center">'+ no++ +'.'+'</td>'+
                    '<td align="center">'+data[i].katadasar+'</td>'+
                    '<td align="center">'+data[i].tipe_katadasar+'</td>'+
                    '<td style="text-align:center;">'+
                      '<button class="btn btn-warning edit-kata-dasar" value="' + data[i].id_ktdasar + '">Pilih</button>'+' '+
                      '<button class="btn btn-danger btn-delete delete-kata-dasar" value="' + data[i].id_ktdasar + '">Hapus</button></td></tr>'+
                    '</td>'+
                '</tr>';
            }
            $('#katadasar-tbody').html(html);
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
}