<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('prestamos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('idReserva')->unsigned()->nullable();
            $table->integer('responsable')->unsigned();
            $table->timestamp('fechaInicio');
            $table->timestamp('fechaFin');
            $table->timestamp('fechaEntrega');
            $table->timestamp('fechaDevolucion')->nullable();
            $table->integer('entregadoPor')->unsigned();
            $table->integer('recibidoPor')->unsigned()->nullable();
            $table->string('observacionesEntrega', 400)->nullable();
            $table->string('observacionesDevolucion', 400)->nullable();
            $table->string('estado');
            $table->boolean('notificadoRetraso')->nullable();
            $table->timestamps();

            $table->foreign('responsable')
                ->references('id')
                ->on('users');

            $table->foreign('entregadoPor')
                ->references('id')
                ->on('users');

            $table->foreign('recibidoPor')
                ->references('id')
                ->on('users');

            $table->foreign('idReserva')
                ->references('id')
                ->on('reservas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('prestamos');
	}

}
