<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerStemming;
use App\Models\TwitterStream;
use App\Models\Stopword;
use App\Models\DataTraining;
use App\Models\WordFrequency;
use App\Models\DataTesting;
use App\Models\Klasifikasi;
use Illuminate\Http\Respons;
use DB;

class ControllerPreprocessing extends Controller
{
    public function preprocessing()
    {
        $title = "Data Preprocessing";
        return view('preprocessing', compact('title'));
    }
   
    public function store_preprocessing()
    {
        $twitter = TwitterStream::where('proses',"0")->get();
        if(count($twitter) == 0){
            return response()->json(0);
        }
        foreach($twitter as $tweet){
            $preprocessing = $tweet->tweet;
            $case_folding = $this->case_folding($preprocessing);
            $cleansing = $this->cleansing($case_folding);
            $tokenizing = $this->tokenizing($cleansing);
            $stopword = $this->stopWord($tokenizing);
            $stemming = $this->stemming($stopword);
            $data[] = [
                'case_folding' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $case_folding
                ],
                'cleansing' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $cleansing
                ],
                'tokenizing' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $tokenizing
                ],
                'stopword' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $stopword
                ],
                'stemming' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $stemming
                ],
            ];
        }
        // return $data;
        return $this->convert_from_latin1_to_utf8_recursively($data);
    }

    private function case_folding($data)
    {
        // $unicode = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $data);
        $lower = strtolower($data);
        return $lower;
    }

    private function cleansing($data)
    {
        $data = preg_replace('/#([\w-]+)/i', '', $data); //  #remove tag
        $data = preg_replace('/@([\w-]+)/i', '', $data); // #remove @someone
        $data = str_replace('rt : ', '', $data); // #remove RT
        $data = str_replace(',', '  ', $data);
        $data = str_replace('.', '  ', $data);
        $data = preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $data); //remove url
        $data = preg_replace('/[^A-Za-z0-9\  ]/', '', $data);
        $data = trim(preg_replace('/\s+/', ' ', $data));
        return $data;
    }

    public function tokenizing($string)
    {
        $array = explode(' ', $string);
        return $array;
    }

    public function stopWord($data) 
    {
        $searchString = implode(" ",$data);
        $stopwords = Stopword::all();
        foreach($stopwords as $stop){
            $list[] = $stop->stopword;
        }
        $wordsFromSearchString = str_word_count($searchString, true);
        $finalWords = array_diff($wordsFromSearchString, $list);
        $implode = implode(" ", $finalWords);
        $array = $this->tokenizing($implode);
        return $array;
    }

    public function stemming($kata)
    {
        $stemming = new ControllerStemming();
        $term = array();
        foreach($kata as $value){
            /* 1. Cek Kata di Kamus jika Ada SELESAI */
            if($stemming->ceKamus($value)){ // Cek Kamus
                array_push($term,$value); // Jika Ada push kedalam array
                continue;
            }
            /* 2. Buang Infection suffixes (\-lah", \-kah", \-ku", \-mu", atau \-nya") */
            $value = $stemming->Del_Inflection_Suffixes($value);

            /* 3. Buang Derivation suffix (\-i" or \-an") */
            $value = $stemming->Del_Derivation_Suffixes($value);

            /* 4. Buang Derivation prefix */
            $value = $stemming->Del_Derivation_Prefix($value);
            
            array_push($term,$value);
        }
        return $term;
    }

    //Unicode
    private static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

            return $dat;
        } else {
            return $dat;
        }
   }

   public function data_latih()
   {
        $twitter = TwitterStream::where('proses',"0")->get();
        foreach($twitter as $tweet => $value){
            $preprocessing = $value->tweet;
            $case_folding = $this->case_folding($preprocessing);
            $cleansing = $this->cleansing($case_folding);
            $tokenizing = $this->tokenizing($cleansing);
            $stopword = $this->stopWord($tokenizing);
            $stemming = $this->stemming($stopword);

            //simpan data training
            $data_latih = new DataTraining();
            $data_latih->id_crawling = $value->id_crawling;
            $data_latih->save();

            //update status data crawling
            $crawling = TwitterStream::where('id_crawling',$value->id_crawling)->update(['status' => "0"]);

            //update proses data crawling
            $crawling = TwitterStream::where('id_crawling',$value->id_crawling)->update(['proses' => "1"]);

            //simpan frekuensi
            for($i=0; $i<count($stemming); $i++){
                $count = WordFrequency::where([['kata', $stemming[$i]],['kategori',$value->kategori]])->count();
                if ($count == 0) {
                    $id_training = DataTraining::where('id_crawling',$value->id_crawling)->first();
                    $wordFrequency = new WordFrequency();
                    $wordFrequency->kata = $stemming[$i];
                    $wordFrequency->kategori = $value->kategori;
                    $wordFrequency->jumlah = 1;
                    $wordFrequency->id_training = $id_training->id_training;
                    $wordFrequency->save();
                } else {
                    $wordFrequency = WordFrequency::where([['kata',$stemming[$i]],['kategori',$value->kategori]])->increment('jumlah', 1);
                }
            }
        }
   }

   public function data_uji()
   {
        $twitter = TwitterStream::where('proses',"0")->get();
        foreach($twitter as $tweet => $value){
            $data_testing = new DataTesting();
            $data_testing->id_crawling = $value->id_crawling;
            $data_testing->save();
            
            //update status data crawling
            $crawling = TwitterStream::where('id_crawling',$value->id_crawling)->update(['status' => "1"]);

            //update proses data crawling
            $crawling = TwitterStream::where('id_crawling',$value->id_crawling)->update(['proses' => "1"]);
        
            //ambil data testing dan klasifikasikan dengan NBC
            $analisa = DataTesting::with(['data_crawling'])->where('id_crawling',$value->id_crawling)->first();
            $kategori = $this->classify($analisa->data_crawling->tweet);
            
            //simpan klasifikasi
            $klasifikasi = new Klasifikasi();
            $klasifikasi->prediksi = $kategori;
            $klasifikasi->id_testing = $analisa->id_testing;
            $klasifikasi->save();
        }
   }

    private function classify($sentence) 
    {   
        $case_folding = $this->case_folding($sentence);
        $cleansing = $this->cleansing($case_folding);
        $tokenizing = $this->tokenizing($cleansing);
        $stopword = $this->stopWord($tokenizing);
        $stemming = $this->stemming($stopword);
        $category = $this->decide($stemming);
        return $category;
    }

    private function decide($keywordsArray) 
    {
        $spam = "Positif";
        $ham = "Negatif";
        $class['class'] = [$spam,$ham];

        $hitung = 1;
        // $sql = mysqli_query($conn, "SELECT count(*) as total FROM (SELECT word FROM wordFrequency GROUP by word) as x");
        // $distinctWords = WordFrequency::select(WordFrequency::selectSub('word','x')->groupBy('word'))->count();
        $distinct = DB::select("SELECT count(*) as total FROM (SELECT kata FROM term_frequency GROUP by kata) as x");
        foreach($distinct as $dst){
            $distinctWords = $dst->total;
        }
        $uniqueWords = $distinctWords;

        foreach ($keywordsArray as $word) {

            foreach($class['class'] as $cls ){
                // $sql = mysqli_query($conn, "SELECT count as total FROM wordFrequency where word = '$word' and category = '$cls' ");
                // $wordCount = mysqli_fetch_assoc($sql);
                // $wordCount = WordFrequency::where([['word',$word], ['category',$cls]])->first();
                $wordC = DB::select("SELECT jumlah as total FROM term_frequency where kata = '$word' and kategori = '$cls' ");
                if($wordC == null){
                    $wordCount = null;
                } else {
                    foreach($wordC as $wC){
                        $wordCount = $wC->total;
                    }
                }

                $total[$cls][$word] = $wordCount;
                $wordSum = DB::table('term_frequency')->select(DB::raw('SUM(jumlah) as jumlah_term'))->where('kategori',$cls)->first();
                $sum[$cls] = $wordSum->jumlah_term;
                
                $prob = ($total[$cls][$word]+1)/($sum[$cls]+$uniqueWords);
                $value[$cls][$word][] = $prob; 
            }
        }	

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
            $prior[$cls] = $Count / $totalCount;
        }

        foreach($value as $key => $val){
            foreach($val as $keys => $vals){
                $hitung = array_product($val[$keys]);
                $tam[$key][] = $hitung;
            }
            $multiply = array_product($tam[$key]);
            $final[$key] = $multiply*$prior[$key];
        }
        
        // echo json_encode($final); die();
        arsort($final);
        $category = key($final);
        return $category;
    }

}
