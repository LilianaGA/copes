//llamar a bd y obtener las materias de cada hijo
$(document).on('change','#select-child',function(){
    var id = $('#select-child option:selected').attr('value');
    clearTable();
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

function clearTable () {
  clearView();
  $('#select-subject').find('option:not(:first)').remove();
}

function clearView () {
  var fountainG = document.getElementById("fountainG");
  fountainG.style.display = "none";
  var allContainer = document.getElementById("allContainer");
  allContainer.style.display = "none";
  $('#Items tr').remove();
  $("#Items").append('<tr class="no-result text-center"><td colspan="5">Debe seleccionar primero la materia</td></tr>');
}

//recorrer para insertar html con el nombre de la materia
function createSubjects (data) {
	var subjectsArray  =  data['Subjects'];
	for (var i = 0; i < subjectsArray.length ; i++) {
		$("#select-subject").append('<option value='+subjectsArray[i].Materia+' data-icon="glyphicon-link">'+subjectsArray[i].Materia+'</option>');	
	}
}

//cuando cambia la materia selecciona se cargan las citas
$(document).on('change','#select-subject',function(){
  var fountainG = document.getElementById("fountainG");
  fountainG.style.display = "";
  var cedula = $('#select-child option:selected').attr('value');  
	var materia = $('#select-subject option:selected').attr('value');
  var seccion = $('#select-child option:selected').attr('seccion');  
  clearView();
  if (materia !== "0") {
  	$.ajax({
    url:'/padre/getAsignaciones/'+cedula+'/'+seccion+'/'+materia
    }).done(function (data) {
      var totalArray  =  data['totales'];
      var html = "";
      $('#Items tr').remove();
      for (var i = 0; i < totalArray.length ; i++) {
        html = '<tr>';
        html += "<td>";
        html +=  totalArray[i].Tipo_Trabajo;
        html += '</td>';
        html += "<td>";
        html +=  totalArray[i].totales;
        html += '</td>';
        html += "<td>";
        html +=  totalArray[i].entregados;
        html += '</td>';
        html += "<td>";
        html +=  totalArray[i].sinpresentar;
        html += '</td>';
        html += "<td>";
        html +=  totalArray[i].pendientes;
        html += '</td>';
        html += "</tr>";
        $("#Items").append(html);
      }
      var allContainer = document.getElementById("allContainer");
      allContainer.style.display = "";
      fountainG.style.display = "none";
    });
  }

});