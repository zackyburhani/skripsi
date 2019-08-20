<?php

namespace App\Http\Controllers;

use DB;
use App\Models\DataTesting;
use App\Models\Klasifikasi;
use App\Models\TwitterStream;
use App\Models\Hasil;
use App\Models\Sentimen;
use App\Models\Proses;
use App\Http\Controllers\ControllerConfusionMatrix;
use App\Http\Controllers\ControllerPreprocessing;

class ControllerAnalisa extends Controller
{
    public function index()
    {
        $title = "Data analisa";
        $testing = DataTesting::count();
        return view('visualisasi.analisa', compact(['title','testing']));
    }

    public function klasifikasi()
    {
        $tampung = array();
        $sum = Klasifikasi::count();
        $data = DB::table('klasifikasi')
                ->select('sentimen.kategori as name',DB::raw('COUNT(*) as y'))
                ->join('sentimen', 'sentimen.id_sentimen', '=', 'klasifikasi.id_sentimen')
                ->groupBy('sentimen.kategori')
                ->get();
        
        foreach($data as $val){
            $tampung[] = [
                'name' => $val->name,
                'persentase' => $val->y,
                'y' => round($val->y/$sum*100,2)
            ];
        }
        return $tampung;
    }

    public function confusion_matrix()
    {
        try {
            $title = "Data Confusion Matrix";
            $matrix = array();
            $testing_data = DataTesting::count();
            $klasifikasi = Klasifikasi::with('sentimen')->get();

            foreach($klasifikasi as $kelas){
                $predictedLabels[] = $kelas->sentimen->kategori;
                $testing = DataTesting::where('id_testing',$kelas->id_testing)->first();
                $twitter = TwitterStream::with('sentimen')->where('id_crawling',$testing->id_crawling)->first();
                $actualLabels[] = $twitter->sentimen->kategori;
            }

            $getPrecision = new ControllerConfusionMatrix($actualLabels, $predictedLabels);
            $accuracy = ControllerConfusionMatrix::score($actualLabels, $predictedLabels);
            $recall = $getPrecision->getRecall();
            $precision = $getPrecision->getPrecision();

            foreach($precision as $index_pc => $value_pc){
                $th[] = $index_pc;
            }
            
            sort($th);
            $confusionMatrix = ControllerConfusionMatrix::compute($actualLabels, $predictedLabels,$th);

            foreach($th as $index_th => $value){
                $matrix[$value] = $confusionMatrix[$index_th];
                if(!array_key_exists($value,$recall)){
                    $recall[$value] = 0;
                } 
                if(!array_key_exists($value,$precision)){
                    $precision[$value] = 0;
                } 
            }

            ksort($precision);
            return view('visualisasi.confusion_matrix', compact(['title','testing_data','confusionMatrix','th','matrix','recall','precision','accuracy']));
        }    
        catch (\Exception $e) {
            return redirect('/crawling')->with('status', 'Data Testing Tidak Ditemukan !');
        }
    }

    public function column_drilldown()
    {
        try {
            $testing_data = DataTesting::count();
            $klasifikasi = Klasifikasi::with('sentimen')->get();

            foreach($klasifikasi as $kelas){
                $predictedLabels[] = $kelas->sentimen->kategori;
                $testing = DataTesting::where('id_testing',$kelas->id_testing)->first();
                $twitter = TwitterStream::where('id_crawling',$testing->id_crawling)->first();
                $actualLabels[] = $twitter->sentimen->kategori;
            }

            $getPrecision = new ControllerConfusionMatrix($actualLabels, $predictedLabels);
            $accuracy = ControllerConfusionMatrix::score($actualLabels, $predictedLabels);
            $error_rate = ControllerConfusionMatrix::error_rate($actualLabels, $predictedLabels);
            $recall = $getPrecision->getRecall();
            $precision = $getPrecision->getPrecision();
            $devide_recall = $getPrecision->getRecall();
            $devide_precision = $getPrecision->getPrecision();

            $precision_micro = $getPrecision->getPrecisionMicro();

            foreach(Sentimen::all() as $kelas){
                $a[] = $precision_micro[$kelas->kategori];
            }

            $micro_precision = array_sum($a)/ DataTesting::count();

            foreach ($devide_recall as $array_key1 => $array_item1) {
                if ($devide_recall[$array_key1] == 0) {
                  unset($devide_recall[$array_key1]);
                }
            }

            foreach ($devide_precision as $array_key2 => $array_item2) {
                if ($devide_precision[$array_key2] == 0) {
                  unset($devide_precision[$array_key2]);
                }
            }

            $sum_precision = array_sum($precision);
            $count_precision = count($devide_precision);
            $sum_recall = array_sum($recall);
            $count_recall = count($devide_recall);
            
            if($sum_precision == 0 && $count_precision == 0){
                $total_precision = 0;
            } else {
                $total_precision = $sum_precision/$count_precision;
            }

            if($sum_recall == 0 && $count_recall == 0){
                $total_recall = 0;
            } else {
                $total_recall = $sum_recall/$count_recall;
            }        

            $data[] = [
                'accuracy' => round($accuracy*100,2),
                'precision' => $precision,
                'recall' => $recall,
                'error_rate' => round($error_rate*100,2),
                'total_precision' => round($total_precision,2),
                'total_recall' => round($total_recall,2),
                'micro_precision' => round($micro_precision,4)*100,
            ]; 

            return response()->json($data);
        }
        catch (\Exception $e) {
            return response()->json(error);
        }
    }

    public function word_cloud()
    {
        $title = "Data Word Cloud";
        $testing_data = DataTesting::count();
        $klasifikasi = Klasifikasi::with('sentimen')->select('id_sentimen')->groupBy('id_sentimen')->get();
        return view('visualisasi.word_cloud', compact(['title','klasifikasi','testing_data']));
    }

    public function data_cloud($kategori)
    {  
        $data = DB::table("term_frequency")
                ->select(DB::raw("REPEAT(CONCAT(kata, ' '), jumlah) as string"))
                ->whereNull('term_frequency.id_training')
                ->WhereNotNull('term_frequency.id_testing')
                ->where('id_sentimen',$kategori)
                ->get();

        if(count($data) == 0){
            return null;
        }

        foreach($data as $dt){
            $string[] = $dt->string;
        }

        $str = implode(" ", $string);
        $str = trim(preg_replace('/\s+/', ' ', $str));
        return $str;
    }

    public function jumlah_kategori_cloud()
    {
        $klasifikasi = Klasifikasi::with('sentimen')->select('id_sentimen')->groupBy('id_sentimen')->get();
        return response()->json($klasifikasi);
    }

    public function prediksi()
    {
        $collection = array();
        $title = "Data Perhitungan Sentimen";
        $sentimen = Sentimen::all();
        $testing_data = DataTesting::count();
        $klasifikasi = DataTesting::with(['data_crawling','klasifikasi'])->get();

        foreach($klasifikasi as $class){
            $prediksi = Klasifikasi::with(['sentimen'])->where('id_testing',$class->id_testing)->first();
            $hasil = Hasil::where('id_testing',$class->id_testing)->get();
            $aktual = Sentimen::where('id_sentimen', $class->data_crawling->id_sentimen)->first();
            $collection[] = [
                'id_testing' => $class->id_testing,
                'username' => $class->data_crawling->username,
                'tweet' => $class->data_crawling->tweet,
                'kategori' => $aktual->kategori,
                'prediksi' => $prediksi->sentimen->kategori,
            ];
        }

        return view('visualisasi.prediksi', compact(['title','sentimen','collection','testing_data','hasil']));
    }


    public function getDetailPrediksi($id)
    {
        $sentimen = Sentimen::all();
        $data = DataTesting::with('data_crawling')->where('id_testing',$id)->first();
        $nbc = Hasil::with(['sentimen'])->where('id_testing',$id)->get();
        $detail_proses = Proses::where('id_testing',$id)->get();

        $preprocessing = new ControllerPreprocessing();
        $case_folding = $preprocessing->case_folding($data->data_crawling->tweet);
        $cleansing = $preprocessing->cleansing($case_folding);
        $tokenizing = $preprocessing->tokenizing($cleansing);
        $stopword = $preprocessing->stopword($tokenizing);
        $stemming = $preprocessing->stemming($stopword);

        foreach($sentimen as $label){
            foreach($stemming as $index_stemming => $value_stemming){
                $kelas_peluang[] = $label->kategori;
            }
        }

        foreach($nbc as $index_nbc){
            $tampung[$index_nbc->sentimen->kategori] = $index_nbc->vmap;
        }

        arsort($tampung); $hasil_klasifikasi = key($tampung);  ;

        $kumpulan = [
            'kelas_peluang' => $kelas_peluang,
            'hasil_klasifikasi' => $hasil_klasifikasi,
            'nbc' => $nbc,
            'detail' => $detail_proses,
            'prepro' => $stemming,
        ];

        return $kumpulan;
    }

    public function data_prediksi($id)
    {   
        $hasil = Hasil::where('id_testing',$id)->get();
        return $hasil;
    }

    public function hapus_testing()
    {
        try{
            $data_training = TwitterStream::where('status','1')->delete();
            return redirect('/visualisasi-data');
        }    
        catch (\Exception $e) {
            return redirect('/visualisasi-data')->with('status', 'Data Tidak Berhasil Dihapus');
        }
    }
}
