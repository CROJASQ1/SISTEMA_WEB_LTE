function listar_estaciones(){

    var texto=document.getElementById("textop").value;  
    var start=document.getElementById("start").value;
    var page=document.getElementById("page").value;
  
      parametros={
          "texto":texto,
          "start":start
      }

      $.ajax({
      data:parametros,
      url:'listar_estaciones.php',
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
                    hrefTextPrefix: 'index.php?busqueda='+texto+'&page='
                  });
                }else{
                  $('.pagination').pagination({
                    items: data.records,
                    itemsOnPage: 10,
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

$('#modal_agregar_estacion').on('show.bs.modal', function(e) {   

    var map = L.map('map').setView([-16.483609396261936, -68.13047964471085], 15);       
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18
    }).addTo(map);
    L.control.scale().addTo(map);          
    L.marker([-16.483609396261936, -68.13047964471085],{draggable: true}).addTo(map).on('move',function (event) {

        $('#inputLatitud').val(this.getLatLng().lat)
        $('#inputLongitud').val(this.getLatLng().lng)

        console.log("INPUT Latitud VALOR : ",$('#inputLatitud').val());
        console.log("INPUT Longitud VALOR : ",$('#inputLongitud').val())
    })
    map.invalidateSize();    

    setTimeout(function() {
        map.invalidateSize();
    }, 200); 

});

$("#modal_agregar_estacion").on("hidden.bs.modal", function () {

      $("#refresh").html("<div id='map'></div>"); 

});  


$('#modal_editar_estacion').on('show.bs.modal', function(e) {
    
    var ides = $(e.relatedTarget).data().ides;  
    var provincia = $(e.relatedTarget).data().provincia;
    var municipio = $(e.relatedTarget).data().municipio;
    var ubi = $(e.relatedTarget).data().ubi;
    var id = $(e.relatedTarget).data().id;
    var sistema = $(e.relatedTarget).data().sistema;
    var idreg = $(e.relatedTarget).data().idreg;
    var nombre = $(e.relatedTarget).data().nombre;
    var localidad = $(e.relatedTarget).data().localidad;
    var latitud = $(e.relatedTarget).data().latitud;
    var longitud = $(e.relatedTarget).data().longitud;

    var map = L.map('map2').setView([latitud , longitud], 15);       
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18
    }).addTo(map);
    L.control.scale().addTo(map);          
    L.marker([latitud, longitud],{draggable: true}).addTo(map).on('move',function (event) {

        $('#inputLatitud_e').val(this.getLatLng().lat)
        $('#inputLongitud_e').val(this.getLatLng().lng)

        console.log("INPUT Latitud VALOR : ",$('#inputLatitud').val());
        console.log("INPUT Longitud VALOR : ",$('#inputLongitud').val())
    })
    map.invalidateSize();    


    setTimeout(function() {
        map.invalidateSize();
    }, 200); 

    var distancia = $(e.relatedTarget).data().distancia;
    var ruteo = $(e.relatedTarget).data().ruteo;

     $("#id_estacion").val(ides); 
     $("#provincia_e").val(provincia);  
     $("#municipio_e").val(municipio);  
     $("#ubicacion_e").val(ubi);  
     $("#id_e").val(id);
     $("#sistema_e").val(sistema);    
     $("#latitud_e").val(latitud);                                  
     $("#longitud_e").val(longitud);  
     $("#distancia_e").val(distancia);  
     $("#ruteo_e").val(ruteo);  
     $("#localidad_e").val(localidad); 
     $("#nombre_estacion_e").val(nombre);
     $("#localidad_e").val(localidad);
     $("#id_regional_e").val(idreg);
    });

  $("#modal_editar_estacion").on("hidden.bs.modal", function () {

    $("#refresh2").html("<div id='map2'></div>"); 

  });  


$('#modal_eliminar_estacion').on('show.bs.modal', function(e) {    
    
  var id = $(e.relatedTarget).data().id;
  console.log(id);
  $("#id_estacion").val(id);                              
});

function borrar_estacion(id){
    parametros={
    'id_estacion':id
    }
    $.ajax({
      data:parametros,
      url:'eliminar_estacion.php',
      type: 'POST',
      success: function (response) {
            console.log(response);
            if(response==1){
              $('#anuncio_servidor').show();
              $('#anuncio_servidor').html("<div class='alert alert-success' style='width:100%'><h4>Estacion eliminado!</h4></div>");
              $("#anuncio_servidor").delay(2000).fadeOut(500); 
              listar_estaciones();
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

function generar_excel(){
  var tipo_excel=$('select[id=tipo_excel]').val();
  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","../pdfexcel/reporteExcel.php")
  form.setAttribute("target","_blank")
  form.innerHTML=`
       <input type="hidden" name="tipo_excel" value="${tipo_excel}">`;
  document.body.appendChild(form);
  form.submit();
  form.remove();
} 

function generar_excel_inventarios(){
  var tipo_excel=$('select[id=tipo_excel]').val();
  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","../pdfexcel/reporteExcel_inventario.php")
  form.setAttribute("target","_blank")
  form.innerHTML=`
        <input type="hidden" name="tipo_excel" value="${tipo_excel}">`;
  document.body.appendChild(form);
  form.submit();
  form.remove();
}
function generar_excel_correctivo(){
  var gestion=$('select[id=gestion]').val();
  var mes=$('select[id=mes]').val();
  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","../pdfexcel/reporteExcelCorrectivo.php")
  form.setAttribute("target","_blank")
  form.innerHTML=`
    <input type="hidden" name="gestion" value="${gestion}">
    <input type="hidden" name="mes" value="${mes}">`;
  document.body.appendChild(form);
  form.submit();
  form.remove();
}
function generar_pdf_grafico(){
  var combo = document.getElementById("idregional_se");
  var regional= combo.options[combo.selectedIndex].text;
  var idregion = $('#idregional_se').val();
  var fechaini = $('#fechainicial_se').val();
  var fechafin = $('#fechafinal_se').val();
  var tipotrab = $('#tipotrabajo_se').val();
  var casogrup = $('#casogrupo_se').val();
  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","../pdfexcel/reportepdfgraficos.php")
  form.setAttribute("target","_blank")
  form.innerHTML=`
    <input type="hidden" name="idregion" value="${idregion}">
    <input type="hidden" name="fechaini" value="${fechaini}">
    <input type="hidden" name="fechafin" value="${fechafin}">
    <input type="hidden" name="tipotrab" value="${tipotrab}">
    <input type="hidden" name="regional" value="${regional}">
    <input type="hidden" name="casogrup" value="${casogrup}">`;
  document.body.appendChild(form);
  form.submit();
  form.remove();
}