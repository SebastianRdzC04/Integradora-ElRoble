<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioClientesController extends Controller
{
    public function create()
    {
        return view('inicio');
    }
}