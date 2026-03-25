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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');

            $table->string('classroom_name');
            $table->string('school_code');

            $table->foreignId('subject_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();

            $table->date('due_date');

            $table->enum('status', ['draft', 'active', 'closed'])->default('active');

            $table->timestamps();
        });

        // Tabel untuk menyimpan hasil pengerjaan siswa
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');

            // Status: pending / submitted / late
            $table->enum('status', ['pending', 'submitted', 'late'])->default('pending');

            // Skor 0-100
            $table->integer('score')->nullable();

            // Kapan dikerjakan?
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            // Satu siswa hanya bisa submit sekali per tugas
            $table->unique(['assignment_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
    }
};
