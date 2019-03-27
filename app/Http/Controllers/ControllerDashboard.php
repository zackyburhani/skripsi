<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerDashboard extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        return view('dashboard', compact('title'));
    }
}
