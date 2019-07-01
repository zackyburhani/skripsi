var url = $('#url').val();
var url_root = $('#url_root').val();
kata_dasar_table();
$('#table-kata-dasar').DataTable();

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
            console.log(data)
            var html = '';
            var i;
            no = 1;
            for(i=0; i<data.length; i++){
                html += 
                '<tr>'+
                    '<td align="center">'+ no++ +'.'+'</td>'+
                    '<td align="center">'+data[i]+'</td>'+
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

$(document).on('click','.btn-hapus-katadasar',function(e) {
    var url = $('#url_root').val();
    swal({
        title: "Warning !",
        text: "Anda Yakin Ingin Menghapus Kata Dasar ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            window.location.href = url + '/hapus-katadasar';
        } else {
            swal.close();
        }
      });
});

window.setTimeout(function() {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){ $(this).remove(); }); 
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){ $(this).remove(); }); 
}, 3000); 