$(document).ready(function () {
  $('#tasasfallas').hide();
});

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

function generar_5(){

  var ini=$('#fecha_ini_2').val();
  var fin=$('#fecha_fin_2').val();
  var tipo_excel=$('#tipo_excel_2').val();

  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","../pdfexcel/reporte_2.php")
  form.setAttribute("target","_blank")
  form.innerHTML=`
       <input type="hidden" name="tipo_excel" value="${tipo_excel}">
       <input type="hidden" name="fechaini_2"" value="${ini}">
       <input type="hidden" name="fechafin_2" value="${fin}">
       `;
       
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


function cambiar1(){

  var ini=$('#fecha_ini').val();
  $('#fecha_fin').val(ini);
  
}

function resetear(){
  $('#fecha_ini').val("");
  $('#fecha_fin').val("");

  document.getElementById('fecha_ini').disabled = true;
  document.getElementById('fecha_fin').disabled = true; 

}

function habilitar(){
  document.getElementById('fecha_ini').disabled = false;
  document.getElementById('fecha_fin').disabled = false; 

}

/* function cambiar2(){

  var fin=$('#fecha_fin').val();
  $('#fecha_ini').val(fin);

} */
function generar_pdf_grafico(){
  var combo = document.getElementById("idregional_se");
  var regional= combo.options[combo.selectedIndex].text;
  var idregion = $('#idregional_se').val();
  var fechaini = $('#fechainicial_se').val();
  var fechafin = $('#fechafinal_se').val();
  if(fechafin >= fechaini){
    var tipotrab = $('#tipotrabajo_se').val();
    var casogrup = $('#casogrupo_se').val();
    var tiporang = $('#tipo_ranqueo').val();
    switch (tipotrab) {
      case 'PREVENTIVO':
        var casopcio = $('#casopcion_se_preven').val();
        break;
      case 'CORRECTIVO':
        var casopcio = $('#casopcion_se_correc').val();
        break;
      case 'EXTRACANON':
        var casopcio = $('#casopcion_se_extra').val()
        break;
      default:
        var casopcio = $('#casopcion_se_todos').val()
        break;
    }
    
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
      <input type="hidden" name="casopcio" value="${casopcio}">
      <input type="hidden" name="tiporang" value="${tiporang}">
      <input type="hidden" name="casogrup" value="${casogrup}">`;
    document.body.appendChild(form);
    form.submit();
    form.remove();
  }else{
    alerta('Rango de fecha no valido');
  }
}
function generar_pdf_grafico_view(){
  var combo = document.getElementById("idregional_se");
  var regional= combo.options[combo.selectedIndex].text;
  var idregion = $('#idregional_se').val();
  var fechaini = $('#fechainicial_se').val();
  var fechafin = $('#fechafinal_se').val();
  if(fechafin >= fechaini){
    var tipotrab = $('#tipotrabajo_se').val();
    var casogrup = $('#casogrupo_se').val();
    var tiporang = $('#tipo_ranqueo').val();
    switch (tipotrab) {
      case 'PREVENTIVO':
        var casopcio = $('#casopcion_se_preven').val();
        break;
      case 'CORRECTIVO':
        var casopcio = $('#casopcion_se_correc').val();
        break;
      case 'EXTRACANON':
        var casopcio = $('#casopcion_se_extra').val()
        break;
      default:
        var casopcio = $('#casopcion_se_todos').val()
        break;
    }
    var formData = new FormData();
  
    formData.append("idregion",idregion);
    formData.append("fechaini",fechaini);
    formData.append("fechafin",fechafin);
    formData.append("tipotrab",tipotrab);
    formData.append("regional",regional);
    formData.append("casopcio",casopcio);
    formData.append("casogrup",casogrup);
    formData.append("tiporang",tiporang);
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../pdfexcel/reportepdfgraficos.php", true); 
    xhr.responseType = "blob";
    xhr.onload = function (e) {
        if (this.status === 200) {
            // console.log(this.response);
            var blob=new Blob([this.response],{type: 'application/pdf'});
            var link=document.createElement('a');
            link.href=window.URL.createObjectURL(blob);
            // console.log(blob);
            // console.log(link.href);
            $("#previsualizacion_reporte").attr('src','../pdfjs/web/viewer.html?file='+link.href);
        }
    };
    xhr.send(formData);
  }else{
    alerta('Rango de fecha no valido');
  }

}
/* function generar_excel_Anexo8(){

  var form = document.createElement("form");
    form.setAttribute("method","post")
    form.setAttribute("action","../pdfexcel/reporte_anexo8.php")
    form.setAttribute("target","_blank")

    document.body.appendChild(form);
    form.submit();
    form.remove();

}  */


function generar_excel_Anexo8(val){
  switch (parseInt(val)) {
    case 1:
      combo = document.getElementById("idregional_se");
      regional= combo.options[combo.selectedIndex].text;
      idregion = $('#idregional_se').val();
    break;
    default:
      combo = document.getElementById("idregional_anexo");
      regional= combo.options[combo.selectedIndex].text;
      idregion = $('#idregional_anexo').val();
    break;
  }

  
  var fechaini = $('#fechainicial_se').val();
  var fechafin = $('#fechafinal_se').val();
  var tipotrab = $('#tipotrabajo_se').val();
  var casogrup = $('#casogrupo_se').val();
  switch (tipotrab) {
    case 'PREVENTIVO':
      var casopcio = $('#casopcion_se_preven').val();
      break;
    case 'CORRECTIVO':
      var casopcio = $('#casopcion_se_correc').val();
      break;
    default:
      var casopcio = '';
      break;
  }
  console.log('anexo 8 envio de datos: ',idregion,fechaini,fechafin,tipotrab,regional,casogrup,casopcio);
  var form = document.createElement("form");
    form.setAttribute("method","post")
    form.setAttribute("action","../pdfexcel/reporte_anexo8.php")
    form.setAttribute("target","_blank")
      form.innerHTML=`
            <input type="hidden" name="idregion" value="${idregion}">
            <input type="hidden" name="fechaini" value="${fechaini}">
            <input type="hidden" name="fechafin" value="${fechafin}">
            <input type="hidden" name="tipotrab" value="${tipotrab}">
            <input type="hidden" name="regional" value="${regional}">
            <input type="hidden" name="casogrup" value="${casogrup}">
            <input type="hidden" name="casopcio" value="${casopcio}">
      `; 
    document.body.appendChild(form);
    form.submit();
    form.remove();

} 


var select_tipotrabajo_se = document.querySelector('#tipotrabajo_se');
select_tipotrabajo_se.addEventListener('change', function(){
  console.log("activando select por tipotrabajo_se.");
  var selectedOption = this.options[select_tipotrabajo_se.selectedIndex];
  var tipotrabajo_se = selectedOption.value;
  switch (tipotrabajo_se) {
    case 'PREVENTIVO':
      $('#solopreventivo').show();
      $('#solotodos').hide();
      $('#solocorrectivo').hide();
      $('#soloextracanon').hide();
      $('#tasasfallas').hide();
      break;
    case 'CORRECTIVO':
      $('#solocorrectivo').show();
      $('#solotodos').hide();
      $('#solopreventivo').hide();
      $('#soloextracanon').hide();
      $('#tasasfallas').hide();
      break;
    case 'EXTRACANON':
      $('#soloextracanon').show();
      $('#solotodos').hide();
      $('#solocorrectivo').hide();
      $('#solopreventivo').hide();
      $('#tasasfallas').hide();
      break;
    default:
      $('#solotodos').show();
      $('#soloextracanon').hide();
      $('#solocorrectivo').hide();
      $('#solopreventivo').hide();
      var caso = parseInt($('#casopcion_se_todos').val());
      if(caso == 3){
        $('#tasasfallas').show();
      }else{
        $('#tasasfallas').hide();
      }
      break;
  }
}, false);

var select_ranqueo = document.querySelector('#tipo_ranqueo');
select_ranqueo.addEventListener('change', function(){
  // console.log("activando select por ranqueo.");
  var selectedOption = this.options[select_ranqueo.selectedIndex];
  var ranqueo = parseInt(selectedOption.value);
  var fecha = $('#fechainicial_se').val();
  var fec = fecha.split('-');
  fecha = fec[0]+"-"+fec[1]+"-01";
  $('#fechainicial_se').val(fecha);
  fecha = new Date(fecha.replace(/-/g, '/'));
  switch (ranqueo) {
    case 2:
      num_meses = 1;
      break;
    case 3:
      num_meses = 3;
      break;
    case 4:
      num_meses = 6;
      break;
    case 5:
      num_meses = 12;
      break;
    default:
      num_meses = 0;
      break;
  }
  console.log(num_meses);
  fecha.setMonth(fecha.getMonth() + num_meses);
  fecha.setDate(fecha.getDate() - 1);
// var today = new Date();
  var date = new Date(fecha);
  var fechanueva = (date.getFullYear()+'-'+completa((date.getMonth()+1))+'-'+completa(date.getDate()));
  $('#fechafinal_se').val(fechanueva);
    if (ranqueo > 1) {
      $('#fechafinal_se').prop('disabled', true);
    } else {
      $('#fechafinal_se').prop('disabled', false);
    }
}, false);

function completa(params) {
  if(parseInt(params) < 10){
    params = '0'+params;
  }
  return params
}

function cambiarfecha() {
  var ranqueo = parseInt($('#tipo_ranqueo').val());
  var fecha = $('#fechainicial_se').val().replace(/-/g, '/');
  // console.log(fecha);
  fecha = new Date(fecha);
  // console.log(ranqueo);
  switch (ranqueo) {
    case 2:
      num_meses = 1;
      break;
    case 3:
      num_meses = 3;
      break;
    case 4:
      num_meses = 6;
      break;
    case 5:
      num_meses = 12;
      break;
    default:
      num_meses = 0;
      break;
  }
  // console.log(num_meses);
  if(num_meses > 0){
    fecha.setMonth(fecha.getMonth() + num_meses);
    fecha.setDate(fecha.getDate() - 1);
    var date = new Date(fecha);
    var fechanueva = (date.getFullYear()+'-'+completa((date.getMonth()+1))+'-'+completa(date.getDate()));
    $('#fechafinal_se').val(fechanueva);
      if (ranqueo > 1) {
        $('#fechafinal_se').prop('disabled', true);
      } else {
        $('#fechafinal_se').prop('disabled', false);
      }
  }
}

function generar_excel_fallas(){
  var combo = document.getElementById("idregional_se");
  var regional= combo.options[combo.selectedIndex].text;
  var idregion = $('#idregional_se').val();
  var fechaini = $('#fechainicial_se').val();
  var fechafin = $('#fechafinal_se').val();
  var casogrup = $('#casogrupo_se').val();
  var tiporang = $('#tipo_ranqueo').val();

  var tipotrab = $('#tipotrabajo_se').val();
  switch (tipotrab) {
    case 'PREVENTIVO':
      var casopcio = $('#casopcion_se_preven').val();
      break;
    case 'CORRECTIVO':
      var casopcio = $('#casopcion_se_correc').val();
      break;
    case 'EXTRACANON':
      var casopcio = $('#casopcion_se_extra').val()
      break;
    default:
      var casopcio = $('#casopcion_se_todos').val()
      break;
  }
  
  var form = document.createElement("form");
  form.setAttribute("method","post")
  form.setAttribute("action","../pdfexcel/reporteExcelCorrectivofiltrado.php")
  form.setAttribute("target","_blank")
  form.innerHTML=`
    <input type="hidden" name="idregion" value="${idregion}">
    <input type="hidden" name="fechaini" value="${fechaini}">
    <input type="hidden" name="fechafin" value="${fechafin}">
    <input type="hidden" name="tipotrab" value="${tipotrab}">
    <input type="hidden" name="regional" value="${regional}">
    <input type="hidden" name="casopcio" value="${casopcio}">
    <input type="hidden" name="tiporang" value="${tiporang}">
    <input type="hidden" name="casogrup" value="${casogrup}">`;
  document.body.appendChild(form);
  form.submit();
  form.remove();
}

var select_todoscasos = document.querySelector('#casopcion_se_todos');
select_todoscasos.addEventListener('change', function(){
  // console.log("activando select por todoscasos.");
  var selectedOption = this.options[select_todoscasos.selectedIndex];
  var todoscasos = parseInt(selectedOption.value);

  switch (todoscasos) {
    case 3:
      $('#tasasfallas').show();
      break;
    default:
      $('#tasasfallas').hide();
      break;
  }
}, false);

var select_idregional = document.querySelector('#idregional_se');
select_idregional.addEventListener('change', function(){
  // console.log("activando select por idregional.");
  var selectedOption = this.options[select_idregional.selectedIndex];
  var idregional = parseInt(selectedOption.value);

  switch (idregional) {
    case 0:
      var caso = parseInt($('#casopcion_se_todos').val());
      var tipotrab = $('#tipotrabajo_se').val();
      if(caso == 3 && tipotrab == 'TODOS'){
        $('#tasasfallas').show();
      }else{
        $('#tasasfallas').hide();
      }
      break;
    default:
      $('#tasasfallas').hide();
      break;
  }
}, false);

function alerta(params) {
  swal({
    title: "Error!",
    text: params,
    icon: "error",
    dangerMode: true,
  })
}

function informa(params) {
  swal({
    title: "Peligro!",
    text: params,
    icon: "warning",
    dangerMode: true,
  })
}