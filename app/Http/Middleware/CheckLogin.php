<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        if (\Auth::user()->name == 'ppic' || \Auth::user()->name == 'finance' || \Auth::user()->name == 'project') {
            return redirect('/sj/dashboard');
        }elseif (\Auth::user()->name == 'kasir') {
            return redirect('/inventory/kasir');
        }
        return $next($request);
    }
}
