<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use App\Models\TwitterStream;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ControllerCrawlingTwitter extends Controller
{
    public function index()
    {
        $title = "Data Stream";
        $data = TwitterStream::orderBy('id_crawling','DESC')->get();
        return view('crawling', compact(['title','data']));
    }

    public function crawling_data(Request $request)
    {
        $keywords = $request->input('keywords');
        $count = $request->input('count');
        $tweets = Twitter::getSearch(['count' => $count, 'q' => $keywords,'tweet_mode' => 'extended', 'format' => 'json']);
        $someObject = json_decode($tweets);
        $data = $someObject->statuses;
        $konvert = json_encode($data); 
        $someObject = json_decode($konvert);
        for($i=0; $i<count($someObject) ; $i++) {
            $twitter = new TwitterStream;
            $twitter->tweet_id = $someObject[$i]->id;
            $twitter->username = $someObject[$i]->user->screen_name;
            $twitter->tweet = $someObject[$i]->full_text;
            $twitter->tgl_tweet = Carbon::parse($someObject[$i]->created_at);
            $twitter->status ="0";
            $twitter->save();
        }
        return redirect('/crawling');
    }

    public function export($format)
    {
        if($format == 'xlsx'){
            return Excel::create('data_crawling', function($excel) {
                $excel->sheet('Data Crawling', function($sheet) {
                    $twitter = TwitterStream::all();
                    if($twitter == ""){
                        return response()->json(null);
                    }
                    $i=1;
                    foreach ($twitter as $key) {
                        
                        $cetak[] = [
                            'No' => $i++,
                            'id' => $key->id_crawling,
                            'tweet_id' => $key->tweet_id,
                            'username' => $key->username,
                            'tweet' => $key->tweet,
                            'tgl_tweet' => $key->tgl_tweet,
                            'Ubah Class' =>''
                        ];
                    }
    
                    $sheet->cells('A1:G1', function ($cells) {
                        $cells->setBackground('#ffcc00');
                        $cells->setAlignment('center');
                    });
                    $sheet->setWidth(array(
                        'A' => 5,
                        'B' => 7,
                        'C' => 25,
                        'D' => 20,
                        'E' => 250,
                        'F' => 10,
                        'G' => 10
                    ));
                    $sheet->fromModel($cetak);
                });
            })->download($format);
        } else {
            return Excel::create('data_crawling', function($excel) {
                $excel->sheet('Data Crawling', function($sheet) {
                    $twitter = TwitterStream::all();
                    if($twitter == ""){
                        return response()->json(null);
                    }
                    foreach ($twitter as $key) {
                        
                        $cetak[] = [
                            "full_text" => $key->full_text,
                            // ";" => ";",
                            // "Class" => $key->class,
                        ];
                    }
                    $sheet->fromModel($cetak);
                });
            })->download($format);
        }
    }

    public function upload(Request $request)
    {
        $filename = $request->file('data_crawling');
        $data = Excel::selectSheets('Data Crawling')->load($filename)->get();

        if(empty($data)){
            return response()->json(error);
        }

        foreach($data as $excel){
            if($excel->ubah_class != ""){
                $upload = TwitterStream::where('id', $excel->id)->update(['class' => $excel->ubah_class]);
            }
        }

        return $upload;
    }

    //useless 
    // private function tokenizing($data)
    // {
    //   $tokenizing = preg_replace('/[^A-Za-z0-9\  ]/', '', $data);
    //   $string = str_replace('  ', ' ', $tokenizing);
    //   $lower = strtolower($string);
    //   return $lower;
    // }

    public function destroy_crawling($id)
    {
        $crawling = TwitterStream::findOrFail($id);
        if($crawling){
            $crawling->delete();
            return response()->json(true);
        } else{
            return response()->json(error);
        } 
    }

    public function update_crawling(Request $request)
    {
        $sentimen = TwitterStream::find($request->id);
        if($sentimen){
            $sentimen->class = $request->klasifikasi;
            $sentimen->save();
            return response()->json($sentimen);
        } else{
            return response()->json(error);
        } 
    }
}
