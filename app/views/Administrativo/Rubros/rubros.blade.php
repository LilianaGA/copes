@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/administrativo/prematricula.css');}} 
{{HTML::style('css/administrativo/reportes.css');}} 
{{HTML::style('css/Contabilidad/reportes.css');}}
{{HTML::style('css/padre/prematricula.css');}}
{{HTML::style('css/administrativo/usuario.css');}}
{{HTML::style('css/administrativo/rubros.css');}}

@stop @section('cuerpo') @parent

	
<div class="container">
    @if(Auth::check())
        <h1 style="text-align:center">Control de Rubros</h1>
        <hr class="colorgraph">
        <div class="row">
            <div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="glyphicon glyphicon-signal"></i> Desglose de Niveles</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Seleccione un Nivel: </label>
                        </div>
                        <div class="col-md-6">
                            <select id="select-level" data-placeholder="Seleccione un Nivel" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                <option value="0"></option>
                                <option value="I">Interactivo</option>  
                                <option value="T">Transición</option>  
                                <option value="1">Primero</option>  
                                <option value="2">Segundo</option>  
                                <option value="3">Tercero</option>  
                                <option value="4">Cuarto</option>  
                                <option value="5">Quinto</option>  
                                <option value="6">Sexto</option>  
                                <option value="7">Séptimo</option>  
                                <option value="8">Octavo</option>  
                                <option value="9">Noveno</option>  
                                <option value="10">Décimo</option>  
                                <option value="11">Undécimo</option> 
                            </select> 
                        </div>
                        <div class="col-md-3">
                            <button onclick="getMaterias()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
                            <button onclick="clearTable()" class="btn btn-primary navbar-btn"> <span class="glyphicon glyphicon-refresh"></span>&nbsp; Limpiar</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div id="fountainG" style="display:none;">
            <div id="fountainG_1" class="fountainG"></div>
            <div id="fountainG_2" class="fountainG"></div>
            <div id="fountainG_3" class="fountainG"></div>
            <div id="fountainG_4" class="fountainG"></div>
            <div id="fountainG_5" class="fountainG"></div>
            <div id="fountainG_6" class="fountainG"></div>
            <div id="fountainG_7" class="fountainG"></div>
            <div id="fountainG_8" class="fountainG"></div>
        </div>
        <div id="allContainer" style="display:none;">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel widget">
                        <div class="panel-heading widget-head">
                            <h3 class="heading"><i class="glyphicon glyphicon-bookmark"></i> Desglose de Secciones</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table" id="Secciones">
                            
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel widget">
                        <div class="panel-heading widget-head">
                            <h3 class="heading"><i class="glyphicon glyphicon-book"></i> Desglose de Materias</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Seleccione una Materia: </label>
                                </div>
                                <div class="col-md-6">
                                    <select type="text" id="select-subject" class="form-control multiselect multiselect-icon" role="multiselect">          
                                        <option value="0" data-icon="glyphicon-picture" selected="selected">Materias</option>          
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button onclick="getRubros()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="fountainGM" style="display:none;">
                <div id="fountainG_1" class="fountainG"></div>
                <div id="fountainG_2" class="fountainG"></div>
                <div id="fountainG_3" class="fountainG"></div>
                <div id="fountainG_4" class="fountainG"></div>
                <div id="fountainG_5" class="fountainG"></div>
                <div id="fountainG_6" class="fountainG"></div>
                <div id="fountainG_7" class="fountainG"></div>
                <div id="fountainG_8" class="fountainG"></div>
            </div>
            <div class="row" id="containsItems" style="display:none;">
                <div class="panel panel-success filterable">
                    <div class="panel-heading">
                        <h3 class="panel-title">Listado de Rubros</h3>
                        <span class="pull-right clickable panel-collapsed" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i></span>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="filters">
                                <th>Descripción</th>
                                <th>Porcentaje</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="Items">
                            <tr class="no-result text-center"><td colspan="3">Debe seleccionar primero la materia</td></tr>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                  <h4 class="modal-title">Agregar Rubro</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="trabajo" class="control-label">Descripción del Rubro</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                    <select id="txt_descripcion" data-placeholder="Seleccione un tipo de trabajo" class="form-control multiselect multiselect-icon" role="multiselect">.
                                        @if(isset($Rubros))
                                            @if(count($Rubros)>0)                                             
                                                @foreach($Rubros as $rubro)
                                                    <option value="{{$rubro->id}}">{{$rubro->Detalle_Rubro}}</option>  
                                                @endforeach                                            
                                            @endif
                                        @endif
                                    </select>
                                    <span class="input-group-addon" data-toggle="modal" data-target="#trabajosModal"><i class="glyphicon glyphicon-plus"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="porcentaje" class="control-label">Porcentaje</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
                                    <input name="porcentaje" id="porcentaje" class="form-control" type="number" value="" placeholder="10" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                     <div class="ui-group-buttons">
                        <button class="btn btn-success" onclick="saveItem()"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</button>
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
                  <h4 class="modal-title">Editar Rubro</h4>
                </div>
                <div id="fountainGU" style="display:none;">
                    <div id="fountainG_1" class="fountainG"></div>
                    <div id="fountainG_2" class="fountainG"></div>
                    <div id="fountainG_3" class="fountainG"></div>
                    <div id="fountainG_4" class="fountainG"></div>
                    <div id="fountainG_5" class="fountainG"></div>
                    <div id="fountainG_6" class="fountainG"></div>
                    <div id="fountainG_7" class="fountainG"></div>
                    <div id="fountainG_8" class="fountainG"></div>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="trabajo" class="control-label">Descripción del Rubro</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                    <select id="txt_descripcion_update" data-placeholder="Seleccione un tipo de trabajo" class="form-control multiselect multiselect-icon" role="multiselect">.
                                        @if(isset($Rubros))
                                            @if(count($Rubros)>0)                                             
                                                @foreach($Rubros as $rubro)
                                                    <option value="{{$rubro->id}}">{{$rubro->Detalle_Rubro}}</option>  
                                                @endforeach                                            
                                            @endif
                                        @endif
                                    </select>
                                    <span class="input-group-addon" data-toggle="modal" data-target="#trabajosModal"><i class="glyphicon glyphicon-plus"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="porcentaje" class="control-label">Porcentaje</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
                                    <input name="porcentaje" id="txt_porcentaje_update" class="form-control" type="number" value="" placeholder="10" required>
                                </div>
                            </div>
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
                                <a class="btn btn-success" onclick="updateItem()" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                                <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
        <!-- Modal Eliminar -->
        <div class="modal fade" id="myModalDelete" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Eliminar Rubro</h4>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea eliminar el rubro?
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <input name="id" id="txt_id_delete" class="form-control" type="text" readonly style="visibility:hidden;">
                        </div>
                        <div class="col-md-6">
                            <div class="ui-group-buttons">
                                <a class="btn btn-success" onclick="confirmDeleteItem()" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Confirmar</a>
                                <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
        <!-- Modal Trabajos -->
        <div class="modal fade" id="trabajosModal" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Agregar Rúbrica</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="rubrica" class="control-label">Nombre del rubro</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-file"></span></span>
                                <input name="rubrica" id="txt_rubrica" class="form-control" type="text" requried>
                            </div>
                        </div>
                    </div>
                    <blockquote>Por favor no repetir el nombre de las rúbricas</blockquote>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ui-group-buttons">
                                <a class="btn btn-success" onclick="saveNew()" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                                <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                            </div>
                        </div>
                    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/admin/rubros.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop	
