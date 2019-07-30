@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-cloud"></i> Word Cloud
    </h1>
    <ol class="breadcrumb">
        <li><a href="/word-cloud"><i class="fa fa-cloud"></i> Word Cloud</a></li>
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
                            <li><a href="{{ url('visualisasi-data') }}" >Visualisasi Data</a></li>
                            <li><a href="{{ url('hasil-perhitungan') }}">Hasil Perhitungan</a></li>
                            <li ><a href="{{ url('confusion-matrix') }}" >Confusion Matriks</a></li>
                            <li class="active"><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="matriks">
                                @foreach($klasifikasi as $class => $val)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div id="container_{{$val->sentimen->kategori}}"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif

<script src="{{asset('js/word_cloud.js')}}"></script>
@endsection