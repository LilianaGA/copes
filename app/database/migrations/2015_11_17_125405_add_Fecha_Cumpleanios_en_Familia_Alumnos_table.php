<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaCumpleaniosEnFamiliaAlumnosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Familia_Alumnos', function($table)
		{
			$date = new DateTime();
		    $table->date('Fecha_Nacimiento')->default($date->format('Y-m-01'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	 	Schema::table('Familia_Alumnos', function ($table) {
            $table->dropColumn('Fecha_Nacimiento');
        });
	}

}
