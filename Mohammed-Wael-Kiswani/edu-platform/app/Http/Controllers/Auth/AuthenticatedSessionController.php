<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // تحقق من بيانات الدخول
        $request->authenticate();

        // تجديد الجلسة بعد تسجيل الدخول
        $request->session()->regenerate();

        // جلب المستخدم الحالي
        $user = auth()->user();

        // إذا كان الأدمن يروح للداشبورد تبع الأدمن
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // المستخدم العادي يروح للملف الشخصي
        return redirect()->route('profile');
    }

    /**
     * Destroy an authenticated session (Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();           // تسجيل الخروج
        $request->session()->invalidate();       // إلغاء صلاحية الجلسة
        $request->session()->regenerateToken();  // تجديد التوكن

        return redirect('/'); // يرجع على الصفحة الرئيسية
    }
}
