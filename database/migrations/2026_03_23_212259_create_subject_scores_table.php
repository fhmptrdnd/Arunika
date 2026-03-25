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
        Schema::create('subject_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');

            // skor 0-100
            $table->integer('score')->default(0);

            // asal skor
            $table->enum('source', ['placement_test', 'game', 'manual'])->default('placement_test');

            // skor game terbaru + rata-rata
            $table->integer('attempts')->default(1);

            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'source']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_scores');
    }
};
