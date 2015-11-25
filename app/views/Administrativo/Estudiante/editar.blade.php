@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/newUser.css');}} @stop @section('cuerpo') @parent
@if(count($Estudiante)>0) @foreach ($Estudiante as $fam)

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h1>Edición del Hijo (a)</h1>
            </div>
            <div class="panel-body">
                {{ HTML::ul($errors->all() )}} {{ Form::model($fam, array('action' => array('AdministradorController@updateStudent', $fam->id), 'method' => 'PUT')) }}
                <div class="row">
                    <div class="col-md-6">
                        {{-- codigofamilia ------------------------}}{{ Form::label('codigofamilia', 'Codigo Familia', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span><?php $codigofamilia = $fam->Codigo_Familia?>
                            <input name="codigofamilia" id="txt_codigofamilia" class="form-control" maxlength="50" type="text" value="{{$fam->Codigo_Familia}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- cedula ------------------------}}{{ Form::label('cedula', 'Cédula', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                            <input name="cedula" id="txt_cedula" class="form-control" maxlength="50" type="text" value="{{$fam->Cedula_Alumno}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{-- Nombre_Alumno ------------------------}}{{ Form::label('nombre_alumno', 'Nombre', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                            <input name="nombre" id="txt_nombre" class="form-control" maxlength="64" type="text" value="{{$fam->Nombre_Alumno}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('nombre_alumno') }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {{-- Apellido1 ------------------------}}{{ Form::label('apellido1_alumno', 'Primer Apellido', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                            <input name="apellido1" id="txt_apellido1" class="form-control" maxlength="64" type="text" value="{{$fam->Apellido1_Alumno}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('apellido1_alumno') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- Apellido2 ------------------------}} {{ Form::label('apellido2_alumno', 'Segundo Apellido', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                            <input name="apellido2" id="txt_apellido2" class="form-control" maxlength="64" type="text" value="{{$fam->Apellido2_Alumno}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('apellido2_alumno') }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {{-- Fecha ------------------------}} {{ Form::label('fecha', 'Fecha de Nacimiento', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                            <input name="fecha" class="form-control" type="date" value="{{$fam->Fecha_Nacimiento}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('fecha') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- Mensual ------------------------}} {{ Form::label('mensual', 'Monto Mensual', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                            <input name="mensual" class="form-control" type="text" value="{{$fam->Monto_Mensual}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('mensual') }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {{-- Seccion ------------------------}} {{ Form::label('seccion', 'Sección', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                            <input name="seccion" class="form-control" type="text"value="{{$fam->Seccion_Alumno}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('seccion') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- Nivel ------------------------}} {{ Form::label('nivel', 'Nivel', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-signal"></span></span>
                            <input name="nivel" class="form-control" type="text" value="{{$fam->Nivel_Alumno}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('nivel') }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                        <button class="btn btn-success btn-block" id="bt_registrarsar_usuario">Guardar</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <a href="/Administrativo/{{$codigofamilia}}/showFamily" class="btn btn-primary btn-block">Cancelar</a>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endforeach @endif 
{{HTML::script('js/authentication/signin.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop