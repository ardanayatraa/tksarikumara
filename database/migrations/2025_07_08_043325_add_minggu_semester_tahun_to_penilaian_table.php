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
        Schema::table('penilaian', function (Blueprint $table) {
            $table->unsignedTinyInteger('minggu_ke')->after('tgl_penilaian');
            $table->string('semester', 10)->after('minggu_ke');
            $table->string('tahun_ajaran', 9)->after('semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropColumn(['minggu_ke', 'semester', 'tahun_ajaran']);
        });
    }
};
