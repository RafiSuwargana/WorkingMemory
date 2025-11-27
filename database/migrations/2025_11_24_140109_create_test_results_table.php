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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_session_id')->constrained()->onDelete('cascade');
            $table->integer('question_number');
            $table->json('question_data'); // store images, domino dots, etc.
            $table->string('correct_answer')->nullable();
            $table->string('user_answer')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->decimal('response_time', 10, 2)->nullable(); // in milliseconds
            $table->boolean('timeout')->default(false);
            $table->timestamp('question_started_at')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
