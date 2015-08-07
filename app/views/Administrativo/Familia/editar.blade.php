@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/newUser.css');}} @stop @section('cuerpo') @parent
@if(count($Familia)>0) @foreach ($Familia as $fam)
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h1>Edición de Familia</h1>
            </div>
            <div class="panel-body">
                {{ HTML::ul($errors->all() )}} {{ Form::model($fam, array('action' => array('AdministradorController@updateFamily', $fam->id), 'method' => 'PUT')) }}
                <div class="row">
                    <div class="col-md-12">
                        {{-- codigofamilia ------------------------}}{{ Form::label('codigofamilia', 'Codigo Familia', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                            <input name="codigofamilia" id="txt_codigofamilia" class="form-control" maxlength="50" type="text" value="{{$fam->Codigo_Familia}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {{-- Apellido1 ------------------------}}{{ Form::label('apellido1', 'Primer Apellido', array('class' => 'control-label')) }}
                        <div class="form-group input-group" style="  padding-right: 15px;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                            <input name="apellido1" id="txt_apellido1" class="form-control" maxlength="64" type="text" value="{{$fam->Apellido1}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('apellido1') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- Apellido2 ------------------------}} {{ Form::label('apellido2', 'Segundo Apellido', array('class' => 'control-label')) }}
                        <div class="form-group input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                            <input name="apellido2" id="txt_apellido2" class="form-control" maxlength="64" type="text" value="{{$fam->Apellido2}}">
                        </div>
                        <p class="text-danger">
                            {{ $errors->newFamily->first('apellido2') }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                        <button class="btn btn-success btn-block" id="bt_registrarsar_usuario">Guardar</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <a href="{{ route('AdminFamilias') }}" class="btn btn-primary btn-block">Cancelar</a>
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