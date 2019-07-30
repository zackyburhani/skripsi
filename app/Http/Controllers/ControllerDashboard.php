<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwitterStream;
use App\Models\Sentimen;
use Illuminate\Support\Facades\Storage;

class ControllerDashboard extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $data_crawling = TwitterStream::count();
        $sentimen = Sentimen::count();
        $kata = Storage::get('public/preprocessing/katadasar/katadasar.txt');
        $stop_list = Storage::get('public/preprocessing/stopword/stopword.txt');

        if(file_exists("storage/preprocessing/katadasar/katadasar.txt")){
            $stemming = $this->total_file($kata);
        }else{
            $stemming = 0;
        }

        if(file_exists("storage/preprocessing/stopword/stopword.txt")){
            $stopword = $this->total_file($stop_list);
        }else{
            $stopword = 0;
        }

        return view('dashboard', compact('title','sentimen','stemming','stopword','data_crawling'));
    }

    private function total_file($param)
    {
        $code = preg_replace('/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n",$param)));
        $kata = explode("\n",$code);
        $count = count($kata);
        return $count;
    }

    public function searchPage(Request $request)
    {
        if($request->search == ""){
            return redirect('/');
        }

        return redirect($request->search);
    }
}
