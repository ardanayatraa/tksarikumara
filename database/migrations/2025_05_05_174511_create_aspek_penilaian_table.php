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
        Schema::create('aspek_penilaian', function (Blueprint $table) {
            $table->id('id_aspek');
            $table->string('kode_aspek')->unique();
            $table->string('nama_aspek');
            $table->string('kategori');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('min_umur')->nullable();
            $table->unsignedBigInteger('max_umur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspek_penilaian');
    }
};
