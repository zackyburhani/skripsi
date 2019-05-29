<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwitterStream;
use App\Models\Stemming;
use App\Models\Stopword;
use App\Models\Sentimen;

class ControllerDashboard extends Controller
{
    public function index()
    {
         $title = "Dashboard";
        $data_crawling = TwitterStream::count();
        $stopword = Stopword::count();
        $stemming = Stemming::count();
        $sentimen = Sentimen::count();
        return view('dashboard', compact('title','sentimen','stemming','stopword','data_crawling'));
    }

    public function searchPage(Request $request)
    {
        return redirect($request->search);
    }
}
