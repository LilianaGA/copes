<?php

class ContadorController extends BaseController
{

	//Validador sobre los permisos del contador
	public function validateContador()
	{
		if (Auth::check()) {
			$permiso = DB::table('Tipos_Acceso AS TA')
		                    ->join('Tipos_Usuarios as TU', 'TU.Tipos_Accesos', '=', 'TA.id')
		                    ->select('TA.Descripcion')
		                    ->where('TU.Cedula_Usuarios', '=',  Auth::user()->username )
		                    ->where('TA.Descripcion', "=", 'Contador')
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

	//Muestra los pagos realizados hasta la fecha
	public function showPagos(){
        if ($this->validateContador() == true) {
    		$now = new DateTime();
        	$data['Pagos'] = DB::table('Pagos as P')
	                    ->select('P.id',
	                    		'P.Banco', 
	                    		'P.Numero_Recibo_Banco', 
	                    		'P.Fecha_Pago', 
	                    		'FA.Nombre_Alumno' ,
	                    		'FA.Apellido1_Alumno', 
	                    		'FA.Seccion_Alumno',
	                    		'P.Mensualidad')
	                    ->join('Familia_Alumnos as FA', 'FA.id', '=', 'P.Cedula_Alumno')
	                    ->whereBetween('P.Fecha_Pago', array($now->format("m") . '-01-' . $now->format("Y"), $now->format('m-d-Y')))
	                    ->orderBy('FA.Nombre_Alumno' , 'asc' )
                        ->get();
            $data['Familia'] = DB::table('Codigo_Familia')
	                    ->select('Codigo_Familia',
	                    		'Apellido1', 
	                    		'Apellido2')
	                    ->get();
            $data['Estudiante'] = DB::table('Familia_Alumnos')
	                    ->select('Cedula_Alumno',
	                    		'Nombre_Alumno',
	                    		'Apellido1_Alumno', 
	                    		'Apellido2_Alumno')
	                    ->get();
            $data['Permiso']  = $this->getRoles();
		  	return View::make('Contabilidad.pagos', $data);
        }else{
            return Redirect::route('logoutFromRol'); 
        }
	}

	//Muestra una serie de reportes
	public function showReportes(){
        if ($this->validateContador() == true) {
        	$now = new DateTime();
        	$data['MontosActuales'] = DB::table('Pagos')
        				->whereBetween('Fecha_Pago', array('01-01-' . $now->format("Y"), $now->format('m-d-Y')))
                        ->sum('Monto_Recibo');
            $data['MontosMensuales'] = DB::select(
                    DB::raw('Select
								sum("Monto_Recibo"),
								"Mensualidad"
							From
								"Pagos"
							Where
								"Fecha_Pago" between \'01-01-' . $now->format("Y") . '\' and \'12-31-' . $now->format('Y') . '\'
							Group by "Mensualidad"
							Order by cast("Mensualidad" as int) asc'));
            $data['MontosAlDia'] = DB::table('Familia_Alumnos as FA')
	                    ->select('FA.Nombre_Alumno', 
	                    		'FA.Apellido1_Alumno', 
	                    		'FA.Apellido2_Alumno', 
	                    		'FA.Seccion_Alumno',
	                    		'P.Monto_Recibo',
	                    		'P.Mensualidad')
	                    ->join('Pagos as P', 'P.Cedula_Alumno', '=', 'FA.id')
	                    ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
	                    ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("Y"), $now->format('m-d-Y')))
	                    ->where('P.Recargo', "=", 0)
	                    ->where('S.Diferencia', "=", 0)
	                    ->orderBy('P.Mensualidad', 'asc')
	                    ->orderBy('FA.Seccion_Alumno', 'asc')
	                    ->orderBy('FA.Nombre_Alumno', 'asc')
	                    ->get();
			$data['MontosMoroso'] = 
        		DB::select(
                    DB::raw('Select 
								CF."Apellido1",
								CF."Apellido2",
								sum(P."Recargo") AS Recargo,
								sum(abs(S."Diferencia")) AS Diferencia,
								sum(P."Recargo") + sum(abs(S."Diferencia")) AS Total
							from "Codigo_Familia" as CF
							inner JOIN "Pagos" as P on P."Codigo_Familia" = CF."Codigo_Familia"
							inner JOIN "Saldos" as S on S."id_Pago" = P.id
							where (P."Recargo" > 0 or S."Diferencia" > 0 ) and P."Fecha_Pago" between \'01-01-' . $now->format("Y") . '\' and \'' . $now->format('m-d-Y') . '\'
							group by CF."Apellido1", CF."Apellido2"
							Order by CF."Apellido1" asc, CF."Apellido2" asc'));
            $data['Familia'] = DB::table('Codigo_Familia')
	                    ->select('Codigo_Familia',
	                    		'Apellido1', 
	                    		'Apellido2')
	                    ->get();
	        $data['Permiso']  = $this->getRoles();
            return View::make('Contabilidad.reportes', $data);
        }else{
            return Redirect::route('logoutFromRol'); 
        }
	}

	//Creación del nuevo pago
	public function createPago(){
		if ($this->validateContador() == true) {
			$data['Estudiantes'] = DB::table('Familia_Alumnos')
	                    ->select('id',
	                    		'Cedula_Alumno',
	                    		'Nombre_Alumno', 
	                    		'Apellido1_Alumno', 
	                    		'Apellido2_Alumno', 
	                    		'Seccion_Alumno')
	                    ->get();
	        $data['Permiso']  = $this->getRoles();
		  	return View::make('Contabilidad.Pagos.nuevo', $data);
        }else{
            return Redirect::route('logoutFromRol'); 
        }
	}

	//Despliega los datos de un pago
	public function displayPay($id){
		if ($this->validateContador() == true) {
    		$data['Pagos'] = DB::table('Pagos as P')
	                    ->select('P.id',
	                    		'P.Banco', 
	                    		'P.Numero_Recibo_Banco', 
	                    		'P.Fecha_Pago', 
	                    		'P.Monto_Recibo',
	                    		'P.Mensualidad',
	                    		'P.Recargo',
	                    		'P.Fecha_Pago',
	                    		'S.Descripcion',
	                    		'S.Diferencia',
	                    		'FA.Nombre_Alumno' ,
	                    		'FA.Apellido1_Alumno', 
	                    		'FA.Apellido2_Alumno', 
	                    		'FA.Seccion_Alumno',
	                    		'FA.Monto_Mensual')
	                    ->join('Familia_Alumnos as FA', 'FA.id', '=', 'P.Cedula_Alumno')
	                    ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
	                    ->where('P.id', "=", $id)
	                    ->get();
            $data['Permiso']  = $this->getRoles();
		  	return View::make('Contabilidad.Pagos.mostrar', $data);
        }else{
            return Redirect::route('logoutFromRol'); 
        }
	}

	//Edición del pago
	public function editPay($id){
		if ($this->validateContador() == true) {
    		$data['Pagos'] = DB::table('Pagos as P')
	                    ->select('P.id',
	                    		'P.Banco', 
	                    		'P.Numero_Recibo_Banco', 
	                    		'P.Fecha_Pago', 
	                    		'P.Monto_Recibo',
	                    		'P.Mensualidad',
	                    		'P.Recargo',
	                    		'P.Fecha_Pago',
	                    		'S.Descripcion',
	                    		'S.Diferencia',
	                    		'FA.Nombre_Alumno' ,
	                    		'FA.Apellido1_Alumno', 
	                    		'FA.Apellido2_Alumno', 
	                    		'FA.Seccion_Alumno',
	                    		'FA.Monto_Mensual')
	                    ->join('Familia_Alumnos as FA', 'FA.id', '=', 'P.Cedula_Alumno')
	                    ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
	                    ->where('P.id', "=", $id)
	                    ->get();
            $data['Permiso']  = $this->getRoles();
		  	return View::make('Contabilidad.Pagos.editar', $data);
        }else{
            return Redirect::route('logoutFromRol'); 
        }
	}

	//Actualización de los datos del pago
	public function updatePago($id){
		if ($this->validateContador() == true) {
			$pagos = Pagos::find($id);
			$pagos->Banco = Input::get('Banco');
			$pagos->Numero_Recibo_Banco = Input::get('Numero_Recibo_Banco');
			$pagos->Monto_Recibo = Input::get('MontoPagado');
			$pagos->Recargo = Input::get('Recargo');
			$fechaAux = substr(Input::get('Fecha_Pago'),3,2) . "/" . substr(Input::get('Fecha_Pago'),0,2) . "/" . substr(Input::get('Fecha_Pago'),6,6);
			$pagos->Fecha_Pago = $fechaAux;
			$pagos->Mensualidad = Input::get('Mensualidad');
			$pagos->save();
			$saldos = Saldos::all();
	        foreach($saldos as $sld){
	            if($sld->id_Pago == $id){
	                $sld->Diferencia = Input::get('Diferencia') * -1;
					$sld->Descripcion = Input::get('Descripcion');
					$sld->save();
	            }
			}
			return Redirect::route('ContPagos');
		}else{

		}
	}

	//Obtiene las secciones de un alumno
	public function getGroup($Cedula_Alumno){
		if ($this->validateContador() == true) {
			$data['Seccion'] = DB::table('Familia_Alumnos')
	                    ->select('Seccion_Alumno', 'Monto_Mensual')
	                    ->where('Cedula_Alumno', "=", $Cedula_Alumno)
	                    ->get();
            return Response::json($data);
		}
	}

	//Obtiene las materias de un alumno
	public function searchSubject($Cedula_Alumno)
	{
		if ($this->validateContador() == true) {
			$data['Materia'] = DB::table('Familia_Alumnos as FA')
	                    ->select('PM.Materia',
	                    		'Cedula_Usuarios')
	                    ->join('Profesor_Materia as PM', 'PM.Seccion', '=', 'FA.Seccion_Alumno')
	                    ->where('FA.Cedula_Alumno', "=", $Cedula_Alumno)
	                    ->get();
            return Response::json($data);
		}
	}

	//Almacena los datos del pago
	public function storePay(){
		if ($this->validateContador() == false) {
            return Redirect::route('logoutFromRol'); 
        }else{
			// Guardar el valor de los campos en el postback
			$user = Familia::all();
	        foreach($user as $usr){
	            if($usr->Cedula_Alumno == Input::get('myselect')){
	                $pagos = new Pagos();
					$pagos->Codigo_Familia = $usr->Codigo_Familia;
					$pagos->Banco = Input::get('searchBanco');
					$pagos->Numero_Recibo_Banco = Input::get('Numero_Recibo_Banco');
					$pagos->Cedula_Alumno = $usr->id;
					$pagos->Monto_Recibo = Input::get('MontoPagado');
					$pagos->Mensualidad = Input::get('searchMes');
					$pagos->Recargo = Input::get('Recargo');
					$fechaAux = substr(Input::get('Fecha_Pago'),3,2) . "/" . substr(Input::get('Fecha_Pago'),0,2) . "/" . substr(Input::get('Fecha_Pago'),6,6);
					$pagos->Fecha_Pago = $fechaAux;
					$pagos->save();
		        	$saldos = new Saldos();
		        	$saldos->Codigo_Familia = $usr->Codigo_Familia;
		        	$saldos->id_Pago = $pagos->id;
		        	if (Input::get('Diferencia') > 0 ) {
		        		$saldos->Diferencia = "-" . Input::get('Diferencia');
		        	}else{
		        		$saldos->Diferencia = 0;
		        	}
		        	$saldos->Descripcion = Input::get('Descripcion');
		        	$saldos->save();
		        	return Redirect::route('ContPagos');
	            }
			}
        	return Redirect::route('ContPagos')
		        	->with('flash_warning', 'El registro del pago no puede ser procesado');
		}
	}

	
	/**
	 * Remueve un registro de la base datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyPay($id)
	{
		if ($this->validateContador() == false) {
            return Redirect::route('logoutFromRol'); 
        }else{
			// delete
	        $saldos = Saldos::all();
			foreach($saldos as $sld){
	            if($sld->id_Pago == $id){
	            	$sld->delete();
            	}
        	}	
        	$pagos = Pagos::find($id);
        	$pagos->delete();
			return Redirect::route('ContPagos');
		}
	}

	//Carga la vista para el calculo de los pagos
	public function viewCalculateNotPaidAccount()
	{
		if ($this->validateContador() == false) {
            return Redirect::route('logoutFromRol'); 
        }else{
        	$data['Permiso']  = $this->getRoles();
			return View::make('Contabilidad.cuentas', $data);
		}
	}

	/* 
	 * Función para calcular alumnos morosos
	 *
	 */
	public function calculateNotPaidAccount($id, $correo)
	{
		$data = DB::select(
                    DB::raw('Select 
								FA.id, 
								FA."Codigo_Familia",
								FA."Monto_Mensual"
							from "Familia_Alumnos" FA, "Codigo_Familia" CF
							where  NOT EXISTS ( Select * from "Pagos" Where "Mensualidad"  = \'' . (int)$id . '\' and "Pagos"."Cedula_Alumno" = FA.id)
							and FA."Codigo_Familia" = CF."Codigo_Familia"
							and CF."Estado" = \'T\''));
		if (isset($data)) {
			$aux = 0;
			$sinCorreo =0;
			foreach($data as $alumno){
				$today = new DateTime();
				$lastDay = new DateTime("" . ($today->format('y')+2000) ."-". $id ."-0");
				$lastDay->modify('M jS');
	            $pagos = new Pagos();
				$pagos->Codigo_Familia = $alumno->Codigo_Familia;
				$pagos->Banco = " ";
				$pagos->Numero_Recibo_Banco = " ";
				$pagos->Cedula_Alumno = $alumno->id;
				$pagos->Monto_Recibo = 0;
				$pagos->Mensualidad = $id;
				$pagos->Recargo = ($alumno->Monto_Mensual * 0.15);
				$pagos->Fecha_Pago = $lastDay;
				$pagos->save();
	        	$saldos = new Saldos();
	        	$saldos->Codigo_Familia = $pagos->Codigo_Familia;
	        	$saldos->id_Pago = $pagos->id;
	    		$saldos->Diferencia = ($alumno->Monto_Mensual * -1);
	    		$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	        	$saldos->Descripcion = "Mensualidad Pendiente de " . $meses[$id - 1];
	        	$saldos->save();
	        	if ($correo == "S") { // Si la función fue llamada por el botón con correos los envía
	        		$now = new DateTime();
					$padre = DB::table('Usuarios_Correos as UC')
				                ->select('UC.Correo',
				                 'CA.Apellido1',
				                 'CA.Apellido2')
				                ->where('U.Codigo_Familia', '=',  $pagos->Codigo_Familia )
				                ->join('Usuarios AS U','U.Cedula','=','UC.Cedula')
				                ->join('Codigo_Familia AS CA','CA.Codigo_Familia','=','U.Codigo_Familia')
				                ->limit(1)
				                ->get(); 
	                $Recargo = DB::select(
				                    DB::raw('Select FA."Nombre_Alumno", FA."Apellido1_Alumno",FA."Apellido2_Alumno", (sum(P."Recargo") + sum(abs(S."Diferencia"))) Total
											from "Pagos" P, "Saldos" S, "Familia_Alumnos" FA
											where P."Codigo_Familia" = \'' . $pagos->Codigo_Familia . '\'
											and S.id = P.id
												and P."Fecha_Pago" between \'01-01-' . ($now->format("y") + 2000) .'\' and \''. $now->format('m-d') . '-' . ($now->format("y") + 2000) . '\'
											and P."Cedula_Alumno" = FA.id
											group by FA."Nombre_Alumno", FA."Apellido1_Alumno",FA."Apellido2_Alumno"'));
					try {
						$data = array( 'titulo'=> 'Recordatorio de Cuentas Pendidentes',  'email' => $padre[0]->Correo, 'name'=> $padre[0]->Apellido1 . ' ' . $padre[0]->Apellido2, 'detalle' => 'Nuestros registros muestran un total de saldos pendientes en la mensualidad de ' . $Recargo[0]->Nombre_Alumno . ' ' . $Recargo[0]->Apellido1_Alumno . ' ' . $Recargo[0]->Apellido2_Alumno . ' por la cantidad de ¢' . $Recargo[0]->total);
				        Mail::queue('Email.cuentas', $data, function($message) use ($data){
				            $message->to($data['email'], $data['name'])->subject('Recordatorio de Cuentas Pendidentes');
				        }); 
			        } catch (Exception $e) {
			        	$sinCorreo += 1;
			        }
                }
	        	$aux = 1;
			}
			if ($aux == 0) {
				$data = false; // Se verificó que no existieran cuentas
				return Response::json($data);
			}
			$data = true;
			return Response::json($data);
		}
		$data = false;
		return Response::json($data);
	}


	//Obtiene los balances de la familia
	public function getFamilyBalance($Code)
	{
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
                        ->where('P.Codigo_Familia', '=',  $Code )
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("y"), $now->format('d/M/y')))
                        ->orderBy('P.Fecha_Pago' , 'asc' )
                        ->get(); 
        return Response::json($data);
	}

	//Obtiene los pagos de la familia
	public function getPaysOfFamily($Code)
	{
		$now = new DateTime();
		$data['Pagos'] = DB::table('Pagos as P')
                        ->join('Familia_Alumnos as FA', 'FA.id', '=', 'P.Cedula_Alumno')
                        ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
                        ->select('P.id',
	                    		'P.Banco', 
	                    		'P.Numero_Recibo_Banco', 
	                    		'P.Fecha_Pago', 
	                    		'FA.Nombre_Alumno' ,
	                    		'FA.Apellido1_Alumno', 
	                    		'FA.Seccion_Alumno',
	                    		'P.Mensualidad')
                        ->where('P.Codigo_Familia', '=', $Code)
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("Y"), '11-30-' . $now->format("Y")))
                        ->orderBy('P.Mensualidad' , 'asc' )
                        ->get(); 
        return Response::json($data);
	}

	//Obtiene los pagos del mes seleccionado
	public function getPaysOfMonth($Code)
	{
		$now = new DateTime();
		$data['Pagos'] = DB::table('Pagos as P')
                        ->join('Familia_Alumnos as FA', 'FA.id', '=', 'P.Cedula_Alumno')
                        ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
                        ->select('P.id',
	                    		'P.Banco', 
	                    		'P.Numero_Recibo_Banco', 
	                    		'P.Fecha_Pago', 
	                    		'FA.Nombre_Alumno' ,
	                    		'FA.Apellido1_Alumno', 
	                    		'FA.Seccion_Alumno',
	                    		'P.Mensualidad')
                        ->where('P.Mensualidad', '=', $Code)
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("Y"), '11-30-' . $now->format("Y")))
                        ->orderBy('P.id' , 'asc' )
                        ->get(); 
        return Response::json($data);
	}

	//Obtiene los pagos del alumno seleccionado
	public function getPaysOfStudent($Code)
	{
		$now = new DateTime();
		$data['Pagos'] = DB::table('Pagos as P')
                        ->join('Familia_Alumnos as FA', 'FA.id', '=', 'P.Cedula_Alumno')
                        ->join('Saldos as S', 'S.id_Pago', '=', 'P.id')
                        ->select('P.id',
	                    		'P.Banco', 
	                    		'P.Numero_Recibo_Banco', 
	                    		'P.Fecha_Pago', 
	                    		'FA.Nombre_Alumno' ,
	                    		'FA.Apellido1_Alumno', 
	                    		'FA.Seccion_Alumno',
	                    		'P.Mensualidad')
                        ->where('FA.Cedula_Alumno', '=', $Code)
                        ->whereBetween('P.Fecha_Pago', array('01-01-' . $now->format("Y"), $now->format('m-d-Y')))
                        ->orderBy('P.Mensualidad' , 'asc' )
                        ->get(); 
        return Response::json($data);
	}
}
