@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/contabilidad/newPago.css');}} 
@stop @section('cuerpo')
@parent
@foreach($Pagos as $usr)
    <div class="row" style="margin-top:4%">
        <div class="col-xs-12 col-sm-8 col-md-10 col-md-offset-1">
        	<div class="panel panel-default" style="margin-top:1%">
                <div class="panel-heading text-center">
                    <h1>Editar Pago </h1>
                </div>
                {{ Form::model($usr, array('action' => array('ContadorController@updatePago', $usr->id), 'method' => 'PUT')) }}
                <div class="panel-body">
                	<div class="row">
                        <div class="col-md-8 form-group"  style="  padding-right: 15px;">
                            <label>Nombre del Estudiante</label>
                            <input id="Nombre" type="text" class="form-control" readonly value="{{$usr->Nombre_Alumno}} {{$usr->Apellido1_Alumno}} {{$usr->Apellido2_Alumno}}">
                		</div>
                		<div class="col-md-4" >
                			<label>Sección</label>
                            <input id="Seccion" type="text" class="form-control" readonly value="{{$usr->Seccion_Alumno}}">
                        </div>
                	</div>
                	<div class="row">
                        <div class="col-md-4  form-group">
                            @if($usr->Recargo < 0)
                                <label>Monto de mensualidad</label>
                            @else
                                <label>Monto de mensualidad más recargo</label>
                            @endif
                            <input id="Monto" type="text" class="form-control" readonly value="{{$usr->Monto_Mensual + $usr->Recargo}}">
                        </div>
                        <div class="col-md-4">
                            <label>Monto Pagado</label>
                            <input type="text" class="form-control" id="MontoPagado" name="MontoPagado" value="{{$usr->Monto_Recibo}}" required>
                            @if($usr->Monto_Recibo == $usr->Monto_Mensual)
                                <span id="pwmatch" class="glyphicon glyphicon-ok" style="color:#00A41E;"> Monto Completo</span>
                            @else
                                <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"> Monto Incompleto</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label>Mensualidad de: </label>
                            <select id="select-month" data-placeholder="Seleccione un Mes" class="chosen-select form-control multiselect multiselect-icon"  name="Mensualidad">
                                <option value=""></option>
                                @if($usr->Mensualidad == 1)
                                    <option value="1" style="display:none">Enero</option>
                                @else
                                    <option value="1" style="display:none" select>Enero</option>
                                @endif
                                @if($usr->Mensualidad == 2)
                                    <option value="2" selected>Febrero</option>
                                @else
                                    <option value="2">Febrero</option>
                                @endif
                                @if($usr->Mensualidad == 3)
                                    <option value="3" selected>Marzo</option>
                                @else
                                    <option value="3">Marzo</option>
                                @endif
                                @if($usr->Mensualidad == 4)
                                    <option value="4" selected>Abril</option>
                                @else
                                    <option value="4">Abril</option>
                                @endif
                                @if($usr->Mensualidad == 5)
                                    <option value="5" selected>Mayo</option>
                                @else
                                    <option value="5">Mayo</option>
                                @endif
                                @if($usr->Mensualidad == 6)
                                    <option value="6" selected>Junio</option>
                                @else
                                    <option value="6">Junio</option>
                                @endif
                                @if($usr->Mensualidad == 7)
                                    <option value="7" selected>Julio</option>
                                @else
                                    <option value="7">Julio</option>
                                @endif
                                @if($usr->Mensualidad == 8)
                                    <option value="8" selected>Agosto</option>
                                @else
                                    <option value="8">Agosto</option>
                                @endif
                                @if($usr->Mensualidad == 9)
                                    <option value="9" selected>Setiembre</option>
                                @else
                                    <option value="9">Setiembre</option>
                                @endif
                                @if($usr->Mensualidad == 10)
                                    <option value="10" selected>Octubre</option>
                                @else
                                    <option value="10">Octubre</option>
                                @endif
                                @if($usr->Mensualidad == 11)
                                    <option value="11" selected>Noviembre</option>
                                @else
                                    <option value="11">Noviembre</option>
                                @endif
                                @if($usr->Mensualidad == 12)
                                    <option value="12" style="display:none" select>Diciembre</option>
                                @else
                                    <option value="12" style="display:none">Diciembre</option>
                                @endif
                            </select> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Número de Recibo</label>
                            <input id="Numero_Recibo_Banco" name="Numero_Recibo_Banco" type="text" class="form-control" value="{{$usr->Numero_Recibo_Banco}}" required>
                        </div>
                        <div class="col-md-4 form-group"  style="  padding-right: 15px;">
                            <label>Fecha de Pago</label>
                            <input id="Fecha_Pago" name="Fecha_Pago" type="text" class="form-control"value='{{date("d-m-Y", strtotime($usr->Fecha_Pago))}}' onblur="resultDate()">
                            <input id="Fecha_Pago1" name="Fecha_Pago1" style="display:none;" type="text" class="form-control"value='{{date("d-m-Y", strtotime($usr->Fecha_Pago))}}'>
                        </div>
                        <div class="col-md-4 form-group"  style="  padding-right: 15px;">
                            <label>Banco</label>
                            <select data-placeholder="Seleccione un banco" class="chosen-select form-control multiselect multiselect-icon"  name="Banco">
                                <option value=""></option>
                                @if($usr->Banco == 1)
                                    <option value="1" selected>Banco Nacional de Costa Rica</option>
                                    <option value="2">Coocique R.L.</option>
                                @else
                                    <option value="1">Banco Nacional de Costa Rica</option>
                                    <option value="2" selected>Coocique R.L.</option>
                                @endif
                            </select> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 form-group"  style="  padding-right: 15px;">
                            <label>Recargo</label>
                            <input id="Recargo" name="Recargo" type="text" class="form-control" readonly value="{{$usr->Recargo}}">
                            <input id="Recargo1" style="display:none;" name="Recargo1" type="text" class="form-control" readonly value="{{$usr->Recargo}}">
                        </div>
                        <div class="col-md-2 form-group"  style="  padding-right: 15px;">
                            <label>Monto pendiente</label>
                            <input id="Diferencia" name="Diferencia" type="text" class="form-control"  readonly value="{{abs($usr->Diferencia)}}">
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Descripcion</label>
                            <input id="Descripcion" name="Descripcion" type="text" class="form-control"  value="{{$usr->Descripcion}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                            <button type="submit" class="btn btn-success btn-block">Guardar</button>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="{{ route('ContPagos') }}" class="btn btn-primary btn-block">Cancelar</a>
                        </div>
                    </div>
    			</div>
                {{ Form::close() }}
    		</div>
    	</div>
    </div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
{{HTML::script('js/contabilidad/editPago.js');}}
<script type="text/javascript">
	var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop
