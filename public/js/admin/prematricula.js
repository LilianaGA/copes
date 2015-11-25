$( "#idCerrar" ).click(function() {
  var id = $('#idCerrar').attr('value');// Número de cédula
  var who = "idCerrar";
  ajaxToChangeStatus(id, 'F', who);
});

$( "#idAbrir" ).click(function() {
  var id = $('#idAbrir').attr('value');// Número de cédula
  var who = "idAbrir";
  ajaxToChangeStatus(id, 'T', who);
});

function ajaxToChangeStatus (id, tipo, who) {
  $("#" + who ).attr('disabled', 'disabled');
  if (id !== "0") {
    $.ajax({
	    url:'/administracion/parametros/'+id+'/'+tipo,
	    data : {
	      id:id, // Cédula
	      tipo:tipo // Identificador del rol
	    }
    }).done(function (data) {
      var respond  =  data;
  		if ((respond == undefined) || (respond == 'Not Found'))  {
  			alert("No se pudo guardar el registro");
  		}else{  	
  			if (who == 'idCerrar') {
				document.getElementById(who).style.display = "none";
  				document.getElementById('idAbrir').style.display = "";
  			}else{
  				document.getElementById(who).style.display = "none";
  				document.getElementById('idCerrar').style.display = "";
  			}
        	$("#" + who ).removeAttr('disabled');
  		};
    });
  }
}

function getFamily() {
    var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
    var id = $('#select-family option:selected').attr('value');
    if (id !== "0") {
        $('#Encargados tr').remove();
        $('#Viejos tr').remove();
        $('#Nuevos tr').remove();
        $.ajax({
            url:'/Administrativo/getFamily/'+id,
            data : {
                id:id
            }
        }).done(function (data) {
        var balanceArray  =  data['Familia'];
        var balanceArrayHijos  =  data['Hijos'];
        var balanceArrayNuevos  =  data['NuevosHijos'];
        for (var i = 0; i < balanceArray.length ; i++) {
            var cedula = balanceArray[i].Cedula;
            var html = "";
            html += '<tr id="Manager' + balanceArray[i].id + '">';
            html += '<td>' + cedula + '</td>';
            html += '<td>' + balanceArray[i].Nombre + '</td>';
            html += '<td>' + balanceArray[i].Apellido1 + '</td>';
            html += '<td>' + balanceArray[i].Apellido2 + '</td>';
            html += '<td>' + balanceArray[i].Direccion + '</td>';
            html += '<td><table  id="Correo'+ cedula + '"">';
            html += '</table></td>';
            html += '<td><table  id="Telefono'+ cedula + '"">';
            html += '</table></td>';
            html += '<td>';
            html += '<a onclick="getManager(' + balanceArray[i].id + ')" data-toggle="modal" data-target="#myModalUpdateManager" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
            html += '</td>';
            html += '</tr>';
            $("#Encargados").append(html);
            cargarCorreos(cedula);
            cargarTelefonos(cedula);           
        }
        for (var i = 0; i < balanceArrayHijos.length ; i++) {
            var html = "";
            html += '<tr id="Hijos' + balanceArrayHijos[i].id + '">';
            html += '<td>' + balanceArrayHijos[i].Cedula_Alumno + '</td>';
            html += '<td>' + balanceArrayHijos[i].Nombre_Alumno + '</td>';
            html += '<td>' + balanceArrayHijos[i].Apellido1_Alumno + '</td>';
            html += '<td>' + balanceArrayHijos[i].Apellido2_Alumno + '</td>';
            html += '<td>' + balanceArrayHijos[i].Fecha_Nacimiento + '</td>';
            html += '<td>' + balanceArrayHijos[i].Seccion_Alumno + '</td>';
            html += '<td>¢' + balanceArrayHijos[i].Monto_Mensual + '</td>';
            html += '<td>';
            html += '<a onclick="getStudent(' + balanceArrayHijos[i].id + ')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
            html += '</td>';
            html += '</tr>';
            $("#Viejos").append(html);
        }  
        for (var i = 0; i < balanceArrayNuevos.length ; i++) {
            var html = "";
            html += '<tr id="Prematriculado' + balanceArrayNuevos[i].id + '">';
            html += '<td>' + balanceArrayNuevos[i].Cedula_Alumno + '</td>';
            html += '<td>' + balanceArrayNuevos[i].Nombre_Alumno + '</td>';
            html += '<td>' + balanceArrayNuevos[i].Apellido1_Alumno + '</td>';
            html += '<td>' + balanceArrayNuevos[i].Apellido2_Alumno + '</td>';
            html += '<td>' + balanceArrayNuevos[i].Fecha_Nacimiento + '</td>';
            html += '<td>' + balanceArrayNuevos[i].Nivel_Alumno + '</td>';
            html += '<td>';
            html += '<a onclick="getNewStudent(' + balanceArrayNuevos[i].id + ')" data-toggle="modal" data-target="#myModalUpdateNewStudent" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
            html += '</td>';
            html += '</tr>';
            $("#Nuevos").append(html);
        }      
        if (balanceArray.length == 0) {
            $('#Content tr').remove();
            var html = '<tr class="no-result text-center"><td colspan="7">No hemos encontrado datos para esta familia</td></tr>';
            $("#Content").append(html);
        }else{            
            fountainG.style.display = "none";
            var allContainer = document.getElementById("allContainer");
            allContainer.style.display = "";
        }
        });
    }else{
        fountainG.style.display = "none";
        alert("Por favor seleccione una familia");
    }
}

function cargarCorreos(id) {
  var html = '';
  $.ajax({
    url:'/Administrativo/getEmails/'+id,
    data : {
        id:id
    }
  }).done(function (data) {
    var EmailsArray  =  data['Emails'];
    for (var a = 0; a < EmailsArray.length ; a++) {
        html += '<tr><td>'+ EmailsArray[a].Correo + '</td></tr>';
    }
    $('#Correo'+id).append(html);
  });
}

function cargarTelefonos(id) {
  var html = '';
  $.ajax({
    url:'/Administrativo/getPhones/'+id,
    data : {
        id:id
    }
  }).done(function (data) {
    var PhonesArray  =  data['Phones'];
    for (var a = 0; a < PhonesArray.length ; a++) {
        html += '<tr><td>'+ PhonesArray[a].Telefono + '</td></tr>';
    }
    $('#Telefono'+id).append(html);
  });
}

function clearTable () {
  $('#Encargados tr').remove();
  $('#Nuevos tr').remove();
  $('#Viejos tr').remove();
  var allContainer = document.getElementById("allContainer");
  allContainer.style.display = "none";
}

function getStudent(id) {
    clearTexts();
    $.ajax({
        url:'/administracion/'+id+'/getStudent',
        data : {
            id:id // Tupla
        }
    }).done(function (data) {
      clearTexts();
        var fountainG = document.getElementById("fountainGS");
        fountainG.style.display = "none";
        var balanceArray  =  data['Hijos'];
        var id = document.getElementById("txt_id");
        id.value = balanceArray[0].id;
        var cedula = document.getElementById("txt_Cedula_Update");
        cedula.value = balanceArray[0].Cedula_Alumno;
        var nombre = document.getElementById("txt_Nombre_Update");
        nombre.value = balanceArray[0].Nombre_Alumno;
        var apellido1 = document.getElementById("txt_Apellido1_Update");
        apellido1.value = balanceArray[0].Apellido1_Alumno;
        var apellido2 = document.getElementById("txt_Apellido2_Update");
        apellido2.value = balanceArray[0].Apellido2_Alumno;
        var nivel = document.getElementById("txt_Nivel_Update");
        nivel.value = balanceArray[0].Nivel_Alumno;
        var seccion = document.getElementById("txt_Seccion_Update");
        seccion.value = balanceArray[0].Seccion_Alumno;
        var monto = document.getElementById("txt_Monto_Update");
        monto.value = balanceArray[0].Monto_Mensual;
        var nacimiento = document.getElementById("txt_Nacimiento_Update");
        nacimiento.value = balanceArray[0].Fecha_Nacimiento;
    });
}

$( "#btnStudentUpdate" ).click(function() {
    var id = $('#txt_id').val();
    var cedula = $('#txt_Cedula_Update').val();
    var nombre = $('#txt_Nombre_Update').val();
    var apellido1 = $('#txt_Apellido1_Update').val();
    var apellido2 = $('#txt_Apellido2_Update').val();
    var nivel = $('#txt_Nivel_Update').val();
    var nacimiento = $('#txt_Nacimiento_Update').val();
    var mensual = $('#txt_Monto_Update').val();
    var seccion = $('#txt_Seccion_Update').val();
    $('#Hijos'+id).empty();
    var html = '<td colspan="7"><div id="fountainGNS" position: relative; width: 120px; height: 14px; margin: auto; margin-top: 1%;">';
    html += '<div id="fountainG_1" class="fountainG"></div>';
    html += '<div id="fountainG_2" class="fountainG"></div>';
    html += '<div id="fountainG_3" class="fountainG"></div>';
    html += '<div id="fountainG_4" class="fountainG"></div>';
    html += '<div id="fountainG_5" class="fountainG"></div>';
    html += '<div id="fountainG_6" class="fountainG"></div>';
    html += '<div id="fountainG_7" class="fountainG"></div>';
    html += '<div id="fountainG_8" class="fountainG"></div>';
    html += '</div></td>';
    $('#Hijos'+id).append(html);
    $.ajax({
      url:'/Administrativo/updateStudent2/'+ id,
      type: "PUT",
      data : {
        cedula:cedula,
        nombre:nombre,
        apellido1:apellido1,
        apellido2:apellido2,
        nacimiento:nacimiento,
        nivel:nivel,
        mensual:mensual,
        seccion:seccion
      }
    }).done(function (data) {
        var balanceArray  =  data;
        clearTexts();
        $('#Hijos'+id).empty();
        var html = '<td>' + balanceArray.Cedula_Alumno + '</td>';
        html += '<td>' + balanceArray.Nombre_Alumno + '</td>';
        html += '<td>' + balanceArray.Apellido1_Alumno + '</td>';
        html += '<td>' + balanceArray.Apellido2_Alumno + '</td>';
        html += '<td>' + balanceArray.Fecha_Nacimiento + '</td>';
        html += '<td>' + balanceArray.Seccion_Alumno + '</td>';
        html += '<td>' + balanceArray.Monto_Mensual + '</td>';
        html += '<td><a onclick="getStudent('+ id +')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a></td>';
        $('#Hijos'+id).append(html);
    });
});

function clearTexts() {
    var fountainG = document.getElementById("fountainGS");
    fountainG.style.display = "";
    var id = document.getElementById("txt_id");
    id.value = "";
    var cedula = document.getElementById("txt_Cedula_Update");
    cedula.value = "";
    var nombre = document.getElementById("txt_Nombre_Update");
    nombre.value = "";
    var apellido1 = document.getElementById("txt_Apellido1_Update");
    apellido1.value = "";
    var apellido2 = document.getElementById("txt_Apellido2_Update");
    apellido2.value = "";
    var nivel = document.getElementById("txt_Nivel_Update");
    nivel.value = "";
    var seccion = document.getElementById("txt_Seccion_Update");
    seccion.value = "";
    var monto = document.getElementById("txt_Monto_Update");
    monto.value = "";
    var nacimiento = document.getElementById("txt_Nacimiento_Update");
    nacimiento.value = "";
}

function clearTextsNewStudent() {
    var fountainG = document.getElementById("fountainGNS");
    fountainG.style.display = "";
    var id = document.getElementById("txt_id_Student");
    id.value = "";
    var cedula = document.getElementById("txt_Cedula_Update_Student");
    cedula.value = "";
    var nombre = document.getElementById("txt_Nombre_Update_Student");
    nombre.value = "";
    var apellido1 = document.getElementById("txt_Apellido1_Update_Student");
    apellido1.value = "";
    var apellido2 = document.getElementById("txt_Apellido2_Update_Student");
    apellido2.value = "";
    var nivel = document.getElementById("txt_Nivel_Update_Student");
    nivel.value = "";
    var seccion = document.getElementById("txt_Seccion_Update_Student");
    seccion.value = "";
    var monto = document.getElementById("txt_Monto_Update_Student");
    monto.value = "";
    var nacimiento = document.getElementById("txt_Nacimiento_Update_Student");
    nacimiento.value = "";
}

function clearTextsManager () {
    var fountainG = document.getElementById("fountainGM");
    fountainG.style.display = "";
    var id = document.getElementById("txt_id_padre");
    id.value = "";
    var cedula = document.getElementById("txt_Cedula_Update_Padre");
    cedula.value = "";
    var nombre = document.getElementById("txt_Nombre_Update_Padre");
    nombre.value = "";
    var apellido1 = document.getElementById("txt_Apellido1_Update_Padre");
    apellido1.value = "";
    var apellido2 = document.getElementById("txt_Apellido2_Update_Padre");
    apellido2.value = "";
    var direccion = document.getElementById("txt_Direccion_Update_Padre");
    direccion.value = "";
    $('#Correos').empty();
    $('#Correos').append('<label for="Correos" class="control-label">Correos</label>');
    $('#Telefonos').empty();
    $('#Telefonos').append('<label for="Telefonos" class="control-label">Teléfonos</label>');
}

function getManager(id) {
  clearTextsManager();
    $.ajax({
        url:'/administracion/'+id+'/getManager',
        data : {
            id:id // Tupla
        }
    }).done(function (data) {
        clearTextsManager();
        var fountainG = document.getElementById("fountainGM");
        fountainG.style.display = "none";
        var balanceArray  =  data['Encargados'];
        var id = document.getElementById("txt_id_padre");
        id.value = balanceArray[0].id;
        var cedula = document.getElementById("txt_Cedula_Update_Padre");
        cedula.value = balanceArray[0].Cedula;
        var nombre = document.getElementById("txt_Nombre_Update_Padre");
        nombre.value = balanceArray[0].Nombre;
        var apellido1 = document.getElementById("txt_Apellido1_Update_Padre");
        apellido1.value = balanceArray[0].Apellido1;
        var apellido2 = document.getElementById("txt_Apellido2_Update_Padre");
        apellido2.value = balanceArray[0].Apellido2;
        var direccion = document.getElementById("txt_Direccion_Update_Padre");
        direccion.value = balanceArray[0].Direccion;
        balanceArrayEmail = data['Usuarios_Correos'];
        var index;
        var html;
        for (index = 0; index < balanceArrayEmail.length; ++index) {
          html =  '<div class="form-group input-group">';
            html += '<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>';
      html += '<input class="form-control" id="Correo' + balanceArrayEmail[index].id + '" type="email" value="' + balanceArrayEmail[index].Correo + '" placeholder="correo@dominio.com">';
            html += '</div>';
            $('#Correos').append(html);
    }
        balanceArrayPhones = data['Usuarios_Telefonos'];
    for (index = 0; index < balanceArrayPhones.length; ++index) {
          html =  '<div class="form-group input-group">';
            html += '<span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>';
      html += '<input class="form-control" id="Telefono' + balanceArrayPhones[index].id + '" type="email" value="' + balanceArrayPhones[index].Telefono + '" placeholder="correo@dominio.com">';
            html += '</div>';
            $('#Telefonos').append(html);
    }
    });
}

$( "#btnManagerUpdate" ).click(function() {
    var idCedula = $('#txt_id_padre').val();
    var cedula = $('#txt_Cedula_Update_Padre').val();
    var nombre = $('#txt_Nombre_Update_Padre').val();
    var apellido1 = $('#txt_Apellido1_Update_Padre').val();
    var apellido2 = $('#txt_Apellido2_Update_Padre').val();
    var direccion = $('#txt_Direccion_Update_Padre').val();
    $('#Manager'+idCedula).empty();
    var html = '<td colspan="8"><div id="fountainGNS" position: relative; width: 120px; height: 14px; margin: auto; margin-top: 1%;">';
    html += '<div id="fountainG_1" class="fountainG"></div>';
    html += '<div id="fountainG_2" class="fountainG"></div>';
    html += '<div id="fountainG_3" class="fountainG"></div>';
    html += '<div id="fountainG_4" class="fountainG"></div>';
    html += '<div id="fountainG_5" class="fountainG"></div>';
    html += '<div id="fountainG_6" class="fountainG"></div>';
    html += '<div id="fountainG_7" class="fountainG"></div>';
    html += '<div id="fountainG_8" class="fountainG"></div>';
    html += '</div></td>';
    $('#Manager'+idCedula).append(html);
    $.ajax({
        url:'/administracion/updateManager/'+ idCedula,
        type: "PUT",
        data : {
            nombre:nombre,
            apellido1:apellido1,
            apellido2:apellido2,
            direccion:direccion,
        }
    }).done(function (data) {
        var balanceArray  =  data;
        var index;
        for (index = 0; index < balanceArrayEmail.length; ++index) {
          var id = balanceArrayEmail[index].id;
          var correo = $('#Correo'+id).val();
          $.ajax({
          url:'/administracion/updateManagerEmails/'+ id,
          type: "PUT",
          data : {
            correo:correo
          }
        }).done(function (data) {
                for (index = 0; index < balanceArrayPhones.length; ++index) {
                    var id = balanceArrayPhones[index].id;
                    var telefono = $('#Telefono'+balanceArrayPhones[index].id).val();
                    $.ajax({
                      url:'/administracion/updateManagerPhones/'+ id,
                      type: "PUT",
                      data : {
                        telefono:telefono
                      }
                    }).done(function (data) {

                        clearTexts();
                        $('#Manager'+idCedula).empty();
                        var html = '<td>' + balanceArray.Cedula + '</td>';
                        html += '<td>' + balanceArray.Nombre + '</td>';
                        html += '<td>' + balanceArray.Apellido1 + '</td>';
                        html += '<td>' + balanceArray.Apellido2 + '</td>';
                        html += '<td>' + balanceArray.Direccion + '</td>';
                        html += '<td style="padding:5px;"><table id="Correo'+balanceArray.Cedula+'"></table></td>';
                        html += '<td style="padding:5px;"><table id="Telefono'+balanceArray.Cedula+'"></table></td>';
                        html += '<td><a onclick="getManager('+ idCedula +')" data-toggle="modal" data-target="#myModalUpdateManager" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a></td>';
                        $('#Manager'+idCedula).append(html);
                        var id = balanceArray.Cedula
                        var html = '';
                        $.ajax({
                        url:'/Administrativo/getEmails/'+id,
                        data : {
                            id:id
                        }
                        }).done(function (data) {
                            var EmailsArray  =  data['Emails'];
                            for (var a = 0; a < EmailsArray.length ; a++) {
                                html += '<tr><td>'+ EmailsArray[a].Correo + '</td></tr>';
                            }
                            $('#Correo'+id).append(html);
                        });
                        var htmlTelefono = '';
                        $.ajax({
                        url:'/Administrativo/getPhones/'+id,
                        data : {
                            id:id
                        }
                        }).done(function (data) {
                            var PhonesArray  =  data['Phones'];
                            for (var a = 0; a < PhonesArray.length ; a++) {
                                htmlTelefono += '<tr><td>'+ PhonesArray[a].Telefono + '</td></tr>';
                            }
                            $('#Telefono'+id).append(htmlTelefono);
                        });
                    });
                }
        });
      }
    });
});

function getNewStudent(id) {
    clearTextsNewStudent();
    $.ajax({
        url:'/administracion/'+id+'/getNewStudent',
        data : {
            id:id // Tupla
        }
    }).done(function (data) {
      clearTextsNewStudent();
        var fountainG = document.getElementById("fountainGNS");
        fountainG.style.display = "none";
        var balanceArray  =  data['Prematriculado'];
        var id = document.getElementById("txt_id_Student");
        id.value = balanceArray[0].id;
        var cedula = document.getElementById("txt_Cedula_Update_Student");
        cedula.value = balanceArray[0].Cedula_Alumno;
        var nombre = document.getElementById("txt_Nombre_Update_Student");
        nombre.value = balanceArray[0].Nombre_Alumno;
        var apellido1 = document.getElementById("txt_Apellido1_Update_Student");
        apellido1.value = balanceArray[0].Apellido1_Alumno;
        var apellido2 = document.getElementById("txt_Apellido2_Update_Student");
        apellido2.value = balanceArray[0].Apellido2_Alumno;
        var nivel = document.getElementById("txt_Nivel_Update_Student");
        nivel.value = balanceArray[0].Nivel_Alumno;
        var nacimiento = document.getElementById("txt_Nacimiento_Update_Student");
        nacimiento.value = balanceArray[0].Fecha_Nacimiento;
    });
}

$( "#btnNewStudentUpdate" ).click(function() {
    var id = $('#txt_id_Student').val();
    var cedula = $('#txt_Cedula_Update_Student').val();
    var nombre = $('#txt_Nombre_Update_Student').val();
    var apellido1 = $('#txt_Apellido1_Update_Student').val();
    var apellido2 = $('#txt_Apellido2_Update_Student').val();
    var nacimiento = $('#txt_Nacimiento_Update_Student').val();
    var nivel = $('#txt_Nivel_Update_Student').val();
    var seccion = $('#txt_Seccion_Update_Student').val();
    var mensual = $('#txt_Monto_Update_Student').val();
    var codigofamilia = $('#select-family option:selected').attr('value');
    $('#Prematriculado'+id).empty();
    var html = '<td colspan="7"><div id="fountainGNS" position: relative; width: 120px; height: 14px; margin: auto; margin-top: 1%;">';
    html += '<div id="fountainG_1" class="fountainG"></div>';
    html += '<div id="fountainG_2" class="fountainG"></div>';
    html += '<div id="fountainG_3" class="fountainG"></div>';
    html += '<div id="fountainG_4" class="fountainG"></div>';
    html += '<div id="fountainG_5" class="fountainG"></div>';
    html += '<div id="fountainG_6" class="fountainG"></div>';
    html += '<div id="fountainG_7" class="fountainG"></div>';
    html += '<div id="fountainG_8" class="fountainG"></div>';
    html += '</div></td>';
    $('#Prematriculado'+id).append(html);
    if ((seccion == "") && (mensual == "")) {
        $.ajax({
            url:'/updateNewStudent/'+ id,
                type: "PUT",
                data : {
                cedula:cedula,
                nombre:nombre,
                apellido1:apellido1,
                apellido2:apellido2,
                nivel:nivel,
                nacimiento:nacimiento
            }
        }).done(function (data) {
            var balanceArray  =  data;
            clearTextsNewStudent();
            $('#Prematriculado'+id).empty();
            var html = '<td>' + balanceArray.Cedula_Alumno + '</td>';
            html += '<td>' + balanceArray.Nombre_Alumno + '</td>';
            html += '<td>' + balanceArray.Apellido1_Alumno + '</td>';
            html += '<td>' + balanceArray.Apellido2_Alumno + '</td>';
            html += '<td>' + balanceArray.Fecha_Nacimiento + '</td>';
            html += '<td>' + balanceArray.Nivel_Alumno + '</td>';
            html += '<td><a onclick="getNewStudent('+ id +')" data-toggle="modal" data-target="#myModalUpdateNewStudent" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a></td>';
            $('#Prematriculado'+id).append(html);
        });
    }else{
        $.ajax({
          url:'/storeStudent2',
          type: "POST",
          data : {
            id:id,
            cedula:cedula,
            codigofamilia:codigofamilia,
            nombre:nombre,
            apellido1:apellido1,
            apellido2:apellido2,
            nivel:nivel,
            seccion:seccion,
            mensual:mensual,
            nacimiento:nacimiento
          }
        }).done(function (data) {
            var balanceArray  =  data;
            clearTexts();
            var html = '<tr id="Hijos"' + balanceArray.id + '><td>' + balanceArray.Cedula_Alumno + '</td>';
            html += '<td>' + balanceArray.Nombre_Alumno + '</td>';
            html += '<td>' + balanceArray.Apellido1_Alumno + '</td>';
            html += '<td>' + balanceArray.Apellido2_Alumno + '</td>';
            html += '<td>' + balanceArray.Fecha_Nacimiento + '</td>';
            html += '<td>' + balanceArray.Nivel_Alumno + '</td>';
            html += '<td>' + balanceArray.Monto_Mensual + '</td>';
            html += '<td><a onclick="getStudent('+ balanceArray.id +')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a></td></tr>';
            $('#Prematriculado'+id).empty();
            $('#Viejos').append(html);
        });
    }
});

//

$( "#btnGuardarNuevo" ).click(function() {
    var codigofamilia = $('#codigofamilia').val();
    var cedula = $('#cedula').val();
    var nombre = $('#nombre').val();
    var apellido1 = $('#apellido1').val();
    var apellido2 = $('#apellido2').val();
    var nivel = $('#nivel').val();
    var nacimiento = $('#nacimiento').val();
    var html = '<td id="carga" colspan="7"><div id="fountainGNS" position: relative; width: 120px; height: 14px; margin: auto; margin-top: 1%;">';
    html += '<div id="fountainG_1" class="fountainG"></div>';
    html += '<div id="fountainG_2" class="fountainG"></div>';
    html += '<div id="fountainG_3" class="fountainG"></div>';
    html += '<div id="fountainG_4" class="fountainG"></div>';
    html += '<div id="fountainG_5" class="fountainG"></div>';
    html += '<div id="fountainG_6" class="fountainG"></div>';
    html += '<div id="fountainG_7" class="fountainG"></div>';
    html += '<div id="fountainG_8" class="fountainG"></div>';
    html += '</div></td>';
    $('#tbody').append(html);
    $.ajax({
        url:'/storeNewStudent',
            type: "POST",
            data : {
                codigofamilia:codigofamilia,
                cedula:cedula,
                nombre:nombre,
                apellido1:apellido1,
                apellido2:apellido2,
                nivel:nivel,
                nacimiento:nacimiento
        }
    }).done(function (data) {
        var balanceArray  =  data;
        clearTextsNewStudent();
        $('#carga').empty();
        var html = '<tr id="Prematriculado' + balanceArray.id + '">';
        html += '<td>' + balanceArray.Cedula_Alumno + '</td>';
        html += '<td>' + balanceArray.Nombre_Alumno + '</td>';
        html += '<td>' + balanceArray.Apellido1_Alumno + '</td>';
        html += '<td>' + balanceArray.Apellido2_Alumno + '</td>';
        html += '<td>' + balanceArray.Fecha_Nacimiento + '</td>';
        html += '<td>' + balanceArray.Nivel_Alumno + '</td>';
        html += '<td><a onclick="getNewStudent('+ balanceArray.id +')" data-toggle="modal" data-target="#myModalUpdateNewStudent" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a></td></tr>';
        $('#tbody').append(html);
    });
});

$( "#btnAcepta" ).click(function() {
    var codigofamilia = $('#select-family option:selected').attr('value');
    $.ajax({
        url:'/finishFamily',
            type: "POST",
            data : {
                codigofamilia:codigofamilia
        }
    }).done(function (data) {
        window.location.href = '/Administrativo/prematricula';
    });
});