<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJackpotPuntoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jackpot_punto_venta', function (Blueprint $table) {
            $table->increments('idJackpotPuntoVenta');
            $table->unsignedInteger('idJackpot')->nullable();
            $table->unsignedInteger('idPuntoVenta')->nullable();
            $table->boolean('estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jackpot_punto_venta');
    }
}
