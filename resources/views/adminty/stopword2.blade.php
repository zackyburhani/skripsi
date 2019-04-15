@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
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
                                    <h4>Stopword</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="/"> Dashboard </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Kosa Kata</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/stopword">Stopword</a>
                                    </li>
                                   </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <form id="frmStopword" name="frmStopword">  
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Stopword</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Masukkan Stopword" name="stopword" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-6" id="addition_button">
                                                <button class="btn btn-primary btn-save" value="add" type="button"><i class="fa fa-save"></i> Simpan</button>
                                            </div>
                                        </div>      
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-body end -->

                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Zero config.table start -->
                            <div class="card">
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px"><center>No.</center></th>
                                                    <th><center>Stopword</center></th>
                                                    <th width="100px"><center>Action</center></th>
                                                </tr>
                                                </thead>
                                                <tbody id="stopword-tbody">
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
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/kosakata/stopword.js')}}"></script>
@endsection