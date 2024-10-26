<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiciosAdminController extends Controller
{
    public function create()
    {
        return view('crearserviciosadmin');
    }
}