<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_class_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('class_id')
                ->constrained('school_classes');

            $table->foreignId('section_id')
                ->constrained('sections');

            $table->foreignId('academic_year_id')
                ->constrained('academic_years');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_class_histories');
    }
};

