@extends('template.index')

@section('main')
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo "100"  ?></h3>

                    <p>Data Crawling</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users fa-fw"></i>
                </div>
                <a href="<?php ?>" class="small-box-footer">Lihat Selengkapnya <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo "2" ?></h3>

                    <p>Data Kriteria</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tag"></i>
                </div>
                <a href="<?php  ?>" class="small-box-footer">Lihat Selengkapnya <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo "3" ?></h3>

                    <p>Data Subkriteria</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tags"></i>
                </div>
                <a href="<?php ?>" class="small-box-footer">Lihat Selengkapnya <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
</section>
<!-- right col -->
@endsection