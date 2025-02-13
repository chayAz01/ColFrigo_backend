<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('contrats');
    }

    public function down()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->string('NumContrat')->primary();
            $table->string('Etat');
            $table->date('date');
            $table->string('clientId');
            $table->string('mdfId');
            $table->string('superviseur');
            $table->foreign('clientId')->references('CodeClient')->on('clients');
            $table->foreign('mdfId')->references('NumSerie')->on('mdfs');
            $table->timestamps();
        });
    }

};
