<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Usage: middleware('role:admin')  or  middleware('role:admin,supervisor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user() || !$request->user()->hasRole($roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
