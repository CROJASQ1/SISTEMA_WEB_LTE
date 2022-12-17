$(document).ready(function(){
  $('#plantilla_caso').val($('#tipo_select').val());
  var idplantilla = parseInt($('#idplantilla_select').val());
  if ($('#id_campos_select').val().trim().length > 0) {
    var campos = $('#id_campos_select').val().split('|');
    // console.log(campos);
    for(var i = 0; i < campos.length; i++){
      // console.log('#switch-'+campos[i]);
      $('#switch-'+campos[i]).prop('checked',true);
      var campo = new listacampo(parseInt(campos[i]));
      plantillascampos.push(campo);
    }
    // console.log(plantillascampos);
  } else {
    // console.log("plantilla sin listados.");
  }
});

var plantillascampos=[];
function listacampo(idca){
  this.idca = idca;
}
function seleccionar(ic) {
  //   console.log(ig,ic); 
  var sw_ex = true; var pos_elim = 0;
  for (var i = 0; i < plantillascampos.length; i++) {
    if (parseInt(plantillascampos[i].idca) == parseInt(ic) ) {
        console.log('si existe'); sw_ex = false;  pos_elim = i;  i = plantillascampos.length; 
    }
  }
  if (sw_ex) {
    var campo = new listacampo(ic);
    plantillascampos.push(campo);
  } else {
    plantillascampos.splice(pos_elim,1);
  }
  //   console.log(plantillascampos);
}
function editarplantilla(){
    $("#edit_plantilla").attr("disabled", true);
    $("#add_plantilla").attr("disabled", true);
    var idplanti = document.getElementById('idplantilla_select').value;
    var plantilla = document.getElementById('plantilla').value;
    var caso  = document.getElementById('plantilla_caso').value;
    if (plantilla.trim().length > 0) {
      var myJsonString = JSON.stringify(plantillascampos);
      console.log("mandando",myJsonString);
      var request = $.ajax({ method : 'POST', url : 'editar.php', dataType : 'json', data : { dato: myJsonString, maestro: plantilla, caso: caso, idplantilla: idplanti}});
        request.done(function(response) {
          if(response.status) {
            alert('Success: ' + response.result + "\n Message: " + response.message);
            window.location.href = '';
          } else { alert('Error: '+response.message+"\n"+response.avisos);
          $("#add_plantilla").attr("disabled", false);
          $("#edit_plantilla").attr("disabled", false);}
        });
        request.fail(function(jqXHR, textStatus) {
        console.log(jqXHR);
        alert("Server request failed: " + textStatus);
        $("#add_plantilla").attr("disabled", false);
        $("#edit_plantilla").attr("disabled", false);
        console.log("activando boton 4");
      });
    } else {
      alert('Requiere un título la plantilla');
      $("#add_plantilla").attr("disabled", false);
      $("#edit_plantilla").attr("disabled", false);
    }
}

function guardarplantilla(){
  $("#add_plantilla").attr("disabled", true);
  $("#edit_plantilla").attr("disabled", true);
  var plantilla = document.getElementById('plantilla').value;
  var caso  = document.getElementById('plantilla_caso').value;
  if (plantilla.trim().length > 0) {
    var myJsonString = JSON.stringify(plantillascampos);
    console.log("mandando",myJsonString);
    var request = $.ajax({ method : 'POST', url : 'guardar.php', dataType : 'json', data : { dato: myJsonString, maestro: plantilla, caso: caso} });
      request.done(function(response) {
        if(response.status) {
          alert('Success: ' + response.result + "\n Message: " + response.message);
          window.location.href = '';
        } else { alert('Error: '+response.message+"\n"+response.avisos); 
        $("#add_plantilla").attr("disabled", false);
        $("#edit_plantilla").attr("disabled", false);}
      });
      request.fail(function(jqXHR, textStatus) {
      console.log(jqXHR);
      alert("Server request failed: " + textStatus);
      $("#add_plantilla").attr("disabled", false);
      $("#edit_plantilla").attr("disabled", false);
      console.log("activando boton 4");
    });
  } else {
    alert('Requiere un título la plantilla');
    $("#add_plantilla").attr("disabled", false);
    $("#edit_plantilla").attr("disabled", false);
  }
}