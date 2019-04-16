<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_venta', function (Blueprint $table) {
            $table->increments('idPuntoVenta');
            $table->unsignedInteger('idEmpresa')->nullable();
            $table->unsignedInteger('idUbigeo')->nullable();
            $table->string('nombre',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punto_venta');
    }
}
