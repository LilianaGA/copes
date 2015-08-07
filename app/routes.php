<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

	Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showWelcome'));
	Route::get('/', array('as' => '/', 'uses' => 'HomeController@showWelcome'));


/*
|--------------------------------------------------------------------------
| Rutas  de Autheticatiion
|--------------------------------------------------------------------------
*/
	
	Route::get('login', array('as' => 'login','uses' => 'UsuarioController@login'))->before('guest');//Carga el formulario de inicio de sesión
	Route::post('login', array('as' => 'login','uses' => 'UsuarioController@authentication'))->before('guest');	//Valida las credenciales del usuario

/*
|--------------------------------------------------------------------------
| Rutas LOGOUT
|--------------------------------------------------------------------------
*/

	Route::get('logout', array('as' => 'logout', function () {
		Auth::logout();
		return Redirect::route('home')->with('flash_info', 'Se ha cerrado la sesión del usuario');
	}))->before('auth');

    Route::get('logoutFromRol', array('as' => 'logoutFromRol', function () {
        Auth::logout();
        return Redirect::route('home')->with('flash_danger', 'Se ha negado el acceso por falta de permisos');
    }));

/*
|--------------------------------------------------------------------------
| Rutas Registrar
|--------------------------------------------------------------------------
*/
//Carga formulario para creación de nuevo registro
	Route::get('signin', array('as' => 'signin','uses' => 'UsuarioController@create'))->before('guest');

//Valida y almacena un nuevo registro de usuario
	Route::post('signin', array('as' => 'signin','uses' => 'UsuarioController@store'))->before('guest');

/*
|--------------------------------------------------------------------------
| Rutas Perfil de Administrador
|--------------------------------------------------------------------------
*/
    Route::get('administracion/usuarios', array('as' => 'usuarios', 'uses' => 'AdministradorController@showUsuarios'))->before('auth');
    Route::get('administracion/profesor', array('as' => 'AdminProfesor', 'uses' => 'AdministradorController@showProfesor'))->before('auth');
    Route::get('administracion/citas', array('as' => 'AdminCitas', 'uses' => 'AdministradorController@showCitas'))->before('auth');
    Route::get('administracion/roles/{id}', array('as' => 'AdminRoles', 'uses' => 'AdministradorController@showRoles'))->before('auth');
    Route::get('administracion/roles/delete/{id}', array('as' => 'AdminRoles', 'uses' => 'AdministradorController@deleteRoles'))->before('auth');
    Route::get('administracion/roles/add/{id}/{tipo}', array('as' => 'AddRoles', 'uses' => 'AdministradorController@addRoles'))->before('auth');
    Route::get('administracion/familias', array('as' => 'AdminFamilias', 'uses' => 'AdministradorController@showFamilias'))->before('auth');
    Route::get('administracion/atencion', array('as' => 'AdminAtencion', 'uses' => 'AdministradorController@showAtencion'))->before('auth');
    Route::get('Administrativo/Usuarios/nuevo', array('as' => 'newUser', 'uses' => 'AdministradorController@createUser'))->before('auth'); 
    Route::post('storeUser', array('as' => 'storeUser','uses' => 'AdministradorController@store'))->before('auth'); 
    Route::post('storeStudent', array('as' => 'storeStudent','uses' => 'AdministradorController@storeStudent'))->before('auth'); 
    Route::get('Administrativo/{id}/edit', array('as' => 'editUser','uses' => 'AdministradorController@editUser'))->before('auth'); 
    Route::get('Administrativo/{user}', array('as' => 'showUser','uses' => 'AdministradorController@mostrar'))->before('auth'); 
    Route::put('Administrativo/{pay}/actualizar', 'AdministradorController@updateUser')->before('auth');
    Route::put('{user}/pass', 'AdministradorController@updatePass')->before('auth');
    Route::get('Administrativo/{id}/eliminar', 'AdministradorController@destroy')->before('auth');
    Route::get('Administrativo/{id}/habilitar', 'AdministradorController@active')->before('auth');
    Route::get('Administrativo/searchTeacher/{id}', 'AdministradorController@searchTeacher')->before('auth');
    Route::get('Administrativo/familias/nuevo', array('as' => 'newFamily', 'uses' => 'AdministradorController@createFamily'))->before('auth'); 
    Route::post('storeFamily', array('as' => 'storeFamily','uses' => 'AdministradorController@storeFamily'))->before('auth'); 
    Route::get('Administrativo/{id}/editFamily', array('as' => 'editFamily','uses' => 'AdministradorController@editFamily'))->before('auth'); 
    Route::put('Administrativo/{id}/updateFamily', array('as' => 'updateFamily','uses' => 'AdministradorController@updateFamily'))->before('auth'); 
    Route::get('Administrativo/{id}/showFamily', array('as' => 'showFamily','uses' => 'AdministradorController@showFamily'))->before('auth'); 
    Route::get('Administrativo/{id}/deleteFamily', 'AdministradorController@deleteFamily')->before('auth');
    Route::get('Administrativo/{id}/activeFamily', 'AdministradorController@activeFamily')->before('auth');
    Route::get('Administrativo/{id}/deleteStudent', 'AdministradorController@deleteStudent')->before('auth');
    Route::get('Administrativo/{id}/activeStudent', 'AdministradorController@activeStudent')->before('auth');
    Route::get('Administrativo/{id}/editStudent', array('as' => 'editStudent','uses' => 'AdministradorController@editStudent'))->before('auth'); 
    Route::put('Administrativo/{id}/updateStudent', array('as' => 'updateStudent','uses' => 'AdministradorController@updateStudent'))->before('auth'); 
    Route::get('Administrativo/statusFamily/{id}', 'AdministradorController@statusFamily')->before('auth');
    Route::get('Administrativo/searchInfo/{id}', 'AdministradorController@showInfo')->before('auth')->before('auth');
    Route::get('Administrativo/updateHour/{CedulaP}/{Dia}/{Hora}', 'AdministradorController@updateHour')->before('auth');
    Route::get('Administrativo/storeHour/{CedulaP}/{Dia}/{Hora}', 'AdministradorController@storeHour')->before('auth');
    Route::get('Administrativo/storeMateria/{Cedula}/{Materia}/{Seccion}', 'AdministradorController@storeMateria')->before('auth');
    Route::get('Administrativo/getFamily/{id}', 'AdministradorController@getFamily')->before('auth');
    Route::get('Administrativo/getEmails/{cedula}', 'AdministradorController@getEmails')->before('auth');
    Route::get('Administrativo/getPhones/{id}', 'AdministradorController@getPhones')->before('auth');
    Route::get('Administrativo/getSubjects/{id}', 'AdministradorController@getSubjects')->before('auth');
    Route::get('Administrativo/{id}/eliminarMateria', 'AdministradorController@deleteSubject')->before('auth');
    Route::get('Administrativo/{id}/searchSubject', 'AdministradorController@searchProfesorSubject')->before('auth');
    Route::get('Administrativo/updateMateria/{Cedula}/{Materia}/{Seccion}', 'AdministradorController@updateMateria')->before('auth');
    Route::get('Administrativo/Citas/nuevo', array('as' => 'newCitas', 'uses' => 'AdministradorController@createCitas'))->before('auth');

/*
|--------------------------------------------------------------------------
| Rutas Perfil de Profesor
|--------------------------------------------------------------------------
*/
    Route::get('profesor/index', array('as' => 'principalProfe', 'uses' => 'ProfesorController@showProfesor'))->before('auth');
    Route::get('profesor/{id}/editar', array('as' => 'editarCita', 'uses' => 'ProfesorController@showCita'))->before('auth');
    Route::get('profesor/{id}/{estado}/{comentario}', 'ProfesorController@updateCita')->before('auth');
    Route::get('profesor/{id}', 'ProfesorController@deleteCita')->before('auth');
	


/*
|--------------------------------------------------------------------------
| Rutas Perfil de Padre
|--------------------------------------------------------------------------
*/
    Route::get('padre/saldos', array('as' => 'saldos', 'uses' => 'PadreController@showSaldos'))->before('auth');
    Route::get('padre/cancelaCitas', array('as' => 'cancelaCitas', 'uses' => 'PadreController@showCancelaCitas'))->before('auth');
    Route::get('padre/citas', array('as' => 'citas', 'uses' => 'PadreController@showCitas'))->before('auth');
    Route::get('padre/certificados', array('as' => 'certificados', 'uses' => 'PadreController@showCertificados'))->before('auth');
    Route::get('padre/showSubjects/{id}', 'PadreController@showSubjects')->before('auth');
    Route::get('padre/showApp/{id}', 'PadreController@showApp')->before('auth');
    Route::get('padre/showAppointByMonth/{id}', 'PadreController@showAppointByMonth')->before('auth');
    Route::get('padre/reserveApp/{CedulaA}/{CedulaP}/{Fecha}', 'PadreController@reserveApp')->before('auth');
    Route::get('padre/{id}', 'PadreController@updateCita')->before('auth');
    Route::get('padre/citas/{id}', 'PadreController@getDate')->before('auth');
    Route::get('padre/sendEmail/{CedulaA}/', 'PadreController@sendEmail')->before('auth');
    Route::get('padre/sendEmail/{CedulaA}/{CedulaP}/{Fecha}/', 'PadreController@sendEmail')->before('auth');
    Route::get('padre/obtenerCertificado/{tipo}/{cedula}/{nombre}/{fecha}/{nivel}/{anio}', 'PadreController@obtenerCertificado')->before('auth');
/*
|--------------------------------------------------------------------------
| Rutas Perfil de Contabilidad
|--------------------------------------------------------------------------
*/
    Route::get('contabilidad/pagos', array('as' => 'ContPagos', 'uses' => 'ContadorController@showPagos'))->before('auth');
	Route::get('contabilidad/pagos/nuevo', array('as' => 'newPago', 'uses' => 'ContadorController@createPago'))->before('auth'); 
    Route::get('contabilidad/reportes', array('as' => 'ContReportes', 'uses' => 'ContadorController@showReportes'))->before('auth');
    Route::post('storePay', array('as' => 'storePay','uses' => 'ContadorController@storePay'))->before('auth'); 
    Route::get('contabilidad/getFamilyBalance/{id}', 'ContadorController@getFamilyBalance')->before('auth');
    Route::get('contabilidad/getPaysOfMonth/{id}', 'ContadorController@getPaysOfMonth')->before('auth');
    Route::get('contabilidad/getPaysOfFamily/{id}', 'ContadorController@getPaysOfFamily')->before('auth');
    Route::get('contabilidad/getPaysOfStudent/{id}', 'ContadorController@getPaysOfStudent')->before('auth');
	Route::get('contabilidad/calculateNotPaidAccount', array('as' => 'calculateNotPaidAccount','uses' => 'ContadorController@viewCalculateNotPaidAccount'))->before('auth'); 
    Route::get('contabilidad/{pay}', array('as' => 'showPago','uses' => 'ContadorController@displayPay'))->before('auth'); 
	Route::get('contabilidad/{pay}/editar', array('as' => 'editPago','uses' => 'ContadorController@editPay'))->before('auth'); 
	Route::put('contabilidad/{pay}/actualizar', 'ContadorController@updatePago')->before('auth');
    Route::get('contabilidad/getGroup/{id}', 'ContadorController@getGroup')->before('auth');
    Route::get('contabilidad/calculateNotPaidAccount/{id}/{correo}', 'ContadorController@calculateNotPaidAccount')->before('auth');
    Route::get('contabilidad/searchSubject/{id}', 'ContadorController@searchSubject')->before('auth');
    Route::get('contabilidad/{id}/eliminarPago', 'ContadorController@destroyPay')->before('auth');


