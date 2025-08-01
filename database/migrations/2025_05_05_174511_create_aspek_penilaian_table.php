<?php

// ========================================
// 1. MIGRATION: AspekPenilaian
// File: database/migrations/2024_01_01_000001_create_aspek_penilaian_table.php
// ========================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspek_penilaian', function (Blueprint $table) {
            $table->id('id_aspek');
            $table->string('kode_aspek', 10)->unique();
            $table->string('nama_aspek');
            $table->boolean('has_sub_aspek')->default(false);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspek_penilaian');
    }
};
