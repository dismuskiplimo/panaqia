<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class User
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

        if(!$user->is_user()){
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
