<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        // جلب كل الكورسات مرتبة حسب الأحدث
        $courses = Course::latest()->get();

        // عدّل هنا حسب مسار الصفحة الفعلي
        return view('frontend.home', compact('courses'));
    }
}
