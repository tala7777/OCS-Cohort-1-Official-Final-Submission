<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lawyer_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('bio')->nullable();
            $table->string('license_number')->nullable();

            $table->string('profile_photo_path')->nullable();

            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lawyer_profiles');
    }
};
