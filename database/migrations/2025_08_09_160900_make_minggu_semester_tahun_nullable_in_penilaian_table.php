<?php

use Doctrine\DBAL\Types\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Register the tinyinteger type with Doctrine DBAL
        if (!Type::hasType('tinyinteger')) {
            Type::addType('tinyinteger', \Doctrine\DBAL\Types\IntegerType::class);
        }
        
        // Get the database platform and register the type mapping
        $platform = DB::getDoctrineConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('tinyinteger', 'integer');

        Schema::table('penilaian', function (Blueprint $table) {
            // Make minggu_ke, semester, and tahun_ajaran nullable to prevent constraint errors
            $table->unsignedTinyInteger('minggu_ke')->nullable()->change();
            $table->string('semester', 10)->nullable()->change();
            $table->string('tahun_ajaran', 9)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Register the tinyinteger type with Doctrine DBAL
        if (!Type::hasType('tinyinteger')) {
            Type::addType('tinyinteger', \Doctrine\DBAL\Types\IntegerType::class);
        }
        
        // Get the database platform and register the type mapping
        $platform = DB::getDoctrineConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('tinyinteger', 'integer');

        Schema::table('penilaian', function (Blueprint $table) {
            $table->unsignedTinyInteger('minggu_ke')->nullable(false)->change();
            $table->string('semester', 10)->nullable(false)->change();
            $table->string('tahun_ajaran', 9)->nullable(false)->change();
        });
    }
};
