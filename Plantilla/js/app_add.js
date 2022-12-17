// document.addEventListener("DOMContentLoaded", () =>{
//     let form = document.getElementById("crear_paciente");
//     form.addEventListener("submit",function(event){
//         event.preventDefault();
//         crear_paciente(this);
//     });
// });

function crear_paciente(form){
    const peticion = new XMLHttpRequest();
        var data=new FormData();
        data=getFormData("crear_paciente",data); 
        for (var value of data.values()) {
            console.log(value); 
        }   
        peticion.open("POST","crear_paciente.php");
        peticion.send(data);
        peticion.onload = function () {
        console.log("respuesta:"+this.responseText);
          if(this.responseText==1){
                $("#modal_respuesta").modal('show');  
          }else{
                if(this.responseText==2){
                    
                    $("#errores").html("<div class='alert alert-danger'>Error!</div");
                   
                }
          }
        };  
}
        function getFiles(variable_archivo)
        {
                var idFiles=document.getElementById(variable_archivo); 
                var archivo=idFiles.files;
                var data=new FormData();
                for(var i=0;i<archivo.length;i++)
                {
                    data.append("archivo"+i,archivo[i]);
                }
                return data;
        }
        
        function getFormData(id,data)
        {
        
          $("#"+id).find("input,select").each(function(i,v) {
                if(v.type!=="file") {
                    if(v.type==="checkbox" && v.checked===true) {
                        data.append(v.name,"on");
                    }else{  
                        console.log("nombre:"+v.name+"valor:"+v.value);
                        data.append(v.name,v.value);
                    }
                }
          });

          $("#"+id).find("textarea,select").each(function(i,v) {
            if(v.type!=="file") {
                if(v.type==="checkbox" && v.checked===true) {
                    data.append(v.name,"on");
                }else{  
                    console.log("nombre:"+v.name+"valor:"+v.value);
                    data.append(v.name,v.value);
                }
            }
          });

          return data;
        }

        function crear_usuario(form){
            const peticion = new XMLHttpRequest();
            var data=new FormData();
            data=getFormData("crear_usuario",data); 
            for (var value of data.values()) {
                console.log(value); 
            }
            peticion.open("POST","crear_usuario.php");
            peticion.send(data);
            peticion.onload = function () {
            console.log("respuesta:"+this.responseText);
                if(this.responseText==1){
                    $("#modal_respuesta_usuario").modal('show');  
                }else{
                    if(this.responseText==2){
                        $("#errores").html("<div class='alert alert-danger'>Error!</div");
                    }
                }
            };
        }

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
function guardarplantilla(){
    $("#add_plantilla").attr("disabled", true);
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
          } else { alert('Error: '+response.message+"\n"+response.avisos); $("#add_plantilla").attr("disabled", false);}
        });
        request.fail(function(jqXHR, textStatus) {
        console.log(jqXHR);
        alert("Server request failed: " + textStatus);
        $("#add_plantilla").attr("disabled", false);
        console.log("activando boton 4");
      });
    } else {
      alert('Requiere un título la plantilla');
      $("#add_plantilla").attr("disabled", false);
    }
}