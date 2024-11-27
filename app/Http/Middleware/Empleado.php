<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Empleado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->check() || auth()->user()->roles->contains('name','empleado'))
        {
            return redirect()->route('inicio')->withErrors('error', 'Solo personal authorizado');
        }
        return $next($request);
    }
}
