<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (session('user.roles_id') == 1 || session('user.roles_id') == 2) {
            return $next($request);
        } else {
            abort(403, 'You don\'t have authorization to access this url!');
        }
    }
}
