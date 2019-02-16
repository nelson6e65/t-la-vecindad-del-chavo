<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request ;

/**
 * Sólo permitir peticiones Ajax/json
 */
class OnlyAjax
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->expectsJson()) {
            abort(403);
        }

        return $next($request);
    }
}
