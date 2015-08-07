<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Citas', function($table) {
            $table->increments('id');
            $table->string('Cedula_Alumno',20);
            $table->integer('id_Hora_Atencion');
            $table->timestamp('Fecha_Cita');
            $table->string('Estado_Cita', 2);
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->foreign('Cedula_Alumno')->references('Cedula_Alumno')->on('Familia_Alumnos');
            $table->foreign('id_Hora_Atencion')->references('id')->on('Hora_Atencion');
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
		Schema::drop('Citas');
	}

}

