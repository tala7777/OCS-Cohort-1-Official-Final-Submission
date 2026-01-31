<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // عرض صفحة الدفع
    public function show(Course $course)
    {
        // Laravel route model binding جلب الكورس تلقائياً
        return view('frontend.payment', compact('course'));
    }

    // تنفيذ الدفع الوهمي
    public function fakePay(Request $request, Course $course)
    {
        // تأكد المستخدم مسجل دخول
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // تسجيل عملية الشراء (دفع وهمي)
        Purchase::firstOrCreate([
            'user_id'   => Auth::id(),
            'course_id' => $course->id,
        ]);

        return redirect()
            ->route('course-details', $course->id)
            ->with('success', 'Payment successful, you can now watch the course 🎉');
    }
}
