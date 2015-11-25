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
        <h1 style="text-align:center">Control de Rúbrica</h1>
        <hr class="colorgraph">
        <div class="row">
            <div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"></h3>
                    <h3 class="heading"></h3>
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
                                    <select id="select-materia" data-placeholder="Seleccione una Matería" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                        <option value="{{$materias[0]->Materia}}" selected>{{$materias[0]->Materia}}</option>  
                                    </select> 
                                @endif
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Seleccione un Período: </label>
                        </div>
                        <div class="col-md-4">
                            <select id="select-periodo" data-placeholder="Seleccione un Período" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                <option value="0"></option>
                                <?php if ((date('M') == 'Feb') || (date('M') == 'Mar') || (date('M') == 'Abr')  || (date('M') == 'May')): ?>
                                    <option value="I" selected>I</option>
                                <?php else: ?>
                                    <option value="I">I</option>
                                <?php endif ?>
                                <?php if ((date('M') == 'Jun') || (date('M') == 'Jul') || (date('M') == 'Ago')): ?>
                                    <option value="II" selected>II</option>
                                <?php else: ?>
                                    <option value="II">II</option>
                                <?php endif ?>
                                <?php if ((date('M') == 'Sep') || (date('M') == 'Oct') || (date('M') == 'Nov')): ?>
                                    <option value="III" selected>III</option>
                                <?php else: ?>
                                    <option value="III">III</option>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Seleccione un Año: </label>
                        </div>
                        <div class="col-md-4">
                            <select id="select-anio" data-placeholder="Seleccione un Año" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                @if(isset($anio))
                                    @if(count($anio)>1) 
                                        <select id="select-materia" data-placeholder="Seleccione una Sección" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                            <option value="0"></option>
                                                @foreach($anio as $year)
                                                    <option value="{{$year->Anio}}">{{$year->Anio}}</option>  
                                                @endforeach
                                        </select> 
                                    @else
                                        <option value="{{date('Y')}}" selected>{{date('Y')}}</option> 
                                    @endif
                                @endif                             
                            </select> 
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
                            <h3 class="panel-title">Listado de la rúbrica</h3>
                        </div>
                        <table class="table" id="table2excel">
                            <thead id="Encabezado">
                                <tr class="filters">
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="Items">
                                <tr class="no-result text-center"><td>Debe seleccionar primero la materia y la sección</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                        <center>
                        <button id="export" class="btn btn-success navbar-btn"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>        
                        </center>
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
@endif
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/admin/rubrica.js');}}
{{HTML::script('js/jquery.table2excel.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop