@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/administrativo/usuario.css');}} 
{{HTML::style('css/administrativo/newCita.css');}} 
{{HTML::style('css/administrativo/horaAtencion.css');}} 
@stop @section('cuerpo')
@parent

@if(Auth::check())
<div class="container">
    <h1 style="text-align:center">Control de Horas de Atención</h1>
    <hr class="colorgraph">
    <div class="row" id="form-olvidado">
        <a id="olvidado2" class="btn btn-info navbar-btn" style=""> <span class="glyphicon glyphicon-plus"></span>&nbsp; Nueva Hora de Atención </a>
        <a id="olvidado" class="btn btn-warning navbar-btn" style=""> <span class="glyphicon glyphicon-pencil"></span>&nbsp; Editar Horas de Atención </a>
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Detalles de Horas de Atención</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs" onclick="PrintElem('#ReporteHorasAtencion')"><i class="fa fa-print"></i> Imprimir</button>
                </div>
            </div>
            <div id="ReporteHorasAtencion">
                <table class="table" style="margin-bottom: 0px;">
                    <thead>
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="Nombre del Profesor" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Día" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Hora" disabled></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($Horas))
                            @if(count($Horas)>0) 
                                @foreach($Horas as $hora)
                                    <tr>
                                        <td>{{$hora->Nombre}} {{$hora->Apellido1}} {{$hora->Apellido2}}</td>
                                        <td>{{$hora->Dia}}</td>
                                        <td>{{$hora->Hora}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="form-olvidado" class="hidden-form">
        <a id="acceso" class="btn btn-info navbar-btn"> <span class="glyphicon glyphicon-eye-open"></span>&nbsp; Mostrar Horas  de Atención </a>
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <label>Nombre del Profesor</label>
                    <select id="select-profesor" data-placeholder="Seleccione un Profesor" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                        <option value="0"></option>
                        @if(isset($Profesores))
                            @if(count($Profesores)>0) 
                                @foreach($Profesores as $hora)
                                    <option value="{{$hora->Cedula}}">{{$hora->Nombre}} {{$hora->Apellido1}} {{$hora->Apellido2}}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                </h3>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Materias</th>
                            </tr>
                        </thead>
                        <tbody id="ContentMateria">
                            <tr class="no-result text-center"><td>Debe seleccionar primero e profesor</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Secciones</th>
                            </tr>
                        </thead>
                        <tbody id="ContentSecciones">
                            <tr class="no-result text-center"><td>Debe seleccionar primero e profesor</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class"row">
                <div class="col-md-6">
                   <div class="panel panel-primary filterable">
                        <div class="panel-heading">
                            <h4 class="panel-title">Día de la Semana</h4>
                        </div>
                        <div id="Dias" class="funkyradio"style="padding: 10px 15px;">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio1"  value="Lunes"/>
                                <label for="radio1">Lunes</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio2"  value="Martes"/>
                                <label for="radio2">Martes</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio3"  value="Miércoles"/>
                                <label for="radio3">Miércoles</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio4"  value="Jueves"/>
                                <label for="radio4">Jueves</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio5"  value="Viernes"/>
                                <label for="radio5">Viernes</label>
                            </div>
                        </div>
                    </div>
                    <a id="guardar" onclick="updateHora()" class="btn btn-success navbar-btn" style="width: 100%;">&nbsp; Guardar </a>
                </div>
                <div class="col-md-6" style="padding-left: 10px;">
                   <div class="panel panel-primary filterable"  style="margin-bottom: 200px;">
                        <div class="panel-heading">
                            <h4 class="panel-title">Hora Atención</h4>
                        </div>
                        <div id="HorasAtencion" class="funkyradio" style="padding: 10px 15px;">
                            @if(isset($Leccion_Hora))
                                @if(count($Leccion_Hora)>0) 
                                    <?php $aux = 6 ?>
                                    @foreach($Leccion_Hora as $LH)
                                        <div class="funkyradio-success"><input type="radio" name="radio1" id="radio{{$aux}}" value="{{$aux-5}}"/><label for="radio{{$aux}}">{{$LH->Hora}}</label></div>
                                        <?php $aux++; ?>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="form-olvidado-2" class="hidden-form">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <label>Nombre del Profesor</label>
                    <select id="select-profesor-2" data-placeholder="Seleccione un Profesor" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
                        <option value="0"></option>
                        @if(isset($ProfesoresNuevos))
                            @if(count($ProfesoresNuevos)>0) 
                                @foreach($ProfesoresNuevos as $hora)
                                    <option value="{{$hora->Cedula}}">{{$hora->Nombre}} {{$hora->Apellido1}} {{$hora->Apellido2}}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                </h3>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Materias</th>
                            </tr>
                        </thead>
                        <tbody id="ContentMateria2">
                            <tr class="no-result text-center"><td>Debe seleccionar primero e profesor</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Secciones</th>
                            </tr>
                        </thead>
                        <tbody id="ContentSecciones2">
                            <tr class="no-result text-center"><td>Debe seleccionar primero e profesor</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class"row">
                <div class="col-md-6">
                   <div class="panel panel-primary filterable">
                        <div class="panel-heading">
                            <h4 class="panel-title">Día de la Semana</h4>
                        </div>
                        <div id="Dias" class="funkyradio"style="padding: 10px 15px;">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio21"  value="Lunes"/>
                                <label for="radio21">Lunes</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio22"  value="Martes"/>
                                <label for="radio22">Martes</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio23"  value="Miércoles"/>
                                <label for="radio23">Miércoles</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio24"  value="Jueves"/>
                                <label for="radio24">Jueves</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="radio25"  value="Viernes"/>
                                <label for="radio25">Viernes</label>
                            </div>
                        </div>
                    </div>
                    <a id="guardar" onclick="storeHora()" class="btn btn-success navbar-btn" style="width: 100%;">&nbsp; Guardar </a>
                </div>
                <div class="col-md-6" style="padding-left: 10px;">
                   <div class="panel panel-primary filterable"  style="margin-bottom: 200px;">
                        <div class="panel-heading">
                            <h4 class="panel-title">Hora Atención</h4>
                        </div>
                        <div id="HorasAtencion" class="funkyradio" style="padding: 10px 15px;">
                            @if(isset($Leccion_Hora))
                                @if(count($Leccion_Hora)>0) 
                                    <?php $aux = 26 ?>
                                    @foreach($Leccion_Hora as $LH)
                                        <div class="funkyradio-success"><input type="radio" name="radio1" id="radio{{$aux}}" value="{{$aux-25}}"/><label for="radio{{$aux}}">{{$LH->Hora}}</label></div>
                                        <?php $aux++; ?>
                                    @endforeach
                                @endif
                            @endif
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
{{HTML::script('js/authentication/login2.js');}}
{{HTML::script('js/admin/horaAtencion.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'ReporteMensuales', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Reportes de Horas de Atención</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="css/contabilidad/reportes.css" type="text/css" />');
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
@stop
