<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVIPUser
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
        if(Auth::check()) {
            
            if (Auth::user()->isEmployee() || Auth::user()->isAdmin()) 
            {            
                return $next($request);
            }
            return redirect(url()->previous()); //Add notice msg later?
        }
        return redirect('login');
    }
}
