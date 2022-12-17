document.addEventListener("DOMContentLoaded", () =>{

    let form = document.getElementById("crear_paciente");
   
    form.addEventListener("submit",function(event){
        event.preventDefault();
        crear_paciente(this);
    });

})

function crear_paciente(form){

/*     $("#barra_estado_empresa").show(); 
 */
/*     var barra_estado=document.getElementById("barra_estado_empresa");
    var span=document.getElementById("barra_estado_empresa");
    var boton_cancelar=document.getElementById("cancelar_2");
    barra_estado.classList.remove('barra_verde','barra_roja'); */

    const peticion = new XMLHttpRequest();

  /*       peticion.upload.addEventListener("progress",(event)=>{
            let porcentaje=Math.round((event.loaded/event.total)*100)
             console.log(porcentaje); 
            barra_estado.style.width = porcentaje+ '%';
            span.innerHTML = porcentaje+'%';

        }); */

 /*        peticion.addEventListener("load",()=>{
            barra_estado.classList.add('barra_verde');
            span.innerHTML ="Progreso completado";

        }); */
 
        /* var data=getFiles("imagen_empresa"); */
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
 

    /*      boton_cancelar.addEventListener("click", () =>{
            peticion.abort();
            barra_estado.classList.remove('barra_verde');
            barra_estado.classList.add('barra_roja');
            span.innerHTML="Progreso Cancelado";

        }); */
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


        document.addEventListener("DOMContentLoaded", () =>{

            let form = document.getElementById("crear_paciente");
           
            form.addEventListener("submit",function(event){
                event.preventDefault();
                crear_usuario(this);
            });
        
        })
        
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

