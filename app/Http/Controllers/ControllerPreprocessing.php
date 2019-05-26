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
use App\Models\Hasil;
use App\Models\Sentimen;
use App\Models\Proses;
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
        $data_training = DataTraining::count();
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
                'training' => $data_training,
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
        $data = preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $data); //remove url
        $data = preg_replace('/#([\w-]+)/i', '', $data); //  #remove tag
        $data = preg_replace('/@([\w-]+)/i', '', $data); // #remove @someone
        $data = str_replace('rt : ', '', $data); // #remove RT
        $data = str_replace(',', '  ', $data);
        $data = str_replace('.', '  ', $data);
        $data = preg_replace('/[^A-Za-z0-9\  ]/', '', $data);
        $data = trim(preg_replace('/\s+/', ' ', $data));
        $data = (string)$data;

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
            if($stemming->cekKamus($value)){ // Cek Kamus
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
                $count = WordFrequency::where([['kata', $stemming[$i]],['id_sentimen',$value->id_sentimen],['id_testing',null]])->count();
                if ($count == 0) {
                    $id_training = DataTraining::where('id_crawling',$value->id_crawling)->first();
                    $wordFrequency = new WordFrequency();
                    $wordFrequency->kata = $stemming[$i];
                    $wordFrequency->id_sentimen = $value->id_sentimen;
                    $wordFrequency->jumlah = 1;
                    $wordFrequency->id_training = $id_training->id_training;
                    $wordFrequency->save();
                } else {
                    $wordFrequency = WordFrequency::where([['kata',$stemming[$i]],['id_testing',null],['id_sentimen',$value->id_sentimen]])->increment('jumlah', 1);
                }
            }
        }
   }

   public function data_uji()
   {
        $twitter = TwitterStream::where('proses',"0")->get();
        foreach($twitter as $tweet => $value){
            $preprocessing = $value->tweet;
            $case_folding = $this->case_folding($preprocessing);
            $cleansing = $this->cleansing($case_folding);
            $tokenizing = $this->tokenizing($cleansing);
            $stopword = $this->stopWord($tokenizing);
            $stemming = $this->stemming($stopword);

            $data_testing = new DataTesting();
            $data_testing->id_crawling = $value->id_crawling;
            $data_testing->save();
            
            //update status data crawling
            $crawling = TwitterStream::where('id_crawling',$value->id_crawling)->update(['status' => "1"]);

            //update proses data crawling
            $crawling = TwitterStream::where('id_crawling',$value->id_crawling)->update(['proses' => "1"]);
        
            //ambil data testing dan klasifikasikan dengan NBC
            $analisa = DataTesting::with(['data_crawling'])->where('id_crawling',$value->id_crawling)->first();
            $kategori = $this->classify($analisa->data_crawling->tweet,$analisa->id_testing);
            
            //ambil data hasil
            $hasil = Hasil::where('id_testing', $analisa->id_testing)->first();
            
            //simpan klasifikasi
            $klasifikasi = new Klasifikasi();
            $klasifikasi->id_sentimen = $kategori['hasil'];
            $klasifikasi->id_testing = $analisa->id_testing;
            $klasifikasi->id_hasil = $hasil->id_hasil;
            $klasifikasi->save();
            
            //simpan frekuensi
            for($i=0; $i<count($stemming); $i++){
                $count = WordFrequency::where([['kata', $stemming[$i]],['id_sentimen',$value->id_sentimen],['id_training',null]])->count();
                if ($count == 0) {
                    $id_training = DataTraining::where('id_crawling',$value->id_crawling)->first();
                    $wordFrequency = new WordFrequency();
                    $wordFrequency->kata = $stemming[$i];
                    $wordFrequency->id_sentimen = $kategori['hasil'];
                    $wordFrequency->jumlah = 1;
                    $wordFrequency->id_testing = $analisa->id_testing;
                    $wordFrequency->save();
                } else {
                    $wordFrequency = WordFrequency::where([['kata',$stemming[$i]],['id_training',null],['id_sentimen',$kategori['hasil']]])->increment('jumlah', 1);
                }
            }

            //simpan proses
            foreach($kategori['value'] as $index_kategori => $value_kategori){
                foreach($value_kategori as $index_kata => $data_kata){
                    foreach($data_kata as $index_nilai => $data_nilai){
                        $id_training = WordFrequency::where([['id_sentimen',$index_kategori],['kata',$index_kata]])->whereNotNull('id_training')->first();
                        $data_proses = new Proses();
                        $data_proses->id_testing = $analisa->id_testing;
                        if(empty($id_training)){
                            $data_proses->id_training = null;
                        } else {
                            $data_proses->id_training = $id_training->id_training;
                        }
                        $data_proses->kemunculan_kata = $index_kata;
                        $data_proses->nilai = $data_nilai;
                        $data_proses->save();
                    }
                }
            }
        }
   }

    private function classify($sentence,$id_testing) 
    {   
        $case_folding = $this->case_folding($sentence);
        $cleansing = $this->cleansing($case_folding);
        $tokenizing = $this->tokenizing($cleansing);
        $stopword = $this->stopWord($tokenizing);
        $stemming = $this->stemming($stopword);
        $category = $this->decide($stemming,$id_testing);
        return $category;
    }

    private function decide($keywordsArray,$id_testing) 
    {
        foreach(Sentimen::all() as $stm){
            $class['class'][] = $stm->id_sentimen;
        }

        $hitung = 1;
        // $sql = mysqli_query($conn, "SELECT count(*) as total FROM (SELECT word FROM wordFrequency GROUP by word) as x");
        // $distinctWords = WordFrequency::select(WordFrequency::selectSub('word','x')->groupBy('word'))->count();
        // $distinct = DB::select("SELECT count(*) as total FROM (SELECT kata FROM term_frequency GROUP by kata) as x");
        $distinct = DB::select("SELECT count(*) as total FROM (SELECT kata FROM term_frequency WHERE term_frequency.id_training is not null GROUP by kata) as x");
        foreach($distinct as $dst){
            $distinctWords = $dst->total;
        }
        $uniqueWords = $distinctWords;

        foreach ($keywordsArray as $word) {

            foreach($class['class'] as $cls ){
                // $sql = mysqli_query($conn, "SELECT count as total FROM wordFrequency where word = '$word' and category = '$cls' ");
                // $wordCount = mysqli_fetch_assoc($sql);
                // $wordCount = WordFrequency::where([['word',$word], ['category',$cls]])->first();
                // $wordC = DB::select("SELECT jumlah as total FROM term_frequency where kata = '$word' and kategori = '$cls'");
                $wordC = DB::select("SELECT jumlah as total FROM term_frequency where kata = '$word' and id_sentimen = '$cls' AND term_frequency.id_training is not null");
                if($wordC == null){
                    $wordCount = null;
                } else {
                    foreach($wordC as $wC){
                        $wordCount = $wC->total;
                    }
                }

                $total[$cls][$word] = $wordCount;
                // $wordSum = DB::table('term_frequency')->select(DB::raw('SUM(jumlah) as jumlah_term'))->where('kategori',$cls)->first();
                $wordSum = DB::table('term_frequency')->select(DB::raw('SUM(jumlah) as jumlah_term'))->where('id_sentimen',$cls)->whereNotNull('id_training')->first();
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
                        ->select('id_sentimen')
                        ->where('id_sentimen', '=', $cls)
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

        foreach($class['class'] as $cls){
            //simpan hasil
            $hasil = new Hasil();
            $hasil->nilai = $final[$cls];
            $hasil->id_testing = $id_testing;
            $hasil->id_sentimen = $cls;
            $hasil->save();
        }

        // echo json_encode($semua_data); die();
        arsort($final);
        $category = key($final);

        $semua_data = [
            'kata_unik' => $uniqueWords,
            'word_count' => $wordCount,
            'total' => $total,
            'sum' => $sum,
            'value' => $value,
            'class' => $Count,
            'total_semua_class' => $totalCount,
            'prior' => $prior,
            'final' => $final,
            'hasil' => $category
        ];

        return $semua_data;
    }

}
