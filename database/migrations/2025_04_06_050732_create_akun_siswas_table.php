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
        Schema::create('akun_siswa', function (Blueprint $table) {
            $table->id('id_akunsiswa');
            $table->unsignedBigInteger('id_kelas')->nullable();
            $table->string('nisn')->unique()->nullable();
            $table->string('namaSiswa')->nullable();
            $table->string('foto')->nullable();
            $table->string('namaOrangTua')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_siswa');
    }
};
