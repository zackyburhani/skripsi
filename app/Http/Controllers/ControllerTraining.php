<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTraining;
use App\Models\WordFrequency;
use App\Models\TwitterStream;
use DB;

class ControllerTraining extends Controller
{
    public function index()
    {
        $title = "Data Training";
        $data_positif = WordFrequency::where('kategori','Positif')->get();
        $data_negatif = WordFrequency::where('kategori','Negatif')->get();
        $data_netral = WordFrequency::where('kategori','Netral')->get();
        $total = WordFrequency::count();

        $distinct = DB::select("SELECT count(*) as total FROM (SELECT kata FROM term_frequency GROUP by kata) as x");
        foreach($distinct as $dst){
            $distinctWords = $dst->total;
        }
        $uniqueWords = $distinctWords;

        // return $data;
        return view('data_training', compact(['title','uniqueWords','data_positif','data_negatif','data_netral','total']));
    }

    public function hapus_training($kategori)
    {
        $data_training = TwitterStream::where('kategori',$kategori)->delete();
        return redirect('/training');
    }

}
