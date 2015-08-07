@extends('layouts.base') @section('cabecera') @parent 
{{HTML::style('css/administrativo/newCita.css');}} 
{{HTML::style('css/administrativo/reportes.css');}} 
{{HTML::style('css/docsupport/chosen.css');}}
@stop @section('cuerpo')
@parent
@if(Auth::check())
	<div class="row" style="margin-top:4%">
	    <div class="col-xs-12 col-sm-8 col-md-10 col-md-offset-1">
	        <div class="panel panel-default" style="margin-top:1%">
	            <div class="panel-heading text-center">
	                <h1>Registro de Roles</h1>
	            </div>
	            <div class="panel-body">
	                <div class="row">
	                    <div class="col-md-12 form-group"  style="  padding-right: 15px;">
	                        <label>Nombre del Usuario</label>
	                        @if(isset($Usuario))
                                @if(count($Usuario)>0) 
                                    @foreach($Usuario as $usr)
                                    	<?php $cedula = $usr->Cedula; ?>
                                    	 <div class="msg"> {{$usr->Nombre}} {{$usr->Apellido1}} {{$usr->Apellido2}}</div>
                                   @endforeach
                                @endif
                            @endif
	                    </div>
	                </div>
	                <div class="row">
	                	@if(isset($RolesInactivos))
                            @if(count($RolesInactivos)>0) 
                                @foreach($RolesInactivos as $rls)
				                    <div class="col-md-6 form-group"  style="  padding-right: 15px;">
				                        <div class="offer offer-radius  offer-success">
						                    <div class="shape"></div>
						                    <div class="offer-content">
						                    	<table class="table">
									                <thead>
									                    <tr>
									                        <th></th>
									                        <th></th>
									                    </tr>
									                </thead>
									                <tbody>
									                    <tr>
									                        <td>
									                        	<div class="msg msg-clear"> 
									                        		<?php
																		switch ($rls->Descripcion) {
																		    case "Encargado":
																		        echo "<span class='glyphicon glyphicon glyphicon-user'></span> " . $rls->Descripcion;
																		        break;
																		    case "Profesor":
																		        echo "<span class='glyphicon glyphicon glyphicon-book'></span> " . $rls->Descripcion;
																		        break;
																		    case "Contador":
																		        echo "<span class='glyphicon glyphicon glyphicon-sort'></span> " . $rls->Descripcion;
																		        break;
																        	case "Administrativo":
																		        echo "<span class='glyphicon glyphicon glyphicon-inbox'></span> " . $rls->Descripcion;
																		        break;
																		    }
																	?>
									                        	</div>
									                        </td>
									                        <td>
									                        	<?php
									                        		if ($rls->Descripcion == "Profesor") {
									                        			echo '<a class="btn icon-btn btn-success" style="float:right;" value="' . $cedula . '" id="id'. $rls->Descripcion . '"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Habilitar</a>';
									                        		}else{
										                        		echo '<a class="btn icon-btn btn-success" style="float:right;" value="' . $cedula . '" id="id'. $rls->Descripcion . '"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Habilitar</a>';
										                        	}
									                        	?>
																<a class="btn icon-btn btn-primary" style="float:right; display:none;" value="0" id={{'id'. $rls->Descripcion .'2'}}><span class="glyphicon btn-glyphicon glyphicon-minus img-circle text-primary"></span>Deshabilitar</a>
									                        </td>
									                    </tr>
									                </tbody>
									            </table>
						                    </div>
						                </div>
				                    </div>
	                    		@endforeach
	                        @endif
	                    @endif
	                	@if(isset($RolesActivos))
                            @if(count($RolesActivos)>0) 
                                @foreach($RolesActivos as $rls)
				                    <div class="col-md-6 form-group"  style="  padding-right: 15px;">
				                        <div class="offer offer-radius  offer-success">
						                    <div class="shape"></div>
						                    <div class="offer-content">
						                    	<table class="table">
									                <thead>
									                    <tr>
									                        <th></th>
									                        <th></th>
									                    </tr>
									                </thead>
									                <tbody>
									                    <tr>
									                        <td>
									                        	<div class="msg msg-clear">
									                        		<?php
																		switch ($rls->Descripcion) {
																		    case "Encargado":
																		        echo "<span class='glyphicon glyphicon glyphicon-user'></span> " . $rls->Descripcion;
																		        break;
																		    case "Profesor":
																		        echo "<span class='glyphicon glyphicon glyphicon-book'></span> " . $rls->Descripcion;
																		        break;
																		    case "Contador":
																		        echo "<span class='glyphicon glyphicon glyphicon-sort'></span> " . $rls->Descripcion;
																		        break;
																        	case "Administrativo":
																		        echo "<span class='glyphicon glyphicon glyphicon-inbox'></span> " . $rls->Descripcion;
																		        break;
																		    }
																	?>
									                        	</div>
									                        </td>
									                        <td>
									                        	<?php
									                        		if ($rls->Descripcion == "Profesor") {
									                        			echo '<a class="btn icon-btn btn-success" style="float:right;  display:none;" value="' . $cedula . '" id="id'. $rls->Descripcion . '" data-toggle="modal" data-target="#myModal"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Habilitar</a>';
									                        		}else{
										                        		echo '<a class="btn icon-btn btn-success" style="float:right;  display:none;" value="' . $cedula . '" id="id'. $rls->Descripcion . '"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Habilitar</a>';
										                        	}
									                        	?>
									                        	<a class="btn icon-btn btn-primary" style="float:right;" id={{'id'. $rls->Descripcion .'2'}} value="{{$rls->id}}"><span class="glyphicon btn-glyphicon glyphicon-minus img-circle text-primary"></span>Deshabilitar</a>
									                        </td>
									                    </tr>
									                </tbody>
									            </table>
						                    </div>
						                </div>
				                    </div>
	                    		@endforeach
	                        @endif
	                    @endif
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{{HTML::script('js/docsupport/chosen.jquery.js');}}
{{HTML::script('js/docsupport/chosen.js');}}
{{HTML::script('docsupport/prism.js.js');}}
{{HTML::script('js/admin/reportes.js');}}
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
