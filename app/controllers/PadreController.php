<?php

class PadreController extends BaseController
{

    //Validador sobre los permisos del padre
    public function validatePadre()
    {
        if (Auth::check()) {
            $permiso = DB::table('Tipos_Acceso AS TA')
                            ->join('Tipos_Usuarios as TU', 'TU.Tipos_Accesos', '=', 'TA.id')
                            ->select('TA.Descripcion')
                            ->where('TU.Cedula_Usuarios', '=',  Auth::user()->username )
                            ->where('TA.Descripcion', "=", 'Encargado')
                            ->get(); 
            if(count($permiso) > 0){ // cuando el indice es mayor a 1
                return true;
            }else{
                return false;
            }
        }else{//en caso de no estar loguead
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

    //Muestra los saldos de la familia
    public function showSaldos(){
        if ($this->validatePadre() == true) {
            $now = new DateTime();
            $data['Saldos'] = DB::table('Pagos as P')
                        ->join('Familia_Alumnos as FA', 'FA.id', '=', 'P.Cedula_Alumno')
                        ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
                        ->select('FA.Nombre_Alumno',
                                 'FA.Apellido1_Alumno',
                                 'FA.Apellido2_Alumno',
                                 'FA.Monto_Mensual',
                                 'P.Fecha_Pago',
                                 'S.Descripcion',
                                 'P.Monto_Recibo',
                                 'P.Recargo',
                                 'S.Diferencia')
                        ->where('P.Codigo_Familia', '=',  Auth::user()->Codigo_Familia )
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("y"), $now->format('M/d/y')))
                        ->get(); 
            $data['MontoRecibo'] = DB::table('Pagos as P')
                        ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
                        ->where('P.Codigo_Familia', '=', Auth::user()->Codigo_Familia )
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("y"), $now->format('M/d/y')))
                        ->sum('P.Monto_Recibo');
            $data['Recargo'] = DB::table('Pagos as P')
                        ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
                        ->where('P.Codigo_Familia', '=',   Auth::user()->Codigo_Familia )
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("y"), $now->format('M/d/y')))
                        ->sum('P.Recargo');            
            $data['Diferencia'] = DB::table('Pagos as P')
                        ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
                        ->where('P.Codigo_Familia', '=',    Auth::user()->Codigo_Familia )
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("y"), $now->format('M/d/y')))
                        ->sum('S.Diferencia');  
            $data['Permiso']  = $this->getRoles();
            return View::make('padre.saldos', $data);
        }else{
            return Redirect::route('logoutFromRol'); //cierra sesion por falta de permisos 
        }
    }

    //Formulario de cancelación de citas
    public function showCancelaCitas()
    {
        if ($this->validatePadre() == false) { //no tiene permisos, primer metodo en la clase
            return Redirect::route('logoutFromRol'); //cierra sesion por falta de permisos 
        }else{
            $date = new DateTime();
            $lastDay = $date->format('Y-m-t');
            $firstDay = $date->format('Y-m-01');
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
                                and C."Estado_Cita" = \'P\'
                                and FA."Codigo_Familia" =\'' . Auth::user()->Codigo_Familia . '\''));
            $data['Permiso']  = $this->getRoles();
        }        
        return View::make('padre.cancelacitas', $data);
    }

    //actualiza los datos de la cancelación de la cita
    public function updateCita($id){
        $cita = Citas::find($id);//buscar en citas
        $controlcitas = new ControlCitas();
        $controlcitas->Codigo_Familia = Auth::user()->Codigo_Familia;
        $controlcitas->Cantidad_Perdida = 1;
        $controlcitas->save();
        $this->sendEmailCancela($cita->Cedula_Alumno, $cita->id_Hora_Atencion, $cita->Fecha_Cita);//envia correo
        Citas::destroy($id);// elimina cita
        return Redirect::route('saldos');
    }
    
    //Muestra las citas de la familia
    public function showCitas(){
        if ($this->validatePadre() == true) {
            $data['Familia_Alumnos'] = DB::table('Familia_Alumnos as FA')
                        ->select('FA.Cedula_Alumno',
                                'FA.Nombre_Alumno',
                                'FA.Apellido1_Alumno',
                                'FA.Apellido2_Alumno')
                        ->where('FA.Codigo_Familia', '=',   Auth::user()->Codigo_Familia )
                        ->get(); 
            $data['Permiso']  = $this->getRoles();
            return View::make('padre.citas', $data);
        }else{
            return Redirect::route('logoutFromRol'); //cierra sesion por falta de permisos 
        }
    }
    
    //Muestra el formulario de la solicitudes de certificados
    public function showCertificados(){
        if ($this->validatePadre() == true) {
            $data['Permiso']  = $this->getRoles();
            return View::make('padre.certificados', $data);
        }else{
            return Redirect::route('logoutFromRol'); //cierra sesion por falta de permisos 
        }
    }

    //Muestra las materias de los alumnos
    public function showSubjects($Cedula_Alumno){
        if ($this->validatePadre() == true) {
            $data['Subjects'] = DB::table('Familia_Alumnos as FA')
                ->select('PM.Materia',
                        'PM.Cedula_Usuarios')
                ->where('FA.Cedula_Alumno', '=',   $Cedula_Alumno )
                ->join('Profesor_Materia AS PM','PM.Seccion','=','FA.Seccion_Alumno')
                ->get();  
                return Response::json($data); //retorna la materias 
        }       
    }

    //Despliega las citas
    public function showApp($Cedula_Profesor)
    {
        if ($this->validatePadre() == true) {
            $data['Days'] = DB::table('Usuarios as U')
                ->select('LH.Hora',
                        'HA.Dia',
                        'C.Estado_Cita',
                        'C.Fecha_Cita')
                ->where('U.Cedula', '=', $Cedula_Profesor)
                ->where('C.Fecha_Cita', '>=', '01/05/2015')
                ->join('Hora_Atencion AS HA','HA.Codigo_Profesor','=','U.id')
                ->join('Leccion_Hora as LH','LH.Numero','=', 'HA.Leccion_Hora')
                ->join('Citas AS C','C.id_Hora_Atencion','=','HA.id')
                ->get();  
                return Response::json($data); 
        }else{
            return Redirect::route('logoutFromRol'); //cierra sesion por falta de permisos 
        }   
    }

    //Obtiene las citas del mes determinado
    public function showAppointByMonth($Cedula_Profesor)
    {
        if ($this->validatePadre() == true) {
            $data = DB::table('Hora_Atencion as HA')
                ->select('LH.Hora',
                        'HA.Dia')
                ->where('HA.Codigo_Profesor', '=', $Cedula_Profesor)
                ->join('Leccion_Hora as LH','LH.Numero','=', 'HA.Leccion_Hora')
                ->get();  

                foreach($data as $key)
                {
                    $array = array();
                    $dayNeeded = $this->translateDayToSpanish($key->Dia);//optiene el dia en español 
                    $array['Hora']  = $key->Hora;// asigna hora
                    $array['Dia']  = $key->Dia;// asigna dia
                    
                    $daysArray = $this->appointmentForCurrentMonth($dayNeeded); //citas de este mes
                    $json = array();// crea un array
                    foreach ($daysArray as $value) {

                        $array['Fecha_Cita']  = $value;//asigna la fecha
                        $fechas = DB::table('Citas')
                                ->select()
                                ->where('Fecha_Cita', '=', $value)
                                ->get(); 
                        if (count($fechas)>0) {
                            $array['Estado_Cita']  = "P";//cita pendiente
                        }else{
                            $array['Estado_Cita']  = "D";//cita disponible
                        }
                        array_push($json, $array);//inserta cita en $json
                    }
                    $newData['Days'] = $json;//se guarda en el key days
                    
                    //var_dump($newData); die;
                    $date = new DateTime();
                    $firstDayOfYear = $date->format('Y-01-01');
                    $lastDay = $date->format('Y-m-t');
                    $firstDay = $date->format('Y-m-01');
                    $newData['Family'] = DB::select(
                            DB::raw('SELECT * FROM "Citas" c
                                WHERE EXISTS (SELECT * 
                                        FROM "Citas" c, "Familia_Alumnos" fa 
                                        WHERE c."Cedula_Alumno" = fa."Cedula_Alumno" 
                                            AND fa."Codigo_Familia" = \'' . Auth::user()->Codigo_Familia . '\') 
                                AND c."Estado_Cita" = \'P\'
                                AND c."Fecha_Cita" BETWEEN \'' . $firstDay . '\' AND \'' . $lastDay . '\''));
                    $newData['Control'] = DB::select(
                            DB::raw('SELECT count("Cantidad_Perdida")
                                FROM "Control_Citas"
                                WHERE "Codigo_Familia" = \'' . Auth::user()->Codigo_Familia . '\'
                                AND created_at BETWEEN \'' . $firstDayOfYear . '\' AND \'' . $lastDay . '\''));
                    return Response::json($newData);

                    //{"Days":[{"Hora":"9:50am a 10:30am","Dia":"Jueves","Estado_Cita":"P","Fecha_Cita":"2015-05-28 00:00:00"}]}
                    //return $this->appointmentForCurrentMonth($dayNeeded);
                }
        }else{
            return Redirect::route('logoutFromRol'); //cierra sesion por falta de permisos 
        }   
    }

    //Traduce el nombre del día
    private function translateDayToSpanish($daySpanish) {

        $daysEnglish = array('Domingo'  => 'Sunday', 'Lunes'  => 'Monday'    , 'Martes' => 'Tuesday'  , 'Miércoles' => 'Wednesday'  ,
                        'Jueves'  => 'Thursday'  ,  'Viernes' => 'Friday'   , 'Sabado' => 'Saturday');
        return $daysEnglish[$daySpanish];
    }

    //Obtiene las fechas para las citas del actual mes
    private function appointmentForCurrentMonth($dayNeeded)
    {
        date_default_timezone_set("America/Costa_Rica");//timezone a utilizar en las citas
        $daysArray =  array(0  => 'Monday'    ,  1 => 'Tuesday'  , 2 => 'Wednesday'  ,
                         3  => 'Thursday'  ,  4 => 'Friday'   , 5 => 'Saturday'   ,
                         6  => 'Sunday' );
        $nameOfDay     = date('l', time());    //nombre del dia 
        $numberOfMonth = date('m',time());     //numero del mes
        $year          = date('Y',time());     //numero de año
        $numberOfDay   = date('j',time());     //indice del dia
        $numberOfDaysByMonth = date('t', mktime(0, 0, 0, $numberOfMonth, 1, $year)); //numero de dias por mes
        $indexByDay          = array_search($nameOfDay, $daysArray); //indice del dia 
        $indexByDayNeeded    = array_search($dayNeeded, $daysArray); //indice del dia necesario
        $daysForThisMonth = array();// array con dias posibles de citas
        if($indexByDay  >= $indexByDayNeeded) { //ejemplo estamos miercoles cita para lunes
            $dayToStart =  ($numberOfDay += 7 ) - ($indexByDay  - $indexByDayNeeded);    
        }
        else {//ejemplo estamos lunes cita para miercoles
            $dayToStart =  ($numberOfDay) + ($indexByDayNeeded  - $indexByDay);
        }
        $stringDate = $numberOfMonth .  "-"  . $dayToStart . "-" .  $year;//concatenando la fecha
    
        if ($dayToStart   <= $numberOfDaysByMonth) { // mientras sea menor que la cantidad de dias en el mes
            $daysForThisMonth = array($stringDate); //inserta el primer item
            while ($dayToStart  <= $numberOfDaysByMonth) { //mientras sea menor que la cantidad de dias del mes, hace el ciclo
                $dayToStart += 7;//28-05-2015 
                $stringDate = $numberOfMonth .  "-"  . $dayToStart . "-" .  $year;//concatenando la fecha
                if ($dayToStart  <= $numberOfDaysByMonth) { //
                    array_push($daysForThisMonth,$stringDate); //inserta $stringDate en $daysForThisMonth
                }
            }
        }
        return $daysForThisMonth;
    }

    //Reserva la cita
    public function reserveApp($cedulaA, $cedulaP, $fecha)
    {
        $Cedula_Alumno   = $cedulaA;//cedula alumno
        $Cedula_Profesor = $cedulaP;//cedula profesor
        $Fecha   = $fecha;
        $id_Hora_Atencion = DB::table('Hora_Atencion as HA')
                ->select('HA.id')
                ->where('HA.Codigo_Profesor', '=',   $Cedula_Profesor )
                ->get();  
        foreach ($id_Hora_Atencion as $id) {
            $idHA = $id->id;
        }
        $CitaCreada = DB::table('Citas')
                            ->select()
                            ->where('id_Hora_Atencion', '=',  $idHA)
                            ->where('Fecha_Cita', "=", $Fecha)
                            ->get(); 
        if (count($CitaCreada) <= 0) {
            $cita = new Citas();
            $cita->Cedula_Alumno = $Cedula_Alumno;
            $cita->id_Hora_Atencion = $idHA;
            $cita->Fecha_Cita = $Fecha;
            $cita->Estado_Cita = 'P';//pendiente
            if (!$cita->save()) {//error al guardar cita
                $data['Respuesta'] = 'Not Found';
                return $data['Respuesta'];
            }else{//guardar cita
                $data['Respuesta'] = 'Successfull';
                return $data['Respuesta'];
            }
        }
        $data['Respuesta'] = 'Not Found';
        return $data['Respuesta'];
    }

    //Envía el correo  para la confirmación de la cita
    public function sendEmail($cedulaA, $cedulaP, $fecha)
    {
    
        $select = DB::table('Usuarios_Correos as UC')
                ->select('UC.Correo',
                 'U.Nombre',
                 'U.Apellido1',
                 'U.Apellido2')
                ->where('U.Cedula', '=',  $cedulaP )
                ->join('Usuarios AS U','U.Cedula','=','UC.Cedula')
                ->limit(1)
                ->get(); 

        $Hora_Atencion = DB::table('Hora_Atencion as HA')
                ->select('HA.Dia', 'LH.Hora')
                ->where('HA.Codigo_Profesor', '=',   $cedulaP )
                ->join('Leccion_Hora AS LH','LH.id','=','HA.Leccion_Hora')
                ->get();  

                

        $Alumno = DB::table('Familia_Alumnos as FA')
                ->select('FA.Nombre_Alumno',
                 'FA.Apellido1_Alumno',
                 'FA.Apellido2_Alumno')
                ->where('FA.Cedula_Alumno', '=',   $cedulaA )
                ->get(); 

        //despliega las iniciales del mes segun el numero de mes
        $mons = array('01' => "Ene", '02' => "Feb", '03' => "Mar", '04' => "Abr", '05' => "May", '06' => "Jun", '07' => "Jul", '08' => "Ago", '09' => "Sep", '10' => "Oct", '11' => "Nov", '12' => "Dec");
        $fechaAux = substr($fecha,3,2) . "/" . $mons[substr($fecha,0,2)] . "/" . substr($fecha,6,6);

        $data = array( 'titulo'=> 'Confirmación de Cita',  'email' => $select[0]->Correo, 'name'=> $select[0]->Nombre . ' ' . $select[0]->Apellido1 . ' ' . $select[0]->Apellido2, 'dia'=> $fechaAux, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma que tiene una cita de atención solicitado por Padre, Madre o Encargado del alumno: ' . $Alumno[0]->Nombre_Alumno . ' ' . $Alumno[0]->Apellido1_Alumno . ' ' . $Alumno[0]->Apellido2_Alumno);
        Mail::queue('Email.citas', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('Confirmación de cita');
        }); 
        var_dump(Mail::failures());

        $padre = DB::table('Usuarios_Correos as UC')
                ->select('UC.Correo',
                 'U.Nombre',
                 'U.Apellido1',
                 'U.Apellido2')
                ->where('U.Cedula', '=',  Auth::user()->Cedula )
                ->join('Usuarios AS U','U.Cedula','=','UC.Cedula')
                ->limit(1)
                ->get(); 

        $data = array( 'titulo'=> 'Confirmación de Cita',  'email' => $padre[0]->Correo, 'name'=> $padre[0]->Nombre . ' ' . $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2, 'dia'=> $fecha, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma que tiene una cita de atención solicitado con el Docente: ' . $select[0]->Nombre . ' ' . $select[0]->Apellido1 . ' ' . $select[0]->Apellido2);
        Mail::queue('Email.citas', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('Confirmación de cita');
        }); 
        var_dump(Mail::failures());

        /**/
    }

    //Envía el correo  para la confirmación de la cita
    public function sendEmailCancela($Cedula_Alumno, $id_Hora_Atencion, $Fecha_Cita)
    {

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
                 'FA.Apellido2_Alumno')
                ->where('FA.Cedula_Alumno', '=',   $Cedula_Alumno )
                ->get(); 

        $date=date_create($Fecha_Cita);
        $fecha = date_format($date,"d - M - y");

        $data = array( 'titulo'=> 'Aviso de Cancelación',  'email' => $Hora_Atencion[0]->Correo, 'name'=> $Hora_Atencion[0]->Nombre . ' ' . $Hora_Atencion[0]->Apellido1 . ' ' . $Hora_Atencion[0]->Apellido2, 'dia'=> $fecha, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma que la cita de atención solicitada por Padre, Madre o Encargado del alumno: ' . $Alumno[0]->Nombre_Alumno . ' ' . $Alumno[0]->Apellido1_Alumno . ' ' . $Alumno[0]->Apellido2_Alumno . ' ha sido cancelada');
        Mail::queue('Email.citas', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('Aviso de Cancelación');
        }); 
        var_dump(Mail::failures());

        $padre = DB::table('Usuarios_Correos as UC')
                ->select('UC.Correo',
                 'U.Nombre',
                 'U.Apellido1',
                 'U.Apellido2')
                ->where('U.Cedula', '=',  Auth::user()->Cedula )
                ->join('Usuarios AS U','U.Cedula','=','UC.Cedula')
                ->limit(1)
                ->get(); 

        $data = array( 'titulo'=> 'Aviso de Cancelación',  'email' => $padre[0]->Correo, 'name'=> $padre[0]->Nombre . ' ' . $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2, 'dia'=> $fecha, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma que la cita de atención solicitada con el Docente: ' . $Hora_Atencion[0]->Nombre . ' ' . $Hora_Atencion[0]->Apellido1 . ' ' . $Hora_Atencion[0]->Apellido2 . ' ha sido cancelada');
        Mail::queue('Email.citas', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('Aviso de Cancelación');
        }); 
        var_dump(Mail::failures());
        
        $data = array( 'titulo'=> 'Aviso de Cancelación',  'email' => 'secretaria.secundaria@copes.ed.cr', 'name'=> 'Secretaría', 'dia'=> $fecha, 'hora'=> $Hora_Atencion[0]->Hora, 'detalle' => 'Se confirma la cancelación de la cita de: ' . $padre[0]->Nombre . ' ' . $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2 . ' con el Docente: ' . $Hora_Atencion[0]->Nombre . ' ' . $Hora_Atencion[0]->Apellido1 . ' ' . $Hora_Atencion[0]->Apellido2 . ' ha sido cancelada');
        Mail::queue('Email.citas', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('Aviso de Cancelación');
        }); 
        var_dump(Mail::failures());
    }

    //Envía un correo para la certificación
    public function obtenerCertificado($tipo, $cedula, $nombre, $fecha, $nivel, $anio)
    {
        $padre = DB::table('Usuarios_Correos as UC')
                ->select('UC.Correo',
                 'U.Nombre',
                 'U.Apellido1',
                 'U.Apellido2')
                ->where('U.Cedula', '=',  Auth::user()->Cedula )
                ->join('Usuarios AS U','U.Cedula','=','UC.Cedula')
                ->limit(1)
                ->get(); 

        $data = array( 'titulo'=> 'Solicitud de Certificación',  'email' => 'secretaria.secundaria@copes.ed.cr', 'name'=> 'Secretaría', 'tipo'=> $tipo, 'numero'=> $cedula, 'nombre' => $nombre, 'fecha' => $fecha, 'nivel' => $nivel, 'anio' => $anio, 'detalle' => 'El padre, madre o encargado: ' . $padre[0]->Nombre . ' ' . $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2 . ' solicita un certificado con los siguientes datos');
        Mail::queue('Email.certificado', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('Solicitud de Certificación');
        }); 
        $data['Respuesta'] = 'Successfull';
        return $data['Respuesta'];
    }

    //Obtiene el día de las citas
    public function getDate($id)
    {
       $date = new DateTime();
            $lastDay = $date->format('Y-m-t');
            $firstDay = $date->format('Y-m-01');
            $data['Citas'] = DB::select(
                    DB::raw('Select
                                C."Fecha_Cita"
                            From "Citas" C, "Hora_Atencion" HA, "Usuarios" U, "Familia_Alumnos" FA, "Leccion_Hora" LH
                            Where
                                C."id_Hora_Atencion" = HA.id
                                and C."Fecha_Cita" BETWEEN \'' . $firstDay . '\' AND \'' . $lastDay . '\'
                                and HA."Codigo_Profesor" = U."Cedula"
                                and C."Cedula_Alumno" = FA."Cedula_Alumno"
                                and HA."Leccion_Hora" = LH.id
                                and C."Estado_Cita" = \'P\'
                                and FA."Codigo_Familia" =\'' . Auth::user()->Codigo_Familia . '\''));
        return Response::json($data); 
    }
}