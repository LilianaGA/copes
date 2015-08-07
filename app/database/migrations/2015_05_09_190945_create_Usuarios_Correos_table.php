<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosCorreosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Usuarios_Correos', function($table) {
                $table->increments('id');
                $table->string('Cedula',20);
                $table->string('Correo', 100);
                $table->foreign('Cedula')->references('Cedula')->on('Usuarios');
                $table->string('remember_token', 100)->nullable()->default(null);
                $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Usuarios_Correos');
	}

}
