<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('inventario', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('placa');
            $table->string('descripcion');
            $table->decimal('valor');
            $table->timestamp('fechaIngreso');
            $table->integer('categoria')->unsigned();
            $table->string('marca');
            $table->boolean('habilitadoPrestamo');
            $table->integer('estado')->unsigned();
            $table->integer('responsable')->unsigned();
            $table->string('rutaImagen');
            $table->boolean('activo');
            $table->timestamps();

            $table->foreign('responsable')
                ->references('id')
                ->on('users');

            $table->foreign('categoria')
                ->references('id')
                ->on('categorias');

            $table->foreign('estado')
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
		Schema::drop('inventario');
	}

}
