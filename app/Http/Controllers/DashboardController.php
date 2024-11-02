<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Event;
use App\Models\Quote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $quotes = Quote::paginate(4);
        $consumables = Consumable::all();
        $events = Event::orderBy('date', 'asc')->where('status', 'Pendiente')->get();
        $currentEvent = Event::where('date', date('Y-m-d'))->first();
        $fullQuoteDates = Quote::selectRaw('date, count(*) as count')
            ->groupBy('date')
            ->having('count', '>=', 3)
            ->pluck('date'); 
        return view('pages.dashboard', compact('quotes', 'consumables', 'events', 'fullQuoteDates', 'currentEvent'));
    }
}
