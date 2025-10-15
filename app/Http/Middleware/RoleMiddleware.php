<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, $roles)) {
            // Kalau tidak punya role yang sesuai, arahkan ke halaman masing-masing
            if ($user && $user->role === 'applicant') {
                return redirect('/applicant/dashboard');
            } elseif ($user && $user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
