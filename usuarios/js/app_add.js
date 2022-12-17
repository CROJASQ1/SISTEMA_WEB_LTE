document.addEventListener("DOMContentLoaded", () =>{

    let form = document.getElementById("agregar_usuario");
   
    form.addEventListener("submit",function(event){
        event.preventDefault();
        enviar_data(this,"agregar_usuario","Usuario creado!");
    });
})

document.addEventListener("DOMContentLoaded", () =>{

    let form = document.getElementById("editar_usuario");
   
    form.addEventListener("submit",function(event){
        event.preventDefault();
        enviar_data(this,"editar_usuario","Usuario editado!");
    });
})


function enviar_data(form,idform,message){

        const peticion = new XMLHttpRequest();
        var data=new FormData();
        data=getFormData(idform,data); 
        for (var value of data.values()) {
            console.log(value); 
        }   
  
        peticion.open("POST",idform+".php");
        peticion.send(data);   
        peticion.onload = function () {
        console.log("respuesta:"+this.responseText);

            if(this.responseText==1){
                    $('#modal_'+idform+'').modal('toggle');
                    $('#anuncio_servidor').show();
                    $("#anuncio_servidor").html('<div class="alert alert-success">'+message+'</div>');   
                    $("#anuncio_servidor").delay(2000).fadeOut(500);
                    listar_usuarios();
            }else{
                    if(this.responseText==2){    
                        $('#modal_'+idform+'').modal('toggle'); 
                        $('#anuncio_servidor').show();  
                        $("#anuncio_servidor").html('<div class="alert alert-danger">Error intente nuevamente!</div>');
                        $("#anuncio_servidor").delay(2000).fadeOut(500);   
                    }else if(this.responseText==10){
                        $('#modal_'+idform+'').modal('toggle');
                        $('#anuncio_servidor').show();
                        $("#anuncio_servidor").html('<div class="alert alert-danger">Error con las variables POST!</div>');   
                        $("#anuncio_servidor").delay(2000).fadeOut(500);
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
                        console.log("nombre:"+v.name+"/ valor:"+v.value);
                        data.append(v.name,v.value);
                    }
                }
          });

          $("#"+id).find("textarea,select").each(function(i,v) {
            if(v.type!=="file") {
                if(v.type==="checkbox" && v.checked===true) {
                    data.append(v.name,"on");
                }else{  
                    console.log("nombre:"+v.name+"/ valor:"+v.value);
                    data.append(v.name,v.value);
                }
            }
          });

          return data;
        }

       

