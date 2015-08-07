@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/padre/citas.css');}} {{HTML::style('css/profesor/index.css');}} @stop @section('cuerpo') @parent

<div id="message"></div>
<br>
<div class="container">
    <h1 style="text-align:center">Solicitud de Citas</h1>
    <hr class="colorgraph">
    <div class="row">    	
        <div class="col-md-8">
            <label for="validate-select"><strong>Listado de Hijos</strong></label>
            <select type="text" id="select-child" class="form-control multiselect multiselect-icon" role="multiselect">  
                <option value="0" data-icon="glyphicon-picture" selected="selected">Listado de Hijos</option> 
                @if(isset($Familia_Alumnos))
                    @if(count($Familia_Alumnos)>0) 
                        @foreach($Familia_Alumnos as $usr)
                            <option value="{{$usr->Cedula_Alumno}}" data-icon="glyphicon-picture">{{$usr->Nombre_Alumno}} {{$usr->Apellido1_Alumno}} {{$usr->Apellido2_Alumno}}</option> 
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
    <div id="Appointments">
    </div>
    <br>
</div>
{{HTML::script('js/authentication/login2.js');}}
{{HTML::script('js/padre/citas.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop