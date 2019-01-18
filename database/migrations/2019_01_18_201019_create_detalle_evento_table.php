<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_evento', function (Blueprint $table) {
            $table->increments('idDetalleEvento');
            $table->unsignedInteger('idEvento')->nullable();
            $table->decimal('multiplicadorApuestaGanada',18,2)->nullable();
            $table->string('valorGanador',10)->nullable();
            $table->unsignedInteger('idPagoApuesta')->nullable();
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
        Schema::dropIfExists('detalle_evento');
    }
}
