<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'course'])->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }
}
