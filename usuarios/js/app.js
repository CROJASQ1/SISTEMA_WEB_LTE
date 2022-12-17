function pagina(){
  document.getElementById("page").value=1;
  document.getElementById("start").value=0;
  listar_usuarios();
}

function listar_usuarios(){
              
  var texto=document.getElementById("textop").value;  
  var start=document.getElementById("start").value;
  var page=document.getElementById("page").value;

    parametros={
        "texto":texto,
        "start":start
    }

    $.ajax({
    data:parametros,
    url:'listar_usuarios.php',
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
                  itemsOnPage: 15,
                  cssStyle:'light-theme',
                  currentPage : page,
                  hrefTextPrefix: 'index.php?busqueda='+texto+'&page='
                });
              }else{
                $('.pagination').pagination({
                  items: data.records,
                  itemsOnPage: 15,
                  cssStyle:'light-theme',
                  currentPage : page,
                  hrefTextPrefix: 'index.php?page='
                });
              }
             
          },beforeSend:function()
          {
            $("#paginacion_1").show(); 
            $("#paginacion_1").html('<div style="text-align:center"><div class="spinner-grow text-primary" style="width: 10rem; height: 10rem;"    role="status"><span class="sr-only">Loading...</span></div></div></div>')
          }
       }); 


}

$('#modal_editar_usuario').on('show.bs.modal', function(e) {    
    
  var id = $(e.relatedTarget).data().id;
  var nombres = $(e.relatedTarget).data().nombres;
  var usuario = $(e.relatedTarget).data().usuario;
  var password = $(e.relatedTarget).data().password;
  var rol = $(e.relatedTarget).data().rol;
  var email = $(e.relatedTarget).data().email;
  var idregional = $(e.relatedTarget).data().idregional;

  $("#id_usuario_e").val(id); 
  $("#nombres_e").val(nombres);   
  $("#usuario_e").val(usuario); 
  $("#contraseña_e").val(password); 
  $("#rol_e").val(rol); 
  $("#email_e").val(email); 
  $("#regional_e").val(idregional); 


});

$('#modal_eliminar_usuarios').on('show.bs.modal', function(e) {    
    
  var id = $(e.relatedTarget).data().id;
  console.log(id);
  $("#id_usuario").val(id);                              
});





   

function borrar_usuario(id){

    parametros={
    'id_usuario':id
    }

    $.ajax({
      data:parametros,
      url:'eliminar_usuario.php',
      type: 'POST',
      success: function (response) {
            console.log(response);
            if(response==1){
              $('#anuncio_servidor').show();
              $('#anuncio_servidor').html("<div class='alert alert-success' style='width:100%'><h4>Usuario eliminado!</h4></div>");
              $("#anuncio_servidor").delay(2000).fadeOut(500); 
              listar_usuarios();
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


function borrar_paciente(id){

      parametros={

      'id_usuario':id

      }

      $.ajax({
        data:parametros,
        url:'elimina_usuario.php',
        type: 'POST',
        success: function (response) {
              console.log(response);
              if(response==1){
                $('#anuncio_servidor').show();
                $('#anuncio_servidor').html("<div class='alert alert-success' style='width:100%'><h4>Usuario eliminado!</h4></div>");
                $("#anuncio_servidor").delay(2000).fadeOut(500); 
                listar_usuarios();
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