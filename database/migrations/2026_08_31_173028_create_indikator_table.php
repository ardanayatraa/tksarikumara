<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ========================================
// 3. MIGRATION: Indikator
// File: database/migrations/2024_01_01_000003_create_indikator_table.php
// ========================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indikator', function (Blueprint $table) {
            $table->id('id_indikator');
            $table->foreignId('aspek_id')
                  ->constrained('aspek_penilaian', 'id_aspek')
                  ->onDelete('cascade');
            $table->foreignId('sub_aspek_id')
                  ->nullable()
                  ->constrained('sub_aspek', 'id_sub_aspek')
                  ->onDelete('cascade');
            $table->string('kode_indikator', 10);
            $table->text('deskripsi_indikator');
            $table->enum('kelompok_usia', ['2-3_tahun', '3-4_tahun','4-5_tahun', '5-6_tahun']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['aspek_id', 'sub_aspek_id', 'kode_indikator', 'kelompok_usia'], 'unique_indikator');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator');
    }
};
