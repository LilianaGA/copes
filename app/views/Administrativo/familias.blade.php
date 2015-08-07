@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/usuario.css');}} @stop @section('cuerpo')
@parent

@if(Auth::check())
<div class="container">
    <h1 style="text-align:center">Control de Familias</h1>
    <hr class="colorgraph">
    <div class="row">
        <div class="col-md-4" style="float:left;">
            <a href="{{ route('newFamily') }}" class="btn btn-info navbar-btn"> <span class="glyphicon glyphicon-plus"></span>&nbsp; Nueva Familia</a>
        </div>
        <div class="col-md-4">
            <label  style="float:right;">Filtrar por estado:</label>
        </div>
        <div class="col-md-4" style="float:right;">
            <select id="select-family" data-placeholder="Seleccione una Familia" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                <option value="0">Familias Activas</option>
                <option value="1">Familias Inactivas</option>
            </select>
        </div>
    </div> 
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Detalles de Familias</h3>
                <div class="pull-right">
                    <button class="btn btn-info btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtro</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Código de la Familia" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Primer Apellido" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Segundo Apellido" disabled></th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody  id="Content">
                    @if(isset($Familias))
                        @if(count($Familias)>0) 
                            @foreach($Familias as $usr)
                                <tr>
                                    <td>{{$usr->Codigo_Familia}}</td>
                                    <td>{{$usr->Apellido1}}</td>
                                    <td>{{$usr->Apellido2}}</td>
                                    <td>
                                        <div class="ui-group-buttons">
                                            <a href="{{'/Administrativo/'.$usr->Codigo_Familia.'/showFamily' }}" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            <div class="or"></div>
                                            <a href="{{'/Administrativo/'.$usr->id.'/editFamily' }}" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                            <div class="or"></div>
                                            <a href="{{'/Administrativo/'.$usr->id.'/deleteFamily' }}" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-unchecked"></span></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                </tbody>
                <tfoot>
                    <tr class="info" style="display: table-row;">
                        <td><strong>Código de la Familia</strong></td>
                        <td><strong>Primer Apellido</strong></td>
                        <td><strong>Segundo Apellido</strong></td>
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
{{HTML::script('js/admin/familia.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop