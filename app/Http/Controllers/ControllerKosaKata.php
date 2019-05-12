<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stemming;
use App\Models\Emoticon;
use App\Models\Stopword;

class ControllerKosaKata extends Controller
{
    public function kata_dasar()
    {
        $title = "Kata Dasar";
        return view('kata_dasar', compact(['title']));
    }

    public function all_kata_dasar()
    {
        $kata_dasar = Stemming::orderby('id_ktdasar', 'DESC')->get();
        return response()->json($kata_dasar);
    }

    public function store_kata_dasar(Request $request)
    {
        $kata_dasar = Stemming::create($request->input());
        return response()->json($kata_dasar);
    }

    public function get_kata_dasar($id)
    {
        $kata_dasar = Stemming::find($id);
        if($kata_dasar){
            return response()->json($kata_dasar);
        } else{
            return response()->json(error);
        }
    }

    public function update_kata_dasar(Request $request,$id)
    {
        $kata_dasar = Stemming::find($id);

        if($kata_dasar){
            $kata_dasar->katadasar = $request->katadasar;
            $kata_dasar->tipe_katadasar = $request->tipe_katadasar;
            $kata_dasar->save();
            return response()->json($kata_dasar);
        } else{
            return response()->json(error);
        } 
    }

    public function delete_kata_dasar($id)
    {
        $kata_dasar = Stemming::findOrFail($id);
        if($kata_dasar){
            $kata_dasar->delete();
            return response()->json(true);
        } else{
            return response()->json(error);
        } 
    }

    public function emoticon()
    {
        $title = "Emoticon";
        return view('emoticon', compact('title'));
    }

    public function all_emoticon()
    {
        $emoticon = Emoticon::orderby('id', 'DESC')->get();
        return response()->json($emoticon);
    }

    public function store_emoticon(Request $request)
    {
        $emoticon = Emoticon::create($request->input());
        return response()->json($emoticon);
    }

    public function get_emoticon($id)
    {
        $emoticon = Emoticon::find($id);
        if($emoticon){
            return response()->json($emoticon);
        } else{
            return response()->json(error);
        }
    }

    public function update_emoticon(Request $request,$id)
    {
        $emoticon = Emoticon::find($id);

        if($emoticon){
            $emoticon->emoticon = $request->emoticon;
            $emoticon->save();
            return response()->json($emoticon);
        } else{
            return response()->json(error);
        } 
    }

    public function delete_emoticon($id)
    {
        $emoticon = Emoticon::findOrFail($id);
        if($emoticon){
            $emoticon->delete();
            return response()->json(true);
        } else{
            return response()->json(error);
        } 
    }

    public function stopword()
    {
        $title = "Stopword";
        return view('stopword', compact('title'));
    }

    public function all_stopword()
    {
        $stopword = Stopword::orderby('id', 'DESC')->get();
        return response()->json($stopword);
    }

    public function store_stopword(Request $request)
    {
        $string = str_replace('  ', ' ', $request->stopword);
        $array = explode(' ', $string);
    
        for($i=0; $i<count($array); $i++){
            $stopword = new Stopword();
            $stopword->stopword = $array[$i];
            $stopword->save();
        }

        return response()->json($stopword);
    }

    public function get_stopword($id)
    {
        $stopword = Stopword::find($id);
        if($stopword){
            return response()->json($stopword);
        } else{
            return response()->json(error);
        }
    }

    public function update_stopword(Request $request,$id)
    {
        $stopword = Stopword::find($id);

        if($stopword){
            $stopword->stopword = $request->stopword;
            $stopword->save();
            return response()->json($stopword);
        } else{
            return response()->json(error);
        } 
    }

    public function delete_stopword($id)
    {
        $stopword = Stopword::findOrFail($id);
        if($stopword){
            $stopword->delete();
            return response()->json(true);
        } else{
            return response()->json(error);
        } 
    }
}
