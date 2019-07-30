$(document).ready(function () {
    $('#table-prediksi').DataTable();
});

$('.btnModalPrediksi').click( function(e) {
    e.preventDefault();

    try {
        $("#modal_detail_prediksi").modal('show');
        var id = $(this).data("id_testing");
        var url = $('#url_root').val();

        $.ajax({
            type: 'GET',
            url: url + "/get-detail-prediksi/" + id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data == 0){
                    swal({
                        icon: "warning",
                        title: "Gagal",
                        text: "Data Tidak Ditemukan",
                    });
                    return false;    
                } else {
                    hasil_preprocessing(data);
                    hasil_detail(data);
                    hasil_nbc(data);
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



        } catch (e) {
            console.log(e);
        }

});

$(document).on('click','.btn-danger',function(e) {
    var url = $('#url_root').val();
    var value = $(this).val();
    
    swal({
        title: "Warning !",
        text: "Anda Yakin Ingin Menghapus Data Testing ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal({
                icon: "success",
                title: "Berhasil",
                text: "Data Testing Berhasil Dihapus",
                timer: 3000
            }).then(function () {
                window.location.href = url + '/hapus-testing/' + value;
            });
        } else {
            swal.close();
        }
    });
});

function hasil_preprocessing(data) {
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.prepro.length; i++){
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td align="center">'+data.prepro[i]+'</td>';
        html = html + '</tr>';
    }
    $('#hasil-preprocessing-tbody').html(html);
}

function hasil_detail(data) {
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.detail.length; i++){
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td align="center">'+data.detail[i].kemunculan_kata+'</td>';
        html = html + '<td align="center">'+data.kelas_peluang[i]+'</td>';
        html = html + '<td align="center">'+data.detail[i].nilai_proses+'</td>';
        html = html + '</tr>';
    }
    $('#hasil-detail-tbody').html(html);
}

function hasil_nbc(data) {
    var html = '';
    var i;
    var no = 1;
    var tampung = [];
    for(i=0; i<data.nbc.length; i++){
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td align="center">'+data.nbc[i].vmap+'</td>';
        html = html + '<td align="center">'+data.nbc[i].sentimen.kategori+'</td>';
        html = html + '</tr>';
    tampung = data.nbc[i].vmap;
    }
    $('#hasil-nbc-tbody').html(html);
    $('#hasil_klasifikasi').text(data.hasil_klasifikasi);
}