<?php

namespace App\Http\Middleware;
use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;


class demo
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
        // If the user is not logged in
        if (Auth::guest()) {
            if ($request->ajax()) {
                return response('Unauthorized!', 401);
            } else {
                return redirect('login');
            }
        }
        return $next($request);
    }
}
