
function calculate() {
  var id = $('#select-month option:selected').attr('value');
  ocultar();
    if (id !== "0") {
      document.getElementById('proceso').style.display = "";
      $.ajax({
      url:'/contabilidad/calculateNotPaidAccount/'+id+'/N',
      data : {
        id:id
      }
      }).done(function (data) {
        if (data == true) {
          document.getElementById('proceso').style.display = "none";
          document.getElementById('procesado').style.display = "";
        }else{
          document.getElementById('proceso').style.display = "none";
          document.getElementById('noDatos').style.display = "";
        }
      });
    }
}

function calculateEmails() {
  var id = $('#select-month option:selected').attr('value');
  ocultar();
    if (id !== "0") {
      document.getElementById('proceso').style.display = "";
      $.ajax({
      url:'/contabilidad/calculateNotPaidAccount/'+id+'/S',
      data : {
        id:id
      }
      }).done(function (data) {
        if (data == true) {
          document.getElementById('proceso').style.display = "none";
          document.getElementById('procesado').style.display = "";
        }else{
          document.getElementById('proceso').style.display = "none";
          document.getElementById('noDatos').style.display = "";
        }
      });
    }
}

function ocultar () {
  document.getElementById('proceso').style.display = "none";
  document.getElementById('procesado').style.display = "none";
  document.getElementById('noDatos').style.display = "none";
}
