<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlCitasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Control_Citas', function($table) {
            $table->increments('id');
            $table->string('Codigo_Familia',20);
            $table->integer('Cantidad_Perdida');
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->foreign('Codigo_Familia')->references('Codigo_Familia')->on('Codigo_Familia');
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
		Schema::drop('Control_Citas');
	}

}
