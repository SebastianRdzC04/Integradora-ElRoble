<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdmin
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
        if(!auth()->check() || !auth()->user()->roles->contains('id', 1))
        {
            if (auth()->user()->roles->contains('id', 2) || auth()->user()->roles->contains('id', 3)) {
                return redirect()->route('dashboard');
            }
            return redirect()->route('inicio')->withErrors('error', 'Solo personal authorizado');
        }
        
        return $next($request);
    }
}
