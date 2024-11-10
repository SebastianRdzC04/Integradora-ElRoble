<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\RateLimiter as RateLimiterFacade;

class CustomThrottleMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $maxAttempts = 5, $decayMinutes = 2, $redirectRoute = 'verification.notice')
    {
        $key = $this->resolveRequestSignature($request);

        // Verificar si el usuario ha excedido el límite de intentos
        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $this->limiter->availableIn($key);

            // Mostrar mensaje de error y redireccionar a la ruta especificada
            session()->flash('error', "Has intentado demasiadas veces. Intenta de nuevo mas tarde.");
            return redirect()->route($redirectRoute);
        }

        // Registrar el intento
        $this->limiter->hit($key, $decayMinutes * 60);

        return $next($request);
    }

    protected function resolveRequestSignature(Request $request)
    {
        // Usar el ID del usuario autenticado o la IP del cliente como clave
        return $request->user() ? $request->user()->id : $request->ip();
    }
}
