 document.addEventListener("DOMContentLoaded", () =>{

    let form = document.getElementById("form_subir");
   
    form.addEventListener("submit",function(event){
        event.preventDefault();
        subir_archivos(this);
    });

})


function subir_archivos(form){
    $("#barra_estado").show(); 
    var id_empresa=$("#input_empresa_crear").val();
    let barra_estado=form.children[1].children[0],  
    span=barra_estado.children[0], 
    boton_cancelar = form.children[3].children[1];



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
            listar_productos(id_empresa);

        });
 
        var data=getFiles("miarchivo");
        data=getFormData("form_subir",data); 


        peticion.open("POST","subir.php");
        peticion.send(data);
        
        
        peticion.onload = function () {
          // do something to response
          console.log("respuesta:"+this.responseText);

          if(this.responseText==1){

                $("#modal_producto").modal('toggle');
                $("#response_cabezera").text('Excelente!');
                $("#respuesta_cuerpo").text('Datos Modificados!');
                $("#modal_respuesta").modal('show');

                $("#barra_estado").delay(500).fadeOut(300); 
             

          }else{

                $("#modal_producto").modal('toggle');
                $("#response_cabezera").text('Error');
                $("#respuesta_cuerpo").text('Algo salio mal');
                $("#modal_respuesta").modal('show');

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
          return data;
        }


        document.addEventListener("DOMContentLoaded", () =>{

          let form = document.getElementById("form_subir2");
         
          form.addEventListener("submit",function(event){
              event.preventDefault();
              subir_archivos2(this);
          });
      
      })
      
      
      function subir_archivos2(form){
          $("#barra_estado2").show(); 
          var id_empresa=$("#input_empresa_crear").val();
          let boton_cancelar = form.children[3].children[1];
 
          barra_estado=document.getElementById("barra_estado2"); 
          span=document.getElementById("barra_estado2"); 
          
      
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
                  listar_productos(id_empresa);
      
              });
       
              var data=getFiles2();
              data=getFormData("form_subir2",data); 
       
 
               peticion.open("POST","crear_producto.php");
              peticion.send(data);
              
              peticion.onload = function () {
               
                console.log("respuesta:"+this.responseText);
      
                if(this.responseText==1){
      
                      $("#modal_crear_producto").modal('toggle');
                      $("#response_cabezera").text('Excelente!');
                      $("#respuesta_cuerpo").text('Producto creado!');
                      $("#modal_respuesta").modal('show');
      
                      $("#barra_estado2").delay(500).fadeOut(300); 
                   
                  
                }else{
      
                      $("#modal_crear_producto").modal('toggle');
                      $("#response_cabezera").text('Error');
                      $("#respuesta_cuerpo").text('Algo salio mal');
                      $("#modal_respuesta").modal('show');
      
                }
      
              };
      
               boton_cancelar.addEventListener("click", () =>{
                  peticion.abort();
                  barra_estado.classList.remove('barra_verde');
                  barra_estado.classList.add('barra_roja');
                  span.innerHTML="Progreso Cancelado";
      
              })   
      } 


      function getFiles2(){
         var idFiles=document.getElementById("miarchivo2"); 
         var archivo=idFiles.files;
         var data=new FormData();

        for(var i=0;i<archivo.length;i++)
        {
          data.append("archivo"+i,archivo[i]);
        }
        return data;
      }
      


      document.addEventListener("DOMContentLoaded", () =>{

        let form = document.getElementById("form_subir_webinventario");
        form.addEventListener("submit",function(event){
            event.preventDefault();
            modificar_webinventario(this);
        });
    
    })


    function modificar_webinventario(form){

      var barra_estado=document.getElementById("barra_estado_webinventario");
      var span=document.getElementById("barra_estado_webinventario");
    /*   var id_pr_inventario=document.getElementById("id_pr_inventario").value; */


      barra_estado.classList.remove('barra_verde','barra_roja');
  
      const peticion = new XMLHttpRequest();

          peticion.upload.addEventListener("progress",(event)=>{
              let porcentaje=Math.round((event.loaded/event.total)*100)
              barra_estado.style.width = porcentaje+ '%';
              span.innerHTML = porcentaje+'%';

          });

          peticion.addEventListener("load",()=>{
              barra_estado.classList.add('barra_verde');
              span.innerHTML ="Progreso completado";
          });

          var data=getFiles("miarchivo_inventario"); 
          data=getFormData("form_subir_webinventario",data); 

            for (var value of data.values()) {
              console.log(value); 
          }   

          peticion.open("POST","subir.php");
          peticion.send(data); 
          
          
          peticion.onload = function () {

          console.log("esta es la respuesta del servidor: "+this.responseText); 

          if(this.responseText==1){

                    $("#modal_producto_2").modal('toggle');
                    $("#response_cabezera").text('Excelente!');
                    $("#respuesta_cuerpo").text('Datos Modificados!');
                    $("#modal_respuesta").modal('show');
                    $("#barra_estado_webinventario").delay(500).fadeOut(300); 
                    listar_productos();


                }else{
                   
                      $("#modal_producto_2").modal('toggle');
                      $("#response_cabezera").text('Error!');
                      $("#respuesta_cuerpo").text('Algo salio mal');
                      $("#modal_respuesta").modal('show');

                      $("#barra_estado_webinventario").delay(500).fadeOut(300); 
                } 

          };  
    } 


    document.addEventListener("DOMContentLoaded", () =>{

      let form = document.getElementById("crear_webinventario");
      form.addEventListener("submit",function(event){
          event.preventDefault();
          crear_webinventario(this);
      });
  
  })


  function crear_webinventario(form){

    var barra_estado=document.getElementById("barra_estado2_web");
    var span=document.getElementById("barra_estado2_web");
  /*   var id_pr_inventario=document.getElementById("id_pr_inventario").value; */


    barra_estado.classList.remove('barra_verde','barra_roja');

    const peticion = new XMLHttpRequest();

        peticion.upload.addEventListener("progress",(event)=>{
            let porcentaje=Math.round((event.loaded/event.total)*100)
            barra_estado.style.width = porcentaje+ '%';
            span.innerHTML = porcentaje+'%';

        });

        peticion.addEventListener("load",()=>{
            barra_estado.classList.add('barra_verde');
            span.innerHTML ="Progreso completado";
        });

        var data=getFiles("miarchivo2_web"); 
        data=getFormData("crear_webinventario",data); 

          for (var value of data.values()) {
            console.log(value); 
        }   

         peticion.open("POST","crear_producto.php");
        peticion.send(data); 
        
        
        peticion.onload = function () {

        console.log("esta es la respuesta del servidor: "+this.responseText); 

        if(this.responseText==1){

                  $("#modal_crear_producto_web").modal('toggle');
                  $("#response_cabezera").text('Excelente!');
                  $("#respuesta_cuerpo").text('Producto Creado!');
                  $("#modal_respuesta").modal('show');
                  $("#barra_estado_2_web").delay(500).fadeOut(300); 
                  listar_productos();


              }else{
                 
                    $("#modal_crear_producto_web").modal('toggle');
                    $("#response_cabezera").text('Error!');
                    $("#respuesta_cuerpo").text('Algo salio mal');
                    $("#modal_respuesta").modal('show');
                    $("#barra_estado_2_web").delay(500).fadeOut(300); 
              } 

        };   
  } 


  document.addEventListener("DOMContentLoaded", () =>{

    let form = document.getElementById("crear_multiempresa");
    form.addEventListener("submit",function(event){
        event.preventDefault();
        crear_multiempresa(this);
    });

})

function crear_multiempresa(form){

  var barra_estado=document.getElementById("barra_estado_m");
  var span=document.getElementById("barra_estado_m");
/*   var id_pr_inventario=document.getElementById("id_pr_inventario").value; */


  barra_estado.classList.remove('barra_verde','barra_roja');

  const peticion = new XMLHttpRequest();

      peticion.upload.addEventListener("progress",(event)=>{
          let porcentaje=Math.round((event.loaded/event.total)*100)
          barra_estado.style.width = porcentaje+ '%';
          span.innerHTML = porcentaje+'%';

      });

      peticion.addEventListener("load",()=>{
          barra_estado.classList.add('barra_verde');
          span.innerHTML ="Progreso completado";
      });

      var data=getFiles("miarchivo_m"); 
      data=getFormData("crear_multiempresa",data); 

      for (var value of data.values()) {
          console.log(value); 
      }   

      peticion.open("POST","crear_producto.php");
      peticion.send(data); 
      
      
      peticion.onload = function () {

      console.log("esta es la respuesta del servidor: "+this.responseText); 

      if(this.responseText==1){

                $("#modal_multiempresa").modal('toggle');
                $("#response_cabezera").text('Excelente!');
                $("#respuesta_cuerpo").text('Producto Creado!');
                $("#modal_respuesta").modal('show');
                $("#barra_estado_m").delay(500).fadeOut(300); 
                listar_productos();


            }else{
               
                  $("#modal_multiempresa").modal('toggle');
                  $("#response_cabezera").text('Error!');
                  $("#respuesta_cuerpo").text('Algo salio mal');
                  $("#modal_respuesta").modal('show');
                  $("#barra_estado_m").delay(500).fadeOut(300); 
            } 

      };    
}


  document.addEventListener("DOMContentLoaded", () =>{

    let form = document.getElementById("form_editar_multiempresa");
    form.addEventListener("submit",function(event){
        event.preventDefault();
        editar_multiempresa(this);
    });

  })

  function editar_multiempresa(form){

  var barra_estado=document.getElementById("barra_estado_editar_m");
  var span=document.getElementById("barra_estado_editar_m");
  /*   var id_pr_inventario=document.getElementById("id_pr_inventario").value; */


  barra_estado.classList.remove('barra_verde','barra_roja');

  const peticion = new XMLHttpRequest();

      peticion.upload.addEventListener("progress",(event)=>{
          let porcentaje=Math.round((event.loaded/event.total)*100)
          barra_estado.style.width = porcentaje+ '%';
          span.innerHTML = porcentaje+'%';

      });

      peticion.addEventListener("load",()=>{
          barra_estado.classList.add('barra_verde');
          span.innerHTML ="Progreso completado";
      });

      var data=getFiles("miarchivo_editar_m"); 
      data=getFormData("form_editar_multiempresa",data); 

      for (var value of data.values()) {
          console.log(value); 
      }   

      peticion.open("POST","subir.php");
      peticion.send(data); 
      
      
      peticion.onload = function () {

      console.log("esta es la respuesta del servidor: "+this.responseText); 

      if(this.responseText==1){

                $("#modal_editar_multiempresa").modal('toggle');
                $("#response_cabezera").text('Excelente!');
                $("#respuesta_cuerpo").text('Datos modificados!');
                $("#modal_respuesta").modal('show');
                $("#barra_estado_editar_m").delay(500).fadeOut(300); 
                listar_productos();


            }else{
              
                  $("#modal_editar_multiempresa").modal('toggle');
                  $("#response_cabezera").text('Error!');
                  $("#respuesta_cuerpo").text('Algo salio mal');
                  $("#modal_respuesta").modal('show');
                  $("#barra_estado_editar_m").delay(500).fadeOut(300); 
            } 

      };    
  } 



  
    

