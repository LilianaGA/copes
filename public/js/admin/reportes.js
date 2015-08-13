$( document ).ready(function() {

});

$( "#btnMateria" ).click(function() {
  var id = $('#idProfesor').attr('value');
  var materia = $('#txt_Materia').val();
  var seccion = $('#txt_Seccion').val();
  $.ajax({
      url:'/Administrativo/storeMateria/'+id+'/'+materia+'/'+seccion,
      data : {
        cedula:id,
        materia:materia,
        seccion:seccion
      }
    }).done(function (data) {
    });
});

//Functions to delete o add role of Encargado
$( "#idEncargado2" ).click(function() {
  var id = $('#idEncargado2').attr('value');
  var who = "idEncargado";
  ajaxToDeleteRole(id, who);
});

$( "#idEncargado" ).click(function() {
  var id = $('#idEncargado').attr('value');
  var who = "idEncargado";
  ajaxToAddRole(id, 1, who);
});

//Functions to delete o add role of Profesor
$( "#idProfesor2" ).click(function() {
  var id = $('#idProfesor2').attr('value');
  var who = "idProfesor";
  ajaxToDeleteRole(id, who);
});

$( "#idProfesor" ).click(function() {
  var id = $('#idProfesor').attr('value');
  var who = "idProfesor";
  ajaxToAddRole(id, 2, who);
});

//Functions to delete o add role of Contador
$( "#idContador2" ).click(function() {
  var id = $('#idContador2').attr('value');
  var who = "idContador";
  ajaxToDeleteRole(id, who);
});

$( "#idContador" ).click(function() {
  var id = $('#idContador').attr('value');
  var who = "idContador";
  ajaxToAddRole(id, 3, who);
});

//Functions to delete o add role of Administrativo
$( "#idAdministrativo2" ).click(function() {
  var id = $('#idAdministrativo2').attr('value');
  var who = "idAdministrativo";
  ajaxToDeleteRole(id, who);
});

$( "#idAdministrativo" ).click(function() {
  var id = $('#idAdministrativo').attr('value');
  var who = "idAdministrativo";
  ajaxToAddRole(id, 4, who);
});




function ajaxToDeleteRole (id, who) {
  $("#" + who + "2" ).attr('disabled', 'disabled');
  if (id !== "0") {
    $.ajax({
	    url:'/administracion/roles/delete/'+id,
	    data : {
	      id:id
	    }
    }).done(function (data) {
      	var respond  =  data;
  		if ((respond == undefined) || (respond == 'Not Found'))  {
  			alert("No se pudo eliminar el registro");
  		};
  		if (respond == 'Successfull') {
  			document.getElementById(who + '2').style.display = "none";
  			$("#" + who + "2").attr("value", "0");
  			document.getElementById(who).style.display = "";
        $("#" + who + "2").removeAttr('disabled');
  		};
    });
  }
}

function ajaxToAddRole (id, tipo, who) {
  $("#" + who ).attr('disabled', 'disabled');
  if (id !== "0") {
    $.ajax({
	    url:'/administracion/roles/add/'+id+'/'+tipo,
	    data : {
	      id:id,
	      tipo:tipo
	    }
    }).done(function (data) {
      var respond  =  data;
  		if ((respond == undefined) || (respond == 'Not Found'))  {
  			alert("No se pudo guardar el registro");
  		}else{  		
  			document.getElementById(who).style.display = "none";
  			document.getElementById(who + '2').style.display = "";
  			$("#" + who + "2").attr("value", respond);
        $("#" + who ).removeAttr('disabled');
  		};
    });
  }
}