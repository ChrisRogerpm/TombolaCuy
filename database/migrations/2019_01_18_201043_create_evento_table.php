<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento', function (Blueprint $table) {
            $table->increments('idEvento');
            $table->unsignedInteger('idConfiguracionEvento')->nullable();
            $table->decimal('incrementoJackpot',18,2)->nullable();
            $table->date('fechaEvento')->nullable();
            $table->time('horaInicio')->nullable();
            $table->time('horaFin')->nullable();
            $table->date('fechaEventoReprogramacion')->nullable();
            $table->time('horaInicioReprogramacion')->nullable();
            $table->time('horaFinReprogramacion')->nullable();
            $table->integer('estadoApuestas')->nullable();
            $table->integer('estadoEvento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento');
    }
}
