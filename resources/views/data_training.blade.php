@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-list-alt"></i> Data Training
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/crawling"><i class="fa fa-list-alt"></i> Data Training</a></li>
    </ol>
</section>

<section class="content">
    @foreach($data_training as $key => $val)
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                @if(COUNT($val) != 0)
                    <h4 class="title">Daftar {{$key}} <button value="{{$key}}" class="btn btn-danger btn-xs btn-fill pull-right"><i class="fa fa-trash"></i> Hapus Data Training {{$key}}</button></h4>
                    <hr>
                    <table style="table-layout:fixed" id="table_{{$key}}" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5px"><center>No.<center></th>
                                <th width="100px"><center>Kata<center></th>
                                <th width="100px"><center>Frequency</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; ?>
                            @foreach($val as $row => $content)
                            <tr>
                                <td align="center">{{$no++ ."."}}</td>
                                <td align="center">{{$content->kata}}</td>
                                <td align="center">{{$content->jumlah}}</td>
                            </tr>           
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p><b><center>Data {{$key}} Tidak Ditemukan</center></b></p>
                @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                     <table>
                        <tbody>
                            @foreach($prior as $pr)
                            <tr>
                                <td width="130px"><h4>Prior {{$pr['kelas']}}</h4></td>
                                <td width="15px"><h4>:</h4></td>
                                <td width="100px"><h4>{{round($pr['nilai'],2)}}</h4></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                     <table>
                        <tbody>
                            @foreach($data_sum as $sum)
                            <tr> 
                                <td width="160px"><h4>Frequency {{$sum['kelas']}}</h4></td>
                                <td width="10px"><h4>:</h4></td>
                                <td width="100px"><h4>{{$sum['jumlah']}}</h4></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                     <table>
                        <tbody>
                            <tr> 
                                <td width="160px"><h4>Total Kata Unik</h4></td>
                                <td width="10px"><h4>:</h4></td>
                                <td width="100px"><h4>{{$uniqueWords}}</h4></td>
                            </tr>
                            <tr>
                                <td><h4>Total Data Training</h4></td>
                                <td><h4>:</h4></td>
                                <td><h4>{{$total}}</h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script text="text/javascript">
$(document).ready( function () {
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    var url = $('#url_root').val();
    $.ajax({
        type: 'GET',   
        url: url + "/data-sentimen",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            $.each( data, function( key, value ) {
                var id = '#table_'+value.kategori;
                $(id).DataTable();
            });
        },
        error: function (data) {
            console.log('Error:', data);
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });
});

$(document).on('click','.btn-danger',function(e) {
    var url = $('#url_root').val();
    var value = $(this).val();
    
    swal({
        title: "Anda Yakin Ingin Menghapus Data Training "+ value + " ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.location.href = url + '/hapus-training/' + value;
        } else {
            swal.close();
        }
    });
});
</script>
@endsection