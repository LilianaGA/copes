@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/profesor/asistencia.css');}} 
{{HTML::style('css/Contabilidad/reportes.css');}}
{{HTML::style('css/padre/prematricula.css');}}@stop @section('cuerpo') @parent
@if(Auth::check())
    <div class="container">
        <h1 style="text-align:center">Control de Asistencia</h1>
        <hr class="colorgraph">
        <div class="row">
            <div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-user"></i> Desglose de Secciones</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Seleccione una Sección: </label>
                        </div>
                        <div class="col-md-6">
                            <select id="select-family" data-placeholder="Seleccione una Sección" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                                <option value="0"></option>
                                @if(isset($secciones))
                                @if(count($secciones)>0) 
                                    @foreach($secciones as $sec)
                                        <option value="{{$sec->Seccion}}">{{$sec->Seccion}}</option>  
                                   @endforeach
                                @endif
                            @endif
                            </select> 
                        </div>
                        <div class="col-md-3">
                            <button onclick="getClassRoom()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
                            <button onclick="clearTable()" class="btn btn-primary navbar-btn"> <span class="glyphicon glyphicon-refresh"></span>&nbsp; Limpiar</button>
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
                    <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                        <table class="table table-striped table-condensed panel panel-default">
                              <thead>
                              <tr>
                                  <th>Ausente</th> 
                                  <th class="success">Presente</th>                                     
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
                        <button onclick="send()" class="btn btn-success navbar-btn">Envíar Ausencias</button>        
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

<!--{{HTML::script('js/authentication/login2.js');}}-->
{{HTML::script('js/profesor/asistencia.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop