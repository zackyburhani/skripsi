$(document).ready(function () {
    $('#table-crawling').DataTable();
});

$(document).on('click', '.btn-export', function (e) {
    var url = $('#url_root').val();
    parameter = $(this).val();
    window.location.href = url + '/export-crawling/' + parameter;
});

$(document).on('click', '.btn-refresh', function (e) {
    var url = $('#url_root').val();
    swal({
            title: "Warning !",
            text: "Anda Yakin Ingin Membersihkan Data ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal({
                    icon: "success",
                    title: "Berhasil",
                    text: "Dataset Berhasil Dihapus",
                    timer: 3000
                }).then(function () {
                    window.location.href = url + '/refresh-crawling';
                });
            } else {
                swal.close();
            }
        });
});

$('#frmUpload').submit(function (e) {
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    e.preventDefault();
    var url_param = $('#url').val();
    var url = $('#url_root').val();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: url + "/upload-crawling",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            $('#frmUpload').trigger("reset");
            $('#myModal').modal('hide');
            swal({
                icon: "success",
                title: "Berhasil",
                text: "Dataset Berhasil Disimpan",
                timer: 3000
            }).then(function () {
                window.location.href = url_param;
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

$(document).on('click', '.delete-tweet', function () {
    var id = $(this).val();
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    var url = $('#url').val();
    swal({
            title: "Warning !",
            text: "Anda Yakin Ingin Menghapus Data ?",
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
                        swal({
                            icon: "success",
                            title: "Berhasil",
                            text: "Data Berhasil Dihapus",
                            timer: 3000
                        }).then(function () {
                            window.location.href = $('#url').val();
                        });
                        // tag = "#del_"+id;
                        // $(tag).remove();
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

function class_sentiment(model) {
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });

    var url = $('#url').val();
    var explode = model.split("|");
    var id = explode[0];
    var formData = {
        klasifikasi: explode[1],
        id: id
    }

    if (id == "") {
        return false;
    }

    var type = "PUT";
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

window.setTimeout(function () {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
    $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 3000);