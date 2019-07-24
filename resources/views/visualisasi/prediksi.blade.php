@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-file-text"></i> Hasil Perhitungan
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/hasil-perhitungan"><i class="fa fa-file-text"></i> Hasil Perhitungan</a></li>
    </ol>
</section>

@if($testing_data == 0)
<section class="content">
    <div class="panel panel-default">
        <div class="panel-body">
            <center>
                <h3>Data <i>Testing</i> Tidak Ditemukan</h3>
            </center>
        </div>
    </div>
</section>
@else
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li><a href="{{ url('visualisasi-data') }}">Visualisasi Data</a></li>
                            <li class="active"><a href="{{ url('hasil-perhitungan') }}">Hasil Perhitungan</a></li>
                            <li><a href="{{ url('confusion-matrix') }}">Confusion Matriks</a></li>
                            <li><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="prediksi_sentimen">
                                <table style="table-layout:fixed" id="table-prediksi"
                                    class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="7%">
                                                <center>No.<center>
                                            </th>
                                            <th width="14%">
                                                <center>Username<center>
                                            </th>
                                            <th width="55%">
                                                <center>Tweet<center>
                                            </th>
                                            <th width="65px">
                                                <center>Actual<center>
                                            </th>
                                            <th width="65px">
                                                <center>Prediction</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        @foreach($collection as $key)
                                        <tr>
                                            <td align="center">{{$no++ ."."}}</td>
                                            <td align="center">{{$key['username']}}</td>
                                            <td align="left"><a data-toggle="modal"
                                                    href="" class="btnModalPrediksi" data-id_testing="{{$key['id_testing']}}"> {{$key['tweet']}}</a></td>
                                            <td align="center">{{$key['kategori']}}</td>
                                            <td align="center">{{$key['prediksi']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- modal --}}
<div class="modal fade" id="modal_detail_prediksi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form id="frmUpload" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-file"></i> Detail Perhitungan</h4>
                </div>
                <div class="modal-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_nbc" data-toggle="tab">Hasil Kategori Sentimen</a></li>
                            <li><a href="#tab_hitung" data-toggle="tab">Detail Perhitungan</a></li>
                            <li><a href="#tab_prepro" data-toggle="tab">Hasil <i>Preprocessing</i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_nbc">
                                <table style="table-layout:fixed" id="table-prediksi"
                                    class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="7%">
                                                <center>No.<center>
                                            </th>
                                            <th>
                                                <center>Hasil <i>Naïve Bayes Classifier (NBC)</i>
                                                    <center>
                                            </th>
                                            <th width="20%">
                                                <center>Kategori<center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="hasil-nbc-tbody">
                                        
                                    </tbody>
                                </table>
                                <hr>
                                <table>
                                    <tr>
                                        
                                        <td>Hasil Klasifikasi : <b id="hasil_klasifikasi"></b></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab_hitung">
                                <table style="table-layout:fixed" id="table-hasil"
                                    class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="7%">
                                                <center>No.<center>
                                            </th>
                                            <th>
                                                <center>Kata<center>
                                            </th>
                                            <th width="20%">
                                                <center>Kategori<center>
                                            </th>
                                            <th width="50%">
                                                <center>Hasil Perhitungan<center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="hasil-detail-tbody">
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab_prepro">
                                {{-- <div style="height: 250px; overflow: scroll;"> --}}
                                    <table style="table-layout:fixed" id="table-prediksi"
                                        class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="7%">
                                                    <center>No.<center>
                                                </th>
                                                <th>
                                                    <center>Hasil <i>Preprocessing</i><center>
                                            </tr>
                                        </thead>
                                        <tbody id="hasil-preprocessing-tbody">
                                            
                                        </tbody>
                                    </table>
                                {{-- </div> --}}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function () {
    $('#table-prediksi').DataTable();
});


$('.btnModalPrediksi').click( function(e) {
    e.preventDefault();

    try {
        $("#modal_detail_prediksi").modal('show');
        var id = $(this).data("id_testing");
        var url = $('#url_root').val();

        $.ajax({
            type: 'GET',
            url: url + "/get-detail-prediksi/" + id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data == 0){
                    swal({
                        icon: "warning",
                        title: "Gagal",
                        text: "Data Tidak Ditemukan",
                    });
                    return false;    
                } else {
                    hasil_preprocessing(data);
                    hasil_detail(data);
                    hasil_nbc(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
                $('.btn-preprocessing').attr('disabled',false);
                $('.btn-preprocessing i.fa-gear').removeClass('fa-spin');
                new PNotify({
                    title: 'Error !',
                    text: 'Terdapat Kesalahan Sistem',
                    type: 'error'
                });
            }
        });



        } catch (e) {
            console.log(e);
        }

});


$(document).on('click','.btn-danger',function(e) {
    var url = $('#url_root').val();
    var value = $(this).val();
    
    swal({
        title: "Warning !",
        text: "Anda Yakin Ingin Menghapus Data Testing ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal({
                icon: "success",
                title: "Berhasil",
                text: "Data Testing Berhasil Dihapus",
                timer: 3000
            }).then(function () {
                window.location.href = url + '/hapus-testing/' + value;
            });
        } else {
            swal.close();
        }
    });
});

function hasil_preprocessing(data) {
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.prepro.length; i++){
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td align="center">'+data.prepro[i]+'</td>';
        html = html + '</tr>';
    }
    $('#hasil-preprocessing-tbody').html(html);
}

function hasil_detail(data) {
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.detail.length; i++){
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td align="center">'+data.detail[i].kemunculan_kata+'</td>';
        html = html + '<td align="center">'+data.kelas_peluang[i]+'</td>';
        html = html + '<td align="center">'+data.detail[i].nilai_proses+'</td>';
        html = html + '</tr>';
    }
    $('#hasil-detail-tbody').html(html);
}

function hasil_nbc(data) {
    var html = '';
    var i;
    var no = 1;
    var tampung = [];
    for(i=0; i<data.nbc.length; i++){
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td align="center">'+data.nbc[i].vmap+'</td>';
        html = html + '<td align="center">'+data.nbc[i].sentimen.kategori+'</td>';
        html = html + '</tr>';
    tampung = data.nbc[i].vmap;
    }
    $('#hasil-nbc-tbody').html(html);
    $('#hasil_klasifikasi').text(data.hasil_klasifikasi);
}


</script>
@endsection