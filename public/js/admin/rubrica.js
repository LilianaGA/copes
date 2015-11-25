function clearTable () {
	var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "none";
    var allContainer = document.getElementById("allContainer");
    allContainer.style.display = "none";       
	var Message = document.getElementById("Message");
	Message.style.display = "none"; 
    $('#Items tr').remove();
    $('#Encabezado th').remove();
    $('#Encabezado tr').remove();
	$("#Items").append('<tr class="no-result text-center"><td colspan="5">Debe seleccionar primero la materia</td></tr>');
	$('#panel-body').empty();	
	$("#mensaje").empty();
}


function getInfo () {
	clearTable();
	var seccion = $('#select-seccion option:selected').attr('value');
	var materia = $('#select-materia option:selected').attr('value');
	var periodo = $('#select-periodo option:selected').attr('value');
	var anio = $('#select-anio option:selected').attr('value');
    var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
  	if ((seccion !== "0") && (materia !== "0")) {
		$.ajax({
	  		url:'/Administrativo/searchRubros/'+seccion+'/'+materia+'/'+periodo+'/'+anio,
			data : {
				seccion:seccion,
				materia:materia,
				periodo:periodo,
				anio:anio
			}
	  	}).done(function (data) {
	  		var informacion = data['Info'];
	  		var rubros  =  data['Items'];
	        var rubrica = data['Rubros'];
	  		if ((informacion.length > 0) && (rubros.length > 0) && (rubrica.length > 0)) {
		  		for (var i = 0; i < informacion.length ; i++) {	 
		  			var infoHTML = "<tr class='filters'>";      		
		       		infoHTML += "<th>Profesor:</th>";
		        	infoHTML += "<th>" + informacion[i].Nombre + " " + informacion[i].Apellido1 + " " + informacion[i].Apellido2 + "</th></tr>";
		        	infoHTML += "<tr class='filters'>";  
		        	infoHTML += "<th>Materia:</th>";
	                infoHTML += "<th>" + informacion[i].Materia + "</th></tr>";
	                infoHTML += "<tr class='filters'>";  
		        	infoHTML += "<th>Sección:</th>";
	                infoHTML += "<th>" + informacion[i].Seccion + "</th></tr>";
	                infoHTML += "<tr class='filters'>";  
		        	infoHTML += "<th>Período:</th>";
		        	switch(periodo) {
					    case 'I':
					        infoHTML += "<th>1</th></tr>";
					        break;
					    case 'II':
					        infoHTML += "<th>2</th></tr>";
					        break;
				        case 'III':
					        infoHTML += "<th>3</th></tr>";
					        break;
					}
	                infoHTML += "<tr class='filters'>";  
	                infoHTML += "<th></th>";
	                infoHTML += "<th>Notas en Porcentajes</th></tr>";
	                infoHTML += "<tr class='filters'>";  
	                infoHTML += "<th></th>";
	                infoHTML += "<th></th></tr>";
		        }
		  		infoHTML += '</tr>';
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
				head += "<th>100%</th></tr>";
				html += "<th>Promedio</th>";
				$("#Encabezado").append(infoHTML);
				$("#Encabezado").append(head);
		        $("#Encabezado").append(html);
		        var auxCedula = "";
		        var auxNota = 0;
	        	$('#Items tr').remove();
		        html = "<tr>";
		        for (var i = 0; i < rubrica.length ; i++) {
		        	if (auxCedula != rubrica[i].cedula_alumno) {
		        		if (i != 0) {
		        			html += "<td>" + auxNota + "</td>";
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
				html += '</tr>';
		        $("#Items").append(html);
		        if (status == false) {
		       		$("#Items").append('<tr class="no-result text-center"><td colspan="'+(rubros.length + 3)+'">No hemos encontrado asignaciones.</td></tr>');
		        };	
		    	var allContainer = document.getElementById("allContainer");
		    	allContainer.style.display = ""; 
	        }else{
	        	$("#mensaje").append('Por el momento no hemos encontrado registros para esa seccioón: ' + seccion + ' y con esa asignatura: ' + materia);
	        	var Message = document.getElementById("Message");
		    	Message.style.display = ""; 
	        }         		
	    	fountainG.style.display = "none";
	  	});
    }else{
    	alert("Debe seleccionar los datos primero");
    	fountainG.style.display = "none";
    }
}

$("#export").click(function(){
    $("#table2excel").table2excel({
        exclude: ".noExl",
        name: "Notas " + $('#select-periodo option:selected').attr('value')
    }); 
 });