<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {   
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anak')->nullable(); 
            $table->string('nik_anak', 16)->unique(); 
            $table->string('password');
            $table->enum('role', ['admin', 'orangtua']);
            $table->timestamps();
    });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
