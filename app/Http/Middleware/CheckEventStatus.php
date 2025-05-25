<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEventStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('event'); // assuming route model binding

        if ($event && $event->status !== 'planned') {
            $user = $request->user();

            // Allow access if user is authenticated and has joined the event
            if (!$user || !$event->participants()->where('user_id', $user->id)->exists()) {
                abort(403, 'Access denied: Event is not available.');
            }
        }

        return $next($request);
    }
}
