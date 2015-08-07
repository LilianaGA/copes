<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		if(Auth::check()){
			$permiso  = DB::table('Tipos_Acceso as TA')
                    ->join('Tipos_Usuarios AS TU', 'TU.Tipos_Accesos', '=', 'TA.id')
                    ->select('TA.Descripcion')
                    ->where('TU.Cedula_Usuarios', '=', Auth::user()->username)
                	->orderBy('TA.id', 'desc')
                    ->get();
            if(count($permiso) > 0){
	    		switch ($permiso[0]->Descripcion) {
		    		case "Encargado":
		    			return Redirect::to('padre/saldos');
		    			break;
		    		case "Profesor";
		    			return Redirect::to('profesor/index');
		    			break;
	    			case "Contador";
		    			return Redirect::to('contabilidad/pagos');
		    			break;
	    			case "Administrativo";
		    			return Redirect::to('administracion/usuarios');
		    			break;
		    		default:
		    			return Redirect::route('logoutFromRol'); 
		    			break;
		    	}
	    	}
        }else{
        	$data['Permisos'] = null;
        } 
		return View::make('index',$data);
	}

}
