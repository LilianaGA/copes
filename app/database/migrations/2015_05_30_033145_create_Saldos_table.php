<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Saldos', function($table) {
            $table->increments('id');
            $table->string('Codigo_Familia',20);
            $table->integer('id_Pago');
            $table->double('Diferencia');
            $table->string('Descripcion',100);
            $table->foreign('id_Pago')->references('id')->on('Pagos');
            $table->foreign('Codigo_Familia')->references('Codigo_Familia')->on('Codigo_Familia');
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
		Schema::drop('Saldos');
	}

}
