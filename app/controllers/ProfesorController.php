<?php

class ProfesorController extends BaseController
{
    //Validador sobre los permisos del profesor
    public function validateProfesor()
    {
        if (Auth::check()) {
            $permiso = DB::table('Tipos_Acceso AS TA')
                            ->join('Tipos_Usuarios as TU', 'TU.Tipos_Accesos', '=', 'TA.id')
                            ->select('TA.Descripcion')
                            ->where('TU.Cedula_Usuarios', '=',  Auth::user()->username )
                            ->where('TA.Descripcion', "=", 'Profesor')
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
    
    //Muestra la cita para ser editado
    public function showCita($id){
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $data['Citas'] = 
                DB::table('Citas as C')
                    ->join('Familia_Alumnos as FA', 'FA.Cedula_Alumno', '=', 'C.Cedula_Alumno')
                    ->join('Hora_Atencion as HA', 'HA.id', '=', 'C.id_Hora_Atencion')
                    ->join('Leccion_Hora as LH', 'LH.id', '=', 'HA.Leccion_Hora')
                    ->select('FA.Nombre_Alumno',
                             'FA.Apellido1_Alumno',
                             'FA.Apellido2_Alumno',
                             'C.id',
                             'C.Fecha_Cita',
                             'HA.Dia',
                             'LH.Hora',
                             'FA.Seccion_Alumno')
                    ->where('C.id', "=", $id)
                    ->get(); 
            $data['Permiso']  = $this->getRoles();
        }        
        return View::make('profesor.edit', $data);
    }

    //Muestra las citas que puede tener asignadas
    public function showProfesor(){
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
        $data['TraerCitas'] = 
                DB::table('Citas as C')
                    ->join('Familia_Alumnos as FA', 'FA.Cedula_Alumno', '=', 'C.Cedula_Alumno')
                    ->join('Hora_Atencion as HA', 'HA.id', '=', 'C.id_Hora_Atencion')
                    ->join('Leccion_Hora as LH', 'LH.id', '=', 'HA.Leccion_Hora')
                    ->select('FA.Nombre_Alumno',
                             'FA.Apellido1_Alumno',
                             'FA.Apellido2_Alumno',
                             'C.id',
                             'C.Fecha_Cita',
                             'HA.Dia',
                             'LH.Hora',
                             'FA.Seccion_Alumno')
                    ->where('HA.Codigo_Profesor', '=',  Auth::user()->username )
                    ->where('C.Estado_Cita', "=", 'P')
                    ->get(); 
            $data['Permiso']  = $this->getRoles();
        }        
		return View::make('profesor.index', $data);
	}

    //Función para actualizar el estado de la cita
    public function updateCita($id, $estado, $comentario)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            if ($estado == 'Pendiente') {
                $data['Respuesta'] = 'Successfull2';
                return $data['Respuesta'];
            }else{
                $cita = Citas::find($id);
                $Hora_Atencion = DB::table('Hora_Atencion as HA')
                        ->select('HA.Dia', 'LH.Hora', 'UC.Correo',
                         'U.Nombre',
                         'U.Apellido1',
                         'U.Apellido2')
                        ->where('HA.id', '=',   $cita->id_Hora_Atencion )
                        ->join('Usuarios AS U','U.Cedula','=','HA.Codigo_Profesor')
                        ->join('Leccion_Hora AS LH','LH.id','=','HA.Leccion_Hora')
                        ->join('Usuarios_Correos AS UC','UC.Cedula','=','U.Cedula')
                        ->get();

                $Alumno = DB::table('Familia_Alumnos as FA')
                        ->select('FA.Nombre_Alumno',
                         'FA.Apellido1_Alumno',
                         'FA.Apellido2_Alumno',
                         'FA.Codigo_Familia')
                        ->where('FA.Cedula_Alumno', '=',   $cita->Cedula_Alumno )
                        ->get();

                $date=date_create($cita->Fecha_Cita);
                $fecha = date_format($date,"d - M - y");

                $data = array( 'titulo'=> 'Bitácora de la cita',  'email' => $Hora_Atencion[0]->Correo, 'name'=> $Hora_Atencion[0]->Nombre . ' ' . $Hora_Atencion[0]->Apellido1 . ' ' . $Hora_Atencion[0]->Apellido2, 'dia'=> $fecha, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma que la cita de atención solicitada por el padre, madre o encargado de: ' . $Alumno[0]->Nombre_Alumno . ' ' . $Alumno[0]->Apellido1_Alumno . ' ' . $Alumno[0]->Apellido2_Alumno . ', se registra que: "' . $estado . '". <br> Observación: ' . $comentario);
                Mail::queue('Email.citas', $data, function($message) use ($data){
                    $message->to($data['email'], $data['name'])->subject('Bitácora de la cita');
                });         
                Citas::destroy($id);
                $data['Respuesta'] = 'Successfull';
                return $data['Respuesta'];
            }
        }
    }

    //Función para la eliminación de la cita
    public function deleteCita($id){
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $cita = Citas::find($id);
            $this->sendEmailCancela($cita->Cedula_Alumno, $cita->id_Hora_Atencion, $cita->Fecha_Cita);
            Citas::destroy($id);
            return Redirect::route('principalProfe');
        }
    }

    //Función para el envió de la cancelación de la cita
    public function sendEmailCancela($Cedula_Alumno, $id_Hora_Atencion, $Fecha_Cita)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $Hora_Atencion = DB::table('Hora_Atencion as HA')
                    ->select('HA.Dia', 'LH.Hora', 'UC.Correo',
                     'U.Nombre',
                     'U.Apellido1',
                     'U.Apellido2')
                    ->where('HA.id', '=',   $id_Hora_Atencion )
                    ->join('Usuarios AS U','U.Cedula','=','HA.Codigo_Profesor')
                    ->join('Leccion_Hora AS LH','LH.id','=','HA.Leccion_Hora')
                    ->join('Usuarios_Correos AS UC','UC.Cedula','=','U.Cedula')
                    ->get();  

            $Alumno = DB::table('Familia_Alumnos as FA')
                    ->select('FA.Nombre_Alumno',
                     'FA.Apellido1_Alumno',
                     'FA.Apellido2_Alumno',
                     'FA.Codigo_Familia')
                    ->where('FA.Cedula_Alumno', '=',   $Cedula_Alumno )
                    ->get(); 

            $date=date_create($Fecha_Cita);
            $fecha = date_format($date,"d - M - y");

            $padre = DB::table('Usuarios_Correos as UC')
                    ->select('UC.Correo',
                     'U.Nombre',
                     'U.Apellido1',
                     'U.Apellido2')
                    ->where('U.Codigo_Familia', '=',  $Alumno[0]->Codigo_Familia )
                    ->join('Usuarios AS U','U.Cedula','=','UC.Cedula')
                    ->limit(1)
                    ->get(); 

            $data = array( 'titulo'=> 'Aviso de Cancelación',  'email' => $padre[0]->Correo, 'name'=> $padre[0]->Nombre . ' ' . $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2, 'dia'=> $fecha, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma que la cita de atención solicitada con el Docente: ' . $Hora_Atencion[0]->Nombre . ' ' . $Hora_Atencion[0]->Apellido1 . ' ' . $Hora_Atencion[0]->Apellido2 . ' ha sido cancelada');
            Mail::queue('Email.citas', $data, function($message) use ($data){
                $message->to($data['email'], $data['name'])->subject('Aviso de Cancelación');
            }); 
            var_dump(Mail::failures());

            $data = array( 'titulo'=> 'Aviso de Cancelación',  'email' => 'secretaria.secundaria@copes.ed.cr', 'name'=> 'Secretaría', 'dia'=> $fecha, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma la cancelación de la cita de: ' . $padre[0]->Nombre . ' ' . $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2 . ' con el Docente: ' . $Hora_Atencion[0]->Nombre . ' ' . $Hora_Atencion[0]->Apellido1 . ' ' . $Hora_Atencion[0]->Apellido2 . ' ha sido cancelada por el docente');
            Mail::queue('Email.citas', $data, function($message) use ($data){
                $message->to($data['email'], $data['name'])->subject('Aviso de Cancelación');
            }); 
            var_dump(Mail::failures());
        }
    }


    //Grettel Monge Rojas

    public function asistencia()
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $data['Permiso']  = $this->getRoles();
            $data['secciones'] = DB::table('Profesor_Materia')
                        ->distinct('Seccion')
                        ->where('Cedula_Usuarios', '=',   Auth::user()->Cedula)
                        ->get(); 
            return View::make('profesor.asistencia', $data);
        }
    }

    public function getStudents($seccion)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $data['alumnos'] = DB::table('Familia_Alumnos as FA')
                        ->select('FA.id','FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Seccion_Alumno', 'FA.Monto_Mensual', 'FA.Estado')
                        ->where('FA.Seccion_Alumno', '=', $seccion)
                        ->get(); 
            return Response::json($data);         
        }
    }

    public function sendClassList($estudiantes)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            if ($estudiantes == "") {
                $datos['Respuesta'] = 'Unsuccessfull';
            } else {
                $data = explode(",", $estudiantes);
                $html = '<br>';
                foreach ($data as $est) {
                    $alumnos = DB::table('Familia_Alumnos as FA')
                            ->select('FA.Cedula_Alumno', 'FA.Nombre_Alumno', 'FA.Apellido1_Alumno', 'FA.Apellido2_Alumno', 'FA.Seccion_Alumno')
                            ->where('FA.Cedula_Alumno', '=', $est)
                            ->get(); 
                    $html .= $alumnos[0]->Cedula_Alumno . ' - ' . $alumnos[0]->Nombre_Alumno . ' ' . $alumnos[0]->Apellido1_Alumno .  ' ' . $alumnos[0]->Apellido2_Alumno . ' - ' . $alumnos[0]->Seccion_Alumno;
                    $html .= "<br>";        
                }

                $encargadoCorreo = DB::table('Parametros')
                            ->select('Estado')
                            ->where('Nombre', '=', 'EncargadoCorreo')
                            ->get(); 

                $encargadoNombre = DB::table('Parametros')
                            ->select('Estado')
                            ->where('Nombre', '=', 'EncargadoNombre')
                            ->get(); 
                $data = array( 'titulo'=> 'Aviso de Asistencia',  'email' => $encargadoCorreo[0]->Estado, 'name'=> $encargadoNombre[0]->Estado , 'detalle' => $html);

                //return View::make('Email.asistencia', $data);

                Mail::queue('Email.asistencia', $data, function($message) use ($data){
                    $message->to($data['email'], $data['name'])->subject('Aviso de Asistencia'); // No funciona
                }); 

                if (Mail::failures()) {
                    $datos['Respuesta'] = 'Unsuccessfull';
                } else {
                    $datos['Respuesta'] = 'Successfull';
                }
            }
            return Response::json($datos);
        }
    }

    public function asignaciones()
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $data['Permiso']  = $this->getRoles();
            $data['secciones'] = DB::table('Profesor_Materia')
                        ->distinct('Seccion')
                        ->where('Cedula_Usuarios', '=',   Auth::user()->Cedula)
                        ->get(); 
            $data['materias'] = DB::table('Profesor_Materia')
                        ->distinct('Materia')
                        ->where('Cedula_Usuarios', '=',   Auth::user()->Cedula)
                        ->get();                        
            $data['tipos'] = DB::table('Rubros_Entregables')
                        ->select('id','Tipo_Trabajo')
                        ->get();  
            return View::make('profesor.Asignaciones.asignaciones', $data);
        }
    }

    public function searchInfo($seccion, $materia)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $datos['entregables'] = DB::table('Entregables as E')
                        ->join('Rubros_Entregables as ER', 'ER.id', '=', 'E.idRubroEntregable')
                        ->select('E.id','ER.Tipo_Trabajo', 'E.Detalle', 'E.Fecha_Entrega', 'E.Estado')
                        ->where('E.Seccion', '=',   $seccion)
                        ->where('E.Materia', '=',   $materia)
                        ->where('E.Fecha_Entrega', '>', date('Y') .'-01-01' )
                        ->get();           
            return Response::json($datos);
        }
    }

    public function saveInfo()
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            Input::flash();
            
            $reglas = array(
                'seccion' => 'required',
                'materia' => 'required',
                'trabajo' => 'required',
                'descripcion' => 'required',
                'fecha' => 'required'
            );
           
            // Crear instancia del validador.
            $validador = Validator::make(Input::all(), $reglas);

            if ($validador->passes()) {
                $entregable = new Entregables();
                $entregable->Seccion = Input::get('seccion');
                $entregable->Materia = Input::get('materia');
                $entregable->idRubroEntregable = Input::get('trabajo');
                $entregable->Detalle = Input::get('descripcion');
                $entregable->Fecha_Entrega = Input::get('fecha');
                $entregable->Estado = 'F';
                if ($entregable->save()) {
                    return Response::json($entregable);
                }
            }else{
                $data = 'Error';
                return Response::json($data);
            } 
        }
    }

    public function deleteItem($id)
    {
       if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            if (Entregables::destroy($id)) {
                return Response::json(true);
            }else{
                return Response::json(false);
            }
        }
    }

    public function searchItem($id)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $datos = 
            DB::select(
                    DB::raw('SELECT
                                E.id,
                                RE.id AS idRE,
                                E."Detalle",
                                E."Fecha_Entrega",
                                E."Estado"
                            FROM "Rubros_Entregables" RE, "Entregables" E
                            WHERE
                                RE.id = E."idRubroEntregable"
                            AND E.id = \'' . $id .'\''));
            return Response::json($datos);
        }
    }

    public function updateItem($id)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $entregable = Entregables::find($id);
            $entregable->Seccion = Input::get('seccion');
            $entregable->Materia = Input::get('materia');
            $entregable->idRubroEntregable = Input::get('trabajo');
            $entregable->Detalle = Input::get('descripcion');
            $entregable->Fecha_Entrega = Input::get('fecha');
            $entregable->Estado = Input::get('estado');
            if ($entregable->save()) {
                return Response::json($entregable);
            }else{
                $data = 'Error';
                return Response::json($data);
            }
        }
    }

    public function newType($id)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $entregable = new RubrosEntregables();
            $entregable->Tipo_Trabajo = $id;
            if ($entregable->save()) {
                return Response::json($entregable);
            }else{
                $data = 'Error';
                return Response::json($data);
            }
        }
    }

    public function getItem($seccion)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $entregable = new RubrosEntregables();
            $entregable->Tipo_Trabajo = Input::get('trabajo');
            if ($entregable->save()) {
                return Response::json($entregable);
            }else{
                $data = 'Error';
                return Response::json($data);
            }
        }
    }

    public function saveItemStudent($estudiantes, $id)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $estudiante = explode(",", $estudiantes);
            foreach ($estudiante as $est) {
                $entregableRecibido = new EntregablesRecibidos();
                $entregableRecibido->idEntregable = $id;
                $entregableRecibido->Cedula_Alumno = $est;
                $entregableRecibido->save();
            }
            $entregable = Entregables::find($id);
            $entregable->Estado = 'T';
            $entregable->save();
            $data['Respuesta'] = 'Successfull';
            return Response::json($data);
        }
    }

    public function getRubros()
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $data['Permiso']  = $this->getRoles();
            $data['secciones'] = DB::table('Profesor_Materia')
                        ->distinct('Seccion')
                        ->where('Cedula_Usuarios', '=',   Auth::user()->Cedula)
                        ->get(); 
            $data['materias'] = DB::table('Profesor_Materia')
                        ->distinct('Materia')
                        ->where('Cedula_Usuarios', '=',   Auth::user()->Cedula)
                        ->get();                        
            $data['tipos'] = DB::table('Rubros_Entregables')
                        ->select('id','Tipo_Trabajo')
                        ->get();  
            return View::make('profesor.Rubros.rubros', $data);
        }
    }


    public function searchRubros($nivel, $materia, $periodo, $anio)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $data['Items'] = DB::table('Rubro_Asignacion as RA')
                    ->select('RA.id','R.Detalle_Rubro', 'RA.Valor')
                    ->join('Rubros as R', 'R.id', "=", "RA.idRubro")
                    ->where('RA.Nivel', '=', strstr($nivel, '-', TRUE))
                    ->where('RA.Materia', '=', $materia)
                    ->orderBy('R.id', 'asc')
                    ->get();     
            $data['Rubros'] = DB::select(
                    DB::raw('SELECT
                                datos2.Cedula_Alumno,
                                concat_ws(\' \', datos1.Nombre_Alumno, datos1.Apellido1_Alumno, datos1.Apellido2_Alumno)AS Nombre_Alumno,
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

    public function searchRubrosAlumno($cedula, $periodo, $anio)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            $data['Alumno'] = DB::table('Familia_Alumnos as FA')
                        ->select('FA.Nombre_Alumno',
                         'FA.Apellido1_Alumno',
                         'FA.Apellido2_Alumno',
                         'FA.Codigo_Familia')
                        ->where('FA.Cedula_Alumno', '=',  $cedula )
                        ->get();
            $data['Rubros'] = DB::select(
                    DB::raw('SELECT
                                datos1.id,
                                datos1.detalle_rubro,
                                datos1.valor,
                                sum(datos1.idAlum + datos2.idAlum) as idAlum,
                                sum(datos1.Valor_Obtenido + datos2.Valor_Obtenido) as Valor_Obtenido
                            FROM((SELECT
                                    rub."Detalle_Rubro" AS Detalle_Rubro,
                                    rubAsig.id AS id,
                                    rubAsig."Valor" AS Valor,
                                    rubAlum.id AS idAlum,
                                    rubAlum."Valor_Obtenido" AS Valor_Obtenido
                                FROM    
                                    "Familia_Alumnos" AS FA,
                                    (SELECT R.id, R."Detalle_Rubro" FROM "Rubros" as R) AS rub,
                                    (SELECT * FROM "Rubro_Asignacion" as RA) as rubAsig,
                                    (SELECT * FROM "Rubro_Alumno" as AR) AS rubAlum
                                WHERE   FA."Cedula_Alumno"  = \'' . $cedula . '\'
                                    AND FA."Estado" = \'T\'
                                    AND rub.id = rubAsig."idRubro"
                                    AND rubAsig.id = rubAlum."idRubro"
                                    AND rubAlum."Cedula_Alumno" = FA."Cedula_Alumno"
                                    AND rubAlum."Trimestre" = \'' . $periodo . '\'
                                    AND rubAlum."Anio" = \'' . $anio . '\')
                                UNION ALL
                                (SELECT
                                    rub."Detalle_Rubro" AS Detalle_Rubro,
                                    rubAsig.id AS id,
                                    rubAsig."Valor" AS Valor,
                                    0 AS idAlum,
                                    0 AS Valor_Obtenido
                                FROM    
                                    "Familia_Alumnos" AS FA,
                                    (SELECT R.id, R."Detalle_Rubro" FROM "Rubros" as R) as rub,
                                    (SELECT * FROM "Rubro_Asignacion" as RA) as rubAsig
                                WHERE   FA."Cedula_Alumno"  = \'' . $cedula . '\'
                                    AND FA."Estado" = \'T\'
                                    AND rub.id = rubAsig."idRubro")) as datos1,
                                (SELECT
                                    rub.id as ide,
                                    rub."Detalle_Rubro" AS Detalle_Rubro,
                                    rubAsig.id AS id,
                                    rubAsig."Valor" AS Valor,
                                    0 AS idAlum,
                                    0 AS Valor_Obtenido
                                FROM    
                                    "Familia_Alumnos" AS FA,
                                    (SELECT R.id, R."Detalle_Rubro" FROM "Rubros" as R) as rub,
                                    (SELECT * FROM "Rubro_Asignacion" as RA) as rubAsig
                                WHERE   FA."Cedula_Alumno"  = \'' . $cedula . '\'
                                    AND FA."Estado" = \'T\'
                                    AND rub.id = rubAsig."idRubro") as datos2
                            WHERE
                                datos1.detalle_rubro  = datos2.detalle_rubro 
                            GROUP BY datos2.ide, datos1.id, datos1.detalle_rubro, datos1.valor
                            ORDER BY datos2.ide ASC'));
            return Response::json($data); 
        }
    }

    public function updateItemAlumno($array)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            if ($array == "") {
                $datos['Respuesta'] = 'Unsuccessfull';
            } else {
                $data = explode(",", $array);
                $html = '<br>';
                foreach ($data as $arr) {
                    $info = explode('-', $arr);
                    if ($info[0] == 0) {
                        $Rubro_Alumno = new RubroAlumno();
                        $Rubro_Alumno->idRubro = $info[1];
                        $Rubro_Alumno->Cedula_Alumno = $info[2];
                        $Rubro_Alumno->Valor_Obtenido = $info[3];
                        $Rubro_Alumno->Trimestre = $info[4];
                        $Rubro_Alumno->Anio = $info[5];
                        $Rubro_Alumno->save();
                    } else {
                        $Rubro_Alumno = RubroAlumno::find($info[0]);
                        $Rubro_Alumno->idRubro = $info[1];
                        $Rubro_Alumno->Cedula_Alumno = $info[2];
                        $Rubro_Alumno->Valor_Obtenido = $info[3];
                        $Rubro_Alumno->Trimestre = $info[4];
                        $Rubro_Alumno->Anio = $info[5];
                        $Rubro_Alumno->save();
                    }
                }
                $datos['Respuesta'] = 'Successfull';
            }
            return Response::json($datos);
        }
    }
}