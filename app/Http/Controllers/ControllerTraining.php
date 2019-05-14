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
        try {
            $title = "Data Training";
            $spam = "Positif";
            $ham = "Negatif";
            $net = "Netral";
            $class['class'] = [$spam,$ham,$net];

            $data_positif = WordFrequency::where('kategori','Positif')->get();
            $data_negatif = WordFrequency::where('kategori','Negatif')->get();
            $data_netral = WordFrequency::where('kategori','Netral')->get();
            $total = WordFrequency::count();

            foreach($class['class'] as $cls){
                $sum = DB::table('term_frequency')->select(DB::raw('SUM(jumlah) as jumlah_term'))->where('kategori',$cls)->whereNotNull('id_training')->first();   
                $data_sum[] = [
                    'kelas' => $cls,
                    'jumlah' => $sum->jumlah_term,
                ];
            }

            $distinct = DB::select("SELECT count(*) as total FROM (SELECT kata FROM term_frequency GROUP by kata) as x");
            foreach($distinct as $dst){
                $distinctWords = $dst->total;
            }
            $uniqueWords = $distinctWords;

            //cari prior
            $i = 0;
            foreach($class['class'] as $cls)
            {
                $Count = DB::table('data_training')
                            ->join('data_crawling', 'data_training.id_crawling', '=', 'data_crawling.id_crawling')
                            ->select('kategori')
                            ->where('kategori', '=', $cls)
                            ->count();
                // $Count = DataTraining::where('kategori',$cls)->count();
                $totalCount = DataTraining::count();
                $prior[] = [
                    'kelas' => $cls,
                    'nilai' => $Count / $totalCount,
                ];
            }
            // return $data;
            return view('data_training', compact(['title','data_sum','prior','uniqueWords','data_positif','data_negatif','data_netral','total']));
        }
        catch (\Exception $e) {
            return redirect('/crawling')->with('status', 'Data Training Tidak Ditemukan !');
        }
    }

    public function hapus_training($kategori)
    {
        $data_training = TwitterStream::where('kategori',$kategori)->delete();
        return redirect('/training');
    }

}
