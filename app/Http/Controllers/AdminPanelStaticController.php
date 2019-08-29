<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPanelStaticController extends Controller
{
    public function index()
    {
        return view('backend.app');
    }
}
