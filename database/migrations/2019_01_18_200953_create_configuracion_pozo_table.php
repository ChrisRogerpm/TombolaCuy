<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionPozoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion_pozo', function (Blueprint $table) {
            $table->increments('idConfiguracionPozo');
            $table->unsignedInteger('idConfiguracionJackpot')->nullable();
            $table->integer('numeroPozo')->nullable();
            $table->decimal('montoBase',18,2)->nullable();
            $table->decimal('montoBaseOculto',18,2)->nullable();
            $table->decimal('incrementoJackpot',18,2)->nullable();
            $table->decimal('incrementoPozoOculto',18,2)->nullable();
            $table->decimal('limiteInferior',18,2)->nullable();
            $table->decimal('limiteSuperior',18,2)->nullable();
            $table->decimal('limiteInferiorOculto',18,2)->nullable();
            $table->decimal('limiteSuperiorOculto',18,2)->nullable();
            $table->integer('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracion_pozo');
    }
}
