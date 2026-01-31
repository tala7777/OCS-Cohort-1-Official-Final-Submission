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
        Schema::table('attendances', function (Blueprint $row) {
            $row->text('absence_reason')->nullable();
            $row->enum('reason_status', ['pending', 'approved'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $row) {
            $row->dropColumn(['absence_reason', 'reason_status']);
        });
    }
};
