<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJackpotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jackpot', function (Blueprint $table) {
            $table->increments('idJackpot');
            $table->unsignedInteger('idConfiguracionJackpot')->nullable();
            $table->unsignedInteger('idPuntoVenta')->nullable();
            $table->string('nombre',50)->nullable();
            $table->integer('estadoJackpot')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jackpot');
    }
}
