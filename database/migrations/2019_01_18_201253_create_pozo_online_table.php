<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePozoOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pozo_online', function (Blueprint $table) {
            $table->increments('idPozoOnline');
            $table->unsignedInteger('idPozoJackpot')->nullable();
            $table->decimal('montoActual',18,2)->nullable();
            $table->decimal('montoPozoOculto',18,2)->nullable();
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
        Schema::dropIfExists('pozo_online');
    }
}
