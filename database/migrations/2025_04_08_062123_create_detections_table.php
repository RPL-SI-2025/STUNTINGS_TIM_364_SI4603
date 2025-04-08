<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetectionsTable extends Migration
{
    public function up()
    {
        Schema::create('detections', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('umur');
            $table->char('jenis_kelamin', 1);
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->float('z_score')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detections');
    }
}
