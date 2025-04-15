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
        Schema::create('nutrition_recomendations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Menu
            $table->text('nutrition'); // Informasi nutrisi
            $table->text('ingredients'); // Bahan-bahan
            $table->text('instructions'); // Cara membuat
            $table->enum('category', ['pagi', 'siang', 'malam', 'snack']); // Kategori makanan
            $table->string('image')->nullable(); // Gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_recomendations');
    }
};
