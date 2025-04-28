<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapanPerkembanganDataTable extends Migration
{
    public function up()
    {
        Schema::create('tahapan_perkembangan_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tahapan_perkembangan_id')->constrained('tahapan_perkembangan')->onDelete('cascade');
            $table->date('tanggal_pencapaian')->nullable();
            $table->enum('status', ['tercapai', 'belum_tercapai'])->default('belum_tercapai');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahapan_perkembangan_data');
    }
}
