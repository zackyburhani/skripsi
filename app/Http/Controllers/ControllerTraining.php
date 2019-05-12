<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTraining;
use App\Models\WordFrequency;
use App\Models\TwitterStream;

class ControllerTraining extends Controller
{
    public function index()
    {
        $title = "Data Training";
        $data_positif = WordFrequency::where('kategori','Positif')->get();
        $data_negatif = WordFrequency::where('kategori','Negatif')->get();
        $data_netral = WordFrequency::where('kategori','Netral')->get();
        $total = WordFrequency::count();
        // return $data;
        return view('data_training', compact(['title','data_positif','data_negatif','data_netral','total']));
    }

    public function hapus_training($kategori)
    {
        $data_training = TwitterStream::where('kategori',$kategori)->delete();
        return redirect('/training');
    }
}
