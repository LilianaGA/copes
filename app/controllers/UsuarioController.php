<?php

class UsuarioController extends BaseController {

	/**
	 * Muestra el formulario de inicio de sessión
	 *
	 * @return Response
	 */
	public function login()
	{
		if(Auth::check()){
			$data['Permisos'] = DB::table('Tipos_Acceso as TA')
                    ->join('Tipos_Usuarios AS TU', 'TU.Tipos_Accesos', '=', 'TA.id')
                    ->select('TA.Descripcion')
                    ->where('TU.Cedula_Usuarios', '=', Auth::user()->username)
                    ->get();
        }else{
        	$data['Permisos'] = "";
        } 
		return View::make('authentication.login', $data);
	}
    
	public function authentication()
	{
		$user = array(
		  	'username' => Input::get('username'),
		  	'password' => Input::get('password')
			);
	  
	    if (Auth::attempt($user)) {
	    	

			$permiso = DB::table('Tipos_Acceso AS TA')
	                    ->join('Tipos_Usuarios as TU', 'TU.Tipos_Accesos', '=', 'TA.id')
	                    ->select('TA.Descripcion')
	                    ->where('TU.Cedula_Usuarios', '=',  Auth::user()->username )
	                    ->orderBy('TA.id', 'desc')
	                    ->get(); 

            $status = DB::table('Codigo_Familia')
	                    ->select('Estado')
	                    ->where('Codigo_Familia', '=',  Auth::user()->Codigo_Familia )
	                    ->get(); 
	                    
        	if ($status[0]->Estado == 'T') {
	        	if(count($permiso) > 0){
		    		switch ($permiso[0]->Descripcion) {
		    			case "Administrativo";
			    			return Redirect::to('administracion/usuarios')
		    		        	->with('flash_success', Auth::user()->Nombre . ' ' . Auth::user()->Apellido1 . ' ha iniciado sesión correctamente');
			    			break;
		    			case "Contador";
			    			return Redirect::to('contabilidad/pagos')
		    		        	->with('flash_success', Auth::user()->Nombre . ' ' . Auth::user()->Apellido1 . ' ha iniciado sesión correctamente');
			    			break;
			    		case "Profesor";
			    			return Redirect::to('profesor/index')
		    		        	->with('flash_success', Auth::user()->Nombre . ' ' . Auth::user()->Apellido1 .' ha iniciado sesión correctamente');
			    			break;
		    			case "Encargado":
			    			return Redirect::to('padre/saldos')
		    		        	->with('flash_success', Auth::user()->Nombre . ' ' . Auth::user()->Apellido1 .' ha iniciado sesión correctamente');
			    			break;
			    		default:
			    			return Redirect::route('logoutFromRol'); 
			    			break;
			    	}
		    	}
		    }
	    	Auth::logout();
    	}//IF de Auth
	    // Si la autenticación fallo volvemos a cargar el formulario de login
	    return Redirect::route('login')
	        ->with('flash_warning', 'Nombre de usuario y/o contraseña incorrecto(s)')
	        ->withInput();
	}


	/**
	 * Muestra el formulario para la creación de un nuevo usuario
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('authentication.signin');
	}

/**
	 * Almacena un nuevo registro en base de datos
	 *
	 * @return Response
	 */
	public function store()
	{
		// Guardar el valor de los campos en el postback
		Input::flash();
			
		// Crear el conjunto de validaciones.
		$reglas = array(
			'Cedula' => 'required|unique:Usuarios', 
			'codigofamilia' => 'required',
			'nombre' => 'required',
			'apellido1' => 'required',
			'apellido2' => 'required',
			'direccion' => 'required',
			'password' => 'required|min:8',
		);

		// Crear instancia del validador.
		$validador = Validator::make(Input::all(), $reglas);
		
		if ($validador->passes()) {
			$user = new User();
			$user->Cedula = Input::get('Cedula');
			$user->username = Input::get('Cedula');
			$user->Codigo_Familia = Input::get('codigofamilia');
			$user->Nombre = Input::get('nombre');
			$user->Apellido1 = Input::get('apellido1');
			$user->Apellido2 = Input::get('apellido2');
			$user->Direccion = Input::get('direccion');
			$user->password = Hash::make(Input::get('password'));
			$user->estado = "T";
			$user->save();
            $user2 = array(
                    'username' => Input::get('cedula'),
                    'password' => Input::get('password')
                    );
            Auth::attempt($user2);
				return Redirect::route('/')
				->with('flash_success', 'El usuario '.$user->username.' se registró correctamente');
		}
		else
		{
			//Se retornar los errores de validacion al formulario
			return Redirect::to('signin')
				->withErrors($validador, 'signin');
		}
	}
}
?>

