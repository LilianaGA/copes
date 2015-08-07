<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoraAtencionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Hora_Atencion', function($table) {
            $table->increments('id');
            $table->string('Codigo_Profesor',20);
            $table->string('Dia',50);
            $table->integer('Leccion_Hora');
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->foreign('Codigo_Profesor')->references('Cedula')->on('Usuarios');
            $table->foreign('Leccion_Hora')->references('id')->on('Leccion_Hora');
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
		Schema::drop('Hora_Atencion');
	}

}
