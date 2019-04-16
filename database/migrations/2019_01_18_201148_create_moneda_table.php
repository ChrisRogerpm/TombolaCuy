<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonedaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moneda', function (Blueprint $table) {
            $table->increments('idMoneda');
            $table->string('nombre',50)->nullable();
            $table->string('simbolo',50)->nullable();
            $table->string('codlso',50)->nullable();
            $table->integer('principal')->nullable();
            $table->integer('estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moneda');
    }
}
