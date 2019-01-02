<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class Manager
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
        $user = Auth::user();

        if(!$user->is_manager()){
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
