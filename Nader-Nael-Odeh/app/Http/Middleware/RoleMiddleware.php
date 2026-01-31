<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
             abort(403, 'Unauthorized action.');
        }

        // Check if the user has one of the allowed roles
        if (! in_array($user->role, $roles)) {
            // Redirect based on their ACTUAL role to keep them in their lane
             if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'lawyer') {
                return redirect()->route('lawyer.dashboard');
            } else {
                return redirect()->route('index'); // User goes to public feed
            }
        }

        // SPECIAL CHECKS FOR LAWYERS
        if ($user->role === 'lawyer' && in_array('lawyer', $roles)) {
             if ($user->status === 'pending') {
                 // Pending lawyers cannot access lawyer dashboard
                 return redirect()->route('home')->with('status', 'Your account is still pending admin approval. You will be notified once approved.');
             }
        }
        
        return $next($request);
    }
}
