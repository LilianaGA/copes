@extends('layouts.base') 
@section('cabecera') 
@parent 
<link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet" media="screen">
{{HTML::style('css/Contabilidad/reportes.css');}}  @stop @section('cuerpo') @parent

	
<div class="container">
    @if(Auth::check())
	<div class="container">
	    <h1 style="text-align:center">Reportes</h1>
	    <hr class="colorgraph">
	    <div class="row">
	    	<div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-calendar"></i> Listado de Pagos Mensual</h3>
                    <span class="pull-right clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                	<div class="panel panel widget filterable">
				            <div class="panel-heading widget-head">
				                <h3 class="heading">Pagos Mensuales hasta la Fecha</h3>
				                <div class="pull-right" style="margin-top:0px">
				                    <button class="btn btn-default btn-xs" onclick="PrintElem('#ReportePagoMensual')"><i class="fa fa-print"></i> Imprimir</button>
				                </div>
				            </div>
				            <div  id="ReportePagoMensual">
					            <table class="table">
					                <thead>
					                    <tr class="filters">
					                        <th><input type="text" class="form-control" placeholder="Mensualidad" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Total de Montos Pagados" disabled></th>
					                    </tr>
					                </thead>
					                <tbody>
					                	@if(isset($MontosMensuales))
					                        @if(count($MontosMensuales)>0) 
					                            @foreach($MontosMensuales as $mm)
					                                <tr>
					                                    <?php
					                                    	$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
					                                    	echo '<td>' . $meses[$mm->Mensualidad  - 1] . ' </td>';
					                                    ?>
					                                    <td>¢{{number_format($mm->sum, 0, ',', '.');}}</td>
				                                </tr>
					                            @endforeach
					                        @else
					                        	<tr class="no-result text-center"><td colspan="6">Resultados no encontrados</td></tr>
						                    @endif
					                    @endif
					                </tbody>
					            </table>
				            </div>
				        </div>
                </div>
            </div>
		</div>
		<br>
		<div class="row">
	    	<div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-calculator"></i> Listado Total de Pagos</h3>
                    <span class="pull-right clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                	<div class="row">
				        <div class="panel panel widget filterable">
				            <div class="panel-heading widget-head">
				                <h3 class="heading">Total de Pagos Recibidos</h3>
				                <div class="pull-right" style="margin-top:0px">
				                    <button class="btn btn-default btn-xs" onclick="PrintElem('#MontosActuales')"><i class="fa fa-print"></i> Imprimir</button>
				                </div>
				            </div>
				            <div  id="MontosActuales">
					            <table class="table">
					                <thead>
					                    <tr class="filters">
					                        <th><input type="text" class="form-control" placeholder="Fecha" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Monto Total" disabled></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    @if(isset($MontosActuales))
                        					@if(count($MontosActuales)>0) 
				                                <tr>
				                                    <td><?php echo date("d - M - y"); ?></td>
				                                    <td>¢{{number_format($MontosActuales, 0, ',', '.');}}</td>
				                                </tr>
					                        @endif
					                    @endif
					                </tbody>
					            </table>
				            </div>
				        </div>
				    </div>	
            	</div>
            </div>
		</div>	
		<br>
		<div class="row">
	    	<div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-check"></i> Listado Mensualidades al Día</h3>
                    <span class="pull-right clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                	<div class="row">
				        <div class="panel panel widget filterable">
				            <div class="panel-heading widget-head">
				                <h3 class="heading">Mensualidades al Día</h3>
				                <div class="pull-right" style="margin-top:0px">
				                    <button class="btn btn-default btn-xs" onclick="PrintElem('#ReporteMensuales')"><i class="fa fa-print"></i> Imprimir</button>
				                </div>
				            </div>
				            <div  id="ReporteMensuales">
					            <table class="table">
					                <thead>
					                    <tr class="filters">
					                        <th><input type="text" class="form-control" placeholder="Nombre del Alumno" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Sección" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Monto Recibido" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Mensualidad" disabled></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    @if(isset($MontosAlDia))
					                        @if(count($MontosAlDia)>0) 
					                            @foreach($MontosAlDia as $pgs)
					                                <tr>
					                                    <td>{{$pgs->Nombre_Alumno}} {{$pgs->Apellido1_Alumno}} {{$pgs->Apellido2_Alumno}}</td>
					                                    <td>{{$pgs->Seccion_Alumno}}</td>
			                                            <td>¢{{number_format($pgs->Monto_Recibo, 0, ',', '.');}}</td>
				                                		<?php
					                                    	$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
					                                    	echo '<td>' . $meses[$pgs->Mensualidad  - 1] . ' </td>';
					                                    ?>
					                                </tr>
					                            @endforeach
					                        @else
					                        	<tr class="no-result text-center"><td colspan="6">Resultados no encontrados</td></tr>
						                    @endif
				                        @endif
					                </tbody>
					            </table>
				            </div>
				        </div>
				    </div>
                </div>
            </div>
		</div>	
		<br>
		<div class="row">
	    	<div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-warning"></i> Listado Mensualidades Morosas</h3>
                    <span class="pull-right clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                	<div class="row">
				        <div class="panel panel widget filterable">
				            <div class="panel-heading widget-head">
				                <h3 class="heading">Mensualidades Morosas</h3>
				                <div class="pull-right" style="margin-top:0px">
				                    <button class="btn btn-default btn-xs" onclick="PrintElem('#ReporteMorosos')"><i class="fa fa-print"></i> Imprimir</button>
				                </div>
				            </div>
				            <div  id="ReporteMorosos">
					            <table class="table">
					                <thead>
					                    <tr class="filters">
					                        <th><input type="text" class="form-control" placeholder="Familia" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Recargos" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Diferencias" disabled></th>
					                        <th><input type="text" class="form-control" placeholder="Monto Pendiente" disabled></th>
					                    </tr>
					                </thead>
					                <tbody>
					                	@if(isset($MontosMoroso))
					                        @if(count($MontosMoroso)>0) 
					                            @foreach($MontosMoroso as $pgs)
					                                <tr>
					                                    <td>{{$pgs->Apellido1}} {{$pgs->Apellido2}}</td>
					                                    <td>¢{{number_format($pgs->recargo, 0, ',', '.');}}</td>
				                                		<td>¢{{number_format($pgs->diferencia, 0, ',', '.');}}</td>
					                                    <td>¢{{number_format($pgs->total, 0, ',', '.');}}</td>
				                                	</tr>
					                            @endforeach
					                        @else
					                        	<tr class="no-result text-center"><td colspan="6">Resultados no encontrados</td></tr>
						                    @endif
					                    @endif
					                </tbody>
					            </table>
				            </div>
				        </div>
				    </div>
                </div>
            </div>
		</div>	
		<br>
		<div class="row">
	    	<div class="panel widget">
                <div class="panel-heading widget-head">
                    <h3 class="heading"><i class="fa fa-user"></i> Listado de Pagos por Familia</h3>
                    <span class="pull-right clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                	<div class="row">
		                <div class="col-md-3">
		                    <label>Seleccione una Familia: </label>
		                </div>
		                <div class="col-md-6">
		                    <select id="select-family" data-placeholder="Seleccione una Familia" class="chosen-select form-control multiselect multiselect-icon"  name="searchFamily">
		                        <option value="0"></option>
		                        @if(isset($Familia))
                                @if(count($Familia)>0) 
                                    @foreach($Familia as $fam)
                                        <option value="{{$fam->Codigo_Familia}}">Familia: {{$fam->Apellido1}} {{$fam->Apellido2}}</option>  
                                   @endforeach
                                @endif
                            @endif
		                    </select> 
		                </div>
		                <div class="col-md-3">
		                    <button onclick="getFamilyBalance()" class="btn btn-default navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Buscar</button>
		                    <button onclick="clearTable()" class="btn btn-primary navbar-btn"> <span class="glyphicon glyphicon-search"></span>&nbsp; Limpiar</button>
		                </div>
		            </div>
                	<div class="panel panel widget filterable">
				            <div class="panel-heading widget-head">
				                <h3 class="heading">Pagos Mensuales</h3>
				                <div class="pull-right" style="margin-top:0px">
				                    <button class="btn btn-default btn-xs" onclick="PrintElem('#ReporteBalanceFamilia')"><i class="fa fa-print"></i> Imprimir</button>
				                </div>
				            </div>
				            <div  id="ReporteBalanceFamilia">
					            <table class="table">
					                <thead>
					                    <thead>
				                            <tr class="filters">
				                                <th><input type="text" class="form-control" placeholder="Nombre Estudiante" disabled></th>
				                                <th><input type="text" class="form-control" placeholder="Fecha de Pago" disabled></th>
				                                <th><input type="text" class="form-control" placeholder="Detalle" disabled></th>
				                                <th><input type="text" class="form-control" placeholder="Monto Mensualidad" disabled></th>
				                                <th><input type="text" class="form-control" placeholder="Monto Pagado" disabled></th>
				                                <th><input type="text" class="form-control" placeholder="Recargo 15%" disabled></th>
				                                <th><input type="text" class="form-control" placeholder="Saldo Actual" disabled></th>
				                            </tr>
				                        </thead>
					                </thead>
					                <tbody id="Content">
					                	<tr class="no-result text-center"><td colspan="7">Debe seleccionar primero la familia</td></tr>
						            </tbody>
					            </table>
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


{{HTML::script('js/contabilidad/reportes.js');}}
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
        mywindow.document.write('<html><head><title>Reportes de Pagos</title>');
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