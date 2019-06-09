@extends('template.index')

@section('main')
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1>
        <i class="fa fa-pie-chart"></i> Visualisasi Data
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="/analisa"><i class="fa fa-pie-chart"></i> Analisa Data</a></li>
    </ol>
</section>

@if($testing_data == 0)
<section class="content">
    <div class="panel panel-default">
        <div class="panel-body">
        <center><h3>Data <i>Testing</i> Tidak Ditemukan</h3></center>
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
                            <li><a href="{{ url('analisa') }}" >Klasifikasi</a></li>
                            <li><a href="{{ url('prediksi-sentimen') }}">Prediksi Sentimen</a></li>
                            <li ><a href="{{ url('confusion-matrix') }}" >Confusion Matriks</a></li>
                            <li class="active"><a href="{{ url('word-cloud') }}">Word Cloud</a></li>
                            <li class="pull-right">
                                <button class="btn btn-danger btn-xs btn-fill pull-right"><i class="fa fa-trash"></i> Hapus Data Testing </button>
                            </i>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="matriks">
                                @foreach($klasifikasi as $class => $val)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div id="container_{{$val->sentimen->kategori}}"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
{{-- <script src="{{asset('js/kosakata/emoticon.js')}}"></script> --}}

<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            beforeSend: function (xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr(
                        'content'));
                }
            },
        });
        var url = $('#url_root').val();
        $.ajax({
            type: "GET",
            url: url + '/jumlah-kategori-cloud/',
            success: function (data) {
                $.each( data, function( key, value ) {
                    $.ajax({
                        type: "GET",
                        url: url + '/data-cloud/'+value.sentimen.id_sentimen,
                        success: function (string) {
                            var chart = 'container_'+value.sentimen.kategori
                            var text = string;
                            var lines = text.split(/[,\. ]+/g);
                                data = Highcharts.reduce(lines, function (arr, word) {
                                    var obj = Highcharts.find(arr, function (obj) {
                                        return obj.name === word;
                                    });
                                    if (obj) {
                                        obj.weight += 1;
                                    } else {
                                        obj = {
                                            name: word,
                                            weight: 1
                                        };
                                        arr.push(obj);
                                    }
                                    return arr;
                                }, []);

                            Highcharts.chart(chart, {
                                series: [{
                                    type: 'wordcloud',
                                    data: data,
                                    name: 'Kemunculan'
                                }],
                                title: {
                                    text: 'Sentimen '+value.sentimen.kategori
                                },
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
        // var text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum erat ac justo sollicitudin, quis lacinia ligula fringilla. Pellentesque hendrerit, nisi vitae posuere condimentum, lectus urna accumsan libero, rutrum commodo mi lacus pretium erat. Phasellus pretium pretium pretium pretium ultrices mi sed semper. Praesent ut tristique magna. Donec nisl tellus, sagittis ut tempus sit amet, consectetur eget erat. Sed ornare gravida lacinia. Curabitur iaculis metus purus, eget pretium est laoreet ut. Quisque tristique augue ac eros malesuada, vitae facilisis mauris sollicitudin. Mauris ac molestie nulla, vitae facilisis quam. Curabitur placerat ornare sem, in mattis purus posuere eget. Praesent non condimentum odio. Nunc aliquet, odio nec auctor congue, sapien justo dictum massa, nec fermentum massa sapien non tellus. Praesent luctus eros et nunc pretium hendrerit. In consequat et eros nec interdum. Ut neque dui, maximus id elit ac, consequat pretium tellus. Nullam vel accumsan lorem.';    
    });

$(document).on('click','.btn-danger',function(e) {
    var url = $('#url_root').val();
    var value = $(this).val();
    
    swal({
        title: "Anda Yakin Ingin Menghapus Data Testing ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.location.href = url + '/hapus-testing/' + value;
        } else {
            swal.close();
        }
    });
});
</script>
@endsection