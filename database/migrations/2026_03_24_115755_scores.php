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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->integer('kelas')->nullable();
            $table->integer('level')->nullable();

            $table->string('mapel', 25)->nullable();

            $table->integer('xp');
            $table->integer('true_answers');

            $table->integer('numerasi')->nullable();
            $table->integer('literasi')->nullable();
            $table->integer('english')->nullable();
            $table->integer('logika')->nullable();
            $table->integer('visual')->nullable();

            $table->timestamps();

            // Optional (disarankan)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
