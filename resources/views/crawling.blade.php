@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-twitter"></i> Data Crawling
    </h1>
    <ol class="breadcrumb">
        <li><a href="/crawling"><i class="fa fa-twitter"></i>Twitter Crawling</a></li>
    </ol>
</section>

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
    @if (session('sukses'))
        <script>            
            swal({
                icon: "success",
                title: "Berhasil",
                text: "Data Berhasil Diproses",
                timer: 3000
            })
        </script>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-success btn-export" value="xlsx"><i class="fa fa-file-excel-o"></i> Export XLSX</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-upload"></i> Import XLSX</button>
                    <button class="btn pull-right btn-danger btn-refresh" value="xlsx"><i class="fa fa-recycle"></i> Bersihkan Data</button>
                </div>
                <div class="panel-body">
                <form method="post" action="{{ route('crawling.crawling_data') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-8">
                            <p>Cari Tweet <i class="fa fa-twitter"></i></p>
                            <input type="text" class="form-control col-sm-12" name="keywords" placeholder="Masukkan Kata Kunci">
                        </div> 
                        <div class="col-sm-2">
                            <p> <i class="fa fa-serch"></i></p>
                            <input type="number" name="count" min="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="Jumlah">
                        </div>                
                        <div class="col-sm-2">
                            <p> <i class="fa fa-serch"></i></p>
                            <button class="btn btn-info btn-block">Search <i class="fa fa-search"></i></button>
                        </div>                           
                    </div>
                    <br>
                    <hr>
                    <table style="table-layout:fixed" id="table-crawling" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="7%"><center>No.<center></th>
                                <th width="14%"><center>Username<center></th>
                                <th width="55%"><center>Tweet<center></th>
                                <th><center>Class<center></th>
                                <th width="50px"><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            @foreach($data as $key)
                            <tr id="del_{{$key->id_crawling}}">
                                <td align="center">{{$no++."."}}</td>
                                <td>{{$key->username}}</td>
                                <td><span>{{$key->tweet}}</span></td>
                                <td align="center">
                                    <select class="dropdown form-control" name="klasifikasi" onchange="class_sentiment(this.value)">
                                            <option value="">--Pilih--</option>
                                        @foreach($sentimen as $kategori)
                                            <option <?php if($kategori->id_sentimen == $key->id_sentimen) echo 'selected="selected"'; ?> value="{{$key->id_crawling}}|{{$kategori->id_sentimen}}">{{$kategori->kategori}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td align="center">
                                <button class="btn btn-danger delete-tweet" value="{{$key->id_crawling}}" type="button"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="frmUpload" enctype="multipart/form-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-xlsx"></i>Upload XLSX</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input type="text" class="form-control file-upload-text" disabled placeholder="select a file..." />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-info file-upload-btn">
                            Browse...
                            <input type="file" class="file-upload" name="data_crawling" />
                        </button>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                    <button type="submit" class="btn btn-primary btn-upload">Import XLSX</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{asset('js/crawling.js')}}"></script>
@endsection