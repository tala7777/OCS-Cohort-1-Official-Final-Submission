<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'teachers' => User::where('role', 'teacher')->count(),
            'students' => User::where('role', 'student')->count(),
            'classes' => SchoolClass::count(),
            'subjects' => Subject::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
