@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/usuario.css');}}
{{HTML::style('css/contabilidad/reportes.css');}}
 @stop @section('cuerpo')
@parent

@if(Auth::check())
<div class="container">
    <h1 style="text-align:center">Control de Usuarios</h1>
    <hr class="colorgraph">
    <a href="{{ route('newUser') }}" class="btn btn-info navbar-btn"> <span class="glyphicon glyphicon-plus"></span>&nbsp; Nuevo Usuario</a>
    <br><br>
    <div class="row">
            <div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-user"></i> Detalle por Familia</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Seleccione una Familia: </label>
                        </div>
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-3">
                            <button onclick="getFamily()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
                            <button onclick="clearTable()" class="btn btn-primary navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Limpiar</button>
                        </div>
                    </div>
                    <div class="panel panel widget filterable">
                        <div class="panel-heading widget-head">
                            <h3 class="heading"></h3>
                            <div class="pull-right" style="margin-top:0px">
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <thead>
                                    <thead>
                                        <tr class="filters">
                                            <th style="padding:5px;"><input type="text" class="form-control" placeholder="Código de la Familia" disabled></th>
                                            <th style="padding:5px;"><input type="text" class="form-control" placeholder="Cédula" disabled></th>
                                            <th style="padding:5px;"><input type="text" class="form-control" placeholder="Nombre Completo" disabled></th>
                                            <th style="padding:5px;"><input type="text" class="form-control" placeholder="Correos" disabled></th>
                                            <th style="padding:5px;"><input type="text" class="form-control" placeholder="Teléfono" disabled></th>
                                            <th style="padding:5px;">Opciones</th>
                                        </tr>
                                    </thead>
                                </thead>
                            </thead>
                            <tbody id="Content">
                                <tr class="no-result text-center"><td colspan="7">Debe seleccionar primero la familia</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="info" style="display: table-row;">
                                    <td style="padding:5px;"><strong>Código de la Familia</strong></td>
                                    <td style="padding:5px;"><strong>Cédula</strong></td>
                                    <td style="padding:5px;"><strong>Nombre</strong></td>
                                    <td style="padding:5px;"><strong>Primer Apellido</strong></td>
                                    <td style="padding:5px;"><strong>Segundo Apellido</strong></td>
                                    <td style="padding:5px;"><strong>Opciones</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
{{HTML::script('js/admin/usuarios.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop