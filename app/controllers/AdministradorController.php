<?php

class AdministradorController extends BaseController
{

	//Validador sobre los permisos del administrador
	public function validateAdministrador()
	{
		if (Auth::check()) {
			$permiso = DB::table('Tipos_Acceso AS TA')
		                    ->join('Tipos_Usuarios as TU', 'TU.Tipos_Accesos', '=', 'TA.id')
		                    ->select('TA.Descripcion')
		                    ->where('TU.Cedula_Usuarios', '=',  Auth::user()->username )
		                    ->where('TA.Descripcion', "=", 'Administrativo')
		                    ->get(); 
            if(count($permiso) > 0){
            	return true;
            }else{
            	return false;
            }
        }else{
        	return false;
        }
	}

	//Muestra la totalidad de las familias para poder desplejar los usuarios
    public function showUsuarios(){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
    		$data['Familia'] = DB::table('Codigo_Familia')
	                    ->select('Codigo_Familia',
	                    		'Apellido1', 
	                    		'Apellido2')
	                    ->get();  
            $data['Permiso']  = $this->getRoles();
        }
        return View::make('Administrativo.usuarios', $data);
	}

	//Obtiene los roles que tiene el usuario
	public function getRoles()
	{
		$permiso = DB::table('Tipos_Acceso AS TA')
	                    ->join('Tipos_Usuarios as TU', 'TU.Tipos_Accesos', '=', 'TA.id')
	                    ->select('TA.Descripcion')
	                    ->where('TU.Cedula_Usuarios', '=',  Auth::user()->username )
	                    ->orderBy('TA.id', 'asc')
	                    ->get(); 
        return $permiso;
	}

	//Despliega todos los profesores registrados con el acceso de profesor
	public function showProfesor(){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
    		$data['Profesor'] = DB::table('Usuarios as U')
	                    ->select('U.Cedula',
	                    		'U.Nombre',
	                    		'U.Apellido1', 
	                    		'U.Apellido2')
	                    ->join('Tipos_Usuarios as TU', 'TU.Cedula_Usuarios', '=', 'U.Cedula')
	                    ->where('Tipos_Accesos', '=', 2)
	                    ->orderBy('U.Nombre', 'asc')
	                    ->orderBy('U.Apellido1', 'asc')
	                    ->orderBy('U.Apellido2', 'asc')
	                    ->get();   		
            $data['Permiso']  = $this->getRoles();
        }
        return View::make('Administrativo.profesor', $data);
	}

	//Obtiene las materias y secciones del profesor consultado
	public function getSubjects($cedula){
    	if ($this->validateAdministrador() == false) {
    	    return Redirect::route('home');
        }else{
    		$data['Materias'] = DB::table('Profesor_Materia')
                ->select('id',
                		'Materia',
                		'Seccion')
                ->where('Cedula_Usuarios', "=", $cedula)
                ->orderBy('Seccion', 'asc')
                ->get();
            $data['Permiso']  = $this->getRoles();
        }
        return Response::json($data);
	}
	
	//Elimina una materia del profesor
	public function deleteSubject($id){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	if (Profesor::destroy($id)) {
				return Response::json(true);
			}else{
				return Response::json(false);
			}
        }
        return Response::json($data);
	}

	//Obtiene las materias y secciones del profesor consultado
	public function searchProfesorSubject($id){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Materias'] = DB::table('Profesor_Materia')
                ->select('id',
                		'Materia',
                		'Seccion')
                ->where('id', "=", $id)
                ->orderBy('Materia', 'asc')
                ->get();
            $data['Permiso']  = $this->getRoles();
        }
        return Response::json($data);
	}

	// Actualiza la materia y seccion seleccionada.
	public function updateMateria($id, $materia, $seccion)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$profesor = Profesor::find($id);
			$profesor->Materia = $materia;
			$profesor->Seccion = $seccion;
			if ($profesor->save()) {
				return Response::json(true);
			}else{
				return Response::json(false);
			}
		}
	}

	//Obtiene los usuarios registrados a la familia
	public function getFamily($Code)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$data['Familia'] = DB::table('Usuarios as U')
	                        ->select('U.id',
	                        		 'U.Codigo_Familia',
	                        		 'U.Cedula',
	                    			 'U.Nombre',
	                                 'U.Apellido1',
	                                 'U.Apellido2',
	                                 'U.estado')
	                        ->where('Codigo_Familia', '=', $Code)
	                        ->orderBy('U.Nombre' , 'asc' )
	                        ->orderBy('U.Apellido1' , 'asc' )
	                        ->orderBy('U.Apellido2' , 'asc' )
	                        ->get(); 
	        return Response::json($data);
	    }
	}

	//Obtiene los correos del usuarios
	public function getEmails($Code)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$data['Emails'] = DB::table('Usuarios_Correos as UC')
	                        ->select('UC.Correo')
	                        ->where('UC.Cedula', '=', $Code)
	                        ->get(); 
	        return Response::json($data);
	    }
	}

	//Obtiene los telefonos del usuarios
	public function getPhones($Code)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$data2['Phones'] = DB::table('Usuarios_Telefonos as UT')
	                        ->select('UT.Telefono')
	                        ->where('UT.Cedula', '=', $Code)
	                        ->get(); 
	        return Response::json($data2);
	    }
	}

	//Muestra las familias que estan activas
	public function showFamilias(){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Familias'] = DB::table('Codigo_Familia')
                ->select('id', 'Codigo_Familia',  'Apellido1', 'Apellido2')
                ->where('Estado', "=", "T")
                ->orderBy('Codigo_Familia', 'asc')
                ->get();
            $data['Permiso']  = $this->getRoles();
        }
        return View::make('Administrativo.familias', $data);
	}

	//Despliega las horas de atención de todos los profesores
	public function showAtencion(){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Permiso']  = $this->getRoles();
        	$data['Leccion_Hora'] = DB::table('Leccion_Hora')
                ->select()
                ->get();
        	$data['Horas'] =DB::select(
        		DB::raw('SELECT 
							U."Cedula",
							U."Nombre",
							U."Apellido1",
							U."Apellido2",
							HA."Dia",
							LH."Hora"
						FROM "Usuarios" U, "Hora_Atencion" HA, "Leccion_Hora" LH
						WHERE
							HA."Codigo_Profesor" = U."Cedula"
							and HA."Leccion_Hora" = LH.id
						ORDER BY
							U."Apellido1" asc'));
    		$data['Profesores'] =DB::select(
        		DB::raw('SELECT 
        					distinct U."Cedula",
							U."Nombre",
							U."Apellido1",
							U."Apellido2"
						FROM "Usuarios" U, "Hora_Atencion" HA, "Leccion_Hora" LH
						WHERE
							HA."Codigo_Profesor" = U."Cedula"
							and HA."Leccion_Hora" = LH.id
						ORDER BY
							U."Apellido1" asc'));
    		$data['ProfesoresNuevos'] =DB::select(
        		DB::raw('SELECT 
        					distinct U."Cedula",
							U."Nombre",
							U."Apellido1",
							U."Apellido2"
						FROM "Usuarios" U, "Tipos_Usuarios" TU
						WHERE
							NOT EXISTS (
							    SELECT *
							    FROM "Hora_Atencion" HA 
							    WHERE HA."Codigo_Profesor" = U."Cedula")
        					AND TU."Cedula_Usuarios" = U."Cedula" 
        					AND TU."Tipos_Accesos" = 2
						ORDER BY
							U."Apellido1" asc'));

        }
        return View::make('Administrativo.atencion', $data);
	}
    
    //Muestra las citas disponibles del mes con todos los profesores
    public function showCitas(){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Permiso']  = $this->getRoles();
        	$date = new DateTime();
            $lastDay = $date->format('Y-m-t');
            $firstDay = $date->format('Y-m-01');
        	$variable = 'P';
        	$data['Citas'] = DB::select(
                    DB::raw('Select
                    			C.id,
								U."Nombre" ,
								U."Apellido1",
								U."Apellido2",
								FA."Nombre_Alumno",
								FA."Apellido1_Alumno",
								FA."Apellido2_Alumno",
								HA."Dia",
								LH."Hora",
								C."Fecha_Cita"
							From "Citas" C, "Hora_Atencion" HA, "Usuarios" U, "Familia_Alumnos" FA, "Leccion_Hora" LH
							Where
								C."id_Hora_Atencion" = HA.id
								and C."Fecha_Cita" BETWEEN \'' . $firstDay . '\' AND \'' . $lastDay . '\'
								and HA."Codigo_Profesor" = U."Cedula"
								and C."Cedula_Alumno" = FA."Cedula_Alumno"
								and HA."Leccion_Hora" = LH.id
								and C."Estado_Cita" = \'' . $variable .'\''));
    		return View::make('Administrativo.citas', $data);
		}
	}

	//Muestra los roles de los usuarios
	public function showRoles($id){
    	if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Permiso']  = $this->getRoles();
        	$data['Usuario'] = DB::table('Usuarios as U')
                ->select('U.Cedula', 'U.Nombre', 'U.Apellido1', 'U.Apellido2')
                ->where('U.Cedula', "=", $id)
                ->get();
        	$data['RolesActivos'] = DB::table('Tipos_Acceso as TA')
                ->select('TU.id', 'TA.Descripcion')
                ->join('Tipos_Usuarios as TU', 'TU.Tipos_Accesos', '=', 'TA.id')
                ->where('TU.Cedula_Usuarios', "=", $id)
                ->get();
            $data['RolesInactivos'] = 
            	DB::select(
                    DB::raw('Select
								TA."Descripcion"
							From
								"Tipos_Acceso" as TA
							Where TA."Descripcion" NOT IN ( Select TA."Descripcion" From "Tipos_Acceso" as TA
							Inner Join "Tipos_Usuarios" as TU on TU."Tipos_Accesos" = TA.id
							Where
								TU."Cedula_Usuarios" = \'' . $id .'\')'));
        	return View::make('Administrativo.roles', $data);
		}
	}

	//Crea el usuario, carga las familias
	public function createUser()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Permiso']  = $this->getRoles();
        	$data['Familia'] = DB::table('Codigo_Familia')
                ->select('id', 'Codigo_Familia',  'Apellido1', 'Apellido2')
                ->where('Estado', "=", "T")
                ->orderBy('Codigo_Familia', 'asc')
                ->get();
			return View::make('Administrativo.Usuarios.nuevo', $data);
		}
	}

	//Crea una nueva familia con la creación del código
	public function createFamily()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Permiso']  = $this->getRoles();
    		$data= DB::table('Codigo_Familia')
                ->select('Codigo_Familia')
                ->orderBy('Codigo_Familia','DESC')
                ->limit(1)
                ->get();
            foreach ($data as $fam) {
            	$codigo = $fam->Codigo_Familia;
            }
            $codigo = substr($codigo, 3, strlen($codigo));
            if ($codigo < 10) {
            	$codigo = 'FAM00' . ($codigo + 1);	// FAM00(1+)
            }elseif ($codigo < 100) {
            	$codigo = 'FAM0' . ($codigo + 1);	// FAM0(10+)
            }else{
            	$codigo = 'FAM' . ($codigo + 1);	// FAM(100+)
            }
            $data['Codigo'] = $codigo;
			return View::make('Administrativo.Familia.nuevo', $data);
		}
	}

	//No esta dentro de las funciones del administrador
	public function createCitas()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Permiso']  = $this->getRoles();
        	$data['Estudiantes'] = DB::table('Familia_Alumnos as FA')
                    ->select('FA.id', 'FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno')
                    ->orderBy('FA.Cedula_Alumno', 'asc')
                    ->get();
			return View::make('Administrativo.Citas.nuevo', $data);
		}
	}

	//Se espera entender la función
	public function searchSubject($cedula)
	{
		$alumno  = User::where('Cedula_Alumno', '', $cedula)->firstOrFail();
		return Response::json($alumno);
	}

	/**
	 * Almacena un nuevo registro en base de datos
	 *
	 * @return Response
	 */
	public function store()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
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
				return Redirect::route('usuarios')
				->with('flash_success', 'El usuario '.$user->Nombre. " " .$user->Apellido1. ' se registró correctamente');
			}
			else
			{
				//Se retornar los errores de validacion al formulario
				return Redirect::route('newUser')
					->withErrors($validador, 'newUser');
			}
		}
	}

	/**
	 * Almacena un nuevo registro en base de datos
	 *
	 * @return Response
	 */
	public function storeStudent()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$alumno = new Familia();
			$alumno->Cedula_Alumno = Input::get('cedula');
			$alumno->Codigo_Familia = Input::get('codigofamilia');
			$alumno->Nombre_Alumno = Input::get('nombre');
			$alumno->Apellido1_Alumno = Input::get('apellido1');
			$alumno->Apellido2_Alumno = Input::get('apellido2');
			$alumno->Seccion_Alumno = Input::get('seccion');
			$alumno->Nivel_Alumno = Input::get('nivel');
			$alumno->Monto_Mensual = Input::get('mensual');
			$alumno->Estado = 'T';
			$alumno->save();
			return Redirect::route('showFamily', array($alumno->Codigo_Familia));
		}
	}

	/**tr
	 * Almacena un nuevo registro en base de datos
	 *
	 * @return Response
	 */
	public function storeFamily()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			// Guardar el valor de los campos en el postback
			Input::flash();
			// Crear el conjunto de validaciones.
			$reglas = array(
				'codigofamilia' => 'required', 
				'apellido1' => 'required',
				'apellido2' => 'required',
			);

			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);
			
			if ($validador->passes()) {
				$familia = new CodigoFamilia();
				$familia->Codigo_Familia = Input::get('codigofamilia');
				$familia->Apellido1 = Input::get('apellido1');
				$familia->Apellido2 = Input::get('apellido2');
				$familia->Estado = "T";
				$familia->save();
				return Redirect::route('AdminFamilias')
				->with('flash_success', 'La familia '.$familia->Apellido1. " " .$familia->Apellido2. ' se registró correctamente');
			}
			else
			{
				//Se retornar los errores de validacion al formulario
				return Redirect::route('newFamily')
					->withErrors($validador, 'newFamily');
			}
		}
	}

	//Muestra los detalles del usuario
	public function Mostrar($id){
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
	    	$data['Usuarios'] = DB::table('Usuarios as U')
	                    ->select('U.id', 'U.Cedula', 'U.Codigo_Familia', 'U.Nombre', 'U.Apellido1', 'U.Apellido2', 'U.Direccion')
	                    ->where('U.id', '=', $id)
	                    ->get();
            $data['Usuarios_Correos'] = DB::table('Usuarios_Correos as UC')
	                    ->select('UC.Correo')
	                    ->where('UC.Cedula', '=', $data['Usuarios'][0]->Cedula)
	                    ->get();
            $data['Usuarios_Telefonos'] = DB::table('Usuarios_Telefonos as UT')
	                    ->select('UT.Telefono')
	                    ->where('UT.Cedula', '=', $data['Usuarios'][0]->Cedula)
	                    ->get();
            $data['Permiso']  = $this->getRoles();
			return View::make('Administrativo.Usuarios.mostrar', $data);
		}
	}

	//Muestra los datos de la familia
	public function showFamily($id){
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Familia'] = DB::table('Codigo_Familia as FA')
	                    ->select('FA.Codigo_Familia', 'FA.Apellido1', 'FA.Apellido2')
	                    ->where('FA.Codigo_Familia', '=', $id)
	                    ->get();
        	$data['Encargados'] = DB::table('Usuarios as U')
	                    ->select('U.Cedula', 'U.Nombre', 'U.Apellido1', 'U.Apellido2')
	                    ->where('U.Codigo_Familia', '=', $id)
	                    ->get();
	    	$data['Hijos'] = DB::table('Familia_Alumnos as FA')
	                    ->select('FA.id','FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Seccion_Alumno', 'FA.Estado')
	                    ->where('FA.Codigo_Familia', '=', $id)
	                    ->get();
	        $data['Permiso']  = $this->getRoles();            	
			return View::make('Administrativo.Familia.mostrar', $data);
		}
	}

	//Muestra los datos del usuario para ser editado
	public function editUser($id){
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
	    	$data['Usuarios'] = DB::table('Usuarios as U')
	                    ->select('U.id', 'U.Cedula as Cedula', 'U.Codigo_Familia as codigofamilia', 'U.password as Contrasena' ,'U.Nombre as nombre', 'U.Apellido1 as apellido1', 'U.Apellido2 as apellido2', 'U.Direccion as direccion')
	                    ->where('U.id', '=', $id)
	                    ->get();
            $data['Usuarios_Correos'] = DB::table('Usuarios_Correos as UC')
	                    ->select('UC.id', 'UC.Correo')
	                    ->where('UC.Cedula', '=', $data['Usuarios'][0]->Cedula)
	                    ->get();
            $data['Usuarios_Telefonos'] = DB::table('Usuarios_Telefonos as UT')
	                    ->select('UT.id', 'UT.Telefono')
	                    ->where('UT.Cedula', '=', $data['Usuarios'][0]->Cedula)
	                    ->get();
            $data['Permiso']  = $this->getRoles();
			return View::make('Administrativo.Usuarios.edit', $data);
		}
	}

	//Muestra los datos de la familia para ser editado
	public function editFamily($id){
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
	    	$data['Familia'] = DB::table('Codigo_Familia as FA')
	                    ->select('FA.id', 'FA.Codigo_Familia', 'FA.Apellido1', 'FA.Apellido2')
	                    ->where('FA.id', '=', $id)
	                    ->get();
            $data['Permiso']  = $this->getRoles();
			return View::make('Administrativo.Familia.editar', $data);
		}
	}

	//Actualiza los datos personales del usuario
	public function updateUser($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			Input::flash();
			
	        $reglas = array(
				'codigofamilia' => 'required',
				'nombre' => 'required',
				'apellido1' => 'required',
				'apellido2' => 'required',
				'direccion' => 'required'
	        );
	       
			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);

	        if ($validador->passes()) {
	            $user = User::find($id);
				$user->username = Input::get('Cedula');
				$user->Codigo_Familia = Input::get('codigofamilia');
				$user->Nombre = Input::get('nombre');
				$user->Apellido1 = Input::get('apellido1');
				$user->Apellido2 = Input::get('apellido2');
				$user->Direccion = Input::get('direccion');
				$user->estado = "T";
	            $user->save();
	            $Emails = UsuariosCorreos::where('Cedula', '=', $user->Cedula)->get();
	            foreach ($Emails as $mail) {
	            	$correo = Input::get('Correo'.$mail->id);
	            	if (($correo == "") ||($correo == null))  {
	            		$mail->destroy($mail->id);
	            	}else{
	            		$mail->Correo = $correo;
		            	$mail->save();		   
		            }
	            }
	            $correo = Input::get('Correo0');
	            if (($correo != "") ||($correo != null))  {
            		$email = new UsuariosCorreos();
            		$email->Cedula = $user->Cedula;
            		$email->Correo = $correo;
	            	$email->save();		
	            }
	            $Telefonos = UsuariosTelefonos::where('Cedula', '=', $user->Cedula)->get();
	            foreach ($Telefonos as $phone) {
	            	$telefono = Input::get('Telefono'.$phone->id);
	            	if (($telefono == "") ||($telefono == null))  {
	            		$phone->destroy($phone->id);
	            	}else{
		            	$phone->Telefono = $telefono;
		            	$phone->save();
		            }
	            }
	            $phone = Input::get('Telefono0');
	            if (($phone != "") ||($phone != null))  {
	            	$phones = new UsuariosTelefonos();
            		$phones->Cedula = $user->Cedula;
            		$phones->Telefono = $phone;
	            	$phones->save();
	            }
	            return Redirect::route('usuarios');
			}
				//Se retornar los errores de validacion al formulario
	            return Redirect::to('/Administrativo/'.$id.'/edit')
					->withErrors($validador, 'signin');
				
		}
	}

	//Actualiza la contraseña
	public function updatePass($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
	        if(Input::get('password1') != null){
	            $usuario = User::find($id);
	            $usuario->password = Hash::make(Input::get('password1'));
	            $usuario->save();
	        }

			return Redirect::route('usuarios');
		}
	}

	// Almacena los datos de la familia
	public function updateFamily($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
	        if((Input::get('apellido1') != null) && (Input::get('apellido2') != null)){
	            $codigofamilia = CodigoFamilia::find($id);
	            $codigofamilia->Apellido1 = Input::get('apellido1');
	            $codigofamilia->Apellido2 = Input::get('apellido2');
	            $codigofamilia->save();
	        }
			return Redirect::route('AdminFamilias');
		}
	}

	/**
	 * Remueve un registro de la base datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			// delete
	        $usuarios = user::find($id);
			$usuarios->estado = "F";
			$usuarios->save();
			return Redirect::route('usuarios');
		}
	}

	/**
	 * Remueve un registro de la base datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function active($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			// delete
	        $usuarios = user::find($id);
			$usuarios->estado = "T";
			$usuarios->save();
			return Redirect::route('usuarios');
		}
	}

	/**
	 * Remueve un registro de la base datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteFamily($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			// delete
			$codigofamilia = CodigoFamilia::find($id);
			$codigofamilia->Estado = "F";
			$codigofamilia->save();
			$usuarios = User::where("Codigo_Familia", $codigofamilia->Codigo_Familia);
			$new_user_data=array('estado'=>'F');
			$usuarios->update($new_user_data);
			return Redirect::route('AdminFamilias');
		}
	}

	/**
	 * Remueve un registro de la base datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function activeFamily($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			// delete
			$codigofamilia = CodigoFamilia::find($id);
			$codigofamilia->Estado = "T";
			$codigofamilia->save();
			$usuarios = User::where("Codigo_Familia", $codigofamilia->Codigo_Familia);
			$new_user_data=array('estado'=>'T');
			$usuarios->update($new_user_data);
			return Redirect::route('AdminFamilias');
		}
	}

	//Busca el nombre del profesor
	public function searchTeacher($cedula) {
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$data['Profesor'] = DB::table('Usuarios as U')
		                    ->select('U.Nombre', 'U.Apellido1', 'U.Apellido2')
		                    ->where('U.Cedula', '=', $cedula)
		                    ->get();
			return Response::json($data);
		}
	}

	//Elimina un rol
	public function deleteRoles($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$tipos = null;
			$tipos = TiposUsuarios::find($id);
			if (!isset($tipos)) {
				$data['Respuesta'] = 'Not Found';
				return $data['Respuesta'];
			}else{
				try {
					$user = Profesor::where('Cedula_Usuarios', '=', $tipos->Cedula_Usuarios)->take(1)->get();
					$hora = Hora::where('Codigo_Profesor', '=', $user[0]->id)->delete();
				} catch (Exception $e) {}
				$profesor = Profesor::where('Cedula_Usuarios', '=', $tipos->Cedula_Usuarios)->delete();
				if ($tipos->delete()) {
					$data['Respuesta'] = 'Successfull';
					return $data['Respuesta'];
				}else{
					$data['Respuesta'] = 'Not Found';
					return $data['Respuesta'];
				}
				$data['Respuesta'] = 'Successfull';
				return $data['Respuesta'];
			}
		}
	}

	//Muestra los datos del estudiante para ser editados
	public function editStudent($id){
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Permiso']  = $this->getRoles();
	    	$data['Estudiante'] = DB::table('Familia_Alumnos as FA')
	                    ->select('FA.id', 'FA.Codigo_Familia', 'FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Seccion_Alumno', 'FA.Nivel_Alumno', 'FA.Monto_Mensual')
	                    ->where('FA.id', '=', $id)
	                    ->get();
			return View::make('Administrativo.Estudiante.editar', $data);
		}
	}

	//Actualiza los datos del estudiante
	public function updateStudent($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			Input::flash();
			
	        $reglas = array(
				'codigofamilia' => 'required',
				'cedula' => 'required',
				'nombre' => 'required',
				'apellido1' => 'required',
				'apellido2' => 'required',
				'seccion' => 'required',
				'nivel' => 'required',
				'mensual' => 'required'
	        );
	       
			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);

	        if ($validador->passes()) {
	            $user = Familia::find($id);
				$user->Cedula_Alumno = Input::get('cedula');
				$user->Codigo_Familia = Input::get('codigofamilia');
				$user->Nombre_Alumno = Input::get('nombre');
				$user->Apellido1_Alumno = Input::get('apellido1');
				$user->Apellido2_Alumno = Input::get('apellido2');
				$user->Seccion_Alumno = Input::get('seccion');
				$user->Nivel_Alumno = Input::get('nivel');
				$user->Monto_Mensual = Input::get('mensual');
				$user->save();
            	return Redirect::route('showFamily', array($user->Codigo_Familia));
			}
				//Se retornar los errores de validacion al formulario
	            return Redirect::to('/Administrativo/'.$id.'/editStudent')
					->withErrors($validador, 'newFamily');
		}
	}

	/**
	 * Remueve un registro de la base datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteStudent($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			// delete
			$user = Familia::find($id);
			$user->Estado = "F";
			$user->save();

        	return Redirect::route('showFamily', array($user->Codigo_Familia));
		}
	}

	/**
	 * Remueve un registro de la base datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function activeStudent($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			// delete
			$user = Familia::find($id);
			$user->Estado = "T";
			$user->save();
			
        	return Redirect::route('showFamily', array($user->Codigo_Familia));
		}
	}

	//Agrega un rol
	public function addRoles($id, $tipo)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$tipos = null;
			$tipos = new TiposUsuarios();
			$tipos->Cedula_Usuarios = $id;
			$tipos->Tipos_Accesos = $tipo;
			if (!$tipos->save()) {
				$data['Respuesta'] = 'Not Found';
				return $data['Respuesta'];
			}else{
				$data['Respuesta'] = $tipo->id;
				return $data['Respuesta'];
			}
		}
	}

	//Obtiene las familias (activas o inactivas)
	public function statusFamily($estado)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$data['Familias'] = DB::table('Codigo_Familia')
	                ->select('id', 'Codigo_Familia',  'Apellido1', 'Apellido2')
	                ->where('Estado', "=", $estado)
	                ->orderBy('Codigo_Familia', 'asc')
	                ->get();
	        return Response::json($data);
	    }
	}

	//Muestra la información de la hora de atención
	public function showInfo($cedula)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$data['Materias'] = DB::table('Profesor_Materia')
					->distinct()
	                ->select('Materia')
	                ->where('Cedula_Usuarios', "=", $cedula)
	                ->orderBy('Materia', 'asc')
	                ->get();
	        $data['Secciones'] = DB::table('Profesor_Materia')
	                ->distinct()
	                ->select('Seccion')
	                ->where('Cedula_Usuarios', "=", $cedula)
	                ->orderBy('Seccion', 'asc')
	                ->get();
	        $data['Hora_Atencion'] = DB::table('Hora_Atencion as HA')
	                ->select('HA.Dia')
	                ->where('HA.Codigo_Profesor', '=', $cedula)
	                ->get();
	     	$data['Leccion_Hora_Activo'] = DB::table('Usuarios as U')
	     			->distinct()
	                ->select('LH.id')
	                ->join('Hora_Atencion as HA', 'HA.Codigo_Profesor', "=", 'U.Cedula')
	                ->join('Leccion_Hora as LH', 'LH.id', "=", "HA.Leccion_Hora")
	                ->where('U.Cedula', '=', $cedula)
	                ->get();   
	        return Response::json($data);
	    }
	}

	//Actualiza la hora de atención
	public function updateHour($cedula, $Dia, $Hora)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$user = User::firstOrCreate(array('Cedula' => $cedula));
			//$leccion = Leccion::where('Hora', '=', $Hora);
			//$profesor = Profesor::firstOrCreate(array('Cedula_Usuarios' => $cedula));
			$hora = Hora::where('Codigo_Profesor', '=', $cedula)->update(array('Dia' => $Dia, 'Leccion_Hora' => $Hora));
			$data['Materias'] = DB::table('Profesor_Materia')
	                ->select('Materia')
	                ->where('Cedula_Usuarios', "=", $cedula)
	                ->orderBy('Materia', 'asc')
	                ->get();
	        $data['Secciones'] = DB::table('Profesor_Materia')
	                ->distinct()
	                ->select('Seccion')
	                ->where('Cedula_Usuarios', "=", $cedula)
	                ->orderBy('Seccion', 'asc')
	                ->get();
	        $data['Hora_Atencion'] = DB::table('Hora_Atencion as HA')
	                ->select('HA.Dia')
	                ->where('HA.Codigo_Profesor', '=', $cedula)
	                ->get();
	     	$data['Leccion_Hora_Activo'] = DB::table('Hora_Atencion as HA')
	     			->distinct()
	                ->select('LH.id')
	                ->join('Leccion_Hora as LH', 'LH.id', "=", "HA.Leccion_Hora")
	                ->where('HA.Codigo_Profesor', '=', $cedula)
	                ->get();   
	        return Response::json($data);
	    }
	}

	//Almacena la hora de atención del profesor
	public function storeHour($cedula, $Dia, $Hora)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$hora = new Hora();
			$hora->Codigo_Profesor = $cedula;
			$hora->Dia = $Dia;
			$hora->Leccion_Hora = $Hora;
			if ($hora->save()) {
				return Response::json(true);
			}else{
				return Response::json(false);
			}
		}
	}

	//Almacena la materia y sección de un profesor
	public function storeMateria($cedula, $materia, $seccion)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$profesor = new Profesor();
			$profesor->Cedula_Usuarios = $cedula;
			$profesor->Materia = $materia;
			$profesor->Seccion = $seccion;
			$profesor->save();
		}
	}
}