<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sentimen;

class ControllerKategori extends Controller
{
    public function kategori()
    {
        $title = "Kategori Sentimen";
        return view('kategori', compact('title'));
    }

    public function all_kategori()
    {
        $kategori = Sentimen::orderby('id_sentimen', 'DESC')->get();
        return response()->json($kategori);
    }

    public function store_kategori(Request $request)
    {
        $kategori = Sentimen::create($request->input());
        return response()->json($kategori);
    }

    public function get_kategori($id)
    {
        $kategori = Sentimen::find($id);
        if($kategori){
            return response()->json($kategori);
        } else{
            return response()->json(error);
        }
    }

    public function update_kategori(Request $request,$id)
    {
        $kategori = Sentimen::find($id);

        if($kategori){
            $kategori->kategori = $request->kategori;
            $kategori->save();
            return response()->json($kategori);
        } else{
            return response()->json(error);
        } 
    }

    public function delete_kategori($id)
    {
        $kategori = Sentimen::findOrFail($id);
        if($kategori){
            $kategori->delete();
            return response()->json(true);
        } else{
            return response()->json(error);
        } 
    }
}
