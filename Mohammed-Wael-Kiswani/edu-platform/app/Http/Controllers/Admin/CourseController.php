<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class CourseController extends Controller
{
    // Dashboard - عرض كل الكورسات في لوحة الإدارة
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    // Form لإضافة كورس جديد
    public function create()
    {
        return view('admin.courses.create');
    }

    // عرض كورس معين في الواجهة الأمامية
    public function show($id)
    {
        $course = Course::findOrFail($id);

        // ✅ تحقق إذا المستخدم اشترى الكورس
        $userHasPurchased = false;
        if (Auth::check()) {
            $userHasPurchased = Purchase::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('frontend.course-details', compact('course', 'userHasPurchased'));
    }

    // حفظ الكورس الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:50',
            'instructor' => 'required|string|max:100',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'instructor' => $request->instructor,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course added successfully.');
    }

    // Form لتعديل كورس
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    // تحديث كورس
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:50',
            'instructor' => 'required|string|max:100',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = $imagePath;
        }

        $course->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'instructor' => $request->instructor,
            'price' => $request->price,
        ]);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    // حذف كورس
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    // Frontend method for all courses
    public function allCourses()
    {
        $courses = Course::paginate(6);

        // ✅ إذا عندك جدول categories في قاعدة البيانات
        $categories = Category::all();

        // ✅ إذا ما عندك جدول وتريد قائمة ثابتة، استخدم السطر التالي بدلاً من السطر أعلاه
        // $categories = collect(['HTML/CSS', 'JavaScript', 'PHP/Laravel', 'Databases', 'Bootstrap']);

        return view('frontend.courses', compact('courses', 'categories'));
    }
}
