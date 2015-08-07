<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Tipos_Usuarios', function($table) {
            $table->increments('id');
            $table->string('Cedula_Usuarios',20);
            $table->integer('Tipos_Accesos');
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->foreign('Cedula_Usuarios')->references('Cedula')->on('Usuarios');
            $table->foreign('Tipos_Accesos')->references('id')->on('Tipos_Acceso');
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
		Schema::drop('Tipos_Usuarios');
	}

}
