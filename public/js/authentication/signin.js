'use strict';
$(document).ready(function() {
  //Asignar el foco al control principal
  $("#txt_Cedula").focus(); 
  $("#CedulaSelect").attr("name", "codigofamilia");
});

//Función que al cancelar redirije a la lista
function cancel(){
  window.location.href = url_home;
}
