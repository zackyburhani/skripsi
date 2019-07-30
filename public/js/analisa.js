$(document).ready(function () {
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr(
                    'content'));
            }
        },
    });
    Highcharts.setOptions({
        colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        })
    });

    var url = $('#url_root').val();
    $.ajax({
        type: "GET",
        url: url + '/data-klasifikasi',
        success: function (datas) {
            var i;
            Highcharts.chart('container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Analisis Sentimen Perbankan Indonesia'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.persentase}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme
                                    .contrastTextColor) || 'black'
                            },
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    name: 'Total Sentimen',
                    data: datas
                }]
            });

        },
        error: function (data) {
            console.log('Error:', data);
            new PNotify({
                title: 'Error !',
                text: 'Tidak Ada Yang Diproses',
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

window.setTimeout(function () {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
    $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 3000);