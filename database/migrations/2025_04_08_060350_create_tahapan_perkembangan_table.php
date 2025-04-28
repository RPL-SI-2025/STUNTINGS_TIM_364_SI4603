<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapanPerkembanganTable extends Migration
{
    public function up()
    {
        Schema::create('tahapan_perkembangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tahapan');
            $table->text('deskripsi')->nullable();
            $table->integer('umur_minimal_bulan')->nullable();
            $table->integer('umur_maksimal_bulan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahapan_perkembangan');
    }
}
