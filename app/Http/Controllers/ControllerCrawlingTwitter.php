<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use App\Models\TwitterStream;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exceptions\Handler;

class ControllerCrawlingTwitter extends Controller
{
    public function index()
    {
        $title = "Data Stream";
        $data = TwitterStream::where('proses',"0")->orderBy('id_crawling','DESC')->get();
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
            $twitter->proses = "0";
            $twitter->kategori = "Netral";
            $twitter->save();
        }
        return redirect('/crawling');
    }

    public function export($format)
    {
        $name = 'data_crawling_'.Carbon::now()->format('d_m_Y');
        if($format == 'xlsx'){
            return Excel::create($name, function($excel) {
                $excel->sheet('Data Crawling', function($sheet) {
                    $twitter = TwitterStream::where('proses',"0")->get();
                    if($twitter == ""){
                        return response()->json(null);
                    }
                    $i=1;
                    foreach ($twitter as $key) {
                        
                        $cetak[] = [
                            'No' => $i++,
                            'tgl_tweet' => Carbon::parse($key->tgl_tweet)->format('d-m-Y'),
                            'tweet_id' => $key->tweet_id,
                            'username' => $key->username,
                            'tweet' => $key->tweet,
                            'label' =>''
                        ];
                    }
    
                    $sheet->cells('A1:F1', function ($cells) {
                        $cells->setBackground('#ffcc00');
                        $cells->setAlignment('center');
                    });
                    $sheet->setWidth(array(
                        'A' => 5,
                        'B' => 10,
                        'C' => 20,
                        'D' => 20,
                        'E' => 250,
                        'F' => 10
                    ));
                    $sheet->fromModel($cetak);
                });
            })->download($format);
        } else {
            return Excel::create($name, function($excel) {
                $excel->sheet('Data Crawling', function($sheet) {
                    $twitter = TwitterStream::where('proses',"0")->get();
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
            $sentimen->kategori = $request->klasifikasi;
            $sentimen->save();
            return response()->json($sentimen);
        } else{
            return response()->json(error);
        } 
    }
}
