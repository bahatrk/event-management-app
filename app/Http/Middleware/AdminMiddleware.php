<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            // Option 1: abort with 403
            abort(403, 'Unauthorized: Admins only.');

            // Option 2: redirect somewhere else, e.g. home with error message
            // return redirect('/')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}
