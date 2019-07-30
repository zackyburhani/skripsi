$(document).ready(function () {
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    var url = $('#url_root').val();
    $.ajax({
        type: 'GET',
        url: url + "/data-sentimen",
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $.each(data, function (key, value) {
                var id = '#table_' + value.kategori;
                $(id).DataTable();
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
});

$(document).on('click', '.btn-danger', function (e) {
    var url = $('#url_root').val();
    var value = $(this).val();

    swal({
            title: "Warning !",
            text: "Anda Yakin Ingin Menghapus Data Training " + value + " ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal({
                    icon: "success",
                    title: "Berhasil",
                    text: "Data Training " + value + " Berhasil Dihapus",
                    timer: 3000
                }).then(function () {
                    window.location.href = url + '/hapus-training/' + value;
                });
            } else {
                swal.close();
            }
        });
});