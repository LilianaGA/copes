$('#confirm').click(function(event){
    event.preventDefault();
    var id = $(this).attr('href');
    if (confirm('¿Está seguro que desea cancelar la cita?')) {
        window.location.replace(id);
    }
});