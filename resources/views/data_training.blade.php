@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-list-alt"></i> Data Training
    </h1>
    <ol class="breadcrumb">
        <li><a href="/training"><i class="fa fa-list-alt"></i> Data Training</a></li>
    </ol>
</section>

<section class="content">
    @foreach($data_training as $key => $val)
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                @if(COUNT($val) != 0)
                    <h4 class="title">Daftar {{$key}} / ({{App\Models\DataTraining::totalSentimen($key)}} Tweet) <button value="{{$key}}" class="btn btn-danger btn-xs btn-fill pull-right"><i class="fa fa-trash"></i> Hapus Data Training {{$key}}</button></h4>
                    <hr>
                    <table style="table-layout:fixed" id="table_{{$key}}" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5px"><center>No.<center></th>
                                <th width="100px"><center>Kata<center></th>
                                <th width="100px"><center>Frequency</center></th>
                                <th width="100px"><center>Nilai Perhitungan</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; ?>
                            @foreach($val as $row => $content)
                            <tr>
                                <td align="center">{{$no++ ."."}}</td>
                                <td align="center">{{$content->kata}}</td>
                                <td align="center">{{$content->jumlah}}</td>
                                <td align="center">{{$content->nilai_bobot}}</td>
                            </tr>           
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p><b><center>Data {{$key}} Tidak Ditemukan</center></b></p>
                @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                     <table>
                        <tbody>
                            @foreach($prior as $pr)
                            <tr>
                                <td width="130px"><h4>Prior {{$pr['kelas']}}</h4></td>
                                <td width="15px"><h4>:</h4></td>
                                <td width="100px"><h4>{{ round($pr['nilai'],4) }}</h4></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                     <table>
                        <tbody>
                            @foreach($data_sum as $sum)
                            <tr> 
                                <td width="160px"><h4>Frequency {{$sum['kelas']}}</h4></td>
                                <td width="10px"><h4>:</h4></td>
                                <td width="100px"><h4>{{$sum['jumlah']}}</h4></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                     <table>
                        <tbody>
                            <tr> 
                                <td width="160px"><h4>Total Kosakata</h4></td>
                                <td width="10px"><h4>:</h4></td>
                                <td width="100px"><h4>{{$uniqueWords}}</h4></td>
                            </tr>
                            {{-- <tr>
                                <td><h4>Total Kata Training</h4></td>
                                <td><h4>:</h4></td>
                                <td><h4>{{$total}}</h4></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('js/training.js')}}"></script>
@endsection