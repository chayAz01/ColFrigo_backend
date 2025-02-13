<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Class newContrats extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->string('NumContrat')->primary();
            $table->string('Etat');
            $table->date('date');
            $table->string('clientId');
            $table->integer('mdfId');
            $table->string('superviseur');
            $table->foreign('clientId')->references('CodeClient')->on('clients');
            $table->foreign('mdfId')->references('NumSerie')->on('mdf');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contrats');
    }

};
