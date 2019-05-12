@extends('template.index')

@section('main')
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$data_crawling}}</h3>

                    <p>Data Crawling</p>
                </div>
                <div class="icon">
                    <i class="fa fa-twitter"></i>
                </div>
                <a href="/crawling" class="small-box-footer">Lihat Selengkapnya <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$stopword}}</h3>

                    <p>Stopwords</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
                <a href="/stopword" class="small-box-footer">Lihat Selengkapnya <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$stemming}}</h3>

                    <p>Kata Dasar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
                <a href="/kata-dasar" class="small-box-footer">Lihat Selengkapnya <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
</section>
<!-- right col -->
@endsection