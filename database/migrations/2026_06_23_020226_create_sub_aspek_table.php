<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_aspek', function (Blueprint $table) {
            $table->id('id_sub_aspek');
            $table->foreignId('aspek_id')
                  ->constrained('aspek_penilaian', 'id_aspek')
                  ->onDelete('cascade');
            $table->string('kode_sub_aspek', 10);
            $table->string('nama_sub_aspek');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['aspek_id', 'kode_sub_aspek']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_aspek');
    }
};
