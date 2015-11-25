<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubroAlumnoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Rubro_Alumno', function($table) {
            $table->increments('id');
            $table->integer('idRubro');
            $table->string('Cedula_Alumno',20);
            $table->integer('Valor_Obtenido');
            $table->string('Trimestre',3);
            $table->string('Anio',4);
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
		Schema::drop('Rubro_Alumno');
	}

}
