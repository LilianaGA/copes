'use strict';

function createNewIdForGroupSpan () {
	$("span:contains('Seleccione por Sección')").attr("id", "spanGroup");
}

$("input[type=text]").keyup(function(){

if($("#Monto").val() == $("#MontoPagado").val()){
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

$( "#select-student" ).change(function() {
  	var id = $('#select-student option:selected').attr('value');
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
});

function selectGroup (data) {
	var appointmentsArray  =  data['Seccion'];
	var selectedItem       =  appointmentsArray[0].Seccion_Alumno;
	var monthlyItem       =  appointmentsArray[0].Monto_Mensual;
	$('#spanGroup').val(selectedItem);
	$('#Monto').val(monthlyItem);
	//$('#select-group option[value='+selectedItem+']').attr('selected','selected');
};


$( "#select-month" ).change(function() {
	resultDate();
});

function resultDate()
{
  	var month 			= $('#select-month option:selected').attr('value');
	var today 			= new Date();
	var limitDay 		= new Date(today.getYear() + 1900, today.getMonth(), 15);
	var lastDay 		= new Date(today.getYear() + 1900, today.getMonth() + 1, 0);
	var dayOfPay		= $("#Fecha_Pago").val();
	var currentMonth	= dayOfPay.slice(3, 5);
	var dayOfPay		= new Date(dayOfPay.slice(3, 5) + "/" + dayOfPay.slice(0, 2) + "/" + dayOfPay.slice(6, 10));
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
			}else{
				$("#Recargo").val(RecargoOriginal);
			}
		}else{
			$("#Recargo").val(RecargoOriginal);
		}
	}else{
		$("#Recargo").val(RecargoOriginal);
	}
};