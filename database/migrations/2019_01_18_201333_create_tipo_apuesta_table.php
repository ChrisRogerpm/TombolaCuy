<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoApuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_apuesta', function (Blueprint $table) {
            $table->increments('idTipoApuesta');
            $table->unsignedInteger('idTipoPago')->nullable();
            $table->integer('valorapuesta')->nullable();
            $table->string('nombre',50)->nullable();
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
        Schema::dropIfExists('tipo_apuesta');
    }
}
