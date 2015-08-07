<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeccionHoraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Leccion_Hora', function($table) {
                $table->increments('id');
                $table->integer('Numero');
                $table->string('Hora',20);
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
		Schema::drop('Leccion_Hora');
	}

}
