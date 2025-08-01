<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ========================================
// 5. MIGRATION: NilaiSiswa
// File: database/migrations/2024_01_01_000005_create_nilai_siswa_table.php
// ========================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_siswa', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('penilaian_id')
                  ->constrained('penilaian', 'id_penilaian')
                  ->onDelete('cascade');
            $table->foreignId('indikator_id')
                  ->constrained('indikator', 'id_indikator')
                  ->onDelete('cascade');
            $table->enum('nilai', ['BB', 'MB', 'BSH', 'BSB']);
            $table->tinyInteger('skor')->comment('1=BB, 2=MB, 3=BSH, 4=BSB');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['penilaian_id', 'indikator_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_siswa');
    }
};
