<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('mdf', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary('NumSerie');
        });
    }

    public function down()
    {
        Schema::table('mdf', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary('CodeColaimo');
        });
    }
};
