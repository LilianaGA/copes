@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/newUser.css');}} @stop @section('cuerpo') @parent
@if(count($Usuarios)>0) @foreach ($Usuarios as $usr)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div style="padding: 20px;" id="form-olvidado">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h2>Editando su información</h2>
                    </div>
                    <div class="panel-body">
                    {{ HTML::ul($errors->all() )}} {{ Form::model($usr, array('action' => array('AdministradorController@updateUser', $usr->id), 'method' => 'PUT')) }}
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Cedula ------------------------}}{{ Form::label('Cedula', 'Cédula', array('class' => 'control-label')) }}
                            <div class="form-group input-group" style="  padding-right: 15px;">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                {{ Form::text('Cedula', Input::old('Cedula'), array( 'name' => 'Cedula', 'id' => 'txt_Cedula', 'class' => 'form-control', 'maxlength' => '20', 'readonly')) }}
                            </div>
                            <p class="text-danger">
                                {{ $errors->signin->first('Cedula') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            {{-- codigofamilia ------------------------}}{{ Form::label('codigofamilia', 'Codigo Familia', array('class' => 'control-label')) }}
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                                {{ Form::text('codigofamilia', Input::old('Codigo_Familia'), array( 'name' => 'codigofamilia', 'id' => 'txt_codigofamilia', 'class' => 'form-control', 'maxlength' => '50', 'readonly')) }}
                            </div>
                            <p class="text-danger">
                                {{ $errors->signin->first('codigofamilia') }}
                            </p>
                        </div>
                    </div>
                    {{-- Nombre ------------------------}}{{ Form::label('nombre', 'Nombre', array('class' => 'control-label')) }}
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                        {{ Form::text('nombre', Input::old('Nombre'), array( 'name' => 'nombre', 'id' => 'txt_nombre', 'class' => 'form-control', 'maxlength' => '20')) }}
                    </div>
                    <p class="text-danger">
                        {{ $errors->signin->first('nombre') }}
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Apellido1 ------------------------}}{{ Form::label('apellido1', 'Primer Apellido', array('class' => 'control-label')) }}
                            <div class="form-group input-group" style="  padding-right: 15px;">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                {{ Form::text('apellido1', Input::old('Apellido1'), array( 'name' => 'apellido1', 'id' => 'txt_apellido1', 'class' => 'form-control', 'maxlength' => '64')) }}
                            </div>
                            <p class="text-danger">
                                {{ $errors->signin->first('apellido1') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            {{-- Apellido2 ------------------------}} {{ Form::label('apellido2', 'Segundo Apellido', array('class' => 'control-label')) }}
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                                {{ Form::text('apellido2', Input::old('Apellido2'), array( 'name' => 'apellido2', 'id' => 'txt_apellido2', 'class' => 'form-control', 'maxlength' => '64')) }}
                            </div>
                            <p class="text-danger">
                                {{ $errors->signin->first('apellido2') }}
                            </p>
                        </div>
                    </div>
                    {{-- Direccion ------------------------}} {{ Form::label('direccion', 'Dirección', array('class' => 'control-label')) }}
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                         {{ Form::text('direccion', Input::old('Direccion'), array( 'name' => 'direccion', 'id' => 'txt_direccion', 'class' => 'form-control', 'maxlength' => '200')) }}
                    </div>
                    <p class="text-danger">
                        {{ $errors->signin->first('direccion') }}
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Correos ------------------------}} {{ Form::label('correo', 'Correo', array('class' => 'control-label')) }}
                            <div class="form-group input-group" style="padding-right: 15px;">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                <input class="form-control" name="Correo0" type="email" value="" placeholder="correo@dominio.com">
                            </div>
                            @foreach ($Usuarios_Correos as $correo)
                                <div class="form-group input-group" style="padding-right: 15px;">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                    <input class="form-control" name="Correo{{$correo->id}}" type="email" value="{{$correo->Correo}}" placeholder="correo@dominio.com">
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            {{-- Teléfono ------------------------}} {{ Form::label('telefono', 'Teléfono', array('class' => 'control-label')) }}
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                                <input class="form-control" name="Telefono0" type="text" value="" placeholder="8888-8888">
                            </div>
                            @foreach ($Usuarios_Telefonos as $phone)
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                                    <input class="form-control" name="Telefono{{$phone->id}}" type="text" value="{{$phone->Telefono}}" placeholder="8888-8888">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="#" id="olvidado">
                                    <p class="text-info">
                                        ¿Cambio de contraseña?</p>
                                </a>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                            <button type="submit" class="btn btn-success btn-block">Guardar</button>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                             <a href="{{ route('usuarios') }}" class="btn btn-primary btn-block">Cancelar</a>
                        </div>
                    </div>
                    {{ Form::close() }}{{ Form::close() }}
                </div>
            </div>
        </div>
        <br><br>
        <div style="display: none;" id="form-olvidado">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h2>Cambio de Contraseña</h2>
                    </div>
                    <div class="panel-body">
                        {{ Form::model($usr, array('action' => array('AdministradorController@updatePass', $usr->id), 'method' => 'PUT')) }}
                        <div class="text-left">
                            {{ Form::password('password1', array( 'name' => 'password1', 'id' => 'password1', 'class' => 'form-control', 'maxlength' => '20', 'type' => 'password', 'placeholder' => 'Nueva Contraseña', 'autocomplete' => 'off', 'required')) }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>&nbsp; Longuitud de 8 caracteres.
                                    <br>
                                    <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>&nbsp; Una letra mayúscula.
                                </div>
                                <div class="col-sm-6">
                                    <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>&nbsp; Una letra minúscula.
                                    <br>
                                    <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>&nbsp; Un número.
                                </div>
                            </div>
                            <br>
                            <input type="password" class="form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off">
                            <div class="row">
                                <div class="col-sm-12">
                                    <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>&nbsp; Contraseñas idénticas.
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6" style="  padding-right: 15px;">
                                <button type="submit" class="btn btn-success btn-block">Guardar</button>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <button class="btn btn-primary btn-block" id="acceso" type="button">Cancelar</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach @endif {{HTML::script('js/profile/edit.js');}}

{{HTML::script('js/admin/edit.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop