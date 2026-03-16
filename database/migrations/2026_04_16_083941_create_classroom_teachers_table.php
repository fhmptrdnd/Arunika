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
        Schema::create('classroom_teachers', function (Blueprint $table) {
            $table->id();

            // Terhubung ke Kelas mana?
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');

            // Terhubung ke Guru siapa?
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');

            // Mengajar Mapel apa?
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_teachers');
    }
};
