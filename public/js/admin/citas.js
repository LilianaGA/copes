
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'ReporteMensuales', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Reportes de Pagos</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="css/contabilidad/reportes.css" type="text/css" />');
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
    $('#confirm').click(function(event){
        event.preventDefault();
        var id = $(this).attr('href');
        if (confirm('¿Está seguro?')) {
            var ruta = '/administracion/' +  id;
            window.location.replace(ruta);
        }
    });