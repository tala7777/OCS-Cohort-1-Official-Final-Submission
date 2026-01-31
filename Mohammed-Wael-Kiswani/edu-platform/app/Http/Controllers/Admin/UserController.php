<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // عرض صفحة جميع المستخدمين
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $totalUsers = User::count();
        $totalCourses = \App\Models\Course::count(); // لو عندك كورسات
        $totalRevenue = 0; // ممكن تضبطها حسب مشروعك

        return view('admin.users.index', compact('users', 'totalUsers', 'totalCourses', 'totalRevenue'));
    }

    // عرض صفحة إضافة مستخدم جديد
    public function create()
    {
        return view('admin.users.create');
    }

    // حفظ مستخدم جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,blocked',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User added successfully!');
    }

    // عرض صفحة تعديل مستخدم
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // تحديث بيانات المستخدم
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,blocked',
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    // حذف مستخدم
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    // عرض صفحة تفاصيل المستخدم
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
