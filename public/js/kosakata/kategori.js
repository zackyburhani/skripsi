var url = $('#url').val();
var url_root = $('#url_root').val();
kategori_table();
$('#table-kategori').DataTable();

//display data edit
$(document).on('click','.edit-kategori',function(){
    var kategori_id = $(this).val();
       
    $.get(url + '/' + kategori_id, function (data) {
        //success data
        if( $('#button-update').length ){
            $('[name="kategori"]').val(data.kategori);
            $('.btn-update').val(data.id_sentimen);
        } else {
            $('[name="kategori"]').val(data.kategori);
            var button = '<div id="button-update"><button type="button" class="btn btn-warning btn-update" value="' + data.id_sentimen + '"><i class="fa fa-edit"></i> Ubah</button> '+' <button type="button" class="btn btn-danger btn-close"><i class="fa fa-close"></i> Batal</button></div>';
            $('#addition_button').append(button);
        }
        $('.btn-save').hide();
    }) 
});

//close
$(document).on('click','.btn-close',function(){
    $('#frmKategori').trigger("reset");
    $('#button-update').remove();
    $('.btn-save').show();
});

//delete item
$(document).on('click','.delete-kategori',function(){
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
                    kategori_table();
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
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    e.preventDefault(); 
    var formData = {
        kategori: $('[name="kategori"]').val(),
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
            kategori_table();
            $('#frmKategori').trigger("reset");
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
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    e.preventDefault(); 
    var formData = {
        kategori: $('[name="kategori"]').val(),
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
            kategori_table();
            $('#frmKategori').trigger("reset");
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

function kategori_table()
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
        url   : url_root + "/kategori-sentimen-all",
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
                    '<td align="center">'+data[i].kategori+'</td>'+
                    '<td style="text-align:center;">'+
                      '<button class="btn btn-warning edit-kategori" value="' + data[i].id_sentimen + '">Pilih</button>'+' '+
                      '<button class="btn btn-danger btn-delete delete-kategori" value="' + data[i].id_sentimen + '">Hapus</button></td></tr>'+
                    '</td>'+
                '</tr>';
            }
            $('#kategori-tbody').html(html);
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