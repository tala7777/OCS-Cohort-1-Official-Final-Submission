<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalLessons = Lesson::count();
        $totalRevenue = Payment::sum('amount');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCourses',
            'totalLessons',
            'totalRevenue'
        ));
    }
}
