<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedToRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            if ($user->role !== 'applicant') {
                return redirect('/home');
            }
        }
        // if ($user) {
        //     if ($user->role === 'admin') {
        //         return redirect('/admin/dashboard');
        //     } elseif ($user->role === 'applicant') {
        //         return redirect('/applicant/dashboard');
        //     }
        // }

        return $next($request);
    }
}
