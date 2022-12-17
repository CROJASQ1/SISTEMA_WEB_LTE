function listar_plantillas(){
    var texto=document.getElementById("textop").value;  
    var start=document.getElementById("start").value;
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

/*       parametros2={
        "id_empresa":id_empresa,
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
                    itemsOnPage: 3,
                    cssStyle:'light-theme',
                    currentPage : page,
                    hrefTextPrefix: 'index3.php?idEmpresaG='+id_empresa+'&busqueda='+texto+'&page='
                  });
                }else{
                  $('.pagination').pagination({
                    items: data.records,
                    itemsOnPage: 3,
                    cssStyle:'light-theme',
                    currentPage : page,
                    hrefTextPrefix: 'index3.php?idEmpresaG='+id_empresa+'&page='
                  });
                }
               
            },beforeSend:function()
            {
              $("#paginacion_1").show(); 
              $("#paginacion_1").html('<div style="text-align:center"><div class="spinner-grow text-primary" style="width: 10rem; height: 10rem;"    role="status"><span class="sr-only">Loading...</span></div></div></div>')
            }
         }); */

 /*    var vinculo=document.getElementById("empresa"+id_empresa);
    vinculo.style.color="black"; 
    vinculo.style.backgroundColor="rgb(240 240 240 / 90%)";   */  
 /*    $("#input_empresa_crear").val(id_empresa); */

}

function listar_usuarios(){
              
  var texto=document.getElementById("textop").value;  
  var start=document.getElementById("start").value;

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

/*       parametros2={
      "id_empresa":id_empresa,
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
                  itemsOnPage: 3,
                  cssStyle:'light-theme',
                  currentPage : page,
                  hrefTextPrefix: 'index3.php?idEmpresaG='+id_empresa+'&busqueda='+texto+'&page='
                });
              }else{
                $('.pagination').pagination({
                  items: data.records,
                  itemsOnPage: 3,
                  cssStyle:'light-theme',
                  currentPage : page,
                  hrefTextPrefix: 'index3.php?idEmpresaG='+id_empresa+'&page='
                });
              }
             
          },beforeSend:function()
          {
            $("#paginacion_1").show(); 
            $("#paginacion_1").html('<div style="text-align:center"><div class="spinner-grow text-primary" style="width: 10rem; height: 10rem;"    role="status"><span class="sr-only">Loading...</span></div></div></div>')
          }
       }); */

/*    var vinculo=document.getElementById("empresa"+id_empresa);
  vinculo.style.color="black"; 
  vinculo.style.backgroundColor="rgb(240 240 240 / 90%)";   */  
/*    $("#input_empresa_crear").val(id_empresa); */

}




$('#modal_editar_paciente').on('show.bs.modal', function(e) {    
    
    var id = $(e.relatedTarget).data().id;

    
     var nombres = $(e.relatedTarget).data().nombres;
    var apellido_paterno = $(e.relatedTarget).data().apellidop;
    var apellidom = $(e.relatedTarget).data().apellidom;
    var categoria = $(e.relatedTarget).data().categoria;
    var departamento = $(e.relatedTarget).data().departamento;
    var direccion = $(e.relatedTarget).data().direccion;
    var ci = $(e.relatedTarget).data().ci;
    var targeta = $(e.relatedTarget).data().targeta;
    var municipio = $(e.relatedTarget).data().municipio;
    var localidad = $(e.relatedTarget).data().localidad;
    var nomapo = $(e.relatedTarget).data().nomapo;
    var ciapo = $(e.relatedTarget).data().ciapo;
    var teleapo = $(e.relatedTarget).data().teleapo;
    var dirapo = $(e.relatedTarget).data().dirapo;
    var fecapo = $(e.relatedTarget).data().fecapo;
    var grapo = $(e.relatedTarget).data().grapo;
    var sexo = $(e.relatedTarget).data().sexo;
    var ante = $(e.relatedTarget).data().ante;

    if(categoria=="SI"){
        $("#resultado_editar").html('<div class="form-group row"><label class="col-sm-6 control-label">Targeta</label><div class="col-sm-4"><input type="text" id="targeta_editar" name="targeta_editar" value="'+targeta+'" class="form-control" placeholder="Escriba la targeta" required ></div></div>');
      }else if(categoria=="NO"){
        $("#resultado_editar").html('<div class="form-group row"><label class="col-sm-6 control-label">C.I.</label><div class="col-sm-4"><input type="text" id="ci_editar" name="ci_editar" class="form-control" value="'+ci+'" placeholder="Escriba ci.." required ></div></div>');
      }

     $("#nombres").val(nombres); 
     $("#ape_paterno").val(apellido_paterno);  
     $("#ape_materno").val(apellidom);  
     $("#categoria_select").val(categoria);  
     $("#direccion").val(direccion);  
     $("#departamento").val(departamento); 
     $("#municipio").val(municipio); 
     $("#localidad").val(localidad); 
     $("#nombre_apo").val(nomapo);
     $("#ci_apo").val(ciapo);
     $("#tel_apo").val(teleapo);
     $("#ci_apo").val(ciapo);
     $("#dir_apo").val(dirapo);
     $("#fec_apo").val(fecapo);
     $("#grupo_san_apo").val(grapo);
     $("#sexo_apo").val(sexo);
     $("#antecedentes").val(ante);
    
                                
});

$('#modal_eliminar').on('show.bs.modal', function(e) {    
    
  var id = $(e.relatedTarget).data().id;
  $("#id_paciente").val(id);                              
});

$('#modal_eliminar_usuario').on('show.bs.modal', function(e) {    
    
  var id = $(e.relatedTarget).data().id;
  $("#id_usuario").val(id);                              
});


   



function borrar_paciente(id){

    parametros={
    'id_paciente':id
    }

    $.ajax({
      data:parametros,
      url:'eliminar_paciente.php',
      type: 'POST',
      success: function (response) {
            console.log(response);
            if(response==1){
              $('#anuncio_servidor').show();
              $('#anuncio_servidor').html("<div class='alert alert-success' style='width:100%'><h4>Paciente eliminado!</h4></div>");
              $("#anuncio_servidor").delay(2000).fadeOut(500); 
              listar_pacientes();
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