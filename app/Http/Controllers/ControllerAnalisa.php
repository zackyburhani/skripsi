<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\DataTraining;
use App\Models\DataTesting;
use App\Models\WordFrequency;
use App\Models\Klasifikasi;
use App\Models\TwitterStream;
use App\Models\Hasil;
use App\Models\Sentimen;
use App\Http\Controllers\ControllerConfusionMatrix;

class ControllerAnalisa extends Controller
{
    public $positif = "Positif";
    public $negatif = "Negatif";
    public $netral = "Netral";

    public function index()
    {
        $title = "Data analisa";
        $testing = DataTesting::count();
        return view('visualisasi.analisa', compact(['title','testing']));
    }

    public function klasifikasi()
    {
        $data =  DB::table('klasifikasi')
                ->select('sentimen.kategori as name',DB::raw('COUNT(*) as y'))
                ->join('sentimen', 'sentimen.id_sentimen', '=', 'klasifikasi.id_sentimen')
                ->groupBy('sentimen.kategori')
                ->get();
        
        $sum = Klasifikasi::count();
        
        $tampung = array();
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
            $testing_data = DataTesting::count();
            // $confusionMatrix = new ControllerConfusionMatrix();

            // $actualLabels = ['TERLAMBAT', 'TEPAT', 'TERLAMBAT', 'TERLAMBAT', 'TEPAT'];
            // $predictedLabels = ['TERLAMBAT', 'TEPAT', 'TERLAMBAT', 'TERLAMBAT', 'TERLAMBAT'];

            // $actualLabels = ['Negatif', 'Positif', 'Negatif', 'Negatif', 'Positif'];
            // $predictedLabels = ['Negatif', 'Positif', 'Negatif', 'Negatif', 'Negatif'];

            $klasifikasi = Klasifikasi::with('sentimen')->get();

            foreach($klasifikasi as $kelas){
                $predictedLabels[] = $kelas->sentimen->kategori;
                $testing = DataTesting::where('id_testing',$kelas->id_testing)->first();
                $twitter = TwitterStream::with('sentimen')->where('id_crawling',$testing->id_crawling)->first();
                $actualLabels[] = $twitter->sentimen->kategori;
            }
            // echo $confusionMatrix = Accuracy::score($actualLabels, $predictedLabels);
            // return $confusionMatrix;

            $getPrecision = new ControllerConfusionMatrix($actualLabels, $predictedLabels);
            $accuracy = ControllerConfusionMatrix::score($actualLabels, $predictedLabels);
            $recall = $getPrecision->getRecall();
            $precision = $getPrecision->getPrecision();
            
            // $th = array_values(array_unique($actualLabels));
            // foreach(Sentimen::all() as $dt){
            //     $th[] = $dt->kategori;
            // }
            foreach($precision as $index_pc => $value_pc){
                $th[] = $index_pc;
            }
            
            sort($th);
            $confusionMatrix = ControllerConfusionMatrix::compute($actualLabels, $predictedLabels,$th);
            
            // $th = [$this->negatif,$this->netral,$this->positif];
            // $tr = [$this->negatif,$this->positif,$this->netral];
            $matrix = array();

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
        $title = "Data Prediksi Sentimen";
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

    public function data_prediksi($id)
    {   
        $hasil = Hasil::where('id_testing',$id)->get();
        return $hasil;
    }

    public function hapus_testing()
    {
        try{
            $data_training = TwitterStream::where('status','1')->delete();
            return redirect('/analisa')->with('sukses', 'Data Berhasil Dihapus !');
        }    
        catch (\Exception $e) {
            return redirect('/analisa')->with('status', 'Data Tidak Berhasil Dihapus');
        }
    }
}
