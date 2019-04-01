var url = $('#url').val();
var url_root = $('#url_root').val();
emoticon_table()
//display data edit
$(document).on('click','.edit-emoticon',function(){
    var emoticon_id = $(this).val();
       
    $.get(url + '/' + emoticon_id, function (data) {
        //success data
        if( $('#button-update').length ){
            $('[name="emoticon"]').val(data.emoticon);
            $('.btn-update').val(data.id);
        } else {
            $('[name="emoticon"]').val(data.emoticon);
            var button = '<div id="button-update"><button type="button" class="btn btn-warning btn-update" value="' + data.id + '"><i class="fa fa-edit"></i> Ubah</button> '+' <button type="button" class="btn btn-danger btn-close"><i class="fa fa-close"></i> Batal</button></div>';
            $('#addition_button').append(button);
        }
        $('.btn-save').hide();
    }) 
});

//close
$(document).on('click','.btn-close',function(){
    $('#frmEmoticon').trigger("reset");
    $('#button-update').remove();
    $('.btn-save').show();
});

//delete item
$(document).on('click','.delete-emoticon',function(){
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
                    emoticon_table();
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
        emoticon: $('[name="emoticon"]').val(),
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
            emoticon_table();
            $('#frmEmoticon').trigger("reset");
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
        emoticon: $('[name="emoticon"]').val(),
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
            emoticon_table();
            $('#frmEmoticon').trigger("reset");
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

function emoticon_table()
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
        url   : url_root + "/emoticon_all",
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
                    '<td align="center">'+data[i].emoticon+'</td>'+
                    '<td style="text-align:center;">'+
                      '<button class="btn btn-warning edit-emoticon" value="' + data[i].id + '">Pilih</button>'+' '+
                      '<button class="btn btn-danger btn-delete delete-emoticon" value="' + data[i].id + '">Hapus</button></td></tr>'+
                    '</td>'+
                '</tr>';
            }
            $('#emoticon-tbody').html(html);
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