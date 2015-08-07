@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/newUser.css');}} @stop @section('cuerpo')
@parent
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h1>Mostrar usuario</h1>
            </div>
            @foreach ($Usuarios as $usr)
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Cedula ------------------------}}{{ Form::label('Cedula', 'Cédula', array('class' => 'control-label')) }}
                            <div class="form-group input-group" style="  padding-right: 15px;">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                <input class="form-control" style="background-color:white;" type="text" disabled value="{{$usr->Cedula}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- codigofamilia ------------------------}}{{ Form::label('codigofamilia', 'Codigo Familia', array('class' => 'control-label')) }}
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                                <input class="form-control" style="background-color:white;" type="text" disabled value="{{$usr->Codigo_Familia}}">
                            </div>
                        </div>
                    </div>
                    {{-- Nombre ------------------------}}{{ Form::label('nombre', 'Nombre', array('class' => 'control-label')) }}
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                        <input class="form-control" style="background-color:white;" type="text" disabled value="{{$usr->Nombre}}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Apellido1 ------------------------}}{{ Form::label('apellido1', 'Primer Apellido', array('class' => 'control-label')) }}
                            <div class="form-group input-group" style="  padding-right: 15px;">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                <input class="form-control" style="background-color:white;" type="text" disabled value="{{$usr->Apellido1}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- Apellido2 ------------------------}} {{ Form::label('apellido2', 'Segundo Apellido', array('class' => 'control-label')) }}
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                                <input class="form-control" style="background-color:white;" type="text" disabled value="{{$usr->Apellido2}}">
                            </div>
                        </div>
                    </div>
                    {{-- Direccion ------------------------}} {{ Form::label('direccion', 'Dirección', array('class' => 'control-label')) }}
                    <div class="form-group input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                         <input class="form-control" style="background-color:white;" type="text" disabled value="{{$usr->Direccion}}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Correos ------------------------}} {{ Form::label('correo', 'Correo', array('class' => 'control-label')) }}
                            <table>
                                @foreach ($Usuarios_Correos as $correo)
                                <tr>
                                    <td>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                            <input class="form-control" style="background-color:white; width: 115%;" type="text" disabled value="{{$correo->Correo}}">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-md-6">
                            {{-- Teléfono ------------------------}} {{ Form::label('telefono', 'Teléfono', array('class' => 'control-label')) }}
                            <table>
                                @foreach ($Usuarios_Telefonos as $phone)
                                <tr>
                                    <td>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                                            <input class="form-control" style="background-color:white; width: 115%;" type="text" disabled value="{{$phone->Telefono}}">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <a href="{{'/administracion/roles/'.$usr->Cedula }}" class="btn btn-danger btn-block" role="button">Modificar Roles</a>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                            <a href="{{'/Administrativo/'.$usr->id.'/edit' }}" class="btn btn-success btn-block" role="button">Editar</a>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="{{ route('usuarios') }}" class="btn btn-primary btn-block">Cancelar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{HTML::script('js/authentication/signin.js');}}
<script type="text/javascript">
    var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop