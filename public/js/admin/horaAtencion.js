'use strict';
$(document).ready(function() {
	demoDisplay();
	$('#olvidado').click(function(e) {
	e.preventDefault();
	$('div#form-olvidado').toggle('500');
	});
	$('#olvidado2').click(function(e) {
	e.preventDefault();
	$('div#form-olvidado-2').toggle('500');
	});
	$('#acceso').click(function(e) {
	e.preventDefault();
	$('div#form-olvidado').toggle('500');
	});
});

function demoDisplay() {
	$(".hidden-form").attr("style", "display:none");
}

$(document).on('change','#select-profesor',function(){
   var id = $('#select-profesor option:selected').attr('value');
  if (id !== "0") {
	$.ajax({
      url:'/Administrativo/searchInfo/'+id,
      data : {
        id:id
      }
      }).done(function (data) {
       	createData(data);
      });
    }
});

$( "#select-profesor-2" ).change(function() {
  var id = $('#select-profesor-2 option:selected').attr('value');
  if (id !== "0") {
	$.ajax({
      url:'/Administrativo/searchInfo/'+id,
      data : {
        id:id
      }
      }).done(function (data) {
       	createData2(data);
      });
    }
});

function createData(data) { 
	//clearAppointments();
	var appointmentsArray  =  data['Materias'];
	$("#ContentMateria").empty();
	var html = "";
	for (var i = 0; i < appointmentsArray.length ; i++) {
	    html = '<tr>';
	    html += '<td>';
	    html +=  appointmentsArray[i].Materia ;
	    html += '</td>';
	    html += '<td>';
     	$("#ContentMateria").append(html);	
	}
	var appointmentsArray  =  data['Secciones'];
	$("#ContentSecciones").empty();
	var html = "";
	for (var i = 0; i < appointmentsArray.length ; i++) {
	    html = '<tr>';
	    html += '<td>';
	    html +=  appointmentsArray[i].Seccion ;
	    html += '</td>';
	    html += '<td>';
     	$("#ContentSecciones").append(html);	
	}
	var appointmentsArray  =  data['Hora_Atencion'][0]["Dia"];
	switch(appointmentsArray) {
    case "Lunes":
        $("#radio1").prop("checked", true);
        break;
    case "Martes":
        $("#radio2").prop("checked", true);
        break;
    case "Miércoles":
        $("#radio3").prop("checked", true);
        break;
    case "Jueves":
        $("#radio4").prop("checked", true);
        break;
    case "Viernes":
        $("#radio5").prop("checked", true);
        break;
	}
	var Leccion_Hora_Activo  =  data['Leccion_Hora_Activo'][0]["id"];
	switch(Leccion_Hora_Activo) {
	    case 1:
	        $("#radio6").prop("checked", true);
	        break;
	    case 2:
	        $("#radio7").prop("checked", true);
	        break;
	    case 3:
	        $("#radio8").prop("checked", true);
	        break;
	    case 4:
	        $("#radio9").prop("checked", true);
	        break;
	    case 5:
	        $("#radio10").prop("checked", true);
	        break;
        case 6:
	        $("#radio11").prop("checked", true);
	        break;
        case 7:
	        $("#radio12").prop("checked", true);
	        break;
        case 8:
	        $("#radio13").prop("checked", true);
	        break;
        case 9:
	        $("#radio14").prop("checked", true);
	        break;
	}
}

function createData2(data) { 
	//clearAppointments();
	var appointmentsArray  =  data['Materias'];
	$("#ContentMateria2").empty();
	var html = "";
	for (var i = 0; i < appointmentsArray.length ; i++) {
	    html = '<tr>';
	    html += '<td>';
	    html +=  appointmentsArray[i].Materia ;
	    html += '</td>';
	    html += '<td>';
     	$("#ContentMateria2").append(html);	
	}
	var appointmentsArray  =  data['Secciones'];
	$("#ContentSecciones2").empty();
	var html = "";
	for (var i = 0; i < appointmentsArray.length ; i++) {
	    html = '<tr>';
	    html += '<td>';
	    html +=  appointmentsArray[i].Seccion ;
	    html += '</td>';
	    html += '<td>';
     	$("#ContentSecciones2").append(html);	
	}
}

function updateHora(){
	var id = $('#select-profesor option:selected').attr('value');
  	if (id !== "0") {
  		var dia = $('input[name="radio"]:checked').attr('value');
  		var hora = $('input[name="radio1"]:checked').attr('value');
	    $.ajax({
	      url:'/Administrativo/updateHour/'+id+'/'+dia+'/'+hora,
	      data : {
	        id:id,
	        Dia:dia,
	        Hora:hora
	      }
	      }).done(function (data) {
	       	alert("Se ha actualizado correctamente");
	       	window.location.replace("/administracion/atencion");
      });
    }
}

function storeHora(){
	var id = $('#select-profesor-2 option:selected').attr('value');
  	if (id !== "0") {
  		var dia = $('input[name="radio"]:checked').attr('value');
  		var hora = $('input[name="radio1"]:checked').attr('value');
	    $.ajax({
	      url:'/Administrativo/storeHour/'+id+'/'+dia+'/'+hora,
	      data : {
	        id:id,
	        Dia:dia,
	        Hora:hora
	      }
	      }).done(function (data) {
	       	alert("Se ha actualizado correctamente");
	       	window.location.replace("/administracion/atencion");
      });
    }
}