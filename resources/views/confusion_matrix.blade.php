@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Analisa Data
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/analisa"><i class="fa fa-users"></i> Analisa Data</a></li>
    </ol>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li><a href="{{ url('analisa') }}">Kalifikasi</a></li>
                            <li class="active"><a href="{{ url('confusion-matrix') }}" >Confusion Matriks</a></li>
                            <li><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="confusion_matrix">
                                <div id="container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <script src="{{asset('js/kosakata/emoticon.js')}}"></script> --}}

<script type="text/javascript">
// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Confusion Matrix'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total Confusion Matrix'
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
                format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    "series": [
        {
            "name": "Browsers",
            "colorByPoint": true,
            "data": [
                {
                    "name": "Chrome",
                    "y": 62.74,
                },
                {
                    "name": "Firefox",
                    "y": 10.57,
                },
                {
                    "name": "Internet Explorer",
                    "y": 7.23,
                },
                {
                    "name": "Edge",
                    "y": 4.02,
                },
            ]
        }
    ]
});
</script>
@endsection