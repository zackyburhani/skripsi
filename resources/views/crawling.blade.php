@extends('template.index')

@section('main')
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        Data Stream
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/crawling"><i class="fa fa-twitter"></i> Crawling Data Twitter</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-success btn-export" value="xlsx"><i class="fa fa-file-excel-o"></i> Export XLSX</button>
                    <button class="btn btn-success btn-export" value="csv"><i class="fa fa-file-o"></i> Export CSV</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-upload"></i> Import XLSX</button>
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
                            <input type="number" name="count" class="form-control" placeholder="Jumlah">
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
                                <th width="15%"><center>Username<center></th>
                                <th width="55%"><center>Tweet<center></th>
                                <th><center>Class<center></th>
                                <th><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            @foreach($data as $key)
                            <tr>
                                <td align="center">{{$no++."."}}</td>
                                <td>{{$key->screen_name}}</td>
                                <td>{{$key->full_text}}</td>
                                <td align="center">{{$key->class}}</td>
                                <td align="center">
                                    <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
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


<script type="text/javascript">
$(document).ready( function () {
    $('#table-crawling').DataTable();
});
$(document).on('click','.btn-export',function(e) {
    var url = $('#url_root').val();
    parameter = $(this).val();
    window.location.href = url + '/export-crawling/' + parameter;
});
    

$('#frmUpload').submit( function(e) {
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    e.preventDefault();
    var url = $('#url_root').val();
    var data = new FormData(this); 
    $.ajax({
        type: 'POST',   
        url: url + "/upload-crawling",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            $('#frmUpload').trigger("reset");
            $('#myModal').modal('hide');
            new PNotify({
                title: 'Sukses !',
                text: 'Data Berhasil Diubah',
                type: 'success'
            });
        },
        error: function (data) {
            console.log('Error:', data);
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });
});
</script>
@endsection