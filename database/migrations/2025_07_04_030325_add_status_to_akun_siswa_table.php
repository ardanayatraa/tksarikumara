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
        Schema::table('akun_siswa', function (Blueprint $table) {
            // Menambahkan kolom status setelah kolom password
            $table->enum('status', ['TK-A', 'TK-B','LULUS',"BELUM-DITENTUKAN"])
                  ->default('BELUM-DITENTUKAN')
                  ->after('password')
                  ->comment('Status akun siswa: active atau inactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('akun_siswa', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
