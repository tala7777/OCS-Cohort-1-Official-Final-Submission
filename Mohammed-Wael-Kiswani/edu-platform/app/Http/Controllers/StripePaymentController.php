<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripePaymentController extends Controller
{
    // صفحة الدفع
    public function show(Course $course)
    {
        return view('frontend.payment', compact('course'));
    }

    // إنشاء جلسة Stripe Checkout
    public function checkout(Request $request, Course $course)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $course->name,
                    ],
                    'unit_amount' => intval($course->price * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success', $course->id),
            'cancel_url' => url()->previous(),
        ]);

        return redirect($session->url);
    }

    // صفحة النجاح بعد الدفع
    public function success(Course $course)
    {
        // ✅ تسجيل الكورس كمشتَرى
        Purchase::firstOrCreate([
            'user_id'   => Auth::id(),
            'course_id' => $course->id,
        ]);

        //  تخزين عملية الدفع في جدول payments
        Payment::create([
            'user_id'   => Auth::id(),
            'course_id' => $course->id,
            'amount'    => $course->price,
            'status'    => 'completed',
        ]);

        return redirect()
            ->route('course-details', $course->id)
            ->with('success_message', [
                'title' => 'Payment Successful 🎉',
                'body'  => 'Congratulations! You now have full access to this course.',
            ]);
    }
}
