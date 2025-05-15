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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama siswa
            $table->string('image_path')->nullable(); // Path ke foto siswa
            $table->string('role'); // Peran (misalnya "Web Developer")
            $table->string('github_url')->nullable(); // Link GitHub
            $table->string('linkedin_url')->nullable(); // Link LinkedIn
            $table->string('instagram_url')->nullable(); // Link Instagram
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
