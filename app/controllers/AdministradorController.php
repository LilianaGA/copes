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
			$profesor = Profesor::find($id);//buscar profesor 
			$profesor->Materia = $materia;//materia del profesor
			$profesor->Seccion = $seccion;//seccion
			if ($profesor->save()) {//si guarda
				return Response::json(true);
			}else{//si da error
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
	                                 'U.Direccion',
	                                 'U.estado')
	                        ->where('Codigo_Familia', '=', $Code)
	                        ->orderBy('U.Nombre' , 'asc' )
	                        ->orderBy('U.Apellido1' , 'asc' )
	                        ->orderBy('U.Apellido2' , 'asc' )
	                        ->get(); 
            $data['Hijos'] = DB::table('Familia_Alumnos as FA')
	                    ->select('FA.id','FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Seccion_Alumno', 'FA.Monto_Mensual', 'FA.Estado', 'FA.Fecha_Nacimiento')
	                    ->where('FA.Codigo_Familia', '=', $Code)
	                    ->get();
            $data['NuevosHijos'] = DB::table('Nuevo_Ingreso as NI')
	                    ->select('NI.id','NI.Cedula_Alumno', 'NI.Nombre_Alumno', 'NI.Apellido1_Alumno', 'NI.Apellido2_Alumno', 'NI.Nivel_Alumno', 'NI.Fecha_Nacimiento')
	                    ->where('NI.Codigo_Familia', '=', $Code)
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
            $codigo = $codigo +1;
            if ($codigo < 10) {
            	$codigo = 'FAM00' . $codigo;	// FAM00(1+)
            }elseif ($codigo < 100) {
            	$codigo = 'FAM0' . $codigo;	// FAM0(10+)
            }else{
            	$codigo = 'FAM' . $codigo;	// FAM(100+)
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

	public function Correo()
	{
		$now = new DateTime();
		$padre = DB::table('Usuarios_Correos as UC')
	                ->select('UC.Correo',
	                'U.Nombre',	
	                 'U.Apellido1',
	                 'U.Apellido2')
	                ->where('U.Codigo_Familia', '=',  Auth::user()->Codigo_Familia )
	                ->join('Usuarios AS U','U.Cedula','=','UC.Cedula')
	                ->join('Codigo_Familia AS CA','CA.Codigo_Familia','=','U.Codigo_Familia')
	                ->limit(1)
	                ->get(); 
        try {
			$data = array( 'titulo'=> 'Configuración de su cuenta',  'email' => $padre[0]->Correo, 'name'=> $padre[0]->Nombre . ' ' . $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2, 'detalle' => 'Para la siguiente información es de suma inportancia que la guarde para hacer uso de la plataforma', 'usuario' => '114610267', 'Contrasena' => 123456789);
	        /*Mail::queue('Email.contrasena', $data, function($message) use ($data){
	            $message->to($data['email'], $data['name'])->subject('Recordatorio de Cuentas Pendidentes');
	        });*/
        } catch (Exception $e) {
        	$sinCorreo += 1;
        }
		return View::make('Email.Contrasena', $data);
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
	                    ->select('FA.id', 'FA.Codigo_Familia', 'FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Seccion_Alumno', 'FA.Nivel_Alumno', 'FA.Monto_Mensual', 'FA.Fecha_Nacimiento')
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
				'mensual' => 'required',
				'fecha' => 'required'
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
				$user->Fecha_Nacimiento= Input::get('fecha');
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
				$data['Respuesta'] = $tipos->id;
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


	// Grettel Monge Rojas

	public function prematricula()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{			 
	        $data['periodo'] = DB::table('Parametros')
		     			->select('id','Estado')
		     			->where('Nombre', '=', 'Prematricula')
		     			->get();
			$data['Familia'] = DB::table('Codigo_Familia as CF')
	                    ->select('CF.Codigo_Familia',
	                    		'CF.Apellido1', 
	                    		'CF.Apellido2')
	                	->join('Prematricula as P', 'P.Codigo_Familia', "=", "CF.Codigo_Familia")
	                	->where('P.Anio', '=', date('Y') + 1)
	                	->where('P.Estado', '=', 'T')
	                    ->get();  
	    	$data['Permiso']  = $this->getRoles();
			return View::make('Administrativo.prematricula', $data);
		}
	}


	public function prematriculaUpdate($id, $tipo)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			$parametro = Parametros::find($id);
			$parametro->Estado = $tipo;
			if (!$parametro->save()) {
				$data['Respuesta'] = 'Not Found';
				return $data['Respuesta'];
			}else{
				$data['Respuesta'] = $parametro->id;
				return $data['Respuesta'];
			}
		}
	}

	//Obtiene la información del alumno
    public function getManager($id)
    {
        if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
            $data['Encargados'] = DB::table('Usuarios as U')
    	                    ->select('U.id','U.Cedula', 'U.Nombre', 'U.Apellido1', 'U.Apellido2', 'U.Direccion')
    	                    ->where('U.id', '=', $id)
    	                    ->get();
            $data['Usuarios_Correos'] = DB::table('Usuarios_Correos as UC')
    	                    ->select('UC.id', 'UC.Correo')
    	                    ->where('UC.Cedula', '=', $data['Encargados'][0]->Cedula)
    	                    ->get();
            $data['Usuarios_Telefonos'] = DB::table('Usuarios_Telefonos as UT')
                        ->select('UT.id', 'UT.Telefono')
                        ->where('UT.Cedula', '=', $data['Encargados'][0]->Cedula)
                        ->get();
            return Response::json($data); 
        }
    }

 //Actualiza los datos personales del usuario
	public function updateManager($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			Input::flash();
			
	        $reglas = array(
				'nombre' => 'required',
				'apellido1' => 'required',
				'apellido2' => 'required',
				'direccion' => 'required'
	        );
	       
			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);

	        if ($validador->passes()) {
	            $user = User::find($id);
				$user->Nombre = Input::get('nombre');
				$user->Apellido1 = Input::get('apellido1');
				$user->Apellido2 = Input::get('apellido2');
				$user->Direccion = Input::get('direccion');
	            $user->save();
        		return Response::json($user); 
			}else{
        		return Response::json($user = User::find($id));  
			}
		}
	}

	//Actualiza los datos personales del usuario
	public function updateManagerEmails($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			Input::flash();
			
	        $reglas = array(
				'correo' => 'required'
	        );
	       
			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);

	        if ($validador->passes()) {
	            $emailsUser = UsuariosCorreos::find($id);
				$emailsUser->Correo = Input::get('correo');
	            $emailsUser->save();
        		return Response::json($emailsUser); 
			}else{
        		return Response::json($emailsUser = UsuariosCorreos::find($id));  
			}
		}
	}

	//Actualiza los datos personales del usuario
	public function updateManagerPhones($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			Input::flash();
			
	        $reglas = array(
				'telefono' => 'required'
	        );
	       
			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);

	        if ($validador->passes()) {
	            $emailsUser = UsuariosTelefonos::find($id);
				$emailsUser->Telefono = Input::get('telefono');
	            $emailsUser->save();
        		return Response::json($emailsUser); 
			}else{
        		return Response::json(UsuariosTelefonos::find($id));  
			}
		}
	}

	//Obtiene la información del alumno
    public function getStudent($id)
    {
        if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
            $data['Hijos'] = DB::table('Familia_Alumnos as FA')
    	                    ->select('FA.id','FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Nivel_Alumno', 'FA.Seccion_Alumno', 'FA.Monto_Mensual', 'FA.Fecha_Nacimiento')
    	                    ->where('FA.id', '=', $id)
    	                    ->get();
            return Response::json($data); 
        }
    }

     //Actualiza los datos del estudiante
	public function updateStudent2($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
			Input::flash();
			
	        $reglas = array(
				'cedula' => 'required',
				'nombre' => 'required',
				'apellido1' => 'required',
				'apellido2' => 'required',
				'seccion' => 'required',
				'nivel' => 'required',
				'mensual' => 'required',
				'nacimiento' => 'required'
	        );
	       
			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);

	        if ($validador->passes()) {
	            $user = Familia::find($id);
				$user->Cedula_Alumno = Input::get('cedula');
				$user->Nombre_Alumno = Input::get('nombre');
				$user->Apellido1_Alumno = Input::get('apellido1');
				$user->Apellido2_Alumno = Input::get('apellido2');
				$user->Seccion_Alumno = Input::get('seccion');
				$user->Fecha_Nacimiento = Input::get('nacimiento');
				$user->Nivel_Alumno = Input::get('nivel');
				$user->Monto_Mensual = Input::get('mensual');
				$user->save();
            	return Response::json($user);  
			}else{
				return Response::json(Familia::find($id)); 
			}
		}
	}

	//obtiene Datos de nuevo estudiante
     public function getNewStudent($id)
    {
        if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
            $data['Prematriculado'] = DB::table('Nuevo_Ingreso as FA')
    	                    ->select('FA.id','FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Fecha_Nacimiento', 'FA.Nivel_Alumno')
    	                    ->where('FA.id', '=', $id)
    	                    ->get();
            return Response::json($data); 
        }
    }

    /**
	 * Almacena un nuevo registro en base de datos
	 *
	 * @return Response
	 */
	public function storeStudent2()
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
			$alumno->Fecha_Nacimiento = Input::get('nacimiento');
			$alumno->Seccion_Alumno = Input::get('seccion');
			$alumno->Nivel_Alumno = Input::get('nivel');
			$alumno->Monto_Mensual = Input::get('mensual');
			$alumno->Estado = 'T';
			if ($alumno->save()) {
				$id = Input::get('id');
				NuevoIngreso::destroy($id);
				return Response::json($alumno);
			}else{
				return Response::json($alumno);
			} 
		}
	}

	public function finishFamily()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
		}else{
			$data = DB::table('Prematricula as P')
                    ->select('P.id')
                    ->where('P.Codigo_Familia', '=', Input::get('codigofamilia'))
                	->where('P.Anio', '=', date('Y') + 1)
                    ->get(); 
			$prematricula = Prematricula::find($data[0]->id);
			$prematricula->Estado = 'F';
			$prematricula->save();
			return Response::json($prematricula);
		}
	}

	public function Rubros()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
        	$data['Rubros'] = DB::table('Rubros')
                    ->select('id','Detalle_Rubro')
                    ->get();  
        	$data['Permiso']  = $this->getRoles();
			return View::make('Administrativo.Rubros.rubros', $data);
		}
	}

	public function searchSubjetcs($nivel)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
		}else{
			$data['Secciones'] = DB::table('Familia_Alumnos')
                    ->select('Seccion_Alumno')
                    ->distinct()
                    ->where('Seccion_Alumno', 'LIKE', $nivel . '-%')
                    ->get(); 
            $data['Materias'] = DB::table('Profesor_Materia')
                    ->select('Materia')
                    ->distinct()
                    ->where('Seccion', 'LIKE', $nivel . '-%')
                    ->get(); 
			return Response::json($data);
		}
	}

	public function searchItems($nivel, $materia)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
		}else{
			$data['Items'] = DB::table('Rubro_Asignacion as RA')
                    ->select('RA.id','R.Detalle_Rubro', 'RA.Valor')
                    ->join('Rubros as R', 'R.id', "=", "RA.idRubro")
                    ->where('RA.Nivel', '=', $nivel)
                    ->where('RA.Materia', '=', $materia)
                    ->get();  
			return Response::json($data);
		}
	}

	public function createNewItem()
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
		}else{
        	
			// Guardar el valor de los campos en el postback
			Input::flash();
			// Crear el conjunto de validaciones.
			$reglas = array(
				'level' => 'required',
				'descripcion' => 'required',
				'porcentaje' => 'required',
				'materia' => 'required',
			);

			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);
			if ($validador->passes()) {
				$rubros = new RubroAsignacion();
				$rubros->idRubro = Input::get('descripcion');
				$rubros->Nivel = Input::get('level');
				$rubros->Materia = Input::get('materia');
				$rubros->Valor = Input::get('porcentaje');
				if (!$rubros->save()) {
					$data = 'Error';
					return Response::json($data);
				}
			}else{
        		$data = 'Error';
				return Response::json($data);
			} 
		}
	}

	public function deleteItem($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
		}else{
			if (RubroAsignacion::destroy($id)) {
				return Response::json(true);
			}else{
				return Response::json(false);
			}
		}
	}

	public function searchItem($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
		}else{
			$data = DB::table('Rubro_Asignacion as RA')
                    ->select('RA.id','R.id as idr', 'RA.Valor')
                    ->join('Rubros as R', 'R.id', "=", "RA.idRubro")
                    ->where('RA.id', '=', $id)
                    ->get();  
			return Response::json($data);
		}
	}

	public function updateItem($id)
	{
		if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
		}else{
			Input::flash();
			
	        $reglas = array(
				'id' => 'required',
				'level' => 'required',
				'materia' => 'required',
				'descripcion' => 'required',
				'porcentaje' => 'required'
	        );
	       
			// Crear instancia del validador.
			$validador = Validator::make(Input::all(), $reglas);

	        if ($validador->passes()) {
	            $rubros = Rubros::find($id);
				$rubros->Nivel = Input::get('level');
				$rubros->Detalle_Rubro = Input::get('descripcion');
				$rubros->Porcentaje = Input::get('porcentaje');
				$rubros->Materia = Input::get('materia');
				if ($rubros->save()) {
            		return Response::json(true);
				}
	        }
			return Response::json(false);
        }
	}

	public function newType($id)
    {
        if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
            $rubro = new Rubros();
            $rubro->Detalle_Rubro = $id;
            if ($rubro->save()) {
                return Response::json($rubro);
            }else{
                $data = 'Error';
                return Response::json($data);
            }
        }
    }

     public function getRubros()
    {
        if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
            $data['Permiso']  = $this->getRoles();
            $data['secciones'] = DB::table('Profesor_Materia')
            			->select('Seccion')
                    	->distinct()
                        ->orderBy('Seccion', 'asc')
                        ->get(); 
            $data['materias'] = DB::table('Profesor_Materia')
            			->select('Materia')
                        ->distinct()
                        ->orderBy('Materia', 'asc')
                        ->get();                        
            $data['tipos'] = DB::table('Rubros_Entregables')
                        ->select('id','Tipo_Trabajo')
                        ->get();  
            $data['anio'] = DB::table('Rubro_Alumno')
            			->select('Anio')
                        ->distinct()
                        ->orderBy('Anio', 'asc')
                        ->get();       
            return View::make('Administrativo.Rubros.rubrica', $data);
        }
    }


    public function searchRubros($nivel, $materia, $periodo, $anio)
    {
        if ($this->validateAdministrador() == false) {
            return Redirect::route('home');
        }else{
            $data['Items'] = DB::table('Rubro_Asignacion as RA')
                    ->select('RA.id','R.Detalle_Rubro', 'RA.Valor')
                    ->join('Rubros as R', 'R.id', "=", "RA.idRubro")
                    ->where('RA.Nivel', '=', strstr($nivel, '-', TRUE))
                    ->where('RA.Materia', '=', $materia)
                    ->orderBy('R.id', 'asc')
                    ->get(); 
            $data['Info'] = DB::table('Profesor_Materia as PM')
                ->select('U.Nombre', 'U.Apellido1', 'U.Apellido2', 'PM.Materia','PM.Seccion')
                ->join('Usuarios as U', 'U.Cedula', "=", "PM.Cedula_Usuarios")
                ->where('Seccion', "=", $nivel)
                ->where('Materia', "=", $materia)
                ->get();
            $data['Rubros'] = DB::select(
                    DB::raw('SELECT
                                datos2.Cedula_Alumno,
                                concat_ws(\' \', datos1.Apellido1_Alumno, datos1.Apellido2_Alumno, datos1.Nombre_Alumno)AS Nombre_Alumno,
                                datos2.Detalle_Rubro,
                                sum(datos1.Valor_Obtenido + datos2.Valor_Obtenido) as Valor_Obtenido
                            FROM((SELECT
                                    FA."Cedula_Alumno" AS Cedula_Alumno, 
                                    FA."Nombre_Alumno" AS Nombre_Alumno, 
                                    FA."Apellido1_Alumno" AS Apellido1_Alumno, 
                                    FA."Apellido2_Alumno" AS Apellido2_Alumno,
                                    rub."Detalle_Rubro" AS Detalle_Rubro,
                                    rubAlum."Valor_Obtenido" AS Valor_Obtenido
                                FROM    
                                    "Familia_Alumnos" AS FA,
                                    (SELECT R.id, R."Detalle_Rubro" FROM "Rubros" as R) AS rub,
                                    (SELECT * FROM "Rubro_Asignacion" as RA) as rubAsig,
                                    (SELECT * FROM "Rubro_Alumno" as AR) AS rubAlum
                                WHERE   FA."Seccion_Alumno"  = \'' . $nivel . '\'
                                    AND FA."Estado" = \'T\'
                                    AND rub.id = rubAsig."idRubro"
                                    AND rubAsig.id = rubAlum."idRubro"
                                    AND rubAlum."Cedula_Alumno" = FA."Cedula_Alumno"
                                    AND rubAsig."Materia" = \'' . $materia . '\'
                                    AND rubAsig."Nivel" = \'' . strstr($nivel, '-', TRUE) . '\'
                                    AND rubAlum."Trimestre" = \'' . $periodo . '\'
                                    AND rubAlum."Anio" = \'' . $anio . '\'
                                ORDER BY FA."Apellido1_Alumno" asc, FA."Apellido2_Alumno" asc, FA."Nombre_Alumno" asc)
                                UNION ALL
                                (SELECT
                                    FA."Cedula_Alumno" AS Cedula_Alumno, 
                                    FA."Nombre_Alumno" AS Nombre_Alumno, 
                                    FA."Apellido1_Alumno" AS Apellido1_Alumno, 
                                    FA."Apellido2_Alumno" AS Apellido2_Alumno,
                                    rub."Detalle_Rubro" AS Detalle_Rubro,
                                    0 AS Valor_Obtenido
                                FROM    
                                    "Familia_Alumnos" AS FA,
                                    (SELECT R.id, R."Detalle_Rubro" FROM "Rubros" as R) as rub,
                                    (SELECT * FROM "Rubro_Asignacion" as RA) as rubAsig
                                WHERE   FA."Seccion_Alumno" = \'' . $nivel . '\'
                                    AND FA."Estado" = \'T\'
                                    AND rub.id = rubAsig."idRubro"
                                    AND rubAsig."Materia" = \'' . $materia .'\'
                                    AND rubAsig."Nivel" = \'' . strstr($nivel, '-', TRUE) . '\'
                                    ORDER BY FA."Apellido1_Alumno" asc, FA."Apellido2_Alumno" asc, FA."Nombre_Alumno" asc)) as datos1,
                                (SELECT
                                    rub.id as id,
                                    FA."Cedula_Alumno" AS Cedula_Alumno, 
                                    concat_ws(\' \', FA."Nombre_Alumno", FA."Apellido1_Alumno", FA."Apellido2_Alumno")AS Nombre_Alumno,
                                    rub."Detalle_Rubro" AS Detalle_Rubro,
                                    0 AS Valor_Obtenido
                                FROM    
                                    "Familia_Alumnos" AS FA,
                                    (SELECT R.id, R."Detalle_Rubro" FROM "Rubros" as R) as rub,
                                    (SELECT * FROM "Rubro_Asignacion" as RA) as rubAsig
                                WHERE   FA."Seccion_Alumno" = \'' . $nivel . '\'
                                    AND FA."Estado" = \'T\'
                                    AND rub.id = rubAsig."idRubro"
                                    AND rubAsig."Materia" = \'' . $materia .'\'
                                    AND rubAsig."Nivel" = \'' . strstr($nivel, '-', TRUE) . '\'
                                    ORDER BY FA."Apellido1_Alumno" asc, FA."Apellido2_Alumno" asc, FA."Nombre_Alumno" asc) as datos2
                            WHERE
                                	datos1.Detalle_Rubro = datos2.Detalle_Rubro
                            AND     datos2.cedula_alumno = datos1.cedula_alumno
                            GROUP BY datos2.id, datos2.Cedula_Alumno, datos2.Nombre_Alumno, datos2.Detalle_Rubro, datos1.Nombre_Alumno, datos1.Apellido1_Alumno, datos1.Apellido2_Alumno
                            ORDER BY datos1.Apellido1_Alumno ASC, datos1.Apellido2_Alumno ASC, datos1.Nombre_Alumno ASC, datos2.id ASC'));
            return Response::json($data); 
        }
    }
}
