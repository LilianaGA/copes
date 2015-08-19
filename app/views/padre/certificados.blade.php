@extends('layouts.base') @section('cabecera') @parent {{HTML::style('css/padre/certificado.css');}} {{HTML::style('css/Contabilidad/cuentas.css');}}@stop @section('cuerpo') @parent

<div class="container">
    <h1 style="text-align:center">Solicitud de Certificaciones</h1>
    <hr class="colorgraph">
    <div class="row"  id="divPrincipal">
        <div class="col-sm-offset-4 col-sm-4">
            <form >
                <div class="form-group">
            		<label for="validate-select">Tipo de Certificación</label>
					<div class="input-group">
                        <select class="form-control" name="validate-select" id="validate-select" placeholder="Validate Select" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="item_1">Record de Notas</option>
                            <option value="item_2">Estudiante Regular</option>
                            <option value="item_3">Certificación de Título</option>
                        </select>
						<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
					</div>
				</div>
                <div class="form-group">
        			<label for="validate-number">Número de Cédula</label>
					<div class="input-group" data-validate="number">
						<input type="text" class="form-control" name="validate-number" id="validate-number" placeholder="Únicamente Números" required>
						<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
					</div>
				</div>
				<div class="form-group">
        			<label for="validate-text">Nombre Completo</label>
					<div class="input-group">
						<input type="text" class="form-control" name="validate-text" id="validate-text" placeholder="Digite el nombre completo" required>
						<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
					</div>
				</div>
                <div class="form-group">
        			<label for="validate-text">Fecha de Nacimiento</label>
					<div class="input-group">
						<input type="text" class="form-control" name="validate-text" id="validate-text-fecha" placeholder="24-03-2015" required>
						<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
					</div>
				</div>
                <div class="form-group">
        			<label for="validate-text">Nivel a Certificar</label>
					<div class="input-group">
						<input type="text" class="form-control" name="validate-text" id="validate-text-nivel" placeholder="Digite el nivel (Materno, Primero, Octavo)" required>
						<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
					</div>
				</div>
                <div class="form-group">
        			<label for="validate-number">Año a Certificar</label>
					<div class="input-group" data-validate="number">
						<input type="text" class="form-control" name="validate-number" id="validate-number-anio" placeholder="2000" required>
						<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
					</div>
				</div> 
                <button type="button" id="botonCertificado" class="btn btn-success col-xs-12" disabled>Enviar</button>
            </form>
        </div>
    </div>
</div>

{{HTML::script('js/authentication/login2.js');}}
{{HTML::script('js/padre/certificado.js');}}
<script type="text/javascript">
    var url_home = "<?= URL::route('home') ?>";
</script>
@stop