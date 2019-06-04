<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTraining;
use App\Models\WordFrequency;
use App\Models\Sentimen;
use App\Models\TwitterStream;
use Illuminate\Http\Respons;
use DB;

class ControllerTraining extends Controller
{
    public function index()
    {
        try {
            $title = "Data Training";
            foreach(Sentimen::all() as $stm){
                $class['class'][] = $stm->kategori;
                $data_training[$stm->kategori] = WordFrequency::where('id_sentimen',$stm->id_sentimen)->whereNotNull('id_training')->get();
            }
            
            // $data_negatif = WordFrequency::where('kategori','Negatif')->get();
            // $data_netral = WordFrequency::where('kategori','Netral')->get();
            $total = WordFrequency::count();
            
            foreach($class['class'] as $cls){
                $sum = DB::table('term_frequency')->select(DB::raw('SUM(jumlah) as jumlah_term'))->join('sentimen', 'sentimen.id_sentimen', '=', 'term_frequency.id_sentimen')->where('sentimen.kategori',$cls)->whereNotNull('id_training')->first();   
                $data_sum[] = [
                    'kelas' => $cls,
                    'jumlah' => $sum->jumlah_term,
                ];
            }

            $distinct = DB::select("SELECT count(*) as total FROM (SELECT kata FROM term_frequency WHERE term_frequency.id_training is not null GROUP by kata) as x");
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
                            ->join('sentimen', 'sentimen.id_sentimen', '=', 'data_crawling.id_sentimen')
                            ->select('sentimen.kategori as kategori')
                            ->where('sentimen.kategori', '=', $cls)
                            ->count();
                // $Count = DataTraining::where('kategori',$cls)->count();
                $totalCount = DataTraining::count();
                $prior[] = [
                    'kelas' => $cls,
                    'nilai' => $Count / $totalCount,
                ];
            }
            // return $prior;
            return view('data_training', compact(['title','data_sum','prior','uniqueWords','data_training','total']));
        }
        catch (\Exception $e) {
            return redirect('/crawling')->with('status', 'Data Training Tidak Ditemukan !');
        }
    }

    public function hapus_training($kategori)
    {
        $sentimen = Sentimen::where('kategori',$kategori)->first();
        $data_training = TwitterStream::where('id_sentimen',$sentimen->id_sentimen)->delete();
        return redirect('/training');
    }

    public function data_sentimen()
    {
        $data_training = Sentimen::all();
        return response()->json($data_training);
    }

}
