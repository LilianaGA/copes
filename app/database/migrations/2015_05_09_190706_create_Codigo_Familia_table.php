<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodigoFamiliaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Codigo_Familia', function($table) {
            $table->increments('id');
            $table->string('Codigo_Familia',50);
            $table->string('Apellido1',40);
            $table->string('Apellido2',40);
            $table->string('Estado',2);
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->unique('Codigo_Familia');
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
		Schema::drop('Codigo_Familia');
	}

}
