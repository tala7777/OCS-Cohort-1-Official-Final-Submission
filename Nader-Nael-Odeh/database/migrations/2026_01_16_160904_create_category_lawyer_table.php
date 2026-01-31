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
       Schema::create('category_lawyer', function (Blueprint $table) {
    $table->id();

    $table->foreignId('lawyer_id')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->foreignId('category_id')
        ->constrained('categories')
        ->cascadeOnDelete();

    $table->timestamps();
    $table->softDeletes();

    $table->unique(['lawyer_id', 'category_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_lawyer');
    }
};
