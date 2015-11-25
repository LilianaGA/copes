function clearTable () {
	var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "none";
    var allContainer = document.getElementById("allContainer");
    allContainer.style.display = "none";
    var allContainerStudents = document.getElementById("allContainerStudents");
    allContainerStudents.style.display = "none";
    var mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";
    $('#Items tr').remove();
	$("#Items").append('<tr class="no-result text-center"><td colspan="5">Debe seleccionar primero la materia</td></tr>');
	$('#mensaje').html("");
	$('#txt_trabajo').val("");
	$('#txt_fecha').val("");
	$('#txt_descripcion').val("");
	$('#txt_id_delete').val("");
	$('#list-group').empty();
	$('#txt_id_item').val("");
}

function getInfo () {
	clearTable();
	var seccion = $('#select-seccion option:selected').attr('value');
	var materia = $('#select-materia option:selected').attr('value');
    var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
  	if ((seccion !== "0") && (materia !== "0")) {
		$.ajax({
	  		url:'/profesor/searchInfo/'+seccion+'/'+materia,
			data : {
				seccion:seccion,
				materia:materia
			}
	  	}).done(function (data) {
	  		var secciones  =  data['entregables'];
	       	var html = "<tr>";
	       	var status = false;
			$('#Items tr').remove();
	        for (var i = 0; i < secciones.length ; i++) {
	        	html = "<tr>";
	            html += "<td id='trabajo" + secciones[i].id + "'>";
	            html +=  secciones[i].Tipo_Trabajo;
	            html += '</td>';
	            html += "<td id='detalle" + secciones[i].id + "'>";
	            html +=  secciones[i].Detalle;
	            html += '</td>';
	            html += "<td id='fecha" + secciones[i].id + "'>";
	            html +=  secciones[i].Fecha_Entrega;
	            html += '</td>';
	            html += "<td>";
	            if (secciones[i].Estado == "T") {
	            	html +=  "Entregado";
	            }else{
	            	html +=  "Pendiente";
	            }
	            html += '</td>';
	            html += '<td style="padding:5px;"><div class="ui-group-buttons">';
	            if (secciones[i].Estado == "F") {
		            html += '<a onclick="getItem(' + secciones[i].id + ')"class="btn btn-success" role="button"><span class="glyphicon glyphicon-save"></span></a>';
		        }else{
		        	html += '<a class="btn btn-default" role="button" disabled><span class="glyphicon glyphicon-saved"></span></a>';
		        }
	            html += '<div class="or"></div>';
	            html += '<a onclick="searchItem(' + secciones[i].id + ')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
	            html += '<div class="or"></div>';
	            html += '<a onclick="deleteItem(' + secciones[i].id + ')" data-toggle="modal" data-target="#myModalDelete" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>';
	            html += '</div></td>';
	            html += "</tr>";	
	            $("#Items").append(html);
	            status = true;
	        }
	        if (status == false) {
	       		$("#Items").append('<tr class="no-result text-center"><td colspan="5">No hemos encontrado asignaciones.</td></tr>');
	        };	          		
	    	var allContainer = document.getElementById("allContainer");
	    	allContainer.style.display = "";
	    	fountainG.style.display = "none";
	  	});
    }else{
    	alert("Debe seleccionar los datos primero");
    	fountainG.style.display = "none";
    }
}

function saveItem () {
	var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
    var seccion = $('#select-seccion option:selected').attr('value');
	var materia = $('#select-materia option:selected').attr('value');
	var trabajo = $('#txt_trabajo').val();
	var fecha = $('#txt_fecha').val();
	var descripcion = $('#txt_descripcion').val();
    $.ajax({
        url:'/profesor/saveInfo',
            type: "POST",
            data : {
            seccion:seccion,
            materia:materia,
            trabajo:trabajo,
            fecha:fecha,
            descripcion:descripcion
        }
    }).done(function (data) {
    	if (data == 'Error') {
    		alert('No se guardó correctamente');
    	} else{
    		$('#txt_trabajo').val("");
			$('#txt_fecha').val("");
			$('#txt_descripcion').val("");
    		html = '<tr>';
	        html += "<td id='trabajo" + data.id + "'>";
	        html +=  data.Tipo_Trabajo;
	        html += '</td>';
	        html += "<td id='detalle" + data.id + "'>";
	        html +=  data.Detalle;
	        html += '</td>';
	        html += "<td id='fecha" + data.id + "'>";
	        html +=  data.Fecha_Entrega;
	        html += '</td>';
	        html += "<td>";
	        if (data.Estado == 'T') {
	        	html += 'Entregado';
	        }else{
	        	html += 'Pendiente';
	        }
	        html += '</td>';
            html += '<td style="padding:5px;"><div class="ui-group-buttons">';
            if (data.Estado == "F") {
	            html += '<a onclick="getItem(' + data.id + ')"class="btn btn-success" role="button"><span class="glyphicon glyphicon-save"></span></a>';
	        }else{
	        	html += '<a class="btn btn-default" role="button" disabled><span class="glyphicon glyphicon-saved"></span></a>';
	        }
            html += '<div class="or"></div>';
            html += '<a onclick="searchItem(' + data.id + ')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
            html += '<div class="or"></div>';
            html += '<a onclick="deleteItem(' + data.id + ')" data-toggle="modal" data-target="#myModalDelete" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>';
            html += '</div></td>';
            html += "</tr>";
	    	$("#Items").append(html);
    		fountainG.style.display = "none";
		};
    });
}

function deleteItem (id) {
	$('#txt_id_delete').val(id);
}

function confirmDeleteItem () {
	var id = $('#txt_id_delete').val();
	$.ajax({
        url:'/profesor/deleteItem/'+id
    }).done(function (data) {
        if (data == true) {
            getInfo();
        } else{
            alert('No hemos podido eliminar la asignación');
        };
    });
}

function searchItem (id) {
	var fountainGU = document.getElementById("fountainGU");
    fountainGU.style.display = "";
    clearModalUpdate();
    $.ajax({
        url:'/profesor/searchItem/'+id
    }).done(function (data) {
        fountainGU.style.display = "none";
        $('#txt_id_update').val(data[0].id);

        $("#txt_trabajo_update").val(data[0].idre);
		//$("txt_trabajo_update[val="+ data[0].idre + "]").prop("selected",true);
		$('#txt_fecha_update').val(data[0].Fecha_Entrega);
		$('#txt_descripcion_update').val(data[0].Detalle);
		if (data[0].Estado == 'T') {
			$('#txt_estado_update').val('Entregado');
		} else{
			$('#txt_estado_update').val('Pendiente');
		};
    });
}

function clearModalUpdate () {
	$('#txt_id_update').val("");
	$('#txt_fecha_update').val("");
	$('#txt_descripcion_update').val("");
	$('#txt_estado_update').val("");
}


function updateItem () {
	var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
    var id = $('#txt_id_update').val();
	var trabajo = $('#txt_trabajo_update option:selected').attr('value');
    var seccion = $('#select-seccion option:selected').attr('value');
	var materia = $('#select-materia option:selected').attr('value');
	var descripcion = $('#txt_descripcion_update').val();
	var fecha = $('#txt_fecha_update').val();
	var estado = $('#txt_estado_update').val();
	if (estado == 'Entregado') {
		estado = 'T';
	} else{
		estado = 'F';
	};
    $.ajax({
        url:'/profesor/updateItem/'+id,
        type: "POST",
        data : {
        	id:id,
            seccion:seccion,
            materia:materia,
            trabajo:trabajo,
            fecha:fecha,
            descripcion:descripcion,
            estado:estado
        }
    }).done(function (data) {
    	if (data == 'Error') {
    		alert('No se guardó correctamente');
    	} else{
    		clearModalUpdate();
    		getInfo ();
		};
    });
}

function saveNewType () {
    var trabajo = $('#txt_asignatura').val();
    if (trabajo != "") {
    	$.ajax({
	        url:'/profesor/newType/',
	        type: "POST",
	        data : {
	        	trabajo:trabajo
	        }
	    }).done(function (data) {
	    	if (data == 'Error') {
	    		alert('No se guardó correctamente');
	    	} else{
	    		var html = "<option value=" + data.id + ">" + data.Tipo_Trabajo + "</option>";
	    		$("#txt_trabajo").append(html);
	    		$("#txt_trabajo_update").append(html);
			};
	    });
    }else{
    	alert("Por favor ingresar un nombre a la asignatura");
    }
}

function getItem (id) {
	$('#txt_id_item').val(id);
	$("#selectItems tr").remove();
	var html = '<tr>';
    html += "<td>";
    html +=  $('#trabajo'+id).html();
    html += '</td>';
    html += "<td>";
    html +=  $('#detalle'+id).html();
    html += '</td>';
    html += "<td>";
    html +=  $('#fecha'+id).html();
    html += '</td>';
    html += '</tr>';
    $("#selectItems").append(html);
	var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
    var seccion = $('#select-seccion option:selected').attr('value');
    $('#list-group').empty();
	$.ajax({
        url:'/profesor/getStudents/'+seccion
    }).done(function (data) {
    	var AlumnosArray  =  data['alumnos'];
		var html = '';
		for (var a = 0; a < AlumnosArray.length ; a++) {
			html += '<li class="list-group-item">';
			html += AlumnosArray[a].Nombre_Alumno + ' ' + AlumnosArray[a].Apellido1_Alumno + ' ' + AlumnosArray[a].Apellido2_Alumno;
			html += '<div class="material-switch pull-right">';
			html += '<input class="messageCheckbox" id="' + a + '" name="' + a + '" type="checkbox" cedula="' + AlumnosArray[a].Cedula_Alumno + '"/>';
			html += '<label for="' + a + '" class="label-success"></label>';
			html += '</div>';
			html += '</li>';
		}
		$('#list-group').append(html);
		fountainG.style.display = "none";
    	var allContainerStudents = document.getElementById("allContainerStudents");
    	allContainerStudents.style.display = "";
    });
}

function send () {
	var fountainG = document.getElementById("fountainG");
	fountainG.style.display = "";
	var allContainerStudents = document.getElementById("allContainerStudents");
	allContainerStudents.style.display = "none";
	var id = $('#txt_id_item').val();
	var arr = [];
	var inputElements = document.getElementsByClassName('messageCheckbox');
	for(var i=0; inputElements[i]; ++i){
		if(inputElements[i].checked){
			arr.push(inputElements[i].getAttribute('cedula'));
		}
	}
	$.ajax({
		url:'/profesor/saveItemStudent/' + arr + '/' + id,
		data : {
			id:id,
			arr:arr
		}
	}).done(function (data) {
		var confirmacion = data['Respuesta'];
		if (confirmacion == 'Successfull'){
			getInfo();
		}else{
			alert('Entrega almacenada incorrectamente.');
		};
	});
}