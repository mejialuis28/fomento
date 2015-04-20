<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministradoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('administradores', function(Blueprint $table)
        {
            $table->integer('usuario')->unsigned();
            $table->boolean('activo');

            $table->foreign('usuario')
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
        Schema::drop('administradores');
	}

}
