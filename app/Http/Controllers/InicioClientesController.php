<?php
// app/Http/Controllers/InicioClientesController.php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Comment;
use Carbon\Carbon;

class InicioClientesController extends Controller
{
    public function create()
    {
        $today = Carbon::today();
        $packages = Package::where('start_date', '<=', $today)
                            ->where('end_date', '>=', $today)
                            ->get();
        $comments = Comment::with('user')->get();

        return view('inicio', compact('packages', 'comments'));
    }
}