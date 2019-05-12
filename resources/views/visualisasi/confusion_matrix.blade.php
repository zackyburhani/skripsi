@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-pie-chart"></i> Analisa Data
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/analisa"><i class="fa fa-users"></i> Analisa Data</a></li>
    </ol>
</section>

@if($testing_data == 0)
<section class="content">
    <div class="panel panel-default">
        <div class="panel-body">
        <center><h3>Data <i>Testing</i> Tidak Ditemukan</h3></center>
        </div>
    </div>           
</section>
@else
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li><a href="{{ url('analisa') }}">Klasifikasi</a></li>
                            <li><a href="{{ url('prediksi-sentimen') }}">Prediksi Sentimen</a></li>
                            <li class="active"><a href="{{ url('confusion-matrix') }}">Confusion Matriks</a></li>
                            <li><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="confusion_matrix">
                                <h4 class="title">
                                    <center>Tabel Confusion Matrix </center>
                                </h4>
                                <hr>
                                <table style="table-layout:fixed" id="table-negatif"
                                    class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="background-color:#F2F1EF"></th>
                                            @foreach($th as $index_th => $head)
                                            <th>
                                                <center>Pred. {{$head}}<center>
                                            </th>
                                            @endforeach
                                            <th>
                                                <center>CLASS RECALL</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        @foreach($matrix as $index_matrix => $value_m)
                                        <tr>
                                            <td align="center"><b>True. {{$index_matrix}}</b></td>
                                            @foreach($value_m as $index_value => $value_v)
                                            <td align="center">{{$value_v}}</td>
                                            @endforeach
                                            <td align="center">{{round($recall[$index_matrix]*100,2)}}%</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td align="center"><b>CLASS PRECISION</b></td>
                                            @foreach($precision as $index_p => $value_p)
                                            <td align="center">{{round($value_p*100,2)}}%</td>
                                            @endforeach
                                            <td style="background-color:#F2F1EF"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <h4> Accuracy : <span id="accuracy">{{round($accuracy*100,2)}}</span>%</h4>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection