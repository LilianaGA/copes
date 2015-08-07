'use strict';
$(document).ready(function() {
  //Asignar el foco al control principal
  $("#txt_username").focus(); 
});

//Función que al cancelar redirije a la lista
function cancel(){
  window.location.href = url_home;
}

$(document).ready(function() {
  $('#olvidado').click(function(e) {
    e.preventDefault();
    $('div#form-olvidado').toggle('500');
  });
  $('#acceso').click(function(e) {
    e.preventDefault();
    $('div#form-olvidado').toggle('500');
  });
});

