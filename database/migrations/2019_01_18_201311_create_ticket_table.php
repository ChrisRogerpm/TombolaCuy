<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->increments('idTicket');
            $table->unsignedInteger('idAperturaCaja')->nullable();
            $table->unsignedInteger('idEvento')->nullable();
            $table->unsignedInteger('idCliente')->nullable();
            $table->string('codigoQR',10)->nullable();
            $table->string('nroTicketParticipante',50)->nullable();
            $table->integer('ganador')->nullable();
            $table->integer('estadoTicket')->nullable();
            $table->decimal('montoTotal',18,2)->nullable();
            $table->dateTime('fechaPago')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
