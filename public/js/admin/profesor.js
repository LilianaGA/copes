$( document ).ready(function() {

});

function confirmar (id) {
    event.preventDefault();
    if (confirm('¿Está seguro que desea borrar?')) { 
        deleteSubject(id);
    }
}

$( "#btnMateria" ).click(function() {
  var id = $('#select-profesor option:selected').attr('value');
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
        getSubjects();
        var materia = document.getElementById("txt_Materia");
        materia.value = "";
        var seccion = document.getElementById("txt_Seccion");
        seccion.value = "";
    });
});

$( "#btnMateriaUpdate" ).click(function() {
  var id = $('#txt_id').val();
  var materia = $('#txt_Materia_Update').val();
  var seccion = $('#txt_Seccion_Update').val();
  $.ajax({
      url:'/Administrativo/updateMateria/'+id+'/'+materia+'/'+seccion,
      data : {
        cedula:id,
        materia:materia,
        seccion:seccion
      }
    }).done(function (data) {
        getSubjects();
        var materia = document.getElementById("txt_Materia_Update");
        materia.value = "";
        var seccion = document.getElementById("txt_Seccion_Update");
        seccion.value = "";
    });
});

function getSubjects() {
    var id = $('#select-profesor option:selected').attr('value');
    if (id !== "0") {
        $('#Content tr').remove();
        $.ajax({
            url:'/Administrativo/getSubjects/'+id,
            data : {
                id:id
            }
        }).done(function (data) {
        var balanceArray  =  data['Materias'];
        var html = "";
        for (var i = 0; i < balanceArray.length ; i++) {
            html = "<tr><td>";
            html +=  balanceArray[i].Materia;
            html += '</td>';
            html += "<td>";
            html +=  balanceArray[i].Seccion;
            html += '</td>';
            html += '<td><div class="ui-group-buttons">';
            html += '<a onclick="editSubject('+balanceArray[i].id+')" data-toggle="modal" data-target="#myModalUpdate" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
            html += '<div class="or"></div>';
            html += '<a onclick="confirmar('+balanceArray[i].id+')" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>';
            html += '</div></td></tr>';
            $("#Content").append(html);
            document.getElementById("nuevo").disabled = false;
        }        
        if (balanceArray.length == 0) {
            var html = '<tr class="no-result text-center"><td colspan="3">No hemos encontrado datos para este(a) docente</td></tr>';
            $("#Content").append(html);
            //document.getElementById("nuevo").disabled = true;
        }
        });
    }else{
        document.getElementById("nuevo").disabled = true;
    }
}

function deleteSubject(id) {
    $.ajax({
        url:'/Administrativo/'+id+'/eliminarMateria',
        data : {
            id:id
        }
    }).done(function (data) {
        getSubjects();
    });
}

function editSubject(id) {
    $.ajax({
        url:'/Administrativo/'+id+'/searchSubject',
        data : {
            id:id
        }
    }).done(function (data) {
        var balanceArray  =  data['Materias'];
        var id = document.getElementById("txt_id");
        id.value = balanceArray[0].id;
        var materia = document.getElementById("txt_Materia_Update");
        materia.value = balanceArray[0].Materia;
        var seccion = document.getElementById("txt_Seccion_Update");
        seccion.value = balanceArray[0].Seccion;
    });
}
