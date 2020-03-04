<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoeController extends Controller
{
    public function index()
    {
        return view('coes.index');
    }
}
