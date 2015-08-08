@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/usuario.css');}} @stop @section('cuerpo')
@parent

@if(Auth::check())
<div class="container">
    <h1 style="text-align:center">Control de Citas</h1>
    <hr class="colorgraph">
    <!--<a href="{{ route('newCitas') }}" class="btn btn-info navbar-btn"> <span class="glyphicon glyphicon-plus"></span>&nbsp; Nueva Cita </a>-->
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Detalles de Citas</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs" onclick="PrintElem('#ReporteFechas')"><i class="fa fa-print"></i> Imprimir</button>
                    <!--<button class="btn btn-info btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtro</button>-->
                </div>
            </div>
            <div id="ReporteFechas">
                <table class="table" style="margin-bottom: 0px;">
                    <thead>
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="Nombre del Profesor" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Nombre del Alumno" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Día" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Hora" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Fecha" disabled></th>
                            <!--<th>Opciones</th>-->
                        </tr>
                    </thead>
                    <tbody >
                        @if(isset($Citas))
                            @if(count($Citas)>0) 
                                @foreach($Citas as $cita)
                                    <tr>
                                        <td>{{$cita->Nombre}} {{$cita->Apellido1}} {{$cita->Apellido2}}</td>
                                        <td>{{$cita->Nombre_Alumno}} {{$cita->Apellido1_Alumno}} {{$cita->Apellido2_Alumno}}</td>
                                        <td>{{$cita->Dia}}</td>
                                        <td>{{$cita->Hora}}</td>
                                        <td>
                                            <?php
                                                $date=date_create($cita->Fecha_Cita);
                                                echo date_format($date,"d - M - y");
                                            ?>
                                        </td>
                                        <!--<td>
                                            <div class="ui-group-buttons">
                                                <a href="{{$cita->id}}" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                                <div class="or"></div>
                                                <a href="{{$cita->id}}" id="confirm" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>
                                            </div>
                                        </td>-->
                                    </tr>
                                @endforeach
                            @else
                                <tr class="no-result text-center"><td colspan="6">Resultados no encontrados</td></tr>
                            @endif
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="info" style="display: table-row;">
                            <td><strong>Nombre del Profesor</strong></td>
                            <td><strong>Nombre del Alumno</strong></td>
                            <td><strong>Día</strong></td>
                            <td><strong>Hora</strong></td>
                            <td><strong>Fecha</strong></td>
                           <!--<td><strong>Opciones</strong></td>-->
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>
                    Permiso Denegado</h2>
                <div class="error-details">
                    Lo sentimos no tienes permiso para visualizar esta página
                </div>
                <div class="error-actions">
                    <a href="/" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-home"></span>&nbsp;
                        Volver a Home </a><a href="/login" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-user"></span>&nbsp; Iniciar Sección</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{HTML::script('js/authentication/login2.js');}}
{{HTML::script('js/admin/citas.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop