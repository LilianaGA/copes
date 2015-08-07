$( document ).ready(function() {

});
//get the id and load groups and subjects
$( "#select-student" ).change(function() {
  var id = $('#select-student option:selected').attr('value');
  clearTeacher();
  ajaxToLoadGroup(id);
  ajaxToLoadSubject(id);
});

function ajaxToLoadGroup (id) {
  if (id !== "0") {
    $.ajax({
    url:'/contabilidad/getGroup/'+id,
    data : {
      id:id
    }
    }).done(function (data) {
      selectGroup(data);
    });
  }
}
//set text of group
function selectGroup (data) {
  var appointmentsArray  =  data['Seccion'];
  var selectedItem       =  appointmentsArray[0].Seccion_Alumno;
  $('#spanGroup').val(selectedItem);
}

function ajaxToLoadSubject (id) {
  clearSubjects();
  if (id !== "0") {
    $.ajax({
    url:'/contabilidad/searchSubject/'+id,
    data : {
      id:id
    }
    }).done(function (data) {
      createSubjects(data);
    });
  }
}
//create options with subjects
function createSubjects (data) {
  var subjectsArray  =  data['Materia'];
  for (var i = 0; i < subjectsArray.length ; i++) {
    $("#select-subject").append('<option value='+subjectsArray[i].Cedula_Usuarios+' data-icon="glyphicon-link">'+subjectsArray[i].Materia+'</option>'); 
  }
}
//remove all items from subjects
function clearSubjects () {
  $('#select-subject').find('option:not(:first)').remove();
}

$( "#select-subject" ).change(function() {
  var id = $('#select-subject option:selected').attr('value');
  ajaxToLoadTeacher(id);
});

function ajaxToLoadTeacher (id) {
  //clearSubjects();
  if (id !== "0") {
    $.ajax({
    url:'/Administrativo/searchTeacher/'+id,
    data : {
      id:id
    }
    }).done(function (data) {
      //createSubjects(data);
      selectTeacher(data);
    });
  }
  else{
    clearTeacher();
  }
}

function selectTeacher (data) {
  var teacherArray  =  data['Profesor'];
  var name          = teacherArray[0].Nombre ;
  var lastName1     = teacherArray[0].Apellido1;
  var lastName2     = teacherArray[0].Apellido2;
  var finalName     = name  + " " + lastName1 + " " + lastName2;
  $('#spanProfesor').val(finalName);
}

function clearTeacher (argument) {
  $('#spanProfesor').val("");
}

