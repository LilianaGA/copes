@extends('layouts.base') @section('cabecera') 
@parent 
    {{HTML::style('css/padre/citas.css');}} 
    {{HTML::style('css/profesor/index.css');}}
    {{HTML::style('css/padre/prematricula.css');}} 
@stop 
@section('cuerpo') @parent

<div id="message"></div>
<br>
<div class="container">
    <h1 style="text-align:center">Total de Asignaciones</h1>
    <hr class="colorgraph">
    <div class="row">    	
        <div class="col-md-8">
            <label for="validate-select"><strong>Listado de Hijos</strong></label>
            <select type="text" id="select-child" class="form-control multiselect multiselect-icon" role="multiselect">  
                <option value="0" data-icon="glyphicon-picture" selected="selected">Listado de Hijos</option> 
                @if(isset($Familia_Alumnos))
                    @if(count($Familia_Alumnos)>0) 
                        @foreach($Familia_Alumnos as $usr)
                            <option value="{{$usr->Cedula_Alumno}}" data-icon="glyphicon-picture" seccion= "{{$usr->Seccion_Alumno}}">{{$usr->Nombre_Alumno}} {{$usr->Apellido1_Alumno}} {{$usr->Apellido2_Alumno}}</option> 
                        @endforeach
                    @endif
                @endif        
            </select> 
        </div> 
        <div class="col-md-4">
            <label for="validate-select"><strong>Listado de Materias</strong></label>
            <select type="text" id="select-subject" class="form-control multiselect multiselect-icon" role="multiselect">          
              <option value="0" data-icon="glyphicon-picture" selected="selected">Materias</option>          
            </select> 
        </div>  
    </div>
    <hr class="colorgraph">
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
        <div class="row" >
            <div class="panel panel-success filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">Listado de Asignaciones</h3>
                </div>
                <table class="table">
                    <thead>
                        <tr class="filters">
                            <th>Tipo</th>
                            <th>Total</th>
                            <th>Entregados</th>
                            <th>Sin Presentar</th>
                            <th>Pendientes</th>
                        </tr>
                    </thead>
                    <tbody id="Items">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/authentication/login2.js');}}
{{HTML::script('js/padre/asignaciones.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop