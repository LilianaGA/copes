@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/administrativo/prematricula.css');}} 
{{HTML::style('css/administrativo/reportes.css');}} 
{{HTML::style('css/Contabilidad/reportes.css');}}
{{HTML::style('css/padre/prematricula.css');}}
{{HTML::style('css/administrativo/usuario.css');}}

@stop @section('cuerpo') @parent

	
@if(Auth::check())
<div class="container">
    <span href="#aboutModal" data-toggle="modal" data-target="#myModal" class='glyphicon glyphicon glyphicon-cog' style="float:right;"></span>
    <h1 style="text-align:center">Control de Prematrícula</h1>
    <hr class="colorgraph">
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="myModalLabel">Período de Prematrícula</h4>
                    </div>
                <div class="modal-body">
                    @if(isset($periodo))
                        @if(count($periodo)>0) 
                            @foreach($periodo as $rls)
                                <div class="offer offer-radius  offer-success">
                                    <div class="shape"></div>
                                    <div class="offer-content">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="msg msg-clear"> 
                                                            <span class='glyphicon glyphicon glyphicon-user'></span> Estado del período de prematrícula
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if ($rls->Estado == "T") {
                                                                echo '<a class="btn icon-btn btn-primary" style="float:right;" value="' . $rls->id . '" id="idCerrar"><span class="glyphicon btn-glyphicon glyphicon-remove img-circle text-primary"></span> Cerrar Período</a>';
                                                                echo '<a class="btn icon-btn btn-success" style="float:right; display:none;" value="' . $rls->id . '" id="idAbrir"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Abrir Período</a>';
                                                            }else{
                                                                echo '<a class="btn icon-btn btn-primary" style="float:right; display:none;" value="' . $rls->id . '" id="idCerrar"><span class="glyphicon btn-glyphicon glyphicon-remove img-circle text-primary"></span> Cerrar Período</a>';
                                                                echo '<a class="btn icon-btn btn-success" style="float:right;" value="' . $rls->id . '" id="idAbrir"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Abrir Período</a>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <center>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="row">
        <div class="panel widget">
            <div class="panel-heading widget-head">
                <h3 class="heading"><i class="fa fa-user"></i> Desglose de Familias</h3>
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
            <div class="panel panel-warning filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalles de Encargados</h3>
                </div>
                <table class="table">
                    <thead>
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="Cédula" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Nombre" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Primer Apellido" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Segundo Apellido" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Dirección" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Correos" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Teléfonos" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Opciones" disabled></th>
                        </tr>
                    </thead>
                    <tbody id="Encargados">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-success filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalles de Alumnos</h3>
                </div>
                <table class="table">
                    <thead><!-- -->
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="Cédula" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Nombre" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Primer Apellido" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Segundo Apellido" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Fecha Nacimiento" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Nivel Actual" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Monto Mensual" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Opciones" disabled></th>
                        </tr>
                    </thead>
                    <tbody id="Viejos">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-danger filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalle de Nuevo Ingreso de Alumnos</h3>
                </div>
                <table class="table">
                    <thead><!-- -->
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="Cédula" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Nombre" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Primer Apellido" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Segundo Apellido" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Fecha de Nacimiento" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Nivel de Ingreso" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Opciones" disabled></th>
                        </tr>
                    </thead>
                    <tbody id="Nuevos">
                        
                    </tbody>
                </table>
            </div>
        </div>        
        <center>
            <a class="btn btn-success" role="button" data-toggle="modal" data-target="#myModalCondiciones"><span class="glyphicon glyphicon-check"></span>&nbsp; Finalizar prematrícular</a>
        </center>
    </div>
    <!-- Modal Condiciones -->
    <div class="modal fade" id="myModalCondiciones" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Condiciones para finalizar con la prematrícula</h4>
            </div>
            <div class="modal-body">
                <center><strong>Importante</strong></center><br>
                Antes de hacer efectiva la prematrícula es importante que por este período se terminará la suscripción de la familia. No se podrá mostrar ni editar.
            </div> 
            <div class="modal-footer">
                <div class="row">
                    <div class="ui-group-buttons">
                        <a class="btn btn-success" id="btnAcepta" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Continuar</a>
                        <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    <!-- Modal Student Update -->
            <div class="modal fade" id="myModalUpdate" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Editar Datos del Alumno</h4>
                    </div>
                     <div id="fountainGS">
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Materia" class="control-label">Cedula</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input name="Materia" id="txt_Cedula_Update" class="form-control" type="text" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Nombre</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                                    <input name="Seccion" id="txt_Nombre_Update" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Materia" class="control-label">Primer Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                    <input name="Materia" id="txt_Apellido1_Update" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Segundo Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                                    <input name="Seccion" id="txt_Apellido2_Update" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Cedula" class="control-label">Fecha de Nacimiento</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    <input name="nacimiento" id="txt_Nacimiento_Update" class="form-control" type="date" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Monto Mensualidad</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                                    <input name="Seccion" id="txt_Monto_Update" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Nivel</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-signal"></span></span>
                                    <input name="Seccion" id="txt_Nivel_Update" class="form-control"  type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Sección</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                                    <input name="Seccion" id="txt_Seccion_Update" class="form-control"  type="text">
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
                                    <a class="btn btn-success" id="btnStudentUpdate" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                                    <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <!-- Modal Manager Update -->
            <div class="modal fade" id="myModalUpdateManager" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Editar Datos del Encargado</h4>
                    </div>
                    <div id="fountainGM">
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Materia" class="control-label">Cedula</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input name="Materia" id="txt_Cedula_Update_Padre" class="form-control" type="text" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Nombre</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                                    <input name="Seccion" id="txt_Nombre_Update_Padre" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Materia" class="control-label">Primer Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                    <input name="Materia" id="txt_Apellido1_Update_Padre" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Segundo Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                                    <input name="Seccion" id="txt_Apellido2_Update_Padre" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Seccion" class="control-label">Dirección</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                                    <input name="Seccion" id="txt_Direccion_Update_Padre" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="Correos">
                                <label for="Correos" class="control-label">Correos</label>
                            </div>
                            <div class="col-md-6" id="Telefonos">
                                <label for="Telefonos" class="control-label">Teléfonos</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input name="id" id="txt_id_padre" class="form-control" type="text" readonly style="visibility:hidden;">
                            </div>
                            <div class="col-md-6">
                                <div class="ui-group-buttons">
                                    <a class="btn btn-success" id="btnManagerUpdate" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                                    <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <!--Modal New Student Update-->
            <div class="modal fade" id="myModalUpdateNewStudent" role="dialog">
                <div class="modal-dialog">
                   Modal content
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Editar Datos de Nuevo Alumno</h4>
                    </div>
                     <div id="fountainGNS">
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Materia" class="control-label">Cedula</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input name="Materia" id="txt_Cedula_Update_Student" class="form-control" type="text" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Nombre</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                                    <input name="Seccion" id="txt_Nombre_Update_Student" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Materia" class="control-label">Primer Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                    <input name="Materia" id="txt_Apellido1_Update_Student" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Segundo Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                                    <input name="Seccion" id="txt_Apellido2_Update_Student" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Cedula" class="control-label">Fecha de Nacimiento</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input name="txt_Nivel_Update_Student" id="txt_Nacimiento_Update_Student" class="form-control" type="date" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Nivel</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-signal"></span></span>
                                    <input name="Seccion" id="txt_Nivel_Update_Student" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Sección</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                                    <input name="Seccion" id="txt_Seccion_Update_Student" class="form-control"  type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Seccion" class="control-label">Monto Mensualidad</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                                    <input name="Seccion" id="txt_Monto_Update_Student" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input name="id" id="txt_id_Student" class="form-control" type="text" readonly style="visibility:hidden;">
                            </div>
                            <div class="col-md-6">
                                <div class="ui-group-buttons">
                                    <a class="btn btn-success" id="btnNewStudentUpdate" role="button" data-dismiss="modal"  ><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                                    <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
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
{{HTML::script('js/admin/prematricula.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop	