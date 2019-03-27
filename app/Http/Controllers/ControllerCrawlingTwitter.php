<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerCrawlingTwitter extends Controller
{
    public function index()
    {
        $title = "Data Stream";
        return view('crawling', compact('title'));
    }
}
