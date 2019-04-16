<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apuesta', function (Blueprint $table) {
            $table->increments('idApuesta');
            $table->unsignedInteger('idTicket')->nullable();
            $table->unsignedInteger('idTipoApuesta')->nullable();
            $table->unsignedInteger('idMoneda')->nullable();
            $table->decimal('montoApostado',18,2)->nullable();
            $table->decimal('montoAPagar',18,2)->nullable();
            $table->integer('ganador')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apuesta');
    }
}
