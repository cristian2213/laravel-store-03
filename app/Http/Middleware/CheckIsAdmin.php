<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // valida que este autenticado y que se administrador
        if ($request->user() != null && $request->user()->isAdmin()) {
            return $next($request);
        }

        abort(403);
    }
}
