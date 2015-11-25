function clearTable () {
	var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "none";    
	var Message = document.getElementById("Message");
	Message.style.display = "none"; 
    $('#Items tr').remove();
    $('#Encabezado th').remove();
	$("#Items").append('<tr class="no-result text-center"><td colspan="5">Debe seleccionar primero la materia</td></tr>');
	$('#panel-body').empty();
	$("#mensaje").empty();
}


function getInfo () {
	clearTable();
    var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
	var seccion = $('#select-seccion option:selected').attr('value');
	var materia = $('#select-materia option:selected').attr('value');
	var periodo = $('#select-periodo option:selected').attr('value');
	var anio = $('#select-anio option:selected').attr('value');
    if ((typeof seccion !== "undefined") && (typeof materia !== "undefined")) {
	  	if ((seccion !== "0") && (materia !== "0")) {
			$.ajax({
		  		url:'/profesor/searchRubros/'+seccion+'/'+materia+'/'+periodo+'/'+anio,
				data : {
					seccion:seccion,
					materia:materia,
					periodo:periodo,
					anio:anio
				}
		  	}).done(function (data) {
		  		var rubros  =  data['Items'];
		  		if (rubros.length > 0) {
			       	var html = "<tr class='filters'>";
			       	var head = "<tr class='filters'>";
			       	var status = false;
			       	head += "<th></th>";
			       	head += "<th style='text-align: right;'>Procentajes ==></th>";
			       	html += "<th>Carnet</th>";
			       	html += "<th>Nombre del Estudiante</th>";
					$('#Encabezado th').remove();
			        for (var i = 0; i < rubros.length ; i++) {
			        	head += "<th>" + rubros[i].Valor + "%</th>";
		                html +="<th>" + rubros[i].Detalle_Rubro + "</th>";	            
			            status = true;
			        }
					head += "<th>100%</th>";
					head += "<th></th></tr>";
					html += "<th>Promedio</th>";
					html += "<th>Opciones</th></tr>";
					$("#Encabezado").append(head);
			        $("#Encabezado").append(html);
			        var rubrica = data['Rubros'];
			        var auxCedula = "";
			        var auxNota = 0;
		        	$('#Items tr').remove();
			        html = "<tr>";
			        for (var i = 0; i < rubrica.length ; i++) {
			        	if (auxCedula != rubrica[i].cedula_alumno) {
			        		if (i != 0) {
			        			html += "<td>" + auxNota + "</td>";
			        			html += '<td><a onclick="getItems(' + auxCedula + ')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a></td>';
			        			html += '</tr>';
			        			$("#Items").append(html);
			        			html = "<tr>";
			        			auxNota = 0;
			        		}
			        		auxCedula = rubrica[i].cedula_alumno;
			        		html += "<td>" + auxCedula + "</td>";
			        		html += "<td>" + rubrica[i].nombre_alumno + "</td>";
			        		html += "<td>" + rubrica[i].valor_obtenido + "</td>";
			        	}else{
			        		html += "<td>" + rubrica[i].valor_obtenido + "</td>";
			        	}
			        	auxNota += parseInt(rubrica[i].valor_obtenido);
			        }
					html += "<td>" + auxNota + "</td>";
					html += '<td><a onclick="getItems(' + auxCedula + ')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a></td>';
					html += '</tr>';
			        $("#Items").append(html);
			        if (status == false) {
			       		$("#Items").append('<tr class="no-result text-center"><td colspan="'+(rubros.length + 3)+'">No hemos encontrado asignaciones.</td></tr>');
			        };	          		
			    	var allContainer = document.getElementById("allContainer");
			    	allContainer.style.display = "";
		    	} else{
			    	$("#mensaje").append('Por el momento no hemos en alumnos asignados a esta materia y sección.');
			    	var Message = document.getElementById("Message");
			    	Message.style.display = ""; 
		    	}
		    	fountainG.style.display = "none";
		  	});
	    }else{
	    	alert("Debe seleccionar los datos primero");
			fountainG.style.display = "none";
	    }
    }else{
    	$("#mensaje").append('Por el momento no tienes materias y/o secciones asignadas.');
    	var Message = document.getElementById("Message");
    	Message.style.display = ""; 
		fountainG.style.display = "none";
    }
}

function getItems (cedula) {
	$('#panel-body').empty();
	var fountainGU = document.getElementById("fountainGU");
	fountainGU.style.display = "";	
	var periodo = $('#select-periodo option:selected').attr('value');
	var anio = $('#select-anio option:selected').attr('value');
	if (cedula != "") {
		$('#txt_id_update').val(cedula);
		$.ajax({
	  		url:'/profesor/searchRubrosAlumno/'+cedula+'/'+periodo+'/'+anio,
			data : {
				cedula:cedula,
				periodo:periodo,
				anio:anio
			}
	  	}).done(function (data) {
	  		var estudiante = data['Alumno'];
	  		var html = "";
	  		html = '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<label class="control-label">Alumno</label>';
            html += '<div class="form-group input-group">';
            html += '<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
			html += '<input class="form-control" type="text" value="' + estudiante[0].Nombre_Alumno + ' ' + estudiante[0].Apellido1_Alumno + ' ' + estudiante[0].Apellido2_Alumno + '" readonly>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            $("#panel-body").append(html);
	  		var rubrica = data['Rubros'];
	  		for (var i = 0; i < rubrica.length ; i++) {
	  			html = '<div class="row">';
	            html += '<div class="col-md-12">';
	            html += '<label for="' + rubrica[i].detalle_rubro + '" class="control-label">' + rubrica[i].detalle_rubro + '</label>';
	            html += '<div class="form-group input-group">';
            	html += '<span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>';
				html += '<input name="' + rubrica[i].detalle_rubro + '" id="txt_' + rubrica[i].id + '" idRubro="' + rubrica[i].id + '" idRubroAlumno="' + rubrica[i].idalum + '" min="0" max="' + rubrica[i].valor + '" value="' + rubrica[i].valor_obtenido + '"class="form-control" type="number" requried>';
				html += '<span class="input-group-addon">' + rubrica[i].valor + '</span>';
	            html += '</div>';
	            html += '</div>';
	            html += '</div>';
	            $("#panel-body").append(html);
	  		}
	  	});
  		fountainGU.style.display = "none";
	}
}

function updateItemAlumno () {
	var fountainGU = document.getElementById("fountainGU");
	fountainGU.style.display = "";	
	var periodo = $('#select-periodo option:selected').attr('value');
	var anio = $('#select-anio option:selected').attr('value');
	var cedula = $('#txt_id_update').val();
	if (cedula != "") {		
		$.ajax({
	  		url:'/profesor/searchRubrosAlumno/'+cedula+'/'+periodo+'/'+anio,
			data : {
				cedula:cedula,
				periodo:periodo,
				anio:anio
			}
	  	}).done(function (data) {
	  		var rubrica = data['Rubros'];
	  		var arr = [];
	  		var valor = "";
	  		for (var i = 0; i < rubrica.length ; i++) {
	  			valor = $('#txt_' + rubrica[i].id).attr('idRubroAlumno') + '-';
	  			valor += $('#txt_' + rubrica[i].id).attr('idRubro') + '-';
	  			valor += cedula + '-';
	  			valor += $('#txt_' + rubrica[i].id).val() + '-';
  				valor += periodo + '-';
  				valor += anio;
  				arr.push(valor);
	  		}
	  		if (arr != "") {
			    $.ajax({
			      url:'/profesor/updateItemAlumno/' + arr,
			      data : {
			          arr:arr
			      }
			    }).done(function (data) {
			      var confirmacion = data['Respuesta'];
			      if (confirmacion == 'Successfull'){
			        getInfo();
			      }else{
			        alert('No pudimos actualizar los datos, por favor enviarlo de nuevo en unos minutos.');
			      };
			    });
		  	}else{
			    alert('Debe indicar los valor primero');
		  	}
	  	});
  		fountainGU.style.display = "none";
	}
}