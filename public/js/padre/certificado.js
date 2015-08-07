$(document).ready(function() {
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup change', function() {
		var $form = $(this).closest('form'),
            $group = $(this).closest('.input-group'),
			$addon = $group.find('.input-group-addon'),
			$icon = $addon.find('span'),
			state = false;
            
    	if (!$group.data('validate')) {
			state = $(this).val() ? true : false;
		}else if ($group.data('validate') == "email") {
			state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
		}else if($group.data('validate') == 'phone') {
			state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
		}else if ($group.data('validate') == "length") {
			state = $(this).val().length >= $group.data('length') ? true : false;
		}else if ($group.data('validate') == "number") {
			state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
		}

		if (state) {
				$addon.removeClass('danger');
				$addon.addClass('success');
				$icon.attr('class', 'glyphicon glyphicon-ok');
		}else{
				$addon.removeClass('success');
				$addon.addClass('danger');
				$icon.attr('class', 'glyphicon glyphicon-remove');
		}
        
        if ($form.find('.input-group-addon.danger').length == 0) {
            $form.find('[type="button"]').prop('disabled', false);
        }else{
            $form.find('[type="button"]').prop('disabled', true);
        }
	});
    
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');
    
    
});

$( "#botonCertificado" ).click(function() {
	var tipo 	= $('#validate-select option:selected').text();
	var cedula 	= $('#validate-number').attr('value');
	var nombre 	= $('#validate-text').attr('value');
	var fecha 	= $('#validate-text-fecha').attr('value');
	fecha = fecha.replace("/", "-");
	fecha = fecha.replace("/", "-");
	var nivel 	= $('#validate-text-nivel').attr('value');
	var anio 	= $('#validate-number-anio').attr('value');
  if (tipo !== "0") {
  	$('#divPrincipal').find('form').remove();
	var html = '<div id="proceso" class="col-md-6 col-md-offset-3" >';
    html += '<div class="modal-dialog modal-m">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<h3 style="margin:0;">Enviando Correo...</h3>';
    html += '</div>';
    html += '<div class="modal-body">';
    html += '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
	$("#divPrincipal").append(html);
	$.ajax({
      url:'/padre/obtenerCertificado/'+tipo+'/'+cedula+'/'+nombre+'/'+fecha+'/'+nivel+'/'+anio,
      data : {
        tipo:tipo,
		cedula:cedula,
		nombre:nombre,
		fecha:fecha,
		nivel:nivel,
		anio:anio
      }
      }).done(function (data) {
       	createData(data);
      });
    }
});


function createData(data){
	var respond  =  data;
	  if (respond.includes('Successfull')) {
		var html = '<div class="container content">';
	    html += '<div class="row">';
	    html += '<div class="col-md-6 col-md-offset-3">';
	    html += '<div class="testimonials">';
	    html += '<div class="active item">';
	    html += '<blockquote><p>Durante los próximos tres días hábiles debe presentarse a la secretaría a retirar la certificación y efectuar la cancelación respectiva. <br> Gracias.</p></blockquote>';
	    html += '<div class="carousel-info">';
	    html += '<img alt="" src="/img/copes.gif" class="pull-left">';
	    html += '<div class="pull-left">';
	    html += '<span class="testimonials-name">Secretaría</span>';
	    html += '<span class="testimonials-post">Colegio Diocesano Padre Eladio Sancho</span>';
	    html += '</div>';
	    html += '</div>';
	    html += '</div>';
	    html += '</div>';
	    html += '</div>';
	    html += '</div>';
	    html += '</div>';
	    $('#proceso').remove();
	    $("#divPrincipal").append(html);
	  }
}

