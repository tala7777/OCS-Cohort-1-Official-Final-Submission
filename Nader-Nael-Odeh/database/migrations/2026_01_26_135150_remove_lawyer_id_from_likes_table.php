<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
                       $table->dropUnique(['user_id', 'lawyer_id']);
            
          
            $table->dropForeign(['lawyer_id']);
            
           
            $table->dropColumn('lawyer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->foreignId('lawyer_id')->constrained('lawyer_profiles')->cascadeOnDelete();
            $table->unique(['user_id', 'lawyer_id']);
        });
    }
};
