<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Attendance;

class BlockMissingAbsenceReason
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->role === 'student') {
            // Exceptions: attendance page itself, logout, submit-reason route
            $allowedRoutes = [
                'student.attendance.index',
                'student.attendance.submit-reason',
                'logout'
            ];

            if (in_array($request->route()->getName(), $allowedRoutes)) {
                return $next($request);
            }

            $hasMissingReason = Attendance::where('student_id', $user->id)
                ->where('status', 'absent')
                ->whereNull('absence_reason')
                ->exists();

            if ($hasMissingReason) {
                return redirect()->route('student.attendance.index')
                    ->with('warning', 'You must submit an absence reason before continuing.');
            }
        }

        return $next($request);
    }
}
