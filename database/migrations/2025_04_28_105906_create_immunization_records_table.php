<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmunizationRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('immunization_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('immunization_id')->constrained()->onDelete('cascade'); 
            $table->date('immunized_at'); 
            $table->enum('status', ['Sudah', 'Belum']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('immunization_records');
    }
}