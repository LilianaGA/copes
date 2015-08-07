<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Pagos', function($table) {
            $table->increments('id');
            $table->string('Codigo_Familia',20);
            $table->string('Banco', 256);
            $table->string('Numero_Recibo_Banco', 50);
            $table->integer('Cedula_Alumno');
            $table->double('Monto_Recibo');
            $table->string('Mensualidad');
            $table->double('Recargo');
            $table->timestamp('Fecha_Pago');
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->foreign('Codigo_Familia')->references('Codigo_Familia')->on('Codigo_Familia');
            $table->foreign('Cedula_Alumno')->references('id')->on('Familia_Alumnos');
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
		Schema::drop('Pagos');
	}

}
