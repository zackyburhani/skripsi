$(document).ready(function () {
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr(
                    'content'));
            }
        },
    });

    var url = $('#url_root').val();
    $.ajax({
        type: "GET",
        url: url + '/column-drilldown',
        success: function (data) {
            let precision = Object.entries(data[0].precision)
            let recall = Object.entries(data[0].recall)
            // Create the chart
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Persentase Confusion Matrix'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: ''
                    }
            
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.2f}%'
                        }
                    }
                },
            
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },

                "series": [
                    {
                        "name": "Confusion Matrix",
                        "colorByPoint": true,
                        "data": [
                            {
                                "name": "Accuracy",
                                "y": data[0].accuracy,
                            },
                            {
                                "name": "Precision",
                                "y": data[0].total_precision,
                                "drilldown": "Precision"
                            },
                            {
                                "name": "Recall",
                                "y": data[0].total_recall,
                                "drilldown": "Recall"
                            },
                            {
                                "name": "Error Rate",
                                "y": data[0].error_rate,
                            }
                        ]
                    }
                ],
                "drilldown": {
                    "series": [
                        {
                            "name": "Precision",
                            "id": "Precision",
                            "data": precision,
                        },
                        {
                            "name": "Recall",
                            "id": "Recall",
                            "data": recall,
                        }
                    ]
                }
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