@extends('layouts.base') @section('cabecera') 
    @parent 
        {{HTML::style('css/Contabilidad/reportes.css');}}
        {{HTML::style('css/padre/prematricula.css');}}
        {{HTML::style('css/administrativo/usuario.css');}}
        {{HTML::style('css/profesor/asistencia.css');}} 
    @stop 
@section('cuerpo') 
@parent
@if(Auth::check())
    <div class="container">
        <h1 style="text-align:center">Control de Asignaciones</h1>
        <hr class="colorgraph">
        <div class="row">
            <div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="glyphicon glyphicon-bookmark"></i> Desglose de Secciones</h3>
                    <h3 class="heading pull-right"><i class="glyphicon glyphicon-book"></i> Desglose de Materias</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Seleccione una Sección: </label>
                        </div>
                        <div class="col-md-4">
                            @if(isset($secciones))
                                @if(count($secciones)>1) 
                                    <select id="select-seccion" data-placeholder="Seleccione una Sección" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                        <option value="0"></option>
                                        @foreach($secciones as $sec)
                                            <option value="{{$sec->Seccion}}">{{$sec->Seccion}}</option>  
                                        @endforeach
                                    </select>
                                @else
                                    <select id="select-seccion" data-placeholder="Seleccione una Sección" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                        <option value="{{$secciones[0]->Seccion}}" selected>{{$secciones[0]->Seccion}}</option>  
                                    </select> 
                                @endif
                            @endif 
                        </div>
                        <div class="col-md-2">
                            <label>Seleccione una Materia: </label>
                        </div>
                        <div class="col-md-4">
                            @if(isset($materias))
                                @if(count($materias)>1) 
                                    <select id="select-materia" data-placeholder="Seleccione una Sección" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                        <option value="0"></option>
                                            @foreach($materias as $sec)
                                                <option value="{{$sec->Materia}}">{{$sec->Materia}}</option>  
                                            @endforeach
                                    </select> 
                                @else
                                    <select id="select-materia" data-placeholder="Seleccione una Sección" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                        <option value="{{$materias[0]->Materia}}" selected>{{$materias[0]->Materia}}</option>  
                                    </select> 
                                @endif
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <button onclick="getInfo()" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
                                <button onclick="clearTable()" class="btn btn-primary navbar-btn"><span class="glyphicon glyphicon-refresh"></span>&nbsp; Limpiar</button>
                            </center>
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
                <div class="row" id="containsItems">
                    <div class="panel panel-success filterable">
                        <div class="panel-heading">
                            <h3 class="panel-title">Listado de Asignaciones</h3>
                            <span class="pull-right clickable panel-collapsed" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i></span>
                        </div>
                        <table class="table">
                            <thead>
                                <tr class="filters">
                                    <th>Tipo de Trabajo</th>
                                    <th>Detalle</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="Items">
                                <tr class="no-result text-center"><td colspan="6">Debe seleccionar primero la materia y la sección</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
            <div id="allContainerStudents" style="display:none;">
                <div class="panel panel-danger filterable">
                    <div class="panel-heading">
                        <h3 class="panel-title">Asignaciones Seleccionada</h3>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="filters">
                                <th>Tipo de Trabajo</th>
                                <th>Detalle</th>
                                <th>Fecha de Entrega</th>
                            </tr>
                        </thead>
                        <tbody id="selectItems">
                            <tr class="no-result text-center"><td colspan="3">Debe seleccionar primero la materia y la sección</td></tr>
                        </tbody>
                    </table>
                </div>
                <input name="id" id="txt_id_item" class="form-control" type="text" readonly style="visibility:hidden;">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                        <table class="table table-striped table-condensed panel panel-default">
                              <thead>
                              <tr>
                                  <th>No presentado</th> 
                                  <th class="success">Presentado</th>                                     
                              </tr>
                          </thead>   
                          <tbody>
                            <tr>
                                <td>Blanco</td>
                                <td class="success">Verde</td>
                            </tr>     
                          </tbody>
                        </table>   
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Alumnos</div>
                            <!-- List group -->
                            <ul class="list-group" id="list-group">
                                
                            </ul>
                        </div>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                        <center>
                        <button onclick="send()" class="btn btn-success navbar-btn">Almacenar Entrega</button>        
                        </center>
                    </div>
                </div>
            </div>
            <!-- / All Container -->
            <div id="proceso" class="col-md-6 col-md-offset-3" style="display:none;">
                <div class="modal-dialog modal-m">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 style="margin:0;">Procesando...</h3>
                        </div>
                        <div class="modal-body">
                            <p>Se están enviando los correos a los encargados, por favor espere.</p>
                            <div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container content" id="Message" style="display:none;">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="testimonials">
                            <div class="active item">
                              <blockquote><p>Estimado (a) {{Auth::user()->Nombre}} {{Auth::user()->Apellido1}} {{Auth::user()->Apellido2}} <p id="mensaje"></p></p></blockquote>
                              <div class="carousel-info">
                                <img alt="" src="http://copes.ed.cr/uploads/3/5/6/8/3568440/8700862_orig.gif" class="pull-left">
                                <div class="pull-left">
                                  <span class="testimonials-name">Administración</span>
                                  <span class="testimonials-post">Colegio Diocesano Padre Eladio Sancho</span>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                  <h4 class="modal-title">Asignar Trabajo</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="trabajo" class="control-label">Tipo de trabajo</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
                                    <select id="txt_trabajo" data-placeholder="Seleccione un tipo de trabajo" class="form-control multiselect multiselect-icon" role="multiselect">
                                        @if(isset($tipos))
                                            @if(count($tipos)>0) 
                                                @foreach($tipos as $tipo)
                                                    <option value="{{$tipo->id}}">{{$tipo->Tipo_Trabajo}}</option>  
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
                                <label for="fecha" class="control-label">Fecha de Entrega</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    <input name="fecha" id="txt_fecha" class="form-control" type="date" requried>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="descripcion" class="control-label">Descripción del Trabajo</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-alphabet"></span></span>
                                    <textarea name="descripcion" id="txt_descripcion" class="form-control" type="text" requried rows="4" style=" resize: none;"> </textarea>
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
                  <h4 class="modal-title">Editar la Asignación</h4>
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
                                <label for="trabajo" class="control-label">Tipo de trabajo</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
                                    @if(isset($tipos))
                                        @if(count($tipos)>0) 
                                            <select id="txt_trabajo_update" data-placeholder="Seleccione un tipo de trabajo" class="form-control multiselect multiselect-icon" role="multiselect">
                                                @foreach($tipos as $tipo)
                                                    <option value="{{$tipo->id}}">{{$tipo->Tipo_Trabajo}}</option>  
                                                @endforeach
                                            </select>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="fecha" class="control-label">Fecha de Entrega</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    <input name="fecha" id="txt_fecha_update" class="form-control" type="date" requried>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="descripcion" class="control-label">Descripción del Trabajo</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-alphabet"></span></span>
                                    <textarea name="descripcion" id="txt_descripcion_update" class="form-control" type="text" requried rows="4" style=" resize: none;"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="estado" class="control-label">Estado</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sort"></span></span>
                                    <input name="estado" id="txt_estado_update" class="form-control" type="text" requried readonly style="background-color:white;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <input name="id" id="txt_id_update" class="form-control" type="text" readonly style="visibility:hidden;">
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
                  <h4 class="modal-title">Eliminar la asignación</h4>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea eliminar la asignación?
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
                  <h4 class="modal-title">Agregar tipo de asignatura</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="asignatura" class="control-label">Nombre de la Asignatura</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-file"></span></span>
                                <input name="asignatura" id="txt_asignatura" class="form-control" type="text" requried>
                            </div>
                        </div>
                    </div>
                    <blockquote>Por favor no repetir el nombre de las asignaturas</blockquote>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ui-group-buttons">
                                <a class="btn btn-success" onclick="saveNewType()" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Confirmar</a>
                                <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/profesor/asignaciones.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop