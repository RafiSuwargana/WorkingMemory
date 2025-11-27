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
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_result_id')->constrained()->onDelete('cascade');
            $table->string('answer_type'); // 'choice', 'sequence', 'sum'
            $table->json('answer_data'); // store specific answer data
            $table->decimal('time_taken', 10, 2); // time to answer in milliseconds
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_answers');
    }
};
