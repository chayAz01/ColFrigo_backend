<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyNumcontratToString extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contrats', function (Blueprint $table) {

            $table->string('NumContrat')->primary()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('contrats', function (Blueprint $table) {

            $table->integer('NumContrat')->primary()->change();
        });
    }
}
