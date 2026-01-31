<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->after('password');
            $table->foreignId('class_id')->nullable()->after('role')->constrained('classes')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->after('class_id')->constrained('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn(['role', 'class_id', 'section_id']);
        });
    }
};
