@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-pie-chart"></i> Visualisasi Data
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/analisa"><i class="fa fa-pie-chart"></i> Analisa Data</a></li>
    </ol>
</section>

@if($testing == 0)
<section class="content">
    @if (session('status'))
        {{-- <div class="alert alert-danger">
            {{ session('status') }}
        </div> --}}

         <script>
            
            swal({
                icon: "error",
                title: "Berhasil",
                text: "Data Tidak Ditemukan",
            })
            
        </script>
    @endif
    <div class="panel panel-default">
        <div class="panel-body">
        <center><h3><i>Data Testing</i> Tidak Ditemukan</h3></center>
        </div>
    </div>           
</section>
@else
<section class="content">
    @if (session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif
    @if (session('sukses'))
        <div class="alert alert-success">
            {{ session('sukses') }}
        </div>
    @endif
     <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="{{ url('analisa') }}">Klasifikasi</a></li>
                            <li><a href="{{ url('prediksi-sentimen') }}">Prediksi Sentimen</a></li>
                            <li><a href="{{ url('confusion-matrix') }}" >Confusion Matriks</a></li>
                            <li><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                            <li class="pull-right">
                                <button class="btn btn-danger btn-xs btn-fill pull-right"><i class="fa fa-trash"></i> Hapus Data Testing </button>
                            </i>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="klasifikasi">
                                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
{{-- <script src="{{asset('js/kosakata/emoticon.js')}}"></script> --}}

<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            beforeSend: function (xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr(
                        'content'));
                }
            },
        });
        // Radialize the colors
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
                // Build the chart
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
window.setTimeout(function() {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){ $(this).remove(); }); 
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){ $(this).remove(); }); 
}, 3000); 
</script>
@endsection