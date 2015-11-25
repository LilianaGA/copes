
@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/contabilidad/reportes.css');}} 
{{HTML::style('css/administrativo/usuario.css');}}
{{HTML::style('css/padre/prematricula.css');}}
@stop @section('cuerpo')
@parent

@if(Auth::check())
    <div class="container">
        <h1 style="text-align:center">Prematrícula</h1> 
        <hr class="colorgraph">
        @if(isset($Periodo) && isset($Prematricula))
            @if(($Periodo[0]->Estado == 'T') && (count($Prematricula)==0))
                <div class="notice notice-danger">
                    <strong>Instrucciones: </strong> 
                    <strong>Es importante para su familia actualizar los datos de los encargados, para evitar posibles acontecimientos.</strong>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="glyphicon glyphicon-chevron-right"></span> "Familia" contiene la información de la familia.
                        </div>
                        <div class="col-md-6">
                            <span class="glyphicon glyphicon-chevron-right"></span> "Detalles de Encargados" contiene la información de los encargados.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="glyphicon glyphicon-chevron-right"></span> "Detalles de Alumnos" contiene los detalles de los alumnos actuales en la institución.
                        </div>
                        <div class="col-md-6">
                            <span class="glyphicon glyphicon-chevron-right"></span> "Detalle de Nuevo Ingreso de Alumnos" contiene el detalle de alumnos de nuevo ingreso.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-info filterable">
                        <div class="panel-heading">
                            <h3 class="panel-title">Familia</h3>
                        </div>
                        <table class="table">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="Primer Apellido" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Segundo Apellido" disabled></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($Familia))
                                    @if(count($Familia)>0) 
                                        @foreach($Familia as $fml)
                                            <tr><?php $codigofamilia = $fml->Codigo_Familia ?>
                                                <td>{{$fml->Apellido1}}</td>
                                                <td>{{$fml->Apellido2}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-warning filterable" style=" margin-bottom: 0px;">
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
                            <tbody>
                                @if(isset($Encargados))
                                    @if(count($Encargados)>0) 
                                        @foreach($Encargados as $usr)
                                            <tr id="Manager{{$usr->id}}">
                                                <td>{{$usr->Cedula}}</td>
                                                <td>{{$usr->Nombre}}</td>
                                                <td>{{$usr->Apellido1}}</td>
                                                <td>{{$usr->Apellido2}}</td>
                                                <td>{{$usr->Direccion}}</td>
                                                <td style="padding:5px;"><table id="Correo{{$usr->Cedula}}"></table></td>
                                                <td style="padding:5px;"><table id="Telefono{{$usr->Cedula}}"></table></td>
                                                <td>
                                                	<a onclick="getManager({{$usr->id}})" data-toggle="modal" data-target="#myModalUpdateManager" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <p style="float:right;">*Para ingresar un encargado por favor comunicarse con la administración del Colegio.</p>
                </div>
                <div class="row">
                    <div class="panel panel-success filterable">
                        <div class="panel-heading">
                            <h3 class="panel-title">Detalles de Alumnos</h3>
                            <span class="pull-right clickable panel-collapsed" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i></span>
                        </div>
                        <table class="table">
                            <thead><!-- -->
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="Cédula" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Nombre" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Primer Apellido" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Segundo Apellido" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Nacimiento" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Nivel Actual" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Opciones" disabled></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($Hijos))
                                    @if(count($Hijos)>0) 
                                        @foreach($Hijos as $usr)
                                            <tr id="Hijos{{$usr->id}}">
                                                <td>{{$usr->Cedula_Alumno}}</td>
                                                <td>{{$usr->Nombre_Alumno}}</td>
                                                <td>{{$usr->Apellido1_Alumno}}</td>
                                                <td>{{$usr->Apellido2_Alumno}}</td>
                                                <td>{{$usr->Fecha_Nacimiento}}</td>
                                                <td>{{$usr->Nivel_Alumno}}</td>
                                                <td>
                                                	<a onclick="getStudent({{$usr->id}})" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-danger filterable">
                        <div class="panel-heading">
                            <h3 class="panel-title">Detalle de Nuevo Ingreso de Alumnos</h3>
                            <span class="pull-right clickable panel-collapsed" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i></span>
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
                            <tbody id="tbody">
                                @if(isset($Prematriculado))
                                    @if(count($Prematriculado)>0) 
                                        @foreach($Prematriculado as $usr)
                                            <tr id="Prematriculado{{$usr->id}}">
                                                <td>{{$usr->Cedula_Alumno}}</td>
                                                <td>{{$usr->Nombre_Alumno}}</td>
                                                <td>{{$usr->Apellido1_Alumno}}</td>
                                                <td>{{$usr->Apellido2_Alumno}}</td>
                                                <td>{{$usr->Fecha_Nacimiento}}</td>
                                                <td>{{$usr->Nivel_Alumno}}</td>
                                                <td>
                                                	<a onclick="getNewStudent({{$usr->id}})" data-toggle="modal" data-target="#myModalUpdateNewStudent" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                              </tbody>
                        </table>
                    </div>
                </div>
                <center>
                    <a class="btn btn-success" role="button" data-toggle="modal" data-target="#myModalCondiciones"><span class="glyphicon glyphicon-check"></span>&nbsp; Prematrícular</a>
                </center>
                <!-- Modal Student Update -->
            <div class="modal fade" id="myModalUpdate" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Editar Datos del Alumno</h4>
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
                                    <input name="Materia" id="txt_Cedula_Update" class="form-control" type="text" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Cedula" class="control-label">Fecha de Nacimiento</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    <input name="nacimiento" id="txt_Nacimiento_Update" class="form-control" type="date" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                            <div class="col-md-12">
                                <label for="Seccion" class="control-label">Nivel</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-signal"></span></span>
                                    <input name="Seccion" id="txt_Nivel_Update" class="form-control"  type="text" readonly>
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
            <!-- Modal Condiciones -->
            <div class="modal fade" id="myModalCondiciones" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Condiciones para continuar con la prematrícula</h4>
                    </div>
                    <div class="modal-body">
                        <center><strong>Importante</strong></center><br>
                        Antes de hacer efectiva la prematrícula es importante para usted y nosotros que actualize los datos de los encargados, esto por el motivo de una constante 
                        comunicación entre la institución con ustedes sobre posibles eventos.
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
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                      <h4 class="modal-title">Ingresar Nuevo Estudiante</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6" style="display:none;">
                                    <label for="codigofamilia" class="control-label">Codigo Familia</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                                        <input name="codigofamilia" id="codigofamilia" class="form-control" style="background-color:white;" type="text" readonly value="{{$codigofamilia}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="Cedula" class="control-label">Cédula</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input name="cedula" id="cedula" class="form-control" type="number" value="" placeholder="0123456789"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="Cedula" class="control-label">Fecha de Nacimiento</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                        <input name="nacimiento" id="nacimiento" class="form-control" type="date" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                                        <input name="nombre" id="nombre" class="form-control" type="text" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="apellido1" class="control-label">Primer Apellido</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                        <input name="apellido1" id="apellido1" class="form-control" type="text"value="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <label for="apellido2" class="control-label">Segundo Apellido</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                                        <input name="apellido2" id="apellido2" class="form-control" type="text" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nombre" class="control-label">Nivel</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-signal"></span></span>
                                        <input name="nivel" id="nivel" class="form-control" type="text" value="" placeholder="Primaria" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                         <div class="ui-group-buttons">
                            <a class="btn btn-success" id="btnGuardarNuevo" role="button" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span>&nbsp; Guardar</a>
                            <a class="btn btn-primary" id="btnCancela" role="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cancelar</a>
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
                    <div id="fountainG">
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
                <div class="container content">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="testimonials">
                                <div class="active item">
                                    <blockquote><p>Estimado (a) {{Auth::user()->Nombre}} {{Auth::user()->Apellido1}} {{Auth::user()->Apellido2}} si visualiza este mensaje es por alguno de estos motivos: <br>
                                    <span class="glyphicon glyphicon-chevron-right"></span> El período de prematrícula se encuentra cerrado <br>
                                    <span class="glyphicon glyphicon-chevron-right"></span> Ya se ha realizado una prematrícula de parte de su familia.</p></blockquote>
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
            @endif            
        @endif
    </div>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/authentication/signin.js');}}
{{HTML::script('js/padre/prematricula.js');}}
<script type="text/javascript">
    var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
        

@stop