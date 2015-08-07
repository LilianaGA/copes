@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/contabilidad/pagos.css');}}

@stop @section('cuerpo') @parent

	
@if(Auth::check())
<div class="container">
    <h1 style="text-align:center">Control de Pagos</h1>
    <hr class="colorgraph">
    <a href="{{ route('newPago') }}" class="btn btn-info navbar-btn"> <span class="glyphicon glyphicon-plus"></span>&nbsp; Nuevo Pago</a>
    <br><br>
    <div class="panel-body" style="padding: 0px;">
        <div class="panel panel widget filterable">
                <div class="panel-heading widget-head">
                    <h3 class="heading">Filtro</h3>
                </div>
                <div id="ReportePagoMensual">
                    <table class="table">
                        <thead>
                            <tr class="filters">
                                <th>Por Mes</th>
                                <th>Por Familia</th>
                                <th>Por Estudiante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
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
                                </td>
                                <td>
                                    <select id="select-family" data-placeholder="Seleccione una Familia" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                        <option value="0"></option>
                                        @if(isset($Familia))
                                            @if(count($Familia)>0) 
                                                @foreach($Familia as $fam)
                                                    <option value="{{$fam->Codigo_Familia}}">Familia: {{$fam->Apellido1}} {{$fam->Apellido2}}</option>  
                                               @endforeach
                                            @endif
                                        @endif
                                    </select> 
                                </td>
                                <td>
                                    <select id="select-student" data-placeholder="Seleccione un Estudiante" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                        <option value="0"></option>
                                        @if(isset($Estudiante))
                                            @if(count($Estudiante)>0) 
                                                @foreach($Estudiante as $est)
                                                    <option value="{{$est->Cedula_Alumno}}">{{$est->Nombre_Alumno}} {{$est->Apellido1_Alumno}} {{$est->Apellido2_Alumno}}</option>  
                                               @endforeach
                                            @endif
                                        @endif
                                    </select> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Detalles de Pagos</h3>
                <div class="pull-right">
                    <button class="btn btn-info btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtro</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Alumno" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Sección" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Núm. de Recibo" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Fecha de Pago" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Mes" disabled></th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="Content">
                    @if(isset($Pagos))
                        @if(count($Pagos)>0) 
                            @foreach($Pagos as $pgs)
                                <tr>
                                    <td>{{$pgs->Nombre_Alumno}} {{$pgs->Apellido1_Alumno}}</td>
                                    <td>{{$pgs->Seccion_Alumno}}</td>
                                    <td>{{$pgs->Numero_Recibo_Banco}}</td>
                                    <td>{{date("d-m-Y", strtotime($pgs->Fecha_Pago))}}</td>
                                    <?php
                                        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                                        echo '<td>' . $meses[$pgs->Mensualidad  - 1] . ' </td>';
                                    ?>
                                    <td>
                                        <div class="ui-group-buttons">
                                            <a href="{{'/contabilidad/'.$pgs->id }}" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            <div class="or"></div>
                                            <a href="{{'/contabilidad/'.$pgs->id.'/editar' }}" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                            <div class="or"></div>
                                            <a onclick="confirmar('{{$pgs->id}}')" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="no-result text-center"><td colspan="6">Resultados no encontrados</td></tr>
                        @endif
                    @endif
                </tbody>
                <tfoot>
                    <tr class="info" style="display: table-row;">
                        <td><strong>Alumno</strong></td>
                        <td><strong>Sección</strong></td>
                        <td><strong>Núm. de Recibo</strong></td>
                        <td><strong>Fecha de Pago</strong></td>
                        <td><strong>Mes</strong></td>
                        <td><strong>Opciones</strong></td>
                    </tr>
                </tfoot>
            </table>
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
{{HTML::script('js/contabilidad/pagos.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop