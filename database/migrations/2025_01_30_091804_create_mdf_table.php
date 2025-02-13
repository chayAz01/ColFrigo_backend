<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMDFTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('MDF', function (Blueprint $table) {
            $table->integer('NumSerie')->primary();
            $table->string('CodeColaimo')->unique();
            $table->string('Type');
            $table->string('Marque');
            $table->string('Fabrication')->nullable();
            $table->string('Predetenseur')->nullable();
            $table->string('Etat');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('MDF');
    }
};
