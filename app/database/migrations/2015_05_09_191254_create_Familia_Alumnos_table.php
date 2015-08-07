<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliaAlumnosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Familia_Alumnos', function($table) {
                $table->increments('id');
                $table->string('Codigo_Familia',20);
                $table->string('Cedula_Alumno',20);
                $table->string('Nombre_Alumno',50);
                $table->string('Apellido1_Alumno', 64);
                $table->string('Apellido2_Alumno', 64);
                $table->string('Seccion_Alumno', 20);
                $table->string('Nivel_Alumno', 20);
                $table->double('Monto_Mensual');
                $table->foreign('Codigo_Familia')->references('Codigo_Familia')->on('Codigo_Familia');
                $table->unique('Cedula_Alumno');
                $table->string('Estado',2);
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
		Schema::drop('Familia_Alumnos');
	}

}
