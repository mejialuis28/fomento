<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return voidse
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombres');
            $table->string('apellidos');
            $table->integer('tipoUsuario')->unsigned();
            $table->string('habilitado');
            $table->string('email');
			$table->integer('documento')->unique();
			$table->string('password', 60);
			$table->rememberToken();
			$table->timestamps();

            $table->foreign('tipoUsuario')
                ->references('id')
                ->on('tipousuario');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
