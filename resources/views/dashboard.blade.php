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

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <p><b>Analisis Sentimen Perbankan Indonesia </b></p>
            </h3>
            <div class="box-tools pull-right">
                <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse"
                    data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i
                        class="fa fa-times"></i></button>
            </div>
        </div>
        <div style="display: block;" class="box-body">
            <b1>
                <p><b>Tentang Aplikasi :</b></p>
                <p>2. Aplikasi Dapat Melakukan <i>Crawling Data Tweet</i> Secara <i>Real-time</i> </p>
                <p>2. Aplikasi Dapat Mengklasifikasikan Sentimen Kedalam Tiga Kelas : Positif, Negatif & Netral</p>
                <p>3. Klasifikasi Menggunakan Algoritme <i>Naïve Bayes Classifier</i> </p>
                <p>4. Preprocessing Terdiri Dari 5 tahap : <i>Case Folding</i>, <i>Cleansing</i>, <i>Tokenizing</i>, <i>Stopword</i> Dan <i>Stemming</i></p>
                <p>5. Menggunakan Algoritme Nazief & Adriani Pada Proses Stemming</p>
                <p>5. Visualisasi Data Menggunakan <i>Pie Chart</i>,<i>Column Chart</i> Dan <i>Word Cloud</i></p>
                <p>5. Pengujian Akurasi Menggunakan Metode <i>Confusion Matrix</i></p>
            </b1>
        </div><!-- /.box-body -->
    </div>


</section>
<!-- right col -->
@endsection