<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBobotToIndikatorAspekTable extends Migration
{
    public function up()
    {
        Schema::table('indikator_aspek', function (Blueprint $table) {
            $table->unsignedTinyInteger('bobot')->default(1)->after('max_umur');
        });
    }

    public function down()
    {
        Schema::table('indikator_aspek', function (Blueprint $table) {
            $table->dropColumn('bobot');
        });
    }
}
