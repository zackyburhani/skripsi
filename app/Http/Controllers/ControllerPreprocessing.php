<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerStemming;
use App\Models\TwitterStream;
use App\Models\Stopword;

class ControllerPreprocessing extends Controller
{
    public function preprocessing()
    {
        $title = "Data Preprocessing";
        return view('preprocessing', compact('title'));
    }

    public function stopWord($searchString) 
    {
        $stopwords = Stopword::all();
        foreach($stopwords as $stop){
            $list[] = $stop->stopword;
        }
        $wordsFromSearchString = str_word_count($searchString, true);
        $finalWords = array_diff($wordsFromSearchString, $list);
        return implode(" ", $finalWords);
    }

    //Unicode
    
    public static function convert_from_latin1_to_utf8_recursively($dat)
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
   

    public function store_preprocessing()
    {
        $twitter = TwitterStream::all();
        foreach($twitter as $tweet){
            $preprocessing = $tweet->full_text;
            $case_folding = $this->case_folding($preprocessing);
            $cleansing = $this->cleansing($case_folding);
            $stopword = $this->stopWord($cleansing);
            $data[] = [
                'case_folding' => [
                    'screen_name' => $tweet->screen_name,
                    'full_text' => $case_folding
                ],
                'cleansing' => [
                    'screen_name' => $tweet->screen_name,
                    'full_text' => $cleansing
                ],
                'stopword' => [
                    'screen_name' => $tweet->screen_name,
                    'full_text' => $stopword
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
        $data = str_replace('rt :', '', $data); // #remove RT
        $data = preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $data); //remove url
        $data = preg_replace('/[^A-Za-z0-9\  ]/', '', $data);
        $data = str_replace('  ', ' ', $data);
        return $data;
    }

    public function stemming()
    {
        $title = "Data Preprocessing";
        return view('stemming', compact('title'));
    }

    public function stemming_post(Request $request)
    {
        $kata = $request->kata;
        $stemming = new ControllerStemming();
        /* 1. Cek Kata di Kamus jika Ada SELESAI */
        if($stemming->ceKamus($kata)){ // Cek Kamus
            return $kata; // Jika Ada kembalikan
        }
        /* 2. Buang Infection suffixes (\-lah", \-kah", \-ku", \-mu", atau \-nya") */
        $kata = $stemming->Del_Inflection_Suffixes($kata);

        /* 3. Buang Derivation suffix (\-i" or \-an") */
        $kata = $stemming->Del_Derivation_Suffixes($kata);

        /* 4. Buang Derivation prefix */
        $kata = $stemming->Del_Derivation_Prefix($kata);

        $title = "hasil";
        return view('stemming', compact(['title','kata']));
    }

}
