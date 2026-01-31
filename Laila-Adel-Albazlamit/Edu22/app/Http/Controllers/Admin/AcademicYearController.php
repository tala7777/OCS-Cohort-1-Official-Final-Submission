<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\StudentClassHistory;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function promoteStudents()
    {
        DB::transaction(function () {

            // 1️⃣ السنة الحالية
            $currentYear = AcademicYear::where('is_active', true)->firstOrFail();

            // 2️⃣ إغلاق السنة الحالية
            $currentYear->update(['is_active' => false]);

            // 3️⃣ إنشاء سنة جديدة
            $newYear = AcademicYear::create([
                'name' => now()->year . '/' . (now()->year + 1),
                'is_active' => true,
            ]);

            // 4️⃣ طلاب السنة الحالية
            $students = StudentClassHistory::with('class')
                ->where('academic_year_id', $currentYear->id)
                ->get();

            foreach ($students as $record) {

                // الصف التالي (مهم يكون عندك order بالجدول)
                $nextClass = SchoolClass::where('order', '>', $record->class->order)
                    ->orderBy('order')
                    ->first();

                // 🎓 إذا ما في صف بعده = تخرّج
                if (!$nextClass) {
                    User::where('id', $record->student_id)
                        ->update(['status' => 'graduated']);
                    continue;
                }

                // 5️⃣ إضافة سجل جديد للسنة الجديدة
                StudentClassHistory::create([
                    'student_id' => $record->student_id,
                    'class_id' => $nextClass->id,
                    'section_id' => $record->section_id, // أو تغييره لاحقًا
                    'academic_year_id' => $newYear->id,
                ]);
            }
        });

        return back()->with('success', 'Academic year ended and students promoted successfully.');
    }
}



