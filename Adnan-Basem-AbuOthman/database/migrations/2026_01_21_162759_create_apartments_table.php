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

        Schema::create('apartments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_id')->constrained('users')->onDelete('restrict');

            $table->string('name', 150);
            $table->string('location');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('area');

            $table->foreignId('university_id')
                ->nullable() // This is the missing piece!
                ->constrained('universities')
                ->onDelete('restrict');


            $table->enum('allowed_gender', ['male', 'female']);
            $table->text('description')->nullable();
            $table->enum('rent_type', ['whole', 'rooms']);
            $table->decimal('price', 10, 2);
            $table->integer('number_of_rooms')->nullable();
            $table->enum('status', ['available', 'rented', 'hidden'])->default('available');

            $table->unsignedBigInteger('views')->default(0);
            

            $table->timestamps();
        });




    }

    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
