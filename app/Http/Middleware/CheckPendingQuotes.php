<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quote;

class CheckPendingQuotes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $pendingQuotesCount = Quote::where('user_id', $user->id)
                ->whereIn('status', ['pendiente cotizacion', 'pendiente'])
                ->count();

            if ($pendingQuotesCount >= 2) {
                return redirect()->route('inicio')->withErrors(['error' => 'No puedes acceder a la página de cotizaciones porque tienes 2 o más cotizaciones pendientes.']);
            }
        }

        return $next($request);
    }
}