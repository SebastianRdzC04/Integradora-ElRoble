<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;

class EmployeeEventController extends Controller
{
    //
    public function showTodayEvent()
    {
        $today = Carbon::today(); // Obtiene la fecha de hoy
        $event = Event::whereDate('start_time', '=', $today)->first(); // Busca el evento de hoy

        if (!$event) {
            return redirect()->back()->with('error', 'No hay eventos para hoy.');
        }

        return view('pages.people.employee.event_now', compact('event'));
    }
}
