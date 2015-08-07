@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/administrativo/newCita.css');}} 
@stop @section('cuerpo')
@parent
<div class="row" style="margin-top:4%">
    <div class="col-xs-12 col-sm-8 col-md-10 col-md-offset-1">
        <a href="{{ route('AdminCitas') }}" class="btn btn-primary navbar-btn"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp; Atrás </a>
        <div class="panel panel-default" style="margin-top:1%">
            <div class="panel-heading text-center">
                <h1>Registro de Citas</h1>
            </div>
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

                    <div class="col-md-4 form-group"  style="  padding-right: 15px;">
                        <label>Materia</label>
                        <select id="select-subject" class="form-control multiselect multiselect-icon" data-style="btn-primary" >
                        <option value="0">Seleccione la materia...</option>
                        </select>
                    </div>
                    <div class="col-md-8" >
                        <label>Nombre del Profesor</label>
                        <input type="text" class="form-control" id="spanProfesor" style="background:white;" readonly>
                    </div>
                </div>

                <div class="offer offer-radius  offer-success">
                    <div class="shape">
                        <div class="shape-text">
                            1                   
                        </div>
                    </div>
                    <div class="offer-content">
                        <table class="table">
                            <thead>
                                <tr class="active">
                                    <th>
                                        Nombre del Estudiante
                                    </th>
                                    <th>
                                        Sección
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Seleccionar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        José Andrés
                                    </td>
                                    <td>
                                        10-5
                                    </td>
                                    <td>
                                        26-05-2015
                                    </td>
                                    <td>
                                        @if(0==0)
                                            <a href="/" class="btn btn-sky text-uppercase"><span class="glyphicon glyphicon-pushpin"></span>&nbsp; Reservar Cita</a>
                                        @else
                                        
                                            <span class="glyphicon glyphicon-lock"><strong>&nbsp; Reservada</strong></span>
                                        
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
{{HTML::script('js/docsupport/chosen.jquery.js');}}

{{HTML::script('js/admin/citas/newCitas.js');}}
<script type="text/javascript">
    var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop
