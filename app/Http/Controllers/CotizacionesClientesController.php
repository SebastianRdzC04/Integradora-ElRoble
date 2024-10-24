<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CotizacionesClientesController extends Controller
{
    public function create()
    {
        return view('cotizacionesclientes');
    }
}