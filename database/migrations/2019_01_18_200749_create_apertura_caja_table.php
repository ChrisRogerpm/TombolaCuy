<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAperturaCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apertura_caja', function (Blueprint $table) {
            $table->increments('idAperturaCaja');
            $table->unsignedInteger('idCaja')->nullable();
            $table->unsignedInteger('idTurno')->nullable();
            $table->string('usuario',50)->nullable();
            $table->date('fechaOperacion')->nullable();
            $table->dateTime('fechaRegistro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apertura_caja');
    }
}
