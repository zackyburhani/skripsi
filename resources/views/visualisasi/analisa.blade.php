@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-pie-chart"></i> Visualisasi Data
    </h1>
    <ol class="breadcrumb">
        <li><a href="/visualisasi-data"><i class="fa fa-pie-chart"></i> Visualisasi Data</a></li>
    </ol>
</section>

@if($testing == 0)
<section class="content">
    @if (session('status'))
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
            <center>
                <h3><i>Data Testing</i> Tidak Ditemukan</h3>
            </center>
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
                            <li class="active"><a href="{{ url('visualisasi-data') }}">Visualisasi Data</a></li>
                            <li><a href="{{ url('hasil-perhitungan') }}">Hasil Perhitungan</a></li>
                            <li><a href="{{ url('confusion-matrix') }}">Confusion Matriks</a></li>
                            <li><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                            <li class="pull-right">
                                <button class="btn btn-danger btn-xs btn-fill pull-right"><i class="fa fa-trash"></i>
                                    Hapus Data Testing </button>
                                </i>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="klasifikasi">
                                <div id="container"
                                    style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
<script src="{{asset('js/analisa.js')}}"></script>
@endsection