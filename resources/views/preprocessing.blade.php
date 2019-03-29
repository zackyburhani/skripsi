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
                                    <h4>Preprocessing</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="/"> Dashboard </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/preprocessing">Preprocessing</a>
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
                            <!-- Bootstrap tab card start -->
                            <div class="card">
                                <div class="card-block">
                                    <!-- Row start -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="sub-title">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary"><i class="fa fa-gears"></i> Mulai Preprocessing</button>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#casefolding" role="tab">Case Folding</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#cleansing" role="tab">Cleansing</a>
                                                    </li>
                                                    <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#stopword" role="tab">Stopword Removal</a>
                                                        </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#emoticon" role="tab">Convert Emoticon</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#negation" role="tab">Convert Negation</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#tokenizing" role="tab">Tokenizing</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#stemming" role="tab">Stemming</a>
                                                    </li>
                                                </ul>
                                                <!-- Tab panes -->
                                                <div class="tab-content tabs card-block">
                                                    <div class="tab-pane active" id="casefolding" role="tabpanel">
                                                        <p class="m-0">1. This is Photoshop's version of Lorem IpThis is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean mas Cum sociis natoque penatibus et magnis dis.....</p>
                                                    </div>
                                                    <div class="tab-pane" id="cleansing" role="tabpanel">
                                                        <p class="m-0">2.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                    </div>
                                                    <div class="tab-pane" id="stopword" role="tabpanel">
                                                        <p class="m-0">3. This is Photoshop's version of Lorem IpThis is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean mas Cum sociis natoque penatibus et magnis dis.....</p>
                                                    </div>
                                                    <div class="tab-pane" id="emoticon" role="tabpanel">
                                                        <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                    </div>
                                                    <div class="tab-pane" id="negation" role="tabpanel">
                                                        <p class="m-0">5.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                    </div>
                                                    <div class="tab-pane" id="tokenizing" role="tabpanel">
                                                        <p class="m-0">6.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                    </div>
                                                    <div class="tab-pane" id="stemming" role="tabpanel">
                                                        <p class="m-0">7.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>
                                    <!-- Row end -->
                                    </div>
                                </div>
                            <!-- Bootstrap tab card end -->
                        </div>
                    </div>      
                </div>
                <!-- Page-body end -->
            </div>
        </div>
    </div>
</div>
@endsection