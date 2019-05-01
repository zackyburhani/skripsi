<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTraining;
use App\Models\WordFrequency;
use App\Models\Klasifikasi;
use DB;

class ControllerAnalisa extends Controller
{
    public $positif;
    public $negatif;

    public function index()
    {
        $this->positif = "Positif";
        $this->negatif = "Negatif";
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
        return view('analisa', compact(['title']));
    }

    public function confusion_matrix()
    {
        $title = "Data Confusion Matrix";
        return view('confusion_matrix', compact(['title']));
    }

    public function word_cloud()
    {
        $title = "Data Word Cloud";
        return view('word_cloud', compact(['title']));
    }

    public function data_cloud()
    {  
        $data = DB::table("term_frequency")
                ->select(DB::raw("REPEAT(CONCAT(kata, ' '), jumlah) as string"))
                ->get();

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
                ->select('prediksi as name',DB::raw('COUNT(*) as y'))
                ->groupBy('prediksi')
                ->get();
        return $data;
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

    public function tokenizing($string)
    {
        $array = explode(' ', $string);
        return $array;
    }

}
