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


        // $this->positif = "Positif";
        // $this->negatif = "Negatif";
        // $this->train('sepakbola indah menyerang', 'Olahraga');
        // $this->train('presiden menaikkan harga bbm', 'Politik');
        // $this->train('partai politik indonesia berburu suara', 'Politik');
        // $this->train('manchester united juara liga inggris', 'Olahraga');
        // $this->train('timnas indonesia gagal juara AFC', 'Olahraga');

        // chinese
        // $this->train('chinese beijing chinese', 'Chinese');
        // $this->train('chinese chinese shanghai', 'Chinese');
        // $this->train('chinese macao', 'Chinese');
        // $this->train('tokyo japan chinese', 'Japan');

        // auto
        
        // $this -> train('saturn dealers car', $this->positif);
        // $this -> train('toyota car tercel', $this->positif);

        // $this -> train('baseball game play', $this->negatif);
        // $this -> train('pulled muscle game',  $this->negatif);

        // $category = $this->classify('home runs game');

        // $classifier -> train('island hated thecors movie', $spam);
        // $this->train('i loved the movie', $this->positif);
        // $this->train('i hated the movie', $this->negatif);
        // $this->train('a great movie good movie', $this->positif);
        // $this->train('poor acting', $this->negatif);
        // $this->train('a good movie great acting',$this->positif);
        // $category = $this->classify('good movie acting');

        // $this -> train('dont buy', $this->negatif);
        // $this -> train('phone got hanged', $this->negatif);
        // $this -> train('battery drains fast', $this->negatif);

        // $this -> train('great camera', $this->positif);
        // $this -> train('durable phone', $this->positif);

        // colahraga
        // $this -> train('sepakbola indah menyerang', $this->positif);
        // $this -> train('presiden menaikkan harga bbm', $this->negatif);
        // $this -> train('partai politik indonesia berburu suara', $this->negatif);
        // $this -> train('manchester united juara liga inggris', $this->positif);
        // $this -> train('timnas indonesia gagal juara AFC', $this->positif);

        // $category[] = $this -> classify('chinese chinese chinese tokyo japan');
        // $category[] = $this -> classify('tokyo japan macao');
        // echo json_encode($category);
        $title = "Data analisa";
        $testing = DataTesting::count();
        return view('visualisasi.analisa', compact(['title','testing']));
    }

    public function confusion_matrix()
    {
        // try {

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
    
        // }    
        // catch (\Exception $e) {
        //     return redirect('/crawling')->with('status', 'Data Testing Tidak Ditemukan !');
        // }
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

    public function jumlah_kategori_cloud()
    {
        $klasifikasi = Klasifikasi::with('sentimen')->select('id_sentimen')->groupBy('id_sentimen')->get();
        return response()->json($klasifikasi);
    }

    public function prediksi()
    {
        $collection = array();
        $title = "Data Prediksi Sentimen";
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
        
        return view('visualisasi.prediksi', compact(['title','collection','testing_data','hasil']));
    }

    public function data_prediksi($id)
    {   
        $hasil = Hasil::where('id_testing',$id)->get();
        return $hasil;
    }

    public function data_cloud($kategori)
    {  
        // $data = DB::table("term_frequency")
        //         ->select(DB::raw("REPEAT(CONCAT(kata, ' '), jumlah) as string"))
        //         ->join('data_testing', 'term_frequency.id_testing', '=', 'data_testing.id_testing')
        //         ->join('data_crawling', 'data_crawling.id_crawling', '=', 'data_testing.id_crawling')
        //         ->join('sentimen', 'data_crawling.id_sentimen', '=', 'sentimen.id_sentimen')
        //         ->whereNull('term_frequency.id_training')
        //         ->WhereNotNull('term_frequency.id_testing')
        //         ->where('sentimen.kategori',$kategori)
        //         ->get();

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

    // public function classify($sentence) 
    // {   
    //     $keywordsArray = $this->tokenizing($sentence);
    //     $category = $this->decide($keywordsArray);
    //     return $category;
    // }

    // public function train($sentence, $category) 
    // {
    //     $spam = $this->positif;
    //     $ham = $this->negatif;

    //     if ($category == $spam || $category == $ham) {

    //         $training = new DataTraining();
    //         $training->tweet = $sentence;
    //         $training->kategori = $category;
    //         $training->save();
    //         $keywordsArray = $this->tokenizing($sentence);

    //         foreach ($keywordsArray as $word) {
    //             $count = WordFrequency::where([['kata', $word],['kategori',$category]])->count();
    //             if ($count == 0) {
    //                 $wordFrequency = new WordFrequency();
    //                 $wordFrequency->kata = $word;
    //                 $wordFrequency->kategori = $category;
    //                 $wordFrequency->jumlah = 1;
    //                 $wordFrequency->save();
    //             } else {
    //                 $wordFrequency = WordFrequency::where('kata',$word)->increment('jumlah', 1);
    //             }
    //         }
    //     } 
    // }

    // public function decide($keywordsArray) 
    // {
    //     $spam = $this->positif;
    //     $ham = $this->negatif;
    //     $class['class'] = [$spam,$ham];

    //     $hitung = 1;
    //     // $sql = mysqli_query($conn, "SELECT count(*) as total FROM (SELECT word FROM wordFrequency GROUP by word) as x");
    //     // $distinctWords = WordFrequency::select(WordFrequency::selectSub('word','x')->groupBy('word'))->count();
    //     $distinct = DB::select("SELECT count(*) as total FROM (SELECT kata FROM term_frequency GROUP by kata) as x");
    //     foreach($distinct as $dst){
    //         $distinctWords = $dst->total;
    //     }
    //     $uniqueWords = $distinctWords;

    //     foreach ($keywordsArray as $word) {

    //         foreach($class['class'] as $cls ){
    //             // $sql = mysqli_query($conn, "SELECT count as total FROM wordFrequency where word = '$word' and category = '$cls' ");
    //             // $wordCount = mysqli_fetch_assoc($sql);
    //             // $wordCount = WordFrequency::where([['word',$word], ['category',$cls]])->first();
    //             $wordC = DB::select("SELECT jumlah as total FROM term_frequency where kata = '$word' and kategori = '$cls' ");
    //             if($wordC == null){
    //                 $wordCount = null;
    //             } else {
    //                 foreach($wordC as $wC){
    //                     $wordCount = $wC->total;
    //                 }
    //             }

    //             $total[$cls][$word] = $wordCount;
    //             $wordSum = DB::table('term_frequency')->select(DB::raw('SUM(jumlah) as jumlah_term'))->where('kategori',$cls)->first();
    //             $sum[$cls] = $wordSum->jumlah_term;
                
    //             $prob = ($total[$cls][$word]+1)/($sum[$cls]+$uniqueWords);
    //             $value[$cls][$word][] = $prob; 
    //         }
    //     }	

    //     //cari prior
    //     $i = 0;
    //     foreach($class['class'] as $cls)
    //     {
    //         $Count = DB::table('data_training')
    //                     ->join('data_crawling', 'data_training.id_crawling', '=', 'data_crawling.id_crawling')
    //                     ->select('kategori')
    //                     ->where('kategori', '=', $cls)
    //                     ->count();
    //         // $Count = DataTraining::where('kategori',$cls)->count();
    //         $totalCount = DataTraining::count();
    //         $prior[$cls] = $Count / $totalCount;
    //     }

    //     foreach($value as $key => $val){
    //         foreach($val as $keys => $vals){
    //             $hitung = array_product($val[$keys]);
    //             $tam[$key][] = $hitung;
    //         }
    //         $multiply = array_product($tam[$key]);
    //         $final[$key] = $multiply*$prior[$key];
    //     }
        
    //     // echo json_encode($final); die();
    //     arsort($final);
    //     $category = key($final);
    //     return $category;
    // }

    // public function tokenizing($string)
    // {
    //     $array = explode(' ', $string);
    //     return $array;
    // }

}
