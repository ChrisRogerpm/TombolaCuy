<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePozoJackpotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pozo_jackpot', function (Blueprint $table) {
            $table->increments('idPozoJackpot');
            $table->unsignedInteger('idJackpot')->nullable();
            $table->unsignedInteger('idTicketGanador')->nullable();
            $table->unsignedInteger('idMoneda')->nullable();
            $table->integer('numeroPozo')->nullable();
            $table->decimal('montoBase',18,2)->nullable();
            $table->decimal('montoBaseOculto',18,2)->nullable();
            $table->decimal('incrementoJackpot',18,2)->nullable();
            $table->decimal('incrementoPozoOculto',18,2)->nullable();
            $table->decimal('limiteInferior',18,2)->nullable();
            $table->decimal('limiteSuperior',18,2)->nullable();
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
        Schema::dropIfExists('pozo_jackpot');
    }
}
