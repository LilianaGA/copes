'use strict';

/*
Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
*/
$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">Resultados no encontrados</td></tr>'));
        }
    });
});

$(document).on('change','#select-family',function(){
   var id = $('#select-family option:selected').attr('value');
  if (id == 0) {
    ajaxToLoadFamily('T');
  }else{
    ajaxToLoadFamily('F');
  }
});

function ajaxToLoadFamily (estado) {
    $.ajax({
    url:'/Administrativo/statusFamily/'+estado,
    data : {
      estado:estado
    }
    }).done(function (data) {
        $('#Content tr').remove();
        var familiaArray  =  data['Familias'];
        for (var i = 0; i < familiaArray.length ; i++) {
            var html = '<tr>';
            html += '<td> ' + familiaArray[i].Codigo_Familia + '</td>';
            html += '<td>' + familiaArray[i].Apellido1 + '</td>';
            html += '<td>' + familiaArray[i].Apellido2 + '</td>';
            html += '<td>';
            html += '<div class="ui-group-buttons">';
            if (estado == 'T') {
                html += '<a href="/Administrativo/' + familiaArray[i].Codigo_Familia + '/showFamily" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open"></span></a>';
                html += '<div class="or"></div>';
                html += '<a href="/Administrativo/' + familiaArray[i].id + '/editFamily" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-edit"></span></a>';
                html += '<div class="or"></div>';
                html += '<a href="/Administrativo/' + familiaArray[i].id + '/deleteFamily" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-unchecked"></span></a>';
            }else{
                html += '<a href="/Administrativo/' + familiaArray[i].Codigo_Familia + '/showFamily" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open"></span></a>';
                html += '<div class="or"></div>';
                html += '<a href="/Administrativo/' + familiaArray[i].id + '/activeFamily" class="btn btn-info" role="button"><span class="glyphicon glyphicon-check"></span></a>';
            }
            html += '</div>';
            html += '</td>';
            html += '</tr>';
            $("#Content").append(html);    
        }
        if (familiaArray.length <= 0 ) {
             $("#Content").append('<tr class="no-result text-center"><td colspan="4">Resultados no encontrados</td></tr>');
        }
    });
}


