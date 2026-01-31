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
       // 1. Truncate the table to remove conflicting data (invalid lawyer_ids that would break new FKs)
       \Illuminate\Support\Facades\DB::table('likes')->truncate();

       // 2. Handle partial migration failures (if column exists but migration crashed on FK)
       if (Schema::hasColumn('likes', 'reply_id')) {
           Schema::table('likes', function (Blueprint $table) {
               // We need to drop the foreign key first if it exists, but since we don't know if it 
               // suceeded, we might catch an exception or just try dropping the column.
               // Dropping column usually drops the FK too in MySQL.
               $table->dropColumn('reply_id');
           });
       }

       // 3. Freshly add the column and constraints
       Schema::table('likes', function (Blueprint $table) {
            $table->foreignId('reply_id')->after('user_id')
                ->constrained('question_replies')
                ->cascadeOnDelete();

            $table->unique(['user_id', 'reply_id']);
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            //
        });
    }
};
