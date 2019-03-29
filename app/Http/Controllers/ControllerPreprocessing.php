<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerPreprocessing extends Controller
{
    public function preprocessing()
    {
        $title = "Data Preprocessing";
        return view('preprocessing', compact('title'));
    }
}
