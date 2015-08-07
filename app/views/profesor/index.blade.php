@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/profesor/index.css');}} @stop @section('cuerpo') @parent
@if(Auth::check())
    <div class="container">
        <h1 style="text-align:center">Atención de Citas</h1>
            <hr class="colorgraph">
        @if(isset($TraerCitas))
            @if(count($TraerCitas) > 0)
                <?php $cont=1; ?>
                @foreach ($TraerCitas as $cita)
                    <div class="offer offer-success">
                        <div class="shape">
                            <div class="shape-text">
                                {{$cont}}					
                            </div>
                        </div>
                        <div class="offer-content">
                            <table class="table">
                                <thead>
                                    <tr class="active">
                                        <th>
                                            Nombre del Estudiante
                                        </th>
                                        <th>
                                            Sección
                                        </th>
                                        <th>
                                            Fecha
                                        </th>
                                        <th>
                                            Hora
                                        </th>
                                        <th>
                                            Estado
                                        </th>
                                        <th>
                                            Opción
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{$cita->Nombre_Alumno }} {{$cita->Apellido1_Alumno }} {{$cita->Apellido2_Alumno}}
                                        </td>
                                        <td>
                                            {{$cita->Seccion_Alumno}}
                                        </td>
                                        <td>
                                            <?php
                                                $date = date_create($cita->Fecha_Cita);
                                                echo $cita->Dia . "  " . date_format($date, 'd - M - Y');
                                            ?>
                                        </td>
                                        <td>
                                            {{$cita->Hora}}
                                        </td>
                                        <td>
                                            Pendiente
                                        </td>
                                        <td>
                                            <div class="ui-group-buttons">
                                                <a href="{{'/profesor/'.$cita->id.'/editar' }}" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>
                                                <div class="or"></div>
                                                <a href="{{'/profesor/'.$cita->id }}" id="confirm" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <?php $cont++; ?> 
                @endforeach
            @else
                <div class="container content">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="testimonials">
                                <div class="active item">
                                  <blockquote><p>Estimado (a) {{Auth::user()->Nombre}} {{Auth::user()->Apellido1}} {{Auth::user()->Apellido2}} no tienes citas pendientes con padres, madres o encargados de familia.</p></blockquote>
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
        @else
            <div class="ProtectedTimeline">
                <h2 class="ProtectedTimeline-heading" id="content-main-heading">No se encontraron resultados.</h2>
                <p class="ProtectedTimeline-explanation">para {{Auth::user()->Nombre}}  {{Auth::user()->Apellido1}}</p>
            </div>
        @endif
    </div>
@endif

{{HTML::script('js/authentication/login2.js');}}
{{HTML::script('js/profesor/index.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop