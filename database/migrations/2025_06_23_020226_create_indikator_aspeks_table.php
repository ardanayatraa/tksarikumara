<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indikator_aspek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspek_id')
                  ->constrained('aspek_penilaian', 'id_aspek')
                  ->onDelete('cascade');
            $table->string('kode_indikator');
            $table->string('nama_indikator');
            $table->unsignedTinyInteger('min_umur');
            $table->unsignedTinyInteger('max_umur');
            $table->timestamps();

            $table->unique(['aspek_id', 'kode_indikator']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator_aspek');
    }
};
