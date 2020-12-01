<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract {
    public function toResponse($request)
    {
        
        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        // if(!session()->has('url.intended'))
        // {
        //     echo("session has intended");
        //     session(['url.intended' => url()->previous()]);
        // }
        #print_r(session());
        #print_r(redirect()->intended()->getTargetUrl());
        // if($request->wantsJson()) {
        //     #response()->json(['two_factor' => false]);
        //     echo("JSON...");
        // } else {
        //     #redirect()->intended();
        //     echo("Intended: " . redirect()->intended());
        // }

        #echo($request->wantsJson());
        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended('/');
    }
}