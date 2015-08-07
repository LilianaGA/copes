@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/newUser.css');}} @stop @section('cuerpo') @parent
<br>
<br>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h1>Registro de usuario</h1>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url' => '/signin', 'role'=>'form')) }}
                <div class="row">
                    <div class="col-md-6">
                        {{-- Cedula ------------------------}}{{ Form::label('Cedula', 'Cédula', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="  padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                            {{ Form::text('Cedula', Input::old('Cedula'), array( 'name' => 'Cedula', 'id' => 'txt_Cedula', 'class' => 'form-control', 'maxlength' => '20')) }}
                        </div>
                        <p class="text-danger">
                            {{ $errors->signin->first('Cedula') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- codigofamilia ------------------------}}{{ Form::label('codigofamilia', 'Codigo Familia', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                            {{ Form::text('codigofamilia', Input::old('codigofamilia'), array( 'name' => 'codigofamilia', 'id' => 'txt_codigofamilia', 'class' => 'form-control', 'maxlength' => '50')) }}
                        </div>
                        <p class="text-danger">
                            {{ $errors->signin->first('codigofamilia') }}
                        </p>
                    </div>
                </div>
                {{-- Nombre ------------------------}}{{ Form::label('nombre', 'Nombre', array('class' => 'control-label')) }}
                <div class="form-group input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                    {{ Form::text('nombre', Input::old('nombre'), array( 'name' => 'nombre', 'id' => 'txt_nombre', 'class' => 'form-control', 'maxlength' => '20')) }}
                </div>
                <p class="text-danger">
                    {{ $errors->signin->first('nombre') }}
                </p>
                <div class="row">
                    <div class="col-md-6">
                        {{-- Apellido1 ------------------------}}{{ Form::label('apellido1', 'Primer Apellido', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="  padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                            {{ Form::text('apellido1', Input::old('apellido1'), array( 'name' => 'apellido1', 'id' => 'txt_apellido1', 'class' => 'form-control', 'maxlength' => '64')) }}
                        </div>
                        <p class="text-danger">
                            {{ $errors->signin->first('apellido1') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- Apellido2 ------------------------}} {{ Form::label('apellido2', 'Segundo Apellido', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                            {{ Form::text('apellido2', Input::old('apellido2'), array( 'name' => 'apellido2', 'id' => 'txt_apellido2', 'class' => 'form-control', 'maxlength' => '64')) }}
                        </div>
                        <p class="text-danger">
                            {{ $errors->signin->first('apellido2') }}
                        </p>
                    </div>
                </div>
                {{-- password ------------------------}} {{ Form::label('password', 'Contraseña', array('class' => 'control-label')) }}
                <div class="form-group input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                     {{ Form::password('password', array( 'name' => 'password', 'id' => 'txt_password', 'class' => 'form-control', 'maxlength' => '20', 'type' => 'password')) }}
                </div>
                <p class="text-danger">
                    {{ $errors->signin->first('password') }}
                </p>
                {{-- Direccion ------------------------}} {{ Form::label('direccion', 'Dirección', array('class' => 'control-label')) }}
                <div class="form-group input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                     {{ Form::text('direccion', Input::old('direccion'), array( 'name' => 'direccion', 'id' => 'txt_direccion', 'class' => 'form-control', 'maxlength' => '200')) }}
                </div>
                <p class="text-danger">
                    {{ $errors->signin->first('direccion') }}
                </p>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                        <button class="btn btn-success btn-block" id="bt_registrarse">Registrarse</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <button class="btn btn-primary btn-block" id="bt_cerrar" onclick="cancel()" type="button">Cerrar</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

{{HTML::script('js/authentication/signin.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop