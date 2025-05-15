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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama proyek (misalnya "E-Commerce Platform")
            $table->string('image_path')->nullable(); // Path ke gambar proyek
            $table->text('description'); // Deskripsi proyek
            $table->string('team_name'); // Nama kelompok (misalnya "Kelompok 1")
            $table->json('technologies')->nullable(); // Teknologi yang digunakan (disimpan sebagai array JSON)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
