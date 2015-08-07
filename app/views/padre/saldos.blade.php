@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/padre/index.css');}} @stop @section('cuerpo') @parent

<div class="container">
    <h1 style="text-align:center">Consulta de Pagos</h1>
    <hr class="colorgraph">
    @if (($Diferencia < 0) || ($Recargo > 0))
        <div class="row" id="">
            <br><br>
            <div class="col-lg-6 col-md-6 col-md-offset-3">
                <div class="alert alert-danger">
                    <i class="icon-ok"></i>
                    <strong>Hola {{Auth::user()->Nombre}} {{Auth::user()->Apellido1}}</strong>
                    <br/>Tienes saldos pendientes por ¢{{number_format(abs($Diferencia) + $Recargo, 0, ',', '.')}}, por favor contactar a contabilidad<br>
                </div>
            </div>
        </div>
    @endif
    @if(isset($Saldos))
        @if(count($Saldos)>0) 
            <div class="row">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading">
                        <h3 class="panel-title">Detalles de Pago</h3>
                        <div class="pull-right">
                            <button class="btn btn-info btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtro</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="filters">
                                <th><input type="text" class="form-control" placeholder="Nombre de Estudiante" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Fecha de Pago" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Detalle" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Monto Mensualidad" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Monto Pagado" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Recargo 15%" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Saldo Actual" disabled></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Saldos as $sld)
                                <tr>
                                    <td>{{$sld->Nombre_Alumno}} {{$sld->Apellido1_Alumno}} {{$sld->Apellido2_Alumno}}</td>
                                    <td>{{ date("d - m - Y",strtotime($sld->Fecha_Pago)) }}</td>
                                    <td>{{$sld->Descripcion}}</td>
                                    <td>¢{{number_format($sld->Monto_Mensual, 0, ',', '')}}</td>
                                    <td>¢{{number_format($sld->Monto_Recibo, 0, ',', '')}}</td>
                                    <td>¢{{number_format($sld->Recargo, 0, ',', '')}}</td>
                                    <td>¢{{number_format($sld->Diferencia, 0, ',', '')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                            <tfoot>
                                @if (($Diferencia < 0) || ($Recargo > 0))
                                    <tr class="btn-primary" style="display: table-row;">
                                        <td>Total Pagado</td>
                                        <td></td>
                                        <td></td>
                                        <td>¢{{number_format(abs($Diferencia) + $MontoRecibo, 0, ',', '.')}}</td>
                                        <td>¢{{number_format($MontoRecibo, 0, ',', '.')}}</td>
                                        <td>¢{{number_format($Recargo, 0, ',', '.')}}</td>
                                        <td>¢{{number_format($Diferencia, 0, ',', '.')}}</td>
                                    </tr>
                                @else
                                    <tr class="btn-success" style="display: table-row;">
                                        <td>Total Pagado</td>
                                        <td></td>
                                        <td></td>
                                        <td>¢{{number_format(abs($Diferencia) + $MontoRecibo, 0, ',', '.')}}</td>
                                        <td>¢{{number_format($MontoRecibo, 0, ',', '.')}}</td>
                                        <td>¢{{number_format($Recargo, 0, ',', '.')}}</td>
                                        <td>¢{{number_format($Diferencia, 0, ',', '.')}}</td>
                                    </tr>
                                @endif
                            </tfoot>
                    </table>
                </div>
            </div>
        @else
            <div class="container content">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="testimonials">
                            <div class="active item">
                                <blockquote>
                                    <p>Estimado (a) {{Auth::user()->Nombre}} {{Auth::user()->Apellido1}} {{Auth::user()->Apellido2}} Por el momentos no hemos encontrado pagos realizados por usted o su familia en nuestros archivos.
                                        <br>
                                        Para mayor información puede contactar al administrador. Teléfono: 2460-0256 ext. 107
                                    </p>
                                 </blockquote>
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
            <div class="container">
                <section class="comment-list">
                    <article class="row">
                        <div class="col-md-2 col-sm-2 hidden-xs">
                          <figure class="thumbnail">
                            <img class="img-responsive" src="/img/copes.gif" />
                            <figcaption class="text-center">COPES</figcaption>
                          </figure>
                        </div>
                        <div class="col-md-10 col-sm-10">
                          <div class="panel panel-default arrow left">
                            <div class="panel-body">
                              <header class="text-left">
                                <div class="comment-user"><i class="fa fa-user"></i> Hola {{Auth::user()->Nombre}} {{Auth::user()->Apellido1}}</div>
                                <br>
                              </header>
                              <div class="comment-post">
                                <p>
                                  Por el momentos no hemos encontrado pagos realizados por usted o su familia en nuestros archivos.
                                  <br>
                                  Para mayor información puede contactar al administrador. Teléfono: 2460-0256 ext. 107
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </article>
                </section>
            </div>
    @endif
</div>

{{HTML::script('js/authentication/login2.js');}}
{{HTML::script('js/padre/saldos.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop