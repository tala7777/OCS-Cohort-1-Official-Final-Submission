<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // تحقق إذا المستخدم مسجل دخول وعنده role = admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // إذا مش أدمن يرجع للصفحة الرئيسية
        return redirect('/');
    }
}
