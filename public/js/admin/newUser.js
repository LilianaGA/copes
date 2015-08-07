$( document ).ready(function() {
    document.getElementById("bt_registrarsar_usuario").disabled = true;
});

//llamar a bd y obtener las materias de cada hijo
$(document).on('change','#select-family',function(){
    document.getElementById("bt_registrarsar_usuario").disabled = false;
});