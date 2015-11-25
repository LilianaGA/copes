<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubroAsignacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Rubro_Asignacion', function($table) {
            $table->increments('id');
            $table->integer('idRubro');
            $table->string('Nivel', 20);
            $table->string('Materia',100);
            $table->string('Valor');
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
		Schema::drop('Rubro_Asignacion');
	}

}
