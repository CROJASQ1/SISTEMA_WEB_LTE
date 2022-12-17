document.addEventListener("DOMContentLoaded", () =>{

    let form = document.getElementById("cambiar_icono");
   
    form.addEventListener("submit",function(event){
        event.preventDefault();
        cambiar_icono(this);
    });

})


function cambiar_icono(form){
    $("#barra_estado").show(); 
    var barra_estado=document.getElementById("barra_estado");
    var span=document.getElementById("barra_estado");
    var boton_cancelar=document.getElementById("cancelar");

    barra_estado.classList.remove('barra_verde','barra_roja');
 
    const peticion = new XMLHttpRequest();

        peticion.upload.addEventListener("progress",(event)=>{
            let porcentaje=Math.round((event.loaded/event.total)*100)
             console.log(porcentaje); 
            barra_estado.style.width = porcentaje+ '%';
            span.innerHTML = porcentaje+'%';

        });

        peticion.addEventListener("load",()=>{
            barra_estado.classList.add('barra_verde');
            span.innerHTML ="Progreso completado";
       });
 
        var data=getFiles("input_icono");
 /*        data=getFormData("form_subir",data);  */


        peticion.open("POST","backend_icono.php");
        peticion.send(data);
        
        
        peticion.onload = function () {
          // do something to response
          console.log("respuesta:"+this.responseText);

          if(this.responseText==1){

            $('#respuesta_servidor').show();
            $("#respuesta_servidor").html("<div class='alert alert-success'><h5>Icono Actualizado!</h5></div");
            $("#respuesta_servidor").delay(2000).fadeOut(500);
            $("#barra_estado").delay(500).fadeOut(300); 
          }else{

            $('#respuesta_servidor').show();
            $("#respuesta_servidor").html("<div class='alert alert-danger'><h5>Algo salio mal :(</h5></div");
            $("#respuesta_servidor").delay(2000).fadeOut(500);
            $("#barra_estado").delay(500).fadeOut(300); 

          }

        };
 

         boton_cancelar.addEventListener("click", () =>{
            peticion.abort();
            barra_estado.classList.remove('barra_verde');
            barra_estado.classList.add('barra_roja');
            span.innerHTML="Progreso Cancelado";

        })  
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
