<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->string('CodeClient')->primary();
            $table->string('nom') ;
            $table->string('prenom') ;
            $table->string('cin')->unique() ;
            $table->string('adresse') ;
            $table->string('telephone');
            $table->string('RaisonSociale')->nullable();
            $table->string('RC')->nullable();
            $table->string('Patente')->nullable();
            $table->string('Secteur');
            $table->string('Region');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('clients') ;
    }
};
