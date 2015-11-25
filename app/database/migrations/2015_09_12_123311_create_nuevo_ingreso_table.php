<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNuevoIngresoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Nuevo_Ingreso', function($table) {
            $table->increments('id');
            $table->string('Codigo_Familia',20);
            $table->string('Cedula_Alumno',20);
            $table->string('Nombre_Alumno',50);
            $table->string('Apellido1_Alumno', 64);
            $table->string('Apellido2_Alumno', 64);
            $table->string('Nivel_Alumno', 20);
            $table->date('Fecha_Nacimiento');
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
		Schema::drop('Nuevo_Ingreso');
	}


}
