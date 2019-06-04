@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-book"></i>
        Stopwords
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-file-text"></i> Kosa Kata</a></li>
        <li><a href="/stopword"><i class="fa fa-book"></i> Stopwords</a></li>
    </ol>
</section>

<section class="content">
    @if (session('gagal'))
        <div class="alert alert-danger">
            {{ session('gagal') }}
        </div>
    @endif
    @if (session('sukses'))
        <div class="alert alert-success">
            {{ session('sukses') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($status === 2)
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary"><i class="fa fa-upload"></i> Upload Stopword</button>
                    @endif
                    <button type="button" class="btn btn-danger btn-hapus-stopword"><i class="fa fa-trash"></i> Hapus Stopword</button>
                </div>
                <div class="box-body">
                    <hr>
                    <table id="table-stopword" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th width="10%"><center>No.</center></th>
                                <th><center>Stopword</center></th>
                            </tr>
                        </thead>
                        <tbody id="stopword-tbody">
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="frmUpload" action="/stopword" method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-xlsx"></i>Upload Stopword</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input type="text" class="form-control file-upload-text" disabled placeholder="file harus bernama stopword.txt" />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-info file-upload-btn">
                            Browse...
                            <input type="file" class="file-upload" name="data_stopword" />
                        </button>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Stopword</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="{{asset('js/kosakata/stopword.js')}}"></script>
@endsection