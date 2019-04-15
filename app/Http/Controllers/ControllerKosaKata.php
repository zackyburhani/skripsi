<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Singkatan;
use App\Models\Emoticon;
use App\Models\Stopword;

class ControllerKosaKata extends Controller
{
    public function singkatan()
    {
        $title = "Singkatan";
        return view('singkatan', compact(['title']));
    }

    public function all_singkatan()
    {
        $singkatan = Singkatan::orderby('id', 'DESC')->get();
        return response()->json($singkatan);
    }

    public function store_singkatan(Request $request)
    {
        $singkatan = Singkatan::create($request->input());
        return response()->json($singkatan);
    }

    public function get_singkatan($id)
    {
        $singkatan = Singkatan::find($id);
        if($singkatan){
            return response()->json($singkatan);
        } else{
            return response()->json(error);
        }
    }

    public function update_singkatan(Request $request,$id)
    {
        $singkatan = Singkatan::find($id);

        if($singkatan){
            $singkatan->singkatan = $request->singkatan;
            $singkatan->makna = $request->makna;
            $singkatan->save();
            return response()->json($singkatan);
        } else{
            return response()->json(error);
        } 
    }

    public function delete_singkatan($id)
    {
        $singkatan = Singkatan::findOrFail($id);
        if($singkatan){
            $singkatan->delete();
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
