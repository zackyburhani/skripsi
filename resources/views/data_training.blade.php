@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        Data Training / ({{$total}})
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/crawling"><i class="fa fa-twitter"></i> Data Training</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="title">Daftar Positif ({{count($data_positif)}}) <a href="{{ URL('training/clear/positif') }}" class="btn btn-info btn-xs btn-fill pull-right">Clear data training positif</a></h4>
                    <hr>
                    @if(COUNT($data_positif) != 0)
                    <div style="height: 300px; overflow: scroll;">
                        <table style="table-layout:fixed" id="table-positif" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5px"><center>No.<center></th>
                                    <th width="100px"><center>Kata<center></th>
                                    <th width="100px"><center>Frequency</center></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; ?>
                            @foreach($data_positif as $key)
                                <tr>
                                    <td align="center">{{$no++ ."."}}</td>
                                    <td align="center">{{$key->kata}}</td>
                                    <td align="center">{{$key->jumlah}}</td>
                                </tr>           
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p><b><center>Data Tidak Ditemukan</center></b></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="title">Daftar Negatif ({{count($data_negatif)}}) <a href="{{ URL('training/clear/positif') }}" class="btn btn-info btn-xs btn-fill pull-right">Clear data training positif</a></h4>
                    <hr>
                    @if(COUNT($data_negatif) != 0)
                    <div style="height: 300px; overflow: scroll;">
                        <table style="table-layout:fixed" id="table-negatif" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5px"><center>No.<center></th>
                                    <th width="100px"><center>Kata<center></th>
                                    <th width="100px"><center>Frequency</center></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; ?>
                            @foreach($data_negatif as $key)
                                <tr>
                                    <td align="center">{{$no++ ."."}}</td>
                                    <td align="center">{{$key->kata}}</td>
                                    <td align="center">{{$key->jumlah}}</td>
                                </tr>           
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p><b><center>Data Tidak Ditemukan</center></b></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="title">Daftar Netral ({{count($data_netral)}}) <a href="{{ URL('training/clear/positif') }}" class="btn btn-info btn-xs btn-fill pull-right">Clear data training positif</a></h4>
                    <hr>
                    @if(COUNT($data_netral) != 0)
                    <div style="height: 300px; overflow: scroll;">
                        <table style="table-layout:fixed" id="table-netral" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5px"><center>No.<center></th>
                                    <th width="100px"><center>Kata<center></th>
                                    <th width="100px"><center>Frequency</center></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; ?>
                            @foreach($data_netral as $key)
                                <tr>
                                    <td align="center">{{$no++ ."."}}</td>
                                    <td align="center">{{$key->kata}}</td>
                                    <td align="center">{{$key->jumlah}}</td>
                                </tr>           
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p><b><center>Data Tidak Ditemukan</center></b></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection