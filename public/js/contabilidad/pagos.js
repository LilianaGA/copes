'use strict'
$(document).ready(function () {
    $("span:contains('Seleccione un Mes')").attr("id", "spanMonth");
    $("span:contains('Seleccione una Familia')").attr("id", "spanFamily");
    $("span:contains('Seleccione un Estudiante')").attr("id", "spanStudent");
    document.getElementById("select_month_chosen").style.width = "100%";;
    document.getElementById("select_family_chosen").style.width = "100%";
    document.getElementById("select_student_chosen").style.width = "100%";
});

$(document).on('change','#select-month', function(){
    var id = $('#select-month option:selected').attr('value');
    $('#Content tr').remove();
    //clearSpanStudent();  
    //clearSpanFamily();
    if (id !== "0") {
		$.ajax({
  			url:'/contabilidad/getPaysOfMonth/'+id,
      		data : {
        		id:id
      		}
      	}).done(function (data) {
       		ajaxToLoadPays(data);
      	});
    }
});

$(document).on('change','#select-family', function(){
    var id = $('#select-family option:selected').attr('value');
    $('#Content tr').remove();
    //clearSpanMonth();
    //clearSpanStudent();  
    if (id !== "0") {
        $.ajax({
            url:'/contabilidad/getPaysOfFamily/'+id,
            data : {
                id:id
            }
        }).done(function (data) {
            ajaxToLoadPays(data);
        });
    }
});

$(document).on('change','#select-student', function(){
    var id = $('#select-student option:selected').attr('value');
    $('#Content tr').remove();
    //clearSpanMonth();  
    //clearSpanFamily();
    if (id !== "0") {
        $.ajax({
            url:'/contabilidad/getPaysOfStudent/'+id,
            data : {
                id:id
            }
        }).done(function (data) {
            ajaxToLoadPays(data);
        });
    }
});

function ajaxToLoadPays(data) {
    
    var balanceArray  =  data['Pagos'];
    var aux = 0;
    for (var i = 0; i < balanceArray.length ; i++) {
        aux = 1;
        var html = "";
        var fecha = balanceArray[i].Fecha_Pago;
        fecha = fecha.replace("-", "/");
        fecha = fecha.replace("-", "/");
        var today = new Date(balanceArray[i].Fecha_Pago);
        var dateString = "";
        if (today.getDate() < 10) {
            dateString = '0' + today.getDate();
        }else{
            dateString = today.getDate();
        }
        dateString += "-";
        if ((today.getMonth() + 1)< 10) {
            dateString += '0' + (today.getMonth() + 1);
        }else{
            dateString += (today.getMonth() + 1);
        }
        dateString += "-" + today.getFullYear();
        var locale = 'de';
        var options = {minimumFractionDigits: 0, maximumFractionDigits: 0};
        var formatter = new Intl.NumberFormat(locale, options);
        var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        html += '<tr>';
        html += '<td>' + balanceArray[i].Nombre_Alumno + ' ' + balanceArray[i].Apellido1_Alumno + '</td>';
        html += '<td>' + balanceArray[i].Seccion_Alumno +'</td>';
        html += '<td>' + balanceArray[i].Numero_Recibo_Banco + '</td>';
        html += '<td>' + dateString + '</td>';
        html += '<td>' + meses[balanceArray[i].Mensualidad  - 1] + ' </td>';
        html += '<td>';
        html += '<div class="ui-group-buttons">';
		html += '<a href="/contabilidad/'+ balanceArray[i].id + '" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open"></span></a>';
        html += '<div class="or"></div>';
        html += '<a href="/contabilidad/'+ balanceArray[i].id + '/editar" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
		html += '<div class="or"></div>';
		html += '<a href="/contabilidad/'+ balanceArray[i].id + '/eliminarPago" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-trash"></span></a>';
        html += '</div>';
        html += '</td>';
        html += '<tr>';
        $("#Content").append(html);    
    }
    if (aux == 0) {
        $("#Content").append('<tr class="no-result text-center"><td colspan="6">Resultados no encontrados</td></tr>');       
    };
 }

function clearTable() {
     $('#Content tr').remove();
     var html = '<tr class="no-result text-center"><td colspan="6">Debe seleccionar primero un filtro</td></tr>';
     $("#Content").append(html);   
}

function clearSpanMonth () {
    $('#spanMonth').empty();
    $('#spanMonth').append('Seleccione un Mes');
}

function clearSpanFamily () {
    $('#spanFamily').empty();
    $('#spanFamily').append('Seleccione una Familia');
}

function clearSpanStudent () {
    $('#spanStudent').empty();
    $('#spanStudent').append('Seleccione un Estudiante');
}

function confirmar (id) {
    event.preventDefault();
    if (confirm('¿Está seguro que desea borrar?')) { 
        window.location.replace('/contabilidad/' + id + '/eliminarPago');
    }
}