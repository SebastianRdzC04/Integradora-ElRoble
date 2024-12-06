<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Event;
use App\Models\Quote;
use Carbon\Carbon;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $inicioMesPasado = Carbon::now()->subMonth()->startOfMonth();
        $finMesPasado = Carbon::now()->subMonth()->endOfMonth();

        $inicioMesActual = Carbon::now()->startOfMonth();
        $finMesActual = Carbon::now()->endOfMonth();



        $quotes = Quote::where('status', 'pendiente cotizacion')->get();
        $quotesPendingToPay = Quote::where('status', 'pendiente')->get();

        $consumables = Consumable::all();
        
        $eventsPending = Event::orderBy('date', 'asc')->where('status', 'Pendiente')->get();
        $eventsFinalized = Event::orderBy('date', 'asc')->where('status', 'Finalizado')->get();
        $currentEvent = Event::whereDate('date', Carbon::now()->format('Y-m-d'))
        ->whereNotIn('status', ['Finalizado', 'Cancelado'])
        ->first();
        // $currentEvent = Event::where('date', date('Y-m-d'))->first();
        $fullQuoteDates = Quote::selectRaw('date, count(*) as count')
        ->whereIn('status', ['pendiente', 'pendiente cotizacion'])
        ->groupBy('date')
        ->having('count', '>=', 3)
        ->pluck('date'); 

        // Informacion sobre eventos
        $eventosDelMesPasado = Event::whereBetween('date', [$inicioMesPasado, $finMesPasado])->get();
        $eventosEsteMes = Event::whereBetween('date', [$inicioMesActual, $finMesActual])->get();
        $porcentaje = 0;
        if (count($eventosDelMesPasado) > 0) {
            $porcentaje = round((count($eventosEsteMes) - count($eventosDelMesPasado)) / count($eventosDelMesPasado) * 100, 2);
        }
        else if (count($eventosEsteMes) > 0) {
            $porcentaje = 100;
        }

        $gananciasNetas = $eventosEsteMes->where('status', 'Finalizado')->sum('total_price');

        $gananciasNetasMesPasado = $eventosDelMesPasado->where('status', 'Finalizado')->sum('total_price');

        $porcentajeGanancias = 0;
        if ($gananciasNetasMesPasado > 0) {
            $porcentajeGanancias = round(($gananciasNetas - $gananciasNetasMesPasado) / $gananciasNetasMesPasado * 100, 2);
        }





        return view('pages.dashboard.dashboard', compact('quotes', 'consumables', 'eventsPending', 'fullQuoteDates', 'porcentaje', 'quotesPendingToPay', 'gananciasNetas', 'porcentajeGanancias', 'eventsFinalized', 'currentEvent'));
    }
}
