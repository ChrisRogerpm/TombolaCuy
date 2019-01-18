<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGanadorEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ganador_evento', function (Blueprint $table) {
            $table->increments('idGanadorEvento');
            $table->unsignedInteger('idApuesta')->nullable();
            $table->string('nroTicketParticipante',10)->nullable();
            $table->dateTime('fechaPago')->nullable();
            $table->string('montoAPagar',10)->nullable();
            $table->string('serieComprobante',10)->nullable();
            $table->string('nroComprobante',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ganador_evento');
    }
}
