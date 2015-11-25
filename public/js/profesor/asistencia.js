function getClassRoom () {
  clearTable();
  var seccion = $('#select-family option:selected').attr('value');
  $('#list-group').empty();
  if (seccion !== "0") {
    var fountainG = document.getElementById("fountainG");
    fountainG.style.display = "";
    $.ajax({
      url:'/profesor/getStudents/' + seccion,
      data : {
          seccion:seccion
        }
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
          var fountainG = document.getElementById("fountainG");
          fountainG.style.display = "none";
          var allContainer = document.getElementById("allContainer");
          allContainer.style.display = "";
      });
  }
}

function clearTable () {
  var fountainG = document.getElementById("fountainG");
  fountainG.style.display = "none";
  var allContainer = document.getElementById("allContainer");
  allContainer.style.display = "none";
  var Message = document.getElementById("Message");
  Message.style.display = "none";
  $('#list-group').empty();
  $('#mensaje').empty();
}

function send () {
  var fountainG = document.getElementById("fountainG");
  fountainG.style.display = "";
  var allContainer = document.getElementById("allContainer");
  allContainer.style.display = "none";
  var arr = [];
  var inputElements = document.getElementsByClassName('messageCheckbox');
  for(var i=0; inputElements[i]; ++i){
    if(!inputElements[i].checked){
     arr.push(inputElements[i].getAttribute('cedula'));
    }
  }
  if (arr != "") {
    $.ajax({
      url:'/profesor/sendClassList/' + arr,
      data : {
          arr:arr
      }
    }).done(function (data) {
      var confirmacion = data['Respuesta'];
      clearTable();
      var Message = document.getElementById("Message");
      Message.style.display = "";
      if (confirmacion == 'Successfull'){
        $('#mensaje').append('Correo enviado correctamente.');
      }else{
        $('#mensaje').append('No pudimos enviar el correo, por favor enviarlo de nuevo en unos minutos.');
      };
    });
  }else{
    clearTable();
    var Message = document.getElementById("Message");
    Message.style.display = "";
    $('#mensaje').append('No existen estudiantes ausentes.');
  }
}