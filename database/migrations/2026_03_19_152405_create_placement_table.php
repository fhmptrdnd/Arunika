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
        Schema::create('placement_questions', function (Blueprint $table) {
            $table->id();
            $table->enum('kelas', [
                'Kelas 1', 'Kelas 2', 'Kelas 3',
                'Kelas 4', 'Kelas 5', 'Kelas 6'
            ]);
            $table->string('subject');
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
        Schema::create('placement_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('kelas');
            $table->json('scores');
            $table->json('answers');
            $table->string('top_subject')->nullable();
            $table->string('second_subject')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placement_results');
        Schema::dropIfExists('placement_questions');
    }
};
