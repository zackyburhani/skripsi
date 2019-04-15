@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">

<section class="content-header">
    <h1>
        <i class="fa fa-align-justify"></i>
        Kata Singkatan
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-file-text"></i> Kosa Kata</a></li>
        <li><a href="/emoticon"><i class="fa fa-align-justify"></i> Kata Singkatan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header">
                    <br>
                    <form id="frmSingkatan" name="frmSingkatan">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Singkatan</label>
                            <div class="col-sm-6">
                                <input type="text" name="singkatan" placeholder="Masukkan Kata Singkatan"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Makna / Arti</label>
                            <div class="col-sm-6">
                                <input type="text" name="makna" placeholder="Masukkan Makna / Arti Singkatan"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6" id="addition_button">
                                <button type="button" class="btn btn-primary btn-save" value="add"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    <hr>
                    <table id="table-singkatan" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th width="40px">
                                    <center>No.</center>
                                </th>
                                <th width="100px">
                                    <center>Singkatan</center>
                                </th>
                                <th>
                                    <center>Makna</center>
                                </th>
                                <th width="100px">
                                    <center>Action</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="singkatan-tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('js/kosakata/singkatan.js')}}"></script>
@endsection