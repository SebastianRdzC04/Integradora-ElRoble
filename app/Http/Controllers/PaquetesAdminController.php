<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaquetesAdminController extends Controller
{
    public function create()
    {
        return view('crearpaquetesadmin');
    }
}