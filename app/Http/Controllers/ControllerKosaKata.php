<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File as files;

class ControllerKosaKata extends Controller
{
    public function kata_dasar()
    {
        $result = files::exists('storage/preprocessing/katadasar');
        if(!empty($result)){
            $status = 1;
        } else {
            $status = 2;
        }
        $title = "Kata Dasar";
        return view('kata_dasar', compact(['title','status']));
    }

    public function all_kata_dasar()
    {
        // $kata_dasar = Stemming::orderby('id_ktdasar', 'DESC')->get();
        $contents = Storage::get('public/preprocessing/katadasar/katadasar.txt');
        $code = preg_replace('/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n",$contents)));
        $kata_dasar = explode("\n",$code);
        return response()->json($kata_dasar);
    }

    public function store_kata_dasar(Request $request)
    {
        $file = $request->file('data_katadasar');  
        if($file == ""){
            return redirect('/kata-dasar')->with('gagal', 'Data Tidak Berhasil Disimpan !');    
        }

        $name = $file->getClientOriginalName();

        if($name != "katadasar.txt"){
            return redirect('/kata-dasar')->with('gagal', 'Data Tidak Berhasil Disimpan !');
        }

        $tujuan_upload = 'storage/preprocessing/katadasar/';
        $file->move($tujuan_upload,$name);
        return redirect('/kata-dasar')->with('sukses', 'Data Berhasil Disimpan !');
    }

    public function delete_kata_dasar()
    {   
        $directory = 'storage/preprocessing/katadasar';
        files::deleteDirectory(public_path($directory));
        return redirect('/kata-dasar')->with('sukses', 'Data Berhasil Dihapus !');
    }

    public function stopword()
    {
        $result = files::exists('storage/preprocessing/stopword');
        if(!empty($result)){
            $status = 1;
        } else {
            $status = 2;
        }
        $title = "Stopword";
        return view('stopword', compact(['title','status']));
    }

    public function all_stopword()
    {
        $contents = Storage::get('public/preprocessing/stopword/stopword.txt');
        $code = preg_replace('/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n",$contents)));
        $stopword = explode("\n",$code);
        return response()->json($stopword);
    }

    public function store_stopword(Request $request)
    {
        $file = $request->file('data_stopword');    

        if($file == ""){
            return redirect('/stopword')->with('gagal', 'Data Tidak Berhasil Disimpan !');    
        }

        $name = $file->getClientOriginalName();

        if($name != "stopword.txt"){
            return redirect('/stopword')->with('gagal', 'Data Tidak Berhasil Disimpan !');
        }

        $tujuan_upload = 'storage/preprocessing/stopword/';
        $file->move($tujuan_upload,$file->getClientOriginalName());
        return redirect('/stopword')->with('sukses', 'Data Berhasil Disimpan !');
    }

    public function delete_stopword()
    {
        $directory = 'storage/preprocessing/stopword';
        files::deleteDirectory(public_path($directory));
        return redirect('/stopword')->with('sukses', 'Data Berhasil Dihapus !');
    }
}
