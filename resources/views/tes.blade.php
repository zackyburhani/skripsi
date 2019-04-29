@extends('template.index')

@section('main')
<table id="allpost" class="table table-striped table-bordered table-list">
    <thead>
        <tr>

            <th>id</th>
            <th>category_id</th>
            <th>title</th>
            <th>action</th>
        </tr>
    </thead>

</table>


<tbody>
    <?php $no=1; ?>
    @foreach($data as $key)
    <tr>
        <td align="center">{{$no++."."}}</td>
        <td>{{$key->screen_name}}</td>
        <?php if($key->class == 'positif') { ?>
            <td style="color:#0074D9"><span id="{{$key->id}}">{{$key->full_text}}</span></td> 
        <?php } else if($key->class == 'negatif') { ?>
            <td style="color:#FF4136"><span id="{{$key->id}}">{{$key->full_text}}</span></td>
        <?php } else { ?>
            <td>{{$key->full_text}}</td>
        <?php } ?>
        <td align="center">
            <select class="dropdown form-control" name="klasifikasi" onchange="class_sentiment(this.value)">
                <option style="color:red" <?php if($key->class=="netral") echo 'selected="selected"'; ?> value="{{$key->id}}|netral">Netral</option>
                <option <?php if($key->class=="positif") echo 'selected="selected"'; ?> value="{{$key->id}}|positif">Positif</option> 
                <option <?php if($key->class=="negatif") echo 'selected="selected"'; ?> value="{{$key->id}}|negatif">Negatif</option>                   
           </select>
        </td>
        <td align="center">
        <button class="btn btn-danger delete-tweet" value="{{$key->id}}" type="button"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    @endforeach
</tbody>

<script type="text/javascript">
	$(function(){
		$("#allpost").DataTable({
			 processing: true,
		        serverSide: true,
            type : "get",
            datatype : "json",
		        ajax: '{{ url("tes") }}',
		        columns: [
              
		            { data: 'id', name: 'id' },
		            { data: 'tweet_id', name: 'tweet_id' },
		            { data: 'full_text', name: 'full_text' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                
		        ]
		});
	});	
</script>
@endsection