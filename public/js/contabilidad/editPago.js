$("input[id=MontoPagado]").keyup(function(){
	var Monto 		= $("#Monto").val();
	var MontoPagado	= $("#MontoPagado").val();
	if( Monto == MontoPagado){
		$("#pwmatch").removeClass("glyphicon-remove");
		$("#pwmatch").addClass("glyphicon-ok");
		$("#pwmatch").css("color","#00A41E");
		$("#pwmatch").text(" Monto Completo");
		$("#Diferencia").val("0");
		$("#Recargo").val("0");
		resultDate();
	}else{
		$("#pwmatch").removeClass("glyphicon-ok");
		$("#pwmatch").addClass("glyphicon-remove");
		$("#pwmatch").css("color","#FF0004");
		$("#pwmatch").text(" Monto Incompleto");
		$("#Diferencia").val(parseInt($("#Monto").val()) - parseInt($("#MontoPagado").val()));
		$("#Recargo").val(parseInt($("#Diferencia").val()) * 0.15);
		resultDate();
	}
});

$( "#select-month" ).change(function() {
	resultDate();
});


function resultDate()
{
	var currentOCh		= $("#Recargo1").val()
	var lastDayPay		= $("#Fecha_Pago1").val();
  	var lastDayPay		= new Date(lastDayPay.slice(3, 5) + "/" + lastDayPay.slice(0, 2) + "/" + lastDayPay.slice(6, 10));
	var month 			= $('#select-month option:selected').attr('value');
	var today 			= new Date();
	var limitDay 		= new Date(today.getYear() + 1900, today.getMonth(), 15);
	var lastDay 		= new Date(today.getYear() + 1900, today.getMonth() + 1, 0);
	var firstDay		= new Date(today.getYear() + 1900, today.getMonth(), 1);
	var dayOfPay		= $("#Fecha_Pago").val();
	var currentMonth	= dayOfPay.slice(3, 5);
	var dayOfPay		= new Date(dayOfPay.slice(3, 5) + "/" + dayOfPay.slice(0, 2) + "/" + dayOfPay.slice(6, 10));
	var Diferencia 			= $("#Diferencia").val();
	if ( currentOCh == Diferencia) {
		$("#Recargo").val(0);
		var Descripcion = $("#Descripcion").val();
		if (!Descripcion.includes(', monto pendiente corresponde al recargo.')) {
			Descripcion += ', monto pendiente corresponde al recargo.';
		};
		$("#Descripcion").val(Descripcion);
	}else{
		var RecargoOriginal = (parseInt($("#Monto").val()) - parseInt($("#MontoPagado").val())) * 0.15;
		if (isNaN(RecargoOriginal)) {
			RecargoOriginal = 0;
		};
		var nDayOfPay 		= Number(dayOfPay);
		var nLimitDay 		= Number(limitDay);
		var nLastDay		= Number(lastDay);
		if ( nDayOfPay > nLimitDay) {
			if (nDayOfPay < nLastDay){
				if (Number(currentMonth) >= Number(month)) {
					var Recargo = parseInt($("#Monto").val()) * 0.15;
					var RecargoFinal = parseInt(RecargoOriginal) + parseInt(Recargo);
					$("#Recargo").val(RecargoFinal);
					if (Number(lastDayPay) < Number(firstDay)) {
						$("#Recargo").val(currentOCh);
					};
				}else{
					$("#Recargo").val(RecargoOriginal);
				}
			}else{
				$("#Recargo").val(RecargoOriginal);
			}
		}else{
			$("#Recargo").val(RecargoOriginal);
		}
	}
};
