<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // إحصائيات الداشبورد
        $totalUsers   = User::count();
        $totalCourses = Course::count();

        // مؤقتًا (لحد ما نعمل payments)
        $totalRevenue = 0;

        /*
        // لاحقًا إذا عملت جدول payments
        $totalRevenue = \DB::table('payments')->sum('amount');
        */

        return view('admin.dashboard', [
            'totalUsers'   => $totalUsers,
            'totalCourses' => $totalCourses,
            'totalRevenue' => $totalRevenue,
        ]);
    }
}
