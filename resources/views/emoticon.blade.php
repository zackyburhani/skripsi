@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Emoticon
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-file-text"></i> Kosa Kata</a></li>
        <li><a href="/emoticon"><i class="fa fa-users"></i> Emoticon</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header">
                    <form id="frmEmoticon" name="frmEmoticon">
                        <div class="form-group">
                            <label class="col-sm-1 col-form-label">Emoticon</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Masukkan Simbol Emoticon" name="emoticon"
                                    class="form-control">
                            </div>
                            <div class="col-sm-5" id="addition_button">
                                <button class="btn btn-primary btn-save" value="add" type="button"><i
                                        class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    <hr>
                    <table id="table-emoticon" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th width="30px">
                                    <center>No.</center>
                                </th>
                                <th>
                                    <center>Emoticon</center>
                                </th>
                                <th width="150px">
                                    <center>Action</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="emoticon-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('js/kosakata/emoticon.js')}}"></script>
@endsection