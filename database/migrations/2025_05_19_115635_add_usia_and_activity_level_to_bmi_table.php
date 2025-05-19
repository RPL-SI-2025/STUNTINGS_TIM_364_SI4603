<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom usia dan activity_level ke tabel bmi.
     */
    public function up(): void
    {
        Schema::table('bmi', function (Blueprint $table) {
            if (!Schema::hasColumn('bmi', 'usia')) {
                $table->integer('usia')->nullable();
            }
            if (!Schema::hasColumn('bmi', 'activity_level')) {
                $table->string('activity_level')->nullable();
            }
        });
    }

    /**
     * Rollback perubahan jika diperlukan.
     */
    public function down(): void
    {
        Schema::table('bmi', function (Blueprint $table) {
            $table->dropColumn('usia');
            $table->dropColumn('activity_level');
        });
    }
};
