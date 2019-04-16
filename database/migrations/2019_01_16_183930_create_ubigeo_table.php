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
            $table->string('PaisId',100)->nullable();
            $table->string('DepartamentoId',100)->nullable();
            $table->string('ProvinciaId',100)->nullable();
            $table->string('DistritoId',100)->nullable();
            $table->string('Nombre',100)->nullable();
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
