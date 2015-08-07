<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesorMateriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Profesor_Materia', function($table) {
            $table->increments('id');
            $table->string('Cedula_Usuarios',20);
            $table->string('Materia',100);
            $table->string('Seccion', 20);
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->foreign('Cedula_Usuarios')->references('Cedula')->on('Usuarios');
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
		Schema::drop('Profesor_Materia');
	}

}
