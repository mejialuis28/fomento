<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallereservasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('detallereservas', function(Blueprint $table)
        {
            $table->integer('idReserva')->unsigned();
            $table->integer('idInventario')->unsigned();

            $table->foreign('idReserva')
                ->references('id')
                ->on('reservas');

            $table->foreign('idInventario')
                ->references('id')
                ->on('inventario');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('detallereservas');
	}

}
