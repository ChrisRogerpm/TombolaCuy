<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_pago', function (Blueprint $table) {
            $table->increments('idTipoPago');
            $table->string('nombre',50)->nullable();
            $table->decimal('multiplicadorDefecto',18,2)->nullable();
            $table->integer('plenoMinimo')->nullable();
            $table->integer('plenoMaximo')->nullable();
            $table->integer('intercalado')->nullable();
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
        Schema::dropIfExists('tipo_pago');
    }
}
