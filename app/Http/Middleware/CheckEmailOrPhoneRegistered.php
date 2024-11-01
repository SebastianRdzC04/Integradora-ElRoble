<?php

namespace App\Http\Middleware;

use App\Models\Person;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckEmailOrPhoneRegistered
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
     public function handle($request, Closure $next)
    {
        $input = ($request)->input('phoneoremail');

        $table = filter_var(($input), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (($table) == 'email')
        {
            if (!User::where($table, $input)->exists()) 
            {
                return redirect()->route('registeruser.create', ['phoneoremail' => $input]);
            }
        }
        else
        {
            if (!Person::where($table, $input)->exists()) 
            {
                return redirect()->route('registeruser.create', ['phoneoremail' => $input]);
            }
        }
        

        return $next(($request));
    }
}
