<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Singkatan;

class ControllerKosaKata extends Controller
{
    public function singkatan()
    {
        $title = "Singkatan";
        $singkatan = Singkatan::all();
        return view('singkatan', compact(['title','singkatan']));
    }

    public function all_singkatan()
    {
        $singkatan = Singkatan::all();
        return response()->json($singkatan);
    }

    public function emoticon()
    {
        $title = "Emoticon";
        return view('emoticon', compact('title'));
    }

    public function store_singkatan(Request $request)
    {
        $singkatan = $request->input('singkatan');
        $makna = $request->input('makna');
        // $store = new Singkatan();
        // $store->singkatan = $singkatan;
        // $store->makna = $makna;
        // $data = $store->save();
        $product = Singkatan::create($request->input());
        return response()->json($product);
        // return response()->json($data);
    }

    public function get_singkatan($id)
    {
        $singkatan = Singkatan::find($id);
        return response()->json($singkatan);
    }

    public function update_singkatan(Request $request,$id)
    {
        $singkatan = Singkatan::find($id);
        $singkatan->singkatan = $request->singkatan;
        $singkatan->makna = $request->makna;
        $singkatan->save();
        return response()->json($singkatan);
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
}
