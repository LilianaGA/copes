$(document).on('click', 'span.clickable', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '.panel div.clickable', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).ready(function () {
    $('.panel-heading span.clickable').click();
    $('.panel div.clickable').click();
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
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});

function getFamilyBalance() {
    var id = $('#select-family option:selected').attr('value');
    if (id !== "0") {
        $('#Content tr').remove();
        $.ajax({
            url:'/contabilidad/getFamilyBalance/'+id,
            data : {
                id:id
            }
        }).done(function (data) {
        var balanceArray  =  data['Saldos'];
        for (var i = 0; i < balanceArray.length ; i++) {
            var html = "";
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
            html += '<tr>';
            html += '<td> ' + balanceArray[i].Nombre_Alumno + ' ' + balanceArray[i].Apellido1_Alumno + ' ' + balanceArray[i].Apellido2_Alumno + '</td>';
            html += '<td>' + dateString + '</td>';
            html += '<td>' + balanceArray[i].Descripcion + '</td>';
            html += '<td>¢' + formatter.format(balanceArray[i].Monto_Mensual) + '</td>';
            html += '<td>¢' + formatter.format(balanceArray[i].Monto_Recibo) + '</td>';
            html += '<td>¢' + formatter.format(balanceArray[i].Recargo) + '</td>';
            html += '<td>¢' + formatter.format(balanceArray[i].Diferencia) + '</td>';
            html += '</tr>';
            $("#Content").append(html);    
        }        
        if (balanceArray.length == 0) {
            $('#Content tr').remove();
             var html = '<tr class="no-result text-center"><td colspan="7">No hemos encontrado datos para esta familia</td></tr>';
             $("#Content").append(html);
        }
        });
    }
}

function clearTable () {
     $('#Content tr').remove();
     var html = '<tr class="no-result text-center"><td colspan="7">Debe seleccionar primero la familia</td></tr>';
     $("#Content").append(html);   
}
