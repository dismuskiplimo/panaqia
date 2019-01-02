<?php

namespace App\Http\Middleware;

use Closure;

use Session;

class NotClosed
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
        if(auth()->user()->closed){
            auth()->logout();

            Session::flash('error', 'Sorry, your account has been closed');
            
            return redirect()->route('login');
        }

        return $next($request);
    }
}
