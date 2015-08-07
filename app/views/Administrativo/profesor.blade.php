@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/administrativo/usuario.css');}}
{{HTML::style('css/contabilidad/reportes.css');}}
 @stop @section('cuerpo')
@parent

    @if(Auth::check())
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Materia y Sección</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <label for="Cedula" class="control-label">Materia</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
                    <input name="Materia" id="txt_Materia" class="form-control" type="text" required>
                </div>
            </div>
            <div class="row">
                <label for="Cedula" class="control-label">Sección</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-bookmark"></span></span>
                    <input name="Seccion" id="txt_Seccion" class="form-control"  type="text" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="ui-group-buttons">
                <a class="btn btn-success" id="btnMateria" role="button"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- Modal Update -->
<div class="modal fade" id="myModalUpdate" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Materia y Sección</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <label for="Materia" class="control-label">Materia</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
                    <input name="Materia" id="txt_Materia_Update" class="form-control" type="text">
                </div>
            </div>
            <div class="row">
                <label for="Seccion" class="control-label">Sección</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-bookmark"></span></span>
                    <input name="Seccion" id="txt_Seccion_Update" class="form-control"  type="text">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-6">
                    <input name="id" id="txt_id" class="form-control" type="text" readonly style="visibility:hidden;">
                </div>
                <div class="col-md-6">
                    <div class="ui-group-buttons">
                        <a class="btn btn-success" id="btnMateriaUpdate" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                        <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
<div class="container">
    <h1 style="text-align:center">Control de Profesores</h1>
    <hr class="colorgraph">
    <div class="row">
            <div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-user"></i> Detalle por Profesor</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Seleccione un (a) Docente: </label>
                        </div>
                        <div class="col-md-6">
                            <select id="select-profesor" data-placeholder="Seleccione un (a) Docente:" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                <option value="0"></option>
                                @if(isset($Profesor))
                                @if(count($Profesor)>0) 
                                    @foreach($Profesor as $fam)
                                        <option value="{{$fam->Cedula}}">{{$fam->Nombre}} {{$fam->Apellido1}} {{$fam->Apellido2}}</option>  
                                   @endforeach
                                @endif
                            @endif
                            </select> 
                        </div>
                        <div class="col-md-4">
                            <button onclick="getSubjects()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
                            <button id="nuevo" class="btn btn-info navbar-btn" data-toggle="modal" data-target="#myModal" disabled> <span class="glyphicon glyphicon-plus"></span>&nbsp; Nueva Materia y Sección</button>
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
                                        <th style="padding:5px;"><input type="text" class="form-control" placeholder="Materias" disabled></th>
                                        <th style="padding:5px;"><input type="text" class="form-control" placeholder="Secciones" disabled></th>
                                        <th style="padding:5px;">Opciones</th>
                                    </tr>
                                </thead>
                            </thead>
                        </thead>
                        <tbody id="Content">
                            <tr class="no-result text-center"><td colspan="3">Debe seleccionar primero un(a) docente</td></tr>
                        </tbody>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/admin/profesor.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop