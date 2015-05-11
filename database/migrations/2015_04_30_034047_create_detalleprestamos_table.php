<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleprestamosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('detalleprestamos', function(Blueprint $table)
        {
            $table->increments('idPrestamo');
            $table->integer('idInventario')->unsigned();
            $table->integer('estadoEntrega')->unsigned();
            $table->integer('estadoDevolucion')->unsigned()->nullable();

            $table->foreign('idPrestamo')
                ->references('id')
                ->on('prestamos');

            $table->foreign('idInventario')
                ->references('id')
                ->on('inventario');

            $table->foreign('estadoEntrega')
                ->references('id')
                ->on('estadoarticulo');

            $table->foreign('estadoDevolucion')
                ->references('id')
                ->on('estadoarticulo');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('detalleprestamos');
	}

}
