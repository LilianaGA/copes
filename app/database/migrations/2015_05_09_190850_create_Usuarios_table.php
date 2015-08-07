<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (Schema::hasTable('users')){
            down();
            up();
        }else{
            Schema::create('Usuarios', function($table) {
                    $table->increments('id');
                    $table->string('Cedula',20);
                    $table->string('username',20);
                    $table->string('Codigo_Familia',50);
                    $table->string('Nombre',50);
                    $table->string('Apellido1', 64);
                    $table->string('Apellido2', 64);
                    $table->string('Direccion', 200);
                    $table->string('password',300);
                    $table->string('estado',2);
                    $table->string('remember_token', 100)->nullable()->default(null);
                    $table->unique('Cedula');
                    $table->foreign('Codigo_Familia')->references('Codigo_Familia')->on('Codigo_Familia');
                    $table->timestamps();
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Usuarios');
	}

}
