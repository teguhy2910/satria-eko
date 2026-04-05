<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!\Auth::check()) {
            return redirect('/login');
        }

        if (!in_array(\Auth::user()->name, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
