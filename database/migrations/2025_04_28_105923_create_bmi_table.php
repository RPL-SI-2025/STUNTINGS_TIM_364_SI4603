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
        Schema::create('bmi', function (Blueprint $table) {
            $table->id();
          
            $table->foreignId('user_id')->nullable()->index();
            $table->date('tanggal');         // untuk tanggal pengukuran
            $table->integer('tinggi');       // tinggi badan dalam cm
            $table->float('berat', 5, 2);    // berat badan, maksimal 999.99
            $table->float('bmi', 5, 2);      // hasil perhitungan BMI
            $table->string('status');        // status BMI (misalnya: kurus, normal, obesitas)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bmi');
    }
};