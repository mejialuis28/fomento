<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reservas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('responsable')->unsigned();
            $table->timestamp('fechaInicio');
            $table->timestamp('fechaFin');
            $table->string('comentarios');
            $table->string('estado');                                  
            $table->timestamps();

            $table->foreign('responsable')
                ->references('id')
                ->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('reservas');
	}

}
