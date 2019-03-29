@extends('template.index')

@section('main')
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
                                            <select class="js-example-tags col-sm-12" name="keywords[]" multiple="multiple">
                                            </select>
                                        </div> 
                                        <div class="col-sm-2">
                                            <p> <i class="fa fa-serch"></i></p>
                                            <input type="number" name="count" class="form-control">
                                        </div>                
                                        <div class="col-sm-2">
                                            <p> <i class="fa fa-serch"></i></p>
                                            <button class="btn btn-primary btn-block">Search <i class="fa fa-search"></i></button>
                                        </div>                           
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Username</th>
                                                    <th>Tweet</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no=1; ?>
                                                    <?php foreach($data as $key) { ?>
                                                    <tr>
                                                        <td>{{$no++}}</td>
                                                        <td>{{$key->screen_name}}</td>
                                                        <td>{{$key->full_text}}</td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Office</th>
                                                </tr>
                                                </tfoot>
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
@endsection