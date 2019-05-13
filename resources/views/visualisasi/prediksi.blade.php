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
        <li><a href="/analisa"><i class="fa fa-pie-chart"></i> Analisa Data</a></li>
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
                            <li class="active"><a href="{{ url('prediksi-sentimen') }}">Prediksi Sentimen</a></li>
                            <li><a href="{{ url('confusion-matrix') }}">Confusion Matriks</a></li>
                            <li><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="prediksi_sentimen">
                                <table style="table-layout:fixed" id="table-prediksi"
                                    class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="7%">
                                                <center>No.<center>
                                            </th>
                                            <th width="14%">
                                                <center>Username<center>
                                            </th>
                                            <th width="55%">
                                                <center>Tweet<center>
                                            </th>
                                            <th width="65px">
                                                <center>Actual<center>
                                            </th>
                                            <th width="65px">
                                                <center>Prediction</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        @foreach($collection as $key)
                                        <tr>
                                            <td align="center">{{$no++ ."."}}</td>
                                            <td align="center">{{$key['username']}}</td>
                                            <td align="left"><a data-toggle="modal"
                                                    href="#Detail_{{$key['id_testing']}}"> {{$key['tweet']}}</a></td>
                                            <td align="center">{{$key['kategori']}}</td>
                                            <td align="center">{{$key['prediksi']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Modal -->
@foreach($collection as $key)
<div class="modal fade" id="Detail_{{$key['id_testing']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form id="frmUpload" enctype="multipart/form-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-xlsx"></i>Detail Confidence</h4>
                </div>
                <div class="modal-body">
                    <table style="table-layout:fixed" id="table-prediksi"
                        class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="7%">
                                    <center>No.<center>
                                </th>
                                <th>
                                    <center>Hasil <i>Naïve Bayes Classifier (NBC)</i>
                                        <center>
                                </th>
                                <th width="20%">
                                    <center>Kategori<center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            <?php $data = App\Models\Klasifikasi::getHasil($key['id_testing']); ?>
                            @foreach($data as $row)
                            <tr>
                                <td align="center">{{$no++ ."."}}</td>
                                <td align="center">{{$row['nilai']}}</td>
                                <td align="center">{{$row['kelas']}}</td>
                            </tr>
                            <?php $tampung[$row['kelas']] = $row['nilai']; ?>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div style="height: 250px; overflow: scroll;">
                        <table style="table-layout:fixed" id="table-prediksi"
                            class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="7%">
                                        <center>No.<center>
                                    </th>
                                    <th>
                                        <center>Hasil <i>Preprocessing</i>
                                        <center>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                <?php $data = App\Models\DataTesting::getFreqTest($key['id_testing']); ?>
                                @foreach($data as $row)
                                <tr>
                                    <td align="center">{{$no++ ."."}}</td>
                                    <td align="center">{{$row['kata']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <?php  arsort($tampung); $hasil_klasifikasi = key($tampung); ?>
                    <table>
                        <tr>
                            <td>Hasil Klasifikasi : <b><?php echo $hasil_klasifikasi ?></b></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endforeach
{{-- <script src="{{asset('js/kosakata/emoticon.js')}}"></script> --}}

<script type="text/javascript">
    $(document).ready(function () {
        $('#table-prediksi').DataTable();
    });
</script>
@endsection