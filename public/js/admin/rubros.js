function clearTable () {
	var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "none";
    var allContainer = document.getElementById("allContainer");
    allContainer.style.display = "none";
    var containsItems = document.getElementById("containsItems");
    containsItems.style.display = "none";
    $('#Secciones tr').remove();
    $('#select-subject').find('option:not(:first)').remove();
   	$('#Items tr').remove();
	$("#Items").append('<tr class="no-result text-center"><td colspan="3">Debe seleccionar primero la materia</td></tr>');
	$('#mensaje').html("");
    $('#descripcion').val("");
	$('#porcentaje').val("");
    $('#txt_id').val("");
    $('#txt_porcentaje_update').val("");
    $('#txt_id_delete').val("");
    $('#txt_rubrica').val("");
}

function clearTable2 () {
    var containsItems = document.getElementById("containsItems");
    containsItems.style.display = "none";
    $('#Items tr').remove();
    $("#Items").append('<tr class="no-result text-center"><td colspan="3">No hemos encontrado rubros asignado.</td></tr>');
}

function getMaterias () {
	clearTable();
	var id = $('#select-level option:selected').attr('value');
    var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
  	if (id !== "0") {
		$.ajax({
	  		url:'/Administrativo/searchSubjetcs/'+id,
			data : {
				id:id
			}
	  	}).done(function (data) {
	       	var secciones  =  data['Secciones'];
	       	var html = "<tr>";
	        for (var i = 0; i < secciones.length ; i++) {
	            html += "<td style='text-align: center;'>";
	            html +=  secciones[i].Seccion_Alumno;
	            html += '</td>';
	        }
	        html += "</tr>";
            $("#Secciones").append(html);
            var materias  =  data['Materias'];
	       	for (var i = 0; i < materias.length ; i++) {
	        	$("#select-subject").append('<option value='+materias[i].Materia+'>'+materias[i].Materia+'</option>');
	        }
	    	var allContainer = document.getElementById("allContainer");
	    	allContainer.style.display = "";
            fountainG.style.display = "none";
	  	});
    }else{
    	alert("Debe seleccionar un nivel");
        fountainG.style.display = "none";
    }
}

function getRubros () {
	var materia = $('#select-subject option:selected').attr('value');
	var id = $('#select-level option:selected').attr('value');
    var fountainGM = document.getElementById("fountainGM");
    fountainGM.style.display = "";
	if (materia !== "0") {
		$.ajax({
	  		url:'/Administrativo/searchItems/'+id+'/'+materia,
			data : {
				id:id
			}
	  	}).done(function (data) {
	       	loadItems(data['Items']);
	  	});
    }else{
        clearTable2();
    	alert("Debe seleccionar una materia");
        var fountainGM = document.getElementById("fountainGM");
        fountainGM.style.display = "none";
    }
}

function loadItems (data) {
	var containsItems = document.getElementById("containsItems");
    containsItems.style.display = "none";
	var html = "";
   	var estado = false;
   	$('#Items tr').remove();
    for (var i = 0; i < data.length ; i++) {
    	html = '<tr>';
        html += "<td>";
        html +=  data[i].Detalle_Rubro;
        html += '</td>';
        html += "<td>";
        html +=  data[i].Valor;
        html += '</td>';
        html += '<td style="padding:5px;"><div class="ui-group-buttons">';
        html += '<a onclick="searchItem(' + data[i].id + ')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
        html += '<div class="or"></div>';
        html += '<a onclick="deleteItem(' + data[i].id + ')" data-toggle="modal" data-target="#myModalDelete" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>';
        html += '</div></td>';
    	html += "</tr>";
    	$("#Items").append(html);
    	estado = true;
    }
    if (estado == false) {
    	$("#Items").append('<tr class="no-result text-center"><td colspan="3">No hemos encontrado rubros asignado.</td></tr>');
    };
    var fountainGM = document.getElementById("fountainGM");
    fountainGM.style.display = "none";
    var containsItems = document.getElementById("containsItems");
    containsItems.style.display = "";
}

function saveItem() {
	var materia = $('#select-subject option:selected').attr('value');
	var level = $('#select-level option:selected').attr('value');
	var descripcion = $('#txt_descripcion option:selected').attr('value');
	var porcentaje = $('#porcentaje').val();
    $.ajax({
        url:'/createNewItem',
            type: "POST",
            data : {
            level:level,
            materia:materia,
            descripcion:descripcion,
            porcentaje:porcentaje
        }
    }).done(function (data) {
    	if (data == 'Error') {
    		alert('No se guardó correctamente');
    	} else{
            getRubros();
		};
    });
}

function searchItem (id) {
    var fountainGU = document.getElementById("fountainGU");
    fountainGU.style.display = "";
    $.ajax({
        url:'/Administrativo/searchItem/'+id,
        data : {
            id:id
        }
    }).done(function (data) {
        var fountainGU = document.getElementById("fountainGU");
        fountainGU.style.display = "none";
        $('#txt_id').val(data[0].id);
        $('#txt_descripcion_update').val(data[0].idr);
        $('#txt_porcentaje_update').val(data[0].Valor);
    });
}

function updateItem () {
    var id = $('#txt_id').val();
    var descripcion = $('#txt_descripcion_update').val();
    var porcentaje = $('#txt_porcentaje_update').val();
    var materia = $('#select-subject option:selected').attr('value');
    var level = $('#select-level option:selected').attr('value');
    if ((descripcion != "") && (porcentaje != "")) {
        $.ajax({
            url:'/Administrativo/updateItem/'+id,
            type: "PUT",
            data : {
                id:id,
                level:level,
                materia:materia,
                descripcion:descripcion,
                porcentaje:porcentaje
            }
        }).done(function (data) {
            if (data == true) {
                getRubros();
            } else{
                alert('No hemos podido actualizar el rubro');
            };
        });
    }else{
        alert('Debe rellenar los campos');
    };
}

function deleteItem (id) {
    $('#txt_id_delete').val(id);
}

function confirmDeleteItem () {
    var id = $('#txt_id_delete').val();
    $.ajax({
        url:'/Administrativo/deleteItem/'+id,
        data : {
            id:id
        }
    }).done(function (data) {
        if (data == true) {
            getRubros();
        } else{
            alert('No hemos podido eliminar el rubro');
        };
    });
}

function saveNew(){
    var rubro = $('#txt_rubrica').val();
    if (rubro != "") {
        $.ajax({
            url:'/Administrativo/newType/'+rubro,
            data : {
                rubro:rubro
            }
        }).done(function (data) {
            if (data == 'Error') {
                alert('No se guardó correctamente');
            } else{
                var html = "<option value=" + data.id + ">" + data.Detalle_Rubro + "</option>";
                $("#txt_descripcion").append(html);
                $("#txt_descripcion_update").append(html);
            };
        });
    }else{
        alert("Por favor ingresar un nombre a la rúbrica");
    }
    $('#txt_rubrica').val("");
}


