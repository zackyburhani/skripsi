<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwitterStream;
use App\Models\Stemming;
use App\Models\Stopword;

class ControllerDashboard extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $data_crawling = TwitterStream::count();
        $stopword = Stopword::count();
        $stemming = Stemming::count();
        return view('dashboard', compact('title','stemming','stopword','data_crawling'));
    }
}
