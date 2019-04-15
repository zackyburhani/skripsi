@extends('template.index')

@section('main')
<input id="url_root" type="hidden" value="{{ url("") }}">
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Data Stream</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/crawling">Crawling Data Twitter</a>
                                    </li>
                                   </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="d-inline">
                                <button class="btn btn-success btn-export" value="xlsx"><i class="fa fa-file-excel-o"></i> Export XLSX</button>
                            </div>
                            <div class="d-inline">
                                <button class="btn btn-success btn-export" value="csv"><i class="fa fa-file-o"></i> Export CSV</button>
                            </div>
                            <div class="d-inline">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-upload"></i> Import XLSX</button>
                            </div>
                        </div>   
                    </div>
                </div>
                
                <!-- Page-header end -->
                <form method="post" action="{{ route('crawling.crawling_data') }}">
                @csrf
                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Zero config.table start -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <p>Cari Tweet <i class="fa fa-twitter"></i></p>
                                            <input type="text" class="form-control col-sm-12" name="keywords" placeholder="Masukkan Kata Kunci">
                                            {{-- <select class="js-example-tags col-sm-12" name="keywords[]" multiple="multiple">
                                            </select> --}}
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
                                    <hr>
                                </div>
                                <div class="card-block">
                                    <div class="">
                                        <table id="simpletable" style="table-layout:fixed;word-wrap: break-word;
                                        word-break: break-all;" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Username</th>
                                                    <th>Tweet</th>
                                                    <th width="100px">Class</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no=1; ?>
                                                    @foreach($data as $key)
                                                    <tr>
                                                        <td align="center">{{$no++."."}}</td>
                                                        <td>{{$key->screen_name}}</td>
                                                        <td>{{$key->full_text}}</td>
                                                        <td>{{$key->class}}</td>
                                                        <td></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Zero config.table end -->
                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <form id="frmUpload" enctype="multipart/form-data">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload XLSX</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-upload">Import XLSX</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
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