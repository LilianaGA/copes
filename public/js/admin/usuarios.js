function getFamily() {
    var id = $('#select-family option:selected').attr('value');
    if (id !== "0") {
        $('#Content tr').remove();
        $.ajax({
            url:'/Administrativo/getFamily/'+id,
            data : {
                id:id
            }
        }).done(function (data) {
        var balanceArray  =  data['Familia'];
        for (var i = 0; i < balanceArray.length ; i++) {
            var html = "";
            html += '<tr>';
            html += '<td style="padding:5px;">' + balanceArray[i].Codigo_Familia + '</td>';
            html += '<td style="padding:5px;">' + balanceArray[i].Cedula + '</td>';
            html += '<td style="padding:5px;"> ' + balanceArray[i].Nombre + ' ' + balanceArray[i].Apellido1 + ' ' + balanceArray[i].Apellido2 + '</td>';
            var cedula = balanceArray[i].Cedula;
            html += '<td style="padding:5px;"><table  id="Correo'+ cedula + '"">';
            html += '</table></td>';
            html += '<td style="padding:5px;"><table  id="Telefono'+ cedula + '"">';
            html += '</table></td>';
            html += '<td style="padding:5px;"><div class="ui-group-buttons">';
            html += '<a href="/Administrativo/' + balanceArray[i].id + '" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open"></span></a>';
            html += '<div class="or"></div>';
            html += '<a href="/Administrativo/' + balanceArray[i].id + '/edit" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
            html += '<div class="or"></div>';
            var estado = balanceArray[i].Estado;
            if (balanceArray[i].estado == "T") {
                html += '<a href="/Administrativo/' + balanceArray[i].id + '/eliminar"  class="btn btn-primary" role="button"><span class="glyphicon glyphicon-unchecked"></span></a>';
            }else{
                html += '<a href="/Administrativo/' + balanceArray[i].id + '/habilitar"  class="btn btn-info" role="button"><span class="glyphicon glyphicon-check"></span></a>';
            };
            html += '</div></td>';
            html += '</tr>';
            $("#Content").append(html);
            cargarCorreos(cedula);
            cargarTelefonos(cedula);
        }        
        if (balanceArray.length == 0) {
            $('#Content tr').remove();
             var html = '<tr class="no-result text-center"><td colspan="7">No hemos encontrado datos para esta familia</td></tr>';
             $("#Content").append(html);
        }
        });
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
     $('#Content tr').remove();
     var html = '<tr class="no-result text-center"><td colspan="7">Debe seleccionar primero la familia</td></tr>';
     $("#Content").append(html);   
}