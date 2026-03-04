<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $roles = null)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (empty($roles)) {
            return $next($request);
        }

        $allowed = array_map('trim', explode(',', $roles));

        $userRole = Auth::user()->role ?? null;

        if (in_array($userRole, $allowed, true)) {
            return $next($request);
        }

        abort(403);
    }
}
