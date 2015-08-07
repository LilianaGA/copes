@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/Contabilidad/cuentas.css');}}  @stop @section('cuerpo') @parent

	
<div class="container">
    @if(Auth::check())
        <div class="container">
            <h1 style="text-align:center">Cálculo de Cuentas Morosas</h1>
            <hr class="colorgraph">
            <div class="row">
                <div class="col-md-2">
                    <label>Seleccione la Mensualidad a calcular: </label>
                </div>
                <div class="col-md-5">
                    <select id="select-month" data-placeholder="Seleccione un Mes" class="chosen-select form-control multiselect multiselect-icon"  name="searchMes">
                        <option value="0"></option>
                        <option value="1" style="display:none">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12" style="display:none">Diciembre</option>
                    </select> 
                </div>
                <div class="col-md-5">
                    <button onclick="calculate()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-transfer"></span>&nbsp;&nbsp; Calcular sin Correos</button>
                    <button onclick="calculateEmails()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-envelope"></span>&nbsp; Calcular con Correos</button>
                </div>
            </div>
            <hr class="colorgraph">
            <div class="row">
                <div id="proceso" class="col-md-6 col-md-offset-3" style="display:none;">
                    <div class="modal-dialog modal-m">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 style="margin:0;">Procesando...</h3>
                            </div>
                            <div class="modal-body">
                                <div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="procesado" class="col-md-6 col-md-offset-3" style="display:none;">
                    <div class="msg msg-success msg-success-text"> <span class="glyphicon glyphicon glyphicon-info-sign"></span>&nbsp; Cálculo Realizado</div>
                </div>
                <div id="noDatos" class="col-md-6 col-md-offset-3" style="display:none;">
                    <div class="msg msg-primary msg-primary-text"> <span class="glyphicon glyphicon glyphicon-ok"></span>&nbsp; No existen cuentas morosas</div>
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
{{HTML::script('js/contabilidad/cuentas.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop