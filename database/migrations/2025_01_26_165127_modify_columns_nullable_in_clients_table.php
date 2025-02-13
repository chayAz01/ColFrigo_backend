<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsNullableInClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('RaisonSociale')->nullable()->change();
            $table->string('RC')->nullable()->change();
            $table->string('Patente')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('RaisonSociale')->nullable(false)->change();
            $table->string('RC')->nullable(false)->change();
            $table->string('Patente')->nullable(false)->change();
        });
    }
}
