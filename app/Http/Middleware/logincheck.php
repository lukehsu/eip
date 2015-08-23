<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use App\mainmenudisplay;
use Request;
class logincheck
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
        //取得網址
        $uri = Request::path();
        $uris = strstr($uri,'/',true);
        //檢查是否有權限進入該區
        $accesschecks = mainmenudisplay::where('user','=',Auth::user()->name)->where('url','=',$uris)->count();
        if ($accesschecks == 0)
        {
            return redirect('login');   
            //echo $uris;           
        }
        return $next($request);
    }
}
