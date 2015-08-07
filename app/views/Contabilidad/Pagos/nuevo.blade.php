@extends('layouts.base') @section('cabecera') @parent 
@stop @section('cuerpo')
@parent
<div class="row" style="margin-top:4%">
    <div class="col-xs-12 col-sm-8 col-md-10 col-md-offset-1">
    	<div class="panel panel-default" style="margin-top:1%">
            <div class="panel-heading text-center">
                <h1>Ingreso de Pago</h1>
            </div>
            {{ Form::open(array('action' => 'ContadorController@storePay', 'method' => 'post', 'enctype'=>'multipart/form-data')) }}
            <div class="panel-body">
            	<div class="row">
                    <div class="col-md-8 form-group"  style="  padding-right: 15px;">
                        <label>Nombre del Estudiante</label>
                        <select id="select-student" data-placeholder="Seleccione el alumno..." class="chosen-select form-control multiselect multiselect-icon"  name="myselect">
                            <option value=""></option>
                            @if(isset($Estudiantes))
                                @if(count($Estudiantes)>0) 
                                    @foreach($Estudiantes as $usr)
                                        <option value="{{$usr->Cedula_Alumno}}" id="{{$usr->id}}" data-icon="glyphicon-user">{{$usr->Nombre_Alumno}} {{$usr->Apellido1_Alumno}} {{$usr->Apellido2_Alumno}}</option>  
                                   @endforeach
                                @endif
                            @endif
                        </select> 
            		</div>
            		<div class="col-md-4 form-group">
            			<label>Sección</label>
                        <input type="text" class="form-control" id="spanGroup" style="background:white;" readonly>
                    </div>
            	</div>
            	<div class="row">
                    <div class="col-md-4">
                        <label>Monto de mensualidad</label>
                        <input id="Monto" type="text" class="form-control" style="background-color: white;" readonly value="">
                    </div>
                    <div class="col-md-4">
                        <label>Monto Pagado</label>
                        <input type="text" class="form-control" id="MontoPagado" name="MontoPagado">
                        <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"> Monto Incompleto</span>
                    </div>
                    <div class="col-md-4">
                        <label>Mensualidad de: </label>
                        <select id="select-month" data-placeholder="Seleccione un Mes" class="chosen-select form-control multiselect multiselect-icon"  name="searchMes">
                            <option value=""></option>
                            <option value="1" style="display:none">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12" style="display:none">Diciembre</option>
                        </select> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Número de Recibo</label>
                        <input id="Numero_Recibo_Banco" name="Numero_Recibo_Banco" type="text" class="form-control" value="">
                    </div>
                    <div class="col-md-4 form-group" style="  padding-right: 15px;">
                        <label>Fecha de Pago</label>
                        <input id="Fecha_Pago" name="Fecha_Pago" type="text" class="form-control" value="" onblur="resultDate()">
                    </div>
                    <div class="col-md-4 form-group" style="  padding-right: 15px;">
                       <label>Banco</label>
                        <select data-placeholder="Seleccione un banco" class="chosen-select form-control multiselect multiselect-icon"  name="searchBanco">
                            <option value=""></option>
                            <option value="1">Banco Nacional de Costa Rica</option>
                            <option value="2">Coocique R.L.</option>
                        </select> 
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-2 form-group"  style="  padding-right: 15px;">
                            <label>Recargo</label>
                            <input id="Recargo" name="Recargo" type="text" class="form-control" readonly value="0">
                        </div>
                        <div class="col-md-2 form-group"  style="  padding-right: 15px;">
                            <label>Monto pendiente</label>
                            <input id="Diferencia" name="Diferencia" type="text" class="form-control"  readonly value="0">
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Descripcion</label>
                            <input id="Descripcion" name="Descripcion" type="text" class="form-control"  value="" data-placeholder="Digite una descripción">
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-success btn-block" id="">Guardar</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('ContPagos') }}" class="btn btn-primary btn-block">Atrás </a>
                    </div>
                </div>
			</div>
            {{ Form::close() }}
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
{{HTML::script('js/contabilidad/newPago.js');}}
<script type="text/javascript">
	var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop
