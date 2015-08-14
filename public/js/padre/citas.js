$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">Resultados no encontrados</td></tr>'));
        }
    });
});
//llamar a bd y obtener las materias de cada hijo
$(document).on('change','#select-child',function(){
    var id = $('#select-child option:selected').attr('value');
    clearSubjects();
    clearAppointments();
    if (id !== "0") {
    	$.ajax({
      url:'/padre/showSubjects/'+id,
      data : {
        id:id
      }
      }).done(function (data) {
       	createSubjects(data);
      });
    }
});
//limpiar items de materias, solo el primero no
function clearSubjects () {
	$('#select-subject').find('option:not(:first)').remove();
}
//recorrer para insertar html con el nombre de la materia
function createSubjects (data) {

	var subjectsArray  =  data['Subjects'];
	for (var i = 0; i < subjectsArray.length ; i++) {
		$("#select-subject").append('<option value='+subjectsArray[i].Cedula_Usuarios+' data-icon="glyphicon-link">'+subjectsArray[i].Materia+'</option>');	
	}
}
//cuando cambia la materia selecciona se cargan las citas
$(document).on('change','#select-subject',function(){
    
	var id = $('#select-subject option:selected').attr('value');
    clearAppointments();
    if (id !== "0") {
    	$.ajax({
      url:'/padre/showAppointByMonth/'+id,
      data : {
        id:id
      }
      }).done(function (data) {
       	createAppointments(data);
      });
    }

});
//limpiar citas
function clearAppointments () {
	$("#Appointments").empty();
}
//crear html para insertar las citas
function createAppointments (data) { 
	//clearAppointments();
	var appointmentsArray  =  data['Days'];
  var appointmentsFamilyArray  =  data['Family'];
  var appointmentsControlArray  =  data['Control'];
  var html = "";
  if (appointmentsControlArray[0].count > 3) {
     html = '<div class="container content">';
      html += '<div class="row">';
      html += '<div class="col-md-6 col-md-offset-3">';
      html += '<div class="testimonials">';
      html += '<div class="active item">';
      html += '<blockquote><p>Su familia ya no tiene acceso a citas por este medio, por favor comunicarse con Recepción del Colegio. <br> Gracias.</p></blockquote>';
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
     $("#Appointments").append(html); 
   }else{
  if (appointmentsFamilyArray.length > 0) {
      html = '<div class="container content">';
      html += '<div class="row">';
      html += '<div class="col-md-6 col-md-offset-3">';
      html += '<div class="testimonials">';
      html += '<div class="active item">';
      html += '<blockquote><p>Su familia ya tiene reservada una cita durante el actual mes, para reservar otra cita por favor llamar a la Recepción del Colegio. <br> Gracias.</p></blockquote>';
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
     $("#Appointments").append(html); 
  }else{
	   if (appointmentsArray.length > 0) {  
      //var html = "";
      for (var i = 0; i < appointmentsArray.length ; i++) {
        html += '<div class="offer offer-success">'
        html += '<div class="shape"> ';
        html += '<div class="shape-text">';
        html += (i + 1);
        html += '</div>';
        html += '</div>';             
        html += '<div class="offer-content">';
        html += '<table class="table">';
        html += '<thead>';
        html += '<tr class="active">';
        html += '<th>';
        html += 'Día de Atención';
        html += '</th>';
        html += '<th>';
        html += 'Hora';
        html += '</th>';
        html += '<th>';
        html += 'Fecha';
        html += '</th>';
        html += '<th>';
        html += 'Seleccionar';
        html += '</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        html += '<tr>';
        html += '<td>';
        html +=  appointmentsArray[i].Dia ;
        html += '</td>';
        html += '<td>';
        html += appointmentsArray[i].Hora;
        html += '</td>';
        html += '<td id="' + ( i + 1 ) + '">';
        html += appointmentsArray[i].Fecha_Cita;// appointmentsArray[i].Fecha_Cita;
        html += '</td>';
        html += '<td>';
        if(appointmentsArray[i].Estado_Cita!="P"){
            html +='<button type="button" id="button'+ (i + 1 ) +'" onclick="reservarCita(' + (i + 1 ) + ')" class="btn btn-sky text-uppercase"><span class="glyphicon glyphicon-pushpin"></span>&nbsp; Reservar Cita</button>';
            html += '<span id="span'+ (i + 1 ) +'" class="glyphicon glyphicon-lock" style="display:none;"><strong>&nbsp; Reservada</strong></span>';
        }else{
            html +='<button type="button" id="button'+ (i + 1 ) +'"  class="btn btn-sky text-uppercase" style="display:none;"><span class="glyphicon glyphicon-pushpin"></span>&nbsp; Reservar Cita</button>';
            html += '<span id="span'+ (i + 1 ) +'"  class="glyphicon glyphicon-lock"><strong>&nbsp; Reservada</strong></span>';
        }
        html += '</td></tr></tbody></table></div></div>';
      }
    }else{
        html = '<div class="container content">';
        html += '<div class="row">';
        html += '<div class="col-md-6 col-md-offset-3">';
        html += '<div class="testimonials">';
        html += '<div class="active item">';
        html += '<blockquote><p>No hay más citas disponibles por este mes. <br> Gracias.</p></blockquote>';
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
    }
    $("#Appointments").append(html);  
    }
  }
}

function reservarCita(id) {
  var cedulaA = $('#select-child option:selected').attr('value');// obtener cedula alumno
  var cedulaP = $('#select-subject option:selected').attr('value');// obtener cedula profesor
  var fecha   = $('#' + id).html();
  if (id !== "0") {
      $.ajax({  //concatenando url
        url:'/padre/reserveApp/'+cedulaA+'/'+cedulaP+'/'+fecha,
        data : {
         cedulaA:cedulaA,
         cedulaP:cedulaP,
         fecha:fecha}
        }
        ).done(function (data) {
          var respond  =  data;
          if ((respond == undefined) || (respond.includes('Not Found')))  {
            var html = '<div class="row" id="Successfull">';
            html    += '<br>'
            html    += '<br>';
            html    += '<div class="col-lg-6 col-md-6  col-md-offset-3">';
            html    += '<div class="alert alert-warning alert-autocloseable-warning">';
            html    += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            html    += '<i class="icon-ok"></i>';
            html    += '<strong>¡Hemos encontrado un problema!</strong>';
            html    += '<br/>La cita ya no esta disponible para su reservación.<br>';
            html    += '</div>';
            html    += '</div>';
            html    += '</div>';
            $("#message").append(html);//insertar html
            $('.alert-autocloseable-warning').delay(5000).fadeOut( "slow", function() { //animacion
              // Animation complete.
              $('#Successfull').prop("disabled", false);
              $('#Successfull').remove();
            });
            document.getElementById('button' + id).style.display = "none";
            document.getElementById('span' + id).style.display = "";
          };
          if (respond.includes('Successfull')) {
            var html = '<div class="row" id="Successfull">';
            html    += '<br>'
            html    += '<br>';
            html    += '<div class="col-lg-6 col-md-6  col-md-offset-3">';
            html    += '<div class="alert alert-success alert-autocloseable-success">';
            html    += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            html    += '<i class="icon-ok"></i>';
            html    += '<strong>¡Cita reservada!</strong>';
            html    += '<br/>La confirmación de la cita será enviada vía correo electrónico<br>';
            html    += '</div>';
            html    += '</div>';
            html    += '</div>';
            $("#message").append(html);
            $('.alert-autocloseable-success').delay(5000).fadeOut( "slow", function() {
              // Animation complete.
              $('#Successfull').prop("disabled", false);
              $('#Successfull').remove();
            });
            var inputs = document.getElementsByClassName('btn-sky');
            for(var i = 1; i <= inputs.length; i++) {
                document.getElementById('button' + i).style.display = "none";
            }
            document.getElementById('span' + id).style.display = "";
            $.ajax({
              url:'/padre/sendEmail/'+cedulaA+'/'+cedulaP+'/'+fecha,
              data : {
               cedulaA:cedulaA,
               cedulaP:cedulaP,
               fecha:fecha}
              });
          };
        });
    }
}

