<?php

class ProfesorController extends BaseController
{

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

    public function updateCita($id, $estado, $comentario)
    {
        if ($this->validateProfesor() == false) {
            return Redirect::route('home');
        }else{
            if ($estado == 'Pendiente') {
                $data['Respuesta'] = 'Successfull';
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
}