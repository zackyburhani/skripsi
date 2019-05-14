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
        // $data = TwitterStream::where('proses',"0")->orderBy('id_crawling','DESC')->get();
        $data = TwitterStream::orderBy('id_crawling','DESC')->get();
        return view('crawling', compact(['title','data']));
    }

    public function crawling_data(Request $request)
    {
        try {
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
            return redirect('/crawling')->with('sukses', 'Data Berhasil Diproses !');
        }
        catch (\Exception $e) {
            return redirect('/crawling')->with('status', 'Tidak Dapat Memproses Data !');
        }
    }

    public function export($format)
    {
        $name = 'data_crawling_'.Carbon::now()->format('d_m_Y');
        if($format == 'xlsx'){
            return Excel::create($name, function($excel) {
                $excel->sheet('Data Crawling', function($sheet) {
                    // $twitter = TwitterStream::where('proses',"0")->get();
                    $twitter = TwitterStream::all();
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
                            'label' =>$key->kategori
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
                    // $twitter = TwitterStream::where('proses',"0")->get();
                    $twitter = TwitterStream::all();
                    if($twitter == ""){
                        return response()->json(null);
                    }
                    foreach ($twitter as $key) {
                        
                        $cetak[] = [
                            "tweet" => $key->tweet,
                            ";" => ";",
                            "label" => $key->kategori,
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
            // if($excel->ubah_class != ""){
            //     $upload = TwitterStream::where('id', $excel->id)->update(['class' => $excel->ubah_class]);
            // }
            $twitter = new TwitterStream();
            $twitter->username = $excel->username;
            $twitter->tweet_id = $excel->tweet_id;
            $twitter->tgl_tweet = Carbon::parse($excel->tgl_tweet)->format('Y-m-d');
            $twitter->status = null;
            $twitter->proses = "0";
            if($excel->label == "") {
                $twitter->kategori = "Netral";    
            } else {
                $twitter->kategori = $excel->label;
            }
            $twitter->tweet = $excel->tweet;
            $upload = $twitter->save();
        }
        if($upload){
            return response()->json(true);
        } else {
            return response()->json(error);
        }
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

    public function refresh_crawling()
    {
        $crawling = TwitterStream::query()->delete();
        return redirect('/crawling');
        
    }
}
