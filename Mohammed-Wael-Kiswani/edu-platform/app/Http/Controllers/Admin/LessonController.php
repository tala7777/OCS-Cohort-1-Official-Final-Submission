<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $lessons = Lesson::with('course')->latest()->get();
          
        return view('admin.lessons.index', compact('courses', 'lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|mimes:mp4,mov,avi|max:2048000', // 2GB
        ]);

        // أولاً عرف $lesson
        $lesson = new Lesson();
        $lesson->course_id = $request->course_id;
        $lesson->title = $request->title;
        $lesson->description = $request->description;

        // بعدين خزّن الفيديو
        if ($request->hasFile('video')) {
            $file = $request->file('video');

            if ($file->isValid()) {
                $path = $file->store('videos', 'public'); // storage/app/public/videos
                $lesson->video_path = $path; // خزن المسار فقط
            } else {
                return back()->with('error', 'Upload failed. Check your file size.');
            }
        }

        // أخيراً احفظ كل شيء في الداتا بيس
        $lesson->save();

        return back()->with('success', 'Lesson uploaded successfully!');
    }

    // ===== دالة الحذف =====
    public function destroy(Lesson $lesson)
    {
        // احذف الفيديو من التخزين إذا موجود
        if ($lesson->video_path && Storage::disk('public')->exists($lesson->video_path)) {
            Storage::disk('public')->delete($lesson->video_path);
        }

        // احذف الدرس من قاعدة البيانات
        $lesson->delete();

        return back()->with('success', 'Lesson deleted successfully!');
    }
}
