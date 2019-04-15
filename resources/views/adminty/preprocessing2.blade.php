@extends('template.index')

@section('main')
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
                                                        <button class="btn btn-primary btn-preprocessing" value="preprocessing"><i class="fa fa-gears"></i> Mulai Preprocessing</button>
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
                                                        {{-- <div class="dt-responsive table-responsive"> --}}
                                                            <table class="">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="40px"><center>No.</center></th>
                                                                        <th width="150px"><center>Username</center></th>
                                                                        <th ><center>Tweet</center></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="casefolding-tbody">
                                                                </tbody>
                                                            </table>
                                                        {{-- </div> --}}
                                                    </div>
                                                    <div class="tab-pane" id="cleansing" role="tabpanel">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="table-cleansing" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="40px"><center>No.</center></th>
                                                                        <th width="150px"><center>Username</center></th>
                                                                        <th ><center>Tweet</center></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="cleansing-tbody">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="stopword" role="tabpanel">
                                                        <table id="table-stopword" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th width="40px"><center>No.</center></th>
                                                                    <th width="150px"><center>Username</center></th>
                                                                    <th ><center>Tweet</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="stopword-tbody">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="emoticon" role="tabpanel">
                                                        <table id="table-emoticon" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th width="40px"><center>No.</center></th>
                                                                    <th width="150px"><center>Username</center></th>
                                                                    <th ><center>Tweet</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="emoticon-tbody">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="negation" role="tabpanel">
                                                        <table id="table-negation" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th width="40px"><center>No.</center></th>
                                                                    <th width="150px"><center>Username</center></th>
                                                                    <th ><center>Tweet</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="negation-tbody">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="tokenizing" role="tabpanel">
                                                        <table id="table-tokenizing" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th width="40px"><center>No.</center></th>
                                                                    <th width="150px"><center>Username</center></th>
                                                                    <th ><center>Tweet</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tokenizing-tbody">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="stemming" role="tabpanel">
                                                        <table id="table-stemming" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th width="40px"><center>No.</center></th>
                                                                    <th width="150px"><center>Username</center></th>
                                                                    <th ><center>Tweet</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="stemming-tbody">
                                                            </tbody>
                                                        </table>
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


<script type="text/javascript">
$(document).on('click','.btn-preprocessing',function(e) {
    parameter = $(this).val();
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    e.preventDefault();
    var url = $('#url_root').val();
    $.ajax({
        type: 'POST',   
        url: url + "/preprocessing",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            casefolding_table(data);
            cleansing_table(data);
            stopword_table(data);
            new PNotify({
                title: 'Sukses !',
                text: 'Data Berhasil Diubah',
                type: 'success'
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

function casefolding_table(data)
{
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.length; i++){
        html += 
            '<tr>'+
                '<td align="center">'+ no++ +'.'+'</td>'+
                '<td>'+data[i].case_folding.screen_name+'</td>'+
                '<td class="anjing">'+data[i].case_folding.full_text+'</td>'+
            '</tr>';
    }
    $('#casefolding-tbody').html(html);
}

function cleansing_table(data)
{
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.length; i++){
        html += 
            '<tr>'+
                '<td align="center">'+ no++ +'.'+'</td>'+
                '<td>'+data[i].cleansing.screen_name+'</td>'+
                '<td>'+data[i].cleansing.full_text+'</td>'+
            '</tr>';
    }
    $('#cleansing-tbody').html(html);
}

function casefolding_table(data)
{
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.length; i++){
        html += 
            '<tr>'+
                '<td align="center">'+ no++ +'.'+'</td>'+
                '<td>'+data[i].case_folding.screen_name+'</td>'+
                '<td>'+data[i].case_folding.full_text+'</td>'+
            '</tr>';
    }
    $('#casefolding-tbody').html(html);
}

function stopword_table(data)
{
    var html = '';
    var i;
    var no = 1;
    for(i=0; i<data.length; i++){
        html += 
            '<tr>'+
                '<td align="center">'+ no++ +'.'+'</td>'+
                '<td>'+data[i].stopword.screen_name+'</td>'+
                '<td>'+data[i].stopword.full_text+'</td>'+
            '</tr>';
    }
    $('#stopword-tbody').html(html);
}

</script>

@endsection