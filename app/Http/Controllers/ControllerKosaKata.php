<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerKosaKata extends Controller
{
    public function singkatan()
    {
        $title = "Singkatan";
        return view('singkatan', compact('title'));
    }

    public function emoticon()
    {
        $title = "Emoticon";
        return view('emoticon', compact('title'));
    }
}
