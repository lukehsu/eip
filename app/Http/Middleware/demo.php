<?php

namespace App\Http\Middleware;
use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Redirect;

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

        //$a = '123';

    }
}
