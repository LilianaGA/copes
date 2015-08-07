@extends('layouts.base') @section('cabecera') @parent @stop @section('cuerpo') @parent
<br>
<br>
<br>
@if(Auth::check())
	
@else
	<div class="row">
	    <div class="col-md-12">
	        <div class="jumbotron">
	            <div class="row">
	                <div class="col-md-8">
	                    <div class="front-welcome-text">
	                        <h2>Bienvenido a la Plataforma de Servicios</h2> 
	                        <h4>del Colegio Diocesano Padre Eladio Sancho</h4>
	                        <br><br><br><br>
                         	<h4>Teléfonos: 2460-0256/2460-2921/24607513. Fax. 24600545.<br>
                            <br>Correo: <a href="mailto:información@copes.ed.cr">información@copes.ed.cr</a><br>
                            <br>www.copes.ed.cr</h4>
	                    </div>
	                </div>
	                <div class="col-md-3">
	                    <br>
	                    <img id="imagen" src="{{ asset('img/copes.gif') }}" />
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endif
@stop
    
@stop