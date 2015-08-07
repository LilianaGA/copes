@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/login.css');}} @stop @section('cuerpo') @parent
<div class="container">
    <br>
    <div class="row">

        <div class="col-md-6 col-md-offset-3">
            <div style="padding: 20px;" id="form-olvidado">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h2>Por favor ingrese sus credenciales</h2>
                    </div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => '/login', 'role'=>'form')) }}
                        <div class="text-left">
                            {{ Form::label('username', 'Usuario', array('class' => 'control-label')) }}
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                {{ Form::text('username', Input::old('username'), array( 'name' => 'username', 'id' => 'txt_username', 'class' => 'form-control', 'maxlength' => '20', 'placeholder' => 'Digite su nombre de usuario')) }}
                            </div>
                            {{ Form::label('password', 'Contraseña', array('class' => 'control-label')) }}
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                {{ Form::password('password', array( 'name' => 'password', 'id' => 'txt_password', 'class' => 'form-control', 'maxlength' => '20', 'type' => 'password', 'placeholder' => 'Digite su contraseña')) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="#" id="olvidado">
                                <p class="text-info">
                                    ¿Olvidaste tu contraseña?</p></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <button class="btn btn-success btn-block" id="bt_login">Iniciar sesión</button>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <button class="btn btn-primary btn-block" id="bt_cerrar" onclick="cancel()" type="button">Cerrar</button>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div style="display: none;" id="form-olvidado">
                <div class="error-template text-center">
                    <h1>
                        Por favor</h1>
                    <h2>
                        Contactar al administrador</h2>
                    <div class="error-details">
                        Teléfono: 2460-0256 ext. 107
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-12">
                        <button class="btn btn-info btn-block" id="acceso" type="button">Regresar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{HTML::script('js/authentication/login.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop