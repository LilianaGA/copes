@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/profesor/edit.css');}} 
@stop @section('cuerpo')
@parent
@foreach($Citas as $cita)
<div id="divPrincipal">
    <div class="row" style="margin-top:4%">
        <div class="col-xs-12 col-sm-8 col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="margin-top:1%">
                <div class="panel-heading text-center">
                    <h1>Editar Cita </h1>
                </div>
                <form id="from" value="{{$cita->id}}">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8 form-group"  style="  padding-right: 15px;">
                                <label>Nombre del Estudiante</label>
                                <input id="Nombre" type="text" class="form-control" readonly value="{{$cita->Nombre_Alumno}} {{$cita->Apellido1_Alumno}} {{$cita->Apellido2_Alumno}}">
                            </div>
                            <div class="col-md-4" >
                                <label>Sección</label>
                                <input id="Seccion" type="text" class="form-control" readonly value="{{$cita->Seccion_Alumno}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4  form-group">
                                <label>Fecha</label>
                                <?php
                                    $date = date_create($cita->Fecha_Cita);
                                    echo '<input id="Fecha" type="text" class="form-control" readonly value="' . $cita->Dia . " " . date_format($date, 'd/m/Y') . '">';
                                ?>
                            </div>
                            <div class="col-md-4  form-group">
                                <label>Hora</label>
                                <input id="Hora" type="text" class="form-control" readonly value="{{$cita->Hora}}">
                            </div>
                            <div class="col-md-4">
                                <label>Situación: </label>
                                <select id="select-status" data-placeholder="Seleccione un Estado" class="chosen-select form-control multiselect multiselect-icon"  name="Estado">
                                    <option value=""></option>
                                    <option value="1" selected>Pendiente</option>
                                    <option value="2">Se presentó</option>
                                    <option value="3">No se presentó</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                          <label for="comment">Observaciones:</label>
                          <textarea class="form-control" rows="5" id="comment" style="resize: none;"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6"  style="  padding-right: 15px;">
                                <button type="button" id="botonCertificado" class="btn btn-success btn-block">Guardar</button>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <a href="{{ route('principalProfe') }}" class="btn btn-primary btn-block">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>

{{HTML::script('js/profesor/edit.js');}}
<script type="text/javascript">
    var url_usuarios = "<?= URL::route('storeUser') ?>";
    var url_home = "<?= URL::route('home') ?>";
</script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>

@stop
