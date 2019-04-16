<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion_evento', function (Blueprint $table) {
            $table->increments('idConfiguracionEvento');
            $table->string('nombre',50)->nullable();
            $table->integer('lapsoProxEventoHoras')->nullable();
            $table->integer('lapsoProxEventoDia')->nullable();
            $table->integer('lapsoProxEventoDiaSemana')->nullable();
            $table->decimal('apuestaMinima',18,2)->nullable();
            $table->decimal('apuestaMaxima',18,2)->nullable();
            $table->integer('minutosPreviosEvento')->nullable();
            $table->integer('diasVigentesCobroTicket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracion_evento');
    }
}
