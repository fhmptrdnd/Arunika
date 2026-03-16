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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Email dibuat nullable karena anak (sub-account) mungkin tidak punya email,
            // mereka bisa login menggunakan username atau cukup dipilih dari dashboard Orang Tua.
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique()->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // 4 Role Utama
            $table->enum('role', ['admin', 'guru', 'parent', 'student'])->default('student');

            // Data Sekolah & Kelas
            $table->string('school_code')->nullable();
            $table->string('school_name')->nullable();
            $table->string('kelas')->nullable();

            $table->foreignId('parent_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->integer('xp')->default(0);
            $table->integer('streak')->default(0);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
