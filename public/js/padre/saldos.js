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

    $('#confirm').click(function(event){  //cancelacion de la cita
        event.preventDefault();
        var id = $(this).attr('value');
        if (id !== "0") {
        $.ajax({
          url:'/padre/citas/'+id,
          data : {
            id:id
          }
          }).done(function (data) {
            var responsed = data['Citas'];
            var today = new Date();
            var cita = new Date(responsed[0].Fecha_Cita);
            cita.setDate(cita.getDate() -1); 
            if (today.getTime() < cita.getTime()) {
                if (confirm('¿Está seguro que desea cancelar la cita?')) {
                    window.location.replace('/padre/' + id);
                }
            }else{
                alert('La cita no puede ser cancelada, durante las 24 horas previas.');
            }
          });
        }
    });
});