<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ========================================
// 4. MIGRATION: Penilaian
// File: database/migrations/2024_01_01_000004_create_penilaian_table.php
// ========================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->unsignedBigInteger('id_akunsiswa');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_kelas');
            $table->date('tgl_penilaian');
            $table->enum('kelompok_usia_siswa', ['2-3_tahun', '3-4_tahun']);
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->text('catatan_umum')->nullable();
            $table->timestamps();

            // Foreign keys (sesuaikan dengan table yang ada)
            // $table->foreign('id_akunsiswa')->references('id')->on('akun_siswa');
            // $table->foreign('id_guru')->references('id_guru')->on('guru');
            // $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
