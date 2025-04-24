<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('immunizations', function (Blueprint $table) {
        $table->string('age')->nullable();
        $table->text('description')->nullable();
    });
}

public function down()
{
    Schema::table('immunizations', function (Blueprint $table) {
        $table->dropColumn(['age', 'description']);
    });
}

};
