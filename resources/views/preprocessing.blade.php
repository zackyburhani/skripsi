@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">

<section class="content-header">
    <h1>
        <i class="fa fa-gears"></i> Preprocessing
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/preprocessing"><i class="fa fa-gears"></i> Preprocessing</a></li>
    </ol>
</section>

<section class="content-header">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-primary btn-preprocessing" value="preprocessing"><i class="fa fa-gear"></i>
                        Mulai Preprocessing</button>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom" id="data_preprocessing_validasi">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#casefolding" data-toggle="tab">Case Folding</a></li>
                                    <li><a href="#cleansing" data-toggle="tab">Cleansing</a></li>
                                    <li><a href="#tokenizing" data-toggle="tab">Tokenizing</a></li>
                                    <li><a href="#stopword" data-toggle="tab">Stopword Removal</a></li>
                                    <li><a href="#stemming" data-toggle="tab">Stemming</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="casefolding">
                                        <table id="table-casefolding" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="casefolding-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="cleansing">
                                        <table id="table-cleansing" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="cleansing-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tokenizing">
                                        <table id="table-tokenizing" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tokenizing-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="stopword">
                                        <table id="table-stopword" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="stopword-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="stemming">
                                        <table id="table-stemming" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="stemming-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal_loading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-xlsx"></i>Upload XLSX</h4>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
</div>

<script src="{{asset('js/preprocessing.js')}}"></script>
@endsection