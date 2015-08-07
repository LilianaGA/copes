<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposAccesoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Tipos_Acceso', function($table) {
            $table->increments('id');
            $table->string('Descripcion',60);
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
		Schema::drop('Tipos_Acceso');
	}

}
