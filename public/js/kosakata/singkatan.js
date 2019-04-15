var url = $('#url').val();
var url_root = $('#url_root').val();
singkatan_table();
$('#table-singkatan').DataTable();

//display data edit
$(document).on('click','.edit-singkatan',function(){
    var singkatan_id = $(this).val();
       
    $.get(url + '/' + singkatan_id, function (data) {
        //success data
        if( $('#button-update').length ){
            $('[name="singkatan"]').val(data.singkatan);
            $('[name="makna"]').val(data.makna);
            $('.btn-update').val(data.id);
        } else {
            $('[name="singkatan"]').val(data.singkatan);
            $('[name="makna"]').val(data.makna);
            var button = '<div id="button-update"><button type="button" class="btn btn-warning btn-update" value="' + data.id + '"><i class="fa fa-edit"></i> Ubah</button> '+' <button type="button" class="btn btn-danger btn-close"><i class="fa fa-close"></i> Batal</button></div>';
            $('#addition_button').append(button);
        }
        $('.btn-save').hide();
    }) 
});

//close
$(document).on('click','.btn-close',function(){
    $('#frmSingkatan').trigger("reset");
    $('#button-update').remove();
    $('.btn-save').show();
});

//delete item
$(document).on('click','.delete-singkatan',function(){
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
                    singkatan_table();
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
        singkatan: $('[name="singkatan"]').val(),
        makna: $('[name="makna"]').val(),
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
            singkatan_table();
            $('#frmSingkatan').trigger("reset");
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
        singkatan: $('[name="singkatan"]').val(),
        makna: $('[name="makna"]').val(),
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
            singkatan_table();
            $('#frmSingkatan').trigger("reset");
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

function singkatan_table()
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
        url   : url_root + "/singkatan_all",
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
                    '<td align="center">'+data[i].singkatan+'</td>'+
                    '<td align="center">'+data[i].makna+'</td>'+
                    '<td style="text-align:center;">'+
                      '<button class="btn btn-warning edit-singkatan" value="' + data[i].id + '">Pilih</button>'+' '+
                      '<button class="btn btn-danger btn-delete delete-singkatan" value="' + data[i].id + '">Hapus</button></td></tr>'+
                    '</td>'+
                '</tr>';
            }
            $('#singkatan-tbody').html(html);
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