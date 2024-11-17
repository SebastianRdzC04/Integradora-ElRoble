<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Event;
use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;


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
        $events = Event::orderBy('date', 'asc')->where('status', 'Pendiente')->get();
        // $currentEvent = Event::where('date', date('Y-m-d'))->first();
        $fullQuoteDates = Quote::selectRaw('date, count(*) as count')
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





        return view('pages.dashboard.dashboard', compact('quotes', 'consumables', 'events', 'fullQuoteDates', 'porcentaje', 'quotesPendingToPay', 'gananciasNetas', 'porcentajeGanancias'));
    }
}
