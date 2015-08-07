@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/Contabilidad/newPago.css');}} 
@stop @section('cuerpo')
@parent
@foreach($Pagos as $usr)
    <div class="row" style="margin-top:4%">
        <div class="col-xs-12 col-sm-8 col-md-10 col-md-offset-1">
        	<div class="panel panel-default" style="margin-top:1%">
                <div class="panel-heading text-center">
                    <h1>Mostrar Pago </h1>
                </div>
                <div class="panel-body">
                	<div class="row">
                        <div class="col-md-8 form-group"  style="  padding-right: 15px;">
                            <label>Nombre del Estudiante</label>
                            <input id="Monto" type="text" class="form-control" style="background-color: white;" readonly value="{{$usr->Nombre_Alumno}} {{$usr->Apellido1_Alumno}} {{$usr->Apellido2_Alumno}}">
                		</div>
                		<div class="col-md-4" >
                			<label>Sección</label>
                            <input id="Monto" type="text" class="form-control" style="background-color: white;" readonly value="{{$usr->Seccion_Alumno}}">
                        </div>
                	</div>
                	<div class="row">
                        <div class="col-md-4  form-group">
                            <label>Monto de mensualidad</label>
                            <input id="Monto" type="text" class="form-control" style="background-color: white;" readonly value="¢{{$usr->Monto_Mensual}}">
                        </div>
                        <div class="col-md-4">
                            <label>Monto Pagado</label>
                            <input type="text" class="form-control" id="MontoPagado"style="background-color: white;" readonly value="¢{{$usr->Monto_Recibo}}">
                        </div>
                        <div class="col-md-4">
                            <label>Mensualidad de: </label>
                            <?php
                                switch ($usr->Mensualidad) {
                                    case 1:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Enero">';
                                        break;
                                    case 2:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Febrero">';
                                        break;
                                    case 3:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Marzo">';
                                        break;
                                    case 4:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Abril">';
                                        break;
                                    case 5:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Mayo">';
                                        break;
                                    case 6:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Junio">';
                                        break;
                                    case 7:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Julio">';
                                        break;
                                    case 8:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Agosto">';
                                        break;
                                    case 9:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Setiembre">';
                                        break;
                                    case 10:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Octubre">';
                                        break;
                                    case 11:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Noviembre">';
                                        break;
                                    case 12:
                                        echo '<input id="Mensualidad" type="text" class="form-control" style="background-color: white;" readonly value="Diciembre">';
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Número de Recibo</label>
                            <input id="Numero" type="text" class="form-control" style="background-color: white;" readonly value="#{{$usr->Numero_Recibo_Banco}}">
                        </div>
                        <div class="col-md-4 form-group"  style="  padding-right: 15px;">
                            <label>Fecha de Pago</label>
                            <input id="Fecha" type="text" class="form-control" style="background-color: white;" readonly value='{{date("d-m-Y", strtotime($usr->Fecha_Pago))}}'>
                        </div>
                        <div class="col-md-4 form-group"  style="  padding-right: 15px;">
                            <label>Banco</label>
                            <?php
                                switch ($usr->Banco) {
                                    case 1:
                                        echo '<input id="Monto" type="text" class="form-control" style="background-color: white;" readonly value="Banco Nacional de Costa Rica">';
                                        break;
                                    
                                    default:
                                        echo '<input id="Monto" type="text" class="form-control" style="background-color: white;" readonly value="Coocique R.L.">';
                                        break;
                                }
                            ?>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 form-group"  style="  padding-right: 15px;">
                            <label>Recargo</label>
                            <input id="Recargo" type="text" class="form-control" style="background-color: white;" readonly value="¢{{$usr->Recargo}}">
                        </div>
                        <div class="col-md-2 form-group"  style="  padding-right: 15px;">
                            <label>Monto pendiente</label>
                            <input id="Diferencia" type="text" class="form-control" style="background-color: white;" readonly value="¢{{abs($usr->Diferencia)}}">
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Descripcion</label>
                            <input id="Descripcion" type="text" class="form-control" style="background-color: white;" readonly value="{{$usr->Descripcion}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                            <a href="{{'/contabilidad/'.$usr->id.'/editar' }}" class="btn btn-info btn-block" role="button">Editar</a>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="{{ route('ContPagos') }}" class="btn btn-primary btn-block">Atrás</a>
                        </div>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
{{HTML::script('js/contabilidad/newPago.js');}}
<script type="text/javascript">
	var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop
