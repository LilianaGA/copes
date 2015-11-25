<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntregablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Entregables', function($table) {
            $table->increments('id');
            $table->integer('idRubroEntregable');
            $table->string('Seccion', 20);
            $table->string('Materia',100);
            $table->text('Detalle');
        	$table->date('Fecha_Entrega');
        	$table->string('Estado',2);
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
		Schema::drop('Entregables');
	}


}
