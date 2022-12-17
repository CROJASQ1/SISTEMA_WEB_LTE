function pagina(){

  var texto=document.getElementById("textop").value;
   if(texto!=""){
     
     $("#page").val(1);
     $("#start").val(0);

   }
   listar_plantillas();
}


function listar_plantillas(){
    var texto=document.getElementById("textop").value;  
    var start=document.getElementById("start").value;
    var page=document.getElementById("page").value;

      parametros={
          "texto":texto,
          "start":start
      }
      $.ajax({
      data:parametros,
      url:'listar_plantillas.php',
      type: 'post',
      success: function (response) {
                $('#resultado').html(response);
        },beforeSend:function()
        {
          $("#resultado").show(); 
          $("#resultado").html('<div style="text-align:center"><div class="spinner-grow text-danger" style="width: 10rem; height: 10rem;" role="status"><span class="sr-only">Loading...</span></div></div></div>')
        }
      });

      parametros2={
        "texto":texto
      }

        jQuery.ajax({
            type: "POST",
            url: "generar_paginacion.php", 
            data: parametros2,
            dataType: "JSON",
            success: function (data) {
                $("#paginacion_1").html(data.tabla);

                if(texto!=""){
            
                  $('.pagination').pagination({
                    items: data.records,
                    itemsOnPage: 10,
                    cssStyle:'light-theme',
                    currentPage : page,
                    hrefTextPrefix: 'plantilla.php?busqueda='+texto+'&page='
                  });
                }else{
                  $('.pagination').pagination({
                    items: data.records,
                    itemsOnPage: 10,
                    cssStyle:'light-theme',
                    currentPage : page,
                    hrefTextPrefix: 'plantilla.php?page='
                  });
                }
               
            },beforeSend:function()
            {
              $("#paginacion_1").show(); 
              $("#paginacion_1").html('<div style="text-align:center"><div class="spinner-grow text-primary" style="width: 10rem; height: 10rem;"    role="status"><span class="sr-only">Loading...</span></div></div></div>')
            }
         }); 

}


$('#modal_eliminar').on('show.bs.modal', function(e) {    
    
  var id = $(e.relatedTarget).data().id;
  $("#id_paciente").val(id);                              
});

$('#modal_eliminar_plantilla').on('show.bs.modal', function(e) {    
  var id = $(e.relatedTarget).data().id;
  console.log("Plantilla: ",id);
  $("#id_plantilla").val(id);
});


   



function borrar_plantilla(id){

    parametros={
    'id_plantilla':id
    }

    $.ajax({
      data:parametros,
      url:'eliminar_Plantilla.php',
      type: 'POST',
      success: function (response) {
            console.log(response);
            if(response==1){
              $('#anuncio_servidor').show();
              $('#anuncio_servidor').html("<div class='alert alert-success' style='width:100%'><center><h4>Plantilla eliminada!</h4></center></div>");
              $("#anuncio_servidor").delay(2000).fadeOut(500); 
              listar_plantillas();
            }else{

                if(response==2){
                  $('#anuncio_servidor').show();
                  $('#anuncio_servidor').html("<div class='alert alert-danger' style='width:100%'><h3>Hubo un problema!! :(</h3></div>");
                  $("#anuncio_servidor").delay(2000).fadeOut(500);
                }else{

                    if(response==10){
                      $('#anuncio_servidor').show();
                      $('#anuncio_servidor').html("<div class='alert alert-primary' style='width:100%'><h3>Error desconocido</h3></div>");
                      $("#anuncio_servidor").delay(2000).fadeOut(500);
                    }

                }

            } 
              
        

    },
    }); 

} 


function editarplantilla(idPlan) {
  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","edit_plantilla.php")
  form.innerHTML=`
      <input type="hidden" name="idplantilla" value="${idPlan}">
  `;
  document.body.appendChild(form);
  form.submit();
  form.remove();
}

function reportes(id_plantilla){
  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","../pdfexcel/pdfReporteNotas.php")
  form.setAttribute("target","_blank")
  form.innerHTML=`
    <input type="hidden" name="id_plantilla" id="id_plantilla" value="${id_plantilla}">
  `;
  document.body.appendChild(form);
  form.submit();
  form.remove();
}

function contraer(val) {
  $("#cerrar"+val).hide();
  $("#abrir"+val).show();
  $("#division"+val).hide();
  $("#clasificacion"+val).show();
}

function mostrar(val) {
  $("#cerrar"+val).show();
  $("#abrir"+val).hide();
  $("#division"+val).show();
  $("#clasificacion"+val).hide();
}