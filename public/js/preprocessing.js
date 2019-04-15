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
    $.ajax({
        type: 'POST',
        url: url + "/preprocessing",
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            casefolding_table(data);
            cleansing_table(data);
            stopword_table(data);
            new PNotify({
                title: 'Sukses !',
                text: 'Data Berhasil Diubah',
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
});

function casefolding_table(data) {
    var html = '';
    var i;
    var no = 1;
    for (i = 0; i < data.length; i++) {
        html +=
            '<tr>' +
            '<td align="center">' + no++ + '.' + '</td>' +
            '<td>' + data[i].case_folding.screen_name + '</td>' +
            '<td class="anjing">' + data[i].case_folding.full_text + '</td>' +
            '</tr>';
    }
    $('#casefolding-tbody').html(html);
}

function cleansing_table(data) {
    var html = '';
    var i;
    var no = 1;
    for (i = 0; i < data.length; i++) {
        html +=
            '<tr>' +
            '<td align="center">' + no++ + '.' + '</td>' +
            '<td>' + data[i].cleansing.screen_name + '</td>' +
            '<td>' + data[i].cleansing.full_text + '</td>' +
            '</tr>';
    }
    $('#cleansing-tbody').html(html);
}

function casefolding_table(data) {
    var html = '';
    var i;
    var no = 1;
    for (i = 0; i < data.length; i++) {
        html +=
            '<tr>' +
            '<td align="center">' + no++ + '.' + '</td>' +
            '<td>' + data[i].case_folding.screen_name + '</td>' +
            '<td>' + data[i].case_folding.full_text + '</td>' +
            '</tr>';
    }
    $('#casefolding-tbody').html(html);
}

function stopword_table(data) {
    var html = '';
    var i;
    var no = 1;
    for (i = 0; i < data.length; i++) {
        html +=
            '<tr>' +
            '<td align="center">' + no++ + '.' + '</td>' +
            '<td>' + data[i].stopword.screen_name + '</td>' +
            '<td>' + data[i].stopword.full_text + '</td>' +
            '</tr>';
    }
    $('#stopword-tbody').html(html);
}