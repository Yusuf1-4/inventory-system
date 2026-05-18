<?php

namespace App\Http\Middleware;

use App\Models\PagePermission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * Usage in routes: middleware('permission:items.manage')
     */
    public function handle(Request $request, Closure $next, string $key): Response
    {
        $user = $request->user();

        if (!$user || !PagePermission::canRole($user->role, $key)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
