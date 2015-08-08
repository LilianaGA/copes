$( "#botonCertificado" ).click(function() {
	var status 		= $('#select-status option:selected').text();
	var comentario 	= $('#comment').attr('value');
	var id 			= $('#from').attr('value');
	if (comentario == "") {
	    comentario = "no";
	}
	
  	$('#divPrincipal').find('div').remove();
	var html = '<div id="proceso" class="col-md-6 col-md-offset-3" >';
    html += '<div class="modal-dialog modal-m">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<h3 style="margin:0;">Actualizando Cita...</h3>';
    html += '</div>';
    html += '<div class="modal-body">';
    html += '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    $("#divPrincipal").append(html);
	$.ajax({
      url:'/profesor/'+id+'/'+status+'/'+comentario,
      data : {
        id:id,
		status:status,
		comentario:comentario
      }
      }).done(function (data) {
       	createData(data);
      });
});


function createData(data){
	var respond  =  data;
	  if (respond == 'Successfull') {
		var html = '<div class="container content">';
	    html += '<div class="row">';
	    html += '<div class="col-md-6 col-md-offset-3">';
	    html += '<div class="testimonials">';
	    html += '<div class="active item">';
	    html += '<blockquote><p>Actualización de la cita se ha completado. <br> Se le enviará un correo para respaldo. <br> Gracias.</p></blockquote>';
	    html += '<div class="carousel-info">';
	    html += '<img alt="" src="/img/copes.gif" class="pull-left">';
	    html += '<div class="pull-left">';
	    html += '<span class="testimonials-name">Administración</span>';
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
	    $('#divPrincipal').delay(5000).fadeOut( "", function() {
              window.location.replace("/profesor/index");
        });
	  }
}

