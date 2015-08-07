@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/contabilidad/reportes.css');}} {{HTML::style('css/administrativo/usuario.css');}}@stop @section('cuerpo')
@parent

@if(Auth::check())<!-- data-toggle="modal" data-target="#myModal"-->
    <div class="container">
        <h1 style="text-align:center">Detalles de la Familia</h1>
        <hr class="colorgraph">
        <div class="row">
            <div class="panel panel-info filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">Familia</h3>
                </div>
                <table class="table">
                    <thead>
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="Codigo Familia" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Primer Apellido" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Segundo Apellido" disabled></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($Familia))
                            @if(count($Familia)>0) 
                                @foreach($Familia as $fml)
                                    <tr><?php $codigofamilia = $fml->Codigo_Familia ?>
                                        <td>{{$fml->Codigo_Familia}}</td>
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
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($Encargados))
                            @if(count($Encargados)>0) 
                                @foreach($Encargados as $usr)
                                    <tr>
                                        <td>{{$usr->Cedula}}</td>
                                        <td>{{$usr->Nombre}}</td>
                                        <td>{{$usr->Apellido1}}</td>
                                        <td>{{$usr->Apellido2}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Agregar Hijos (as)</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        {{ Form::open(array('url' => '/storeStudent', 'role'=>'form')) }}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="codigofamilia" class="control-label">Codigo Familia</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                                    <input name="codigofamilia" class="form-control" style="background-color:white;" type="text" readonly value="{{$codigofamilia}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Cedula" class="control-label">Cédula</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input name="cedula" class="form-control" type="text" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nombre" class="control-label">Nombre</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
                                    <input name="nombre" class="form-control" type="text" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="apellido1" class="control-label">Primer Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
                                    <input name="apellido1" class="form-control" type="text"value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <label for="apellido2" class="control-label">Segundo Apellido</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-bold"></span></span>
                                    <input name="apellido2" class="form-control" type="text" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="seccion" class="control-label">Sección</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                                    <input name="seccion" class="form-control" type="text"value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="nivel" class="control-label">Nivel</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-signal"></span></span>
                                    <input name="nivel" class="form-control" type="text" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="mensual" class="control-label">Monto Mensual</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                                    <input name="mensual" class="form-control" type="text" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-success btn-block" id="">Guardar</button>
                  {{ Form::close() }}
                </div>
              </div>
            </div>
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
                            <th><input type="text" class="form-control" placeholder="Sección" disabled></th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($Hijos))
                            @if(count($Hijos)>0) 
                                @foreach($Hijos as $usr)
                                    <tr>
                                        <td>{{$usr->Cedula_Alumno}}</td>
                                        <td>{{$usr->Nombre_Alumno}}</td>
                                        <td>{{$usr->Apellido1_Alumno}}</td>
                                        <td>{{$usr->Apellido2_Alumno}}</td>
                                        <td>{{$usr->Seccion_Alumno}}</td>
                                        <td>
                                            <div class="ui-group-buttons">
                                                <a href="{{'/Administrativo/'.$usr->id.'/editStudent' }}" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                                <div class="or"></div>
                                                <a href="{{'/Administrativo/'.$usr->id.'/deleteStudent' }}" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/authentication/signin.js');}}
<script type="text/javascript">
    var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop