<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntregablesRecibidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Entregables_Recibidos', function($table) {
            $table->increments('id');
            $table->integer('idEntregable');
            $table->string('Cedula_Alumno',20);
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
		Schema::drop('Entregables_Recibidos');
	}

}
