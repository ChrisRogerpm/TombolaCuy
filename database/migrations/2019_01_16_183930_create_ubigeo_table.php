<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbigeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubigeo', function (Blueprint $table) {
            $table->increments('idUbigeo');
            $table->string('PaisId')->nullable();
            $table->string('DepartamentoId')->nullable();
            $table->string('ProvinciaId')->nullable();
            $table->string('DistritoId')->nullable();
            $table->string('Nombre')->nullable();
            $table->date('fechaRegistro')->nullable();
            $table->boolean('Estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubigeo');
    }
}
