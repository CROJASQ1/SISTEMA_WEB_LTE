<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }
include("../conexion.php");
date_default_timezone_set('America/La_Paz');
$year = date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta http-equiv="expires" content="0">
    
    <meta http-equiv="Cache-Control" content="no-cache">
      
    <meta http-equiv="Pragma" CONTENT="no-cache">

  <title>Reportes</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Chilanka&display=swap" rel="stylesheet">
  <script src="../js/jquery-3.3.1.js"></script> 
  <link rel="stylesheet" href="../dist_pagination/simplePagination.css">
  <script src="../dist_pagination/jquery.simplePagination.js"></script> 
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">
  <!-- Navbar -->
 

  <?php
  $reportes=true;
  include("../nav/nav.php");
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
            <div style="width: 100%;text-align: center;" id="anuncio_servidor"></div>
          </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark" style="font-family: 'Chilanka', cursive;">Generaci&oacute;n de Reportes</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">

                      <!-- tabs -->
                      <div class="pcss3t pcss3t-effect-scale pcss3t-theme-1">
                        <input type="radio" name="pcss3t" checked  id="tab1"class="tab-content-first">
                        <label for="tab1"><i class="icon-bolt"></i> REPORTES</label>
                        <!-- <input type="radio" name="pcss3t" id="tab2" class="tab-content-2">
                        <label for="tab2" title="ESTADO DE LOS SERVICIOS"><i class="icon-picture"></i> SERVICIOS</label>
                        <input type="radio" name="pcss3t" id="tab3" class="tab-content-3">
                        <label for="tab3" title="LECTURAS TECNICAS SISTEMAS DE TRANSMICION"><i class="icon-cogs"></i> TRANSMICION</label>
                        <input type="radio" name="pcss3t" id="tab4" class="tab-content-4">
                        <label for="tab4" title="LECTURAS TECNICAS SISTEMA DE ENERGIA COMERCIAL"><i class="icon-globe"></i> COMERCIAL</label>
                        <input type="radio" name="pcss3t" id="tab5" class="tab-content-5">
                        <label for="tab5" title="LECTURAS TECNICAS SISTEMA DE ENERGIA SOLAR"><i class="icon-globe"></i> ENERGIA SOLAR</label>
                        <input type="radio" name="pcss3t" id="tab6" class="tab-content-6">
                        <label for="tab6" title="LECTURAS TECNICAS SISTEMA DE PROTECCION"><i class="icon-globe"></i> PROTECCION</label>
                        <input type="radio" name="pcss3t" id="tab7" class="tab-content-7">
                        <label for="tab7" title="INVETARIO DE EQUIPOS TX/RX"><i class="icon-globe"></i> I. EQUIPOS TX/RX</label>
                        <input type="radio" name="pcss3t" id="tab8" class="tab-content-8">
                        <label for="tab8" title="INVENTARIO EQUIPOS DE ENERGIA"><i class="icon-globe"></i> I. EQUIPOS DE ENERGIA</label>
                        <input type="radio" name="pcss3t" id="tab9" class="tab-content-9">
                        <label for="tab9" title="INVENTARIO PANELES SOLARES"><i class="icon-globe"></i> I. PANELES SOLARES</label>
                        <input type="radio" name="pcss3t" id="tab10" class="tab-content-10">
                        <label for="tab10" title="INVENTARIO BATERIAS"><i class="icon-globe"></i> I. BATERIAS</label>
                        <input type="radio" name="pcss3t" id="tab11" class="tab-content-last">
                        <label for="tab11" title="INVENTARIO DE EQUIPO INFORMATICO"><i class="icon-globe"></i> I. DE EQUIPO INFORMATICO</label> -->
                        <ul>
                          <li class="tab-content tab-content-first typography pcss3t-ul">
                            <div class="typography pcss3t-ul">
                                <h1>Filtrado generador de reportes</h1>
                                <div class="form-group row">
                                      <label style="align-items: center;text-align:center" class="col-sm-1 col-form-label">GESTI&Oacute;N</label>
                                      <div class="col-sm-2" >
                                        <select name="gestion" id="gestion" class="form-control">
                                          <?php 
                                            for ($i=$year; $i <= $year+1 ; $i++) { 
                                              echo '<option value="'.$i.'">'.$i.'</option>';
                                            }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="col-sm-2" >
                                        <select name="mes" id="mes" class="form-control">
                                          <option value="1">ENERO</option>
                                          <option value="2">FEBRERO</option>
                                          <option value="3">MARZO</option>
                                          <option value="4">ABRIL</option>
                                          <option value="5">MAYO</option>
                                          <option value="6">JUNIO</option>
                                          <option value="7">JULIO</option>
                                          <option value="8">AGOSTO</option>
                                          <option value="9">SEPTIEMBRE</option>
                                          <option value="10">OCTUBRE</option>
                                          <option value="11">NOVIEMBRE</option>
                                          <option value="12">DICIEMBRE</option>
                                        </select>
                                      </div>
                                      <button class="btn btn-success" onclick="generar_excel_correctivo()">Generar Excel</button>
                                </div>

<br><br>


                                  <h1>Filtrado generador de reportes</h1>

                                  <button class="btn btn-info" onclick="resetear()">Generar reporte completo</button>
                                  <button class="btn btn-warning" onclick="habilitar()">Habilitar Rango de fechas</button><br><br>
                                            
                                       <div class="form-group row">
                                            <label class="col-sm-1 control-label">Selecciona fecha inicial</label>
                                              <div class="col-sm-4">
                                                   <input type="date" id='fecha_ini' onchange="cambiar1()" class="form-control">    
                                              </div>
                                              <label class="col-sm-1 control-label">Selecciona fecha final</label>
                                              <div class="col-sm-4">
                                                  <input type="date" id='fecha_fin' onchange="cambiar2()" class="form-control">    
                                              </div>
                                        </div>  


                                          <div class="form-group row">
                                              <label class="col-sm-1 control-label">Selecciona tipo</label>
                                                  <div class="col-sm-4">
                                                            <select name="tipo_excel" id="tipo_excel" class="form-control" required>
                                                                <option value="correctivo"> Correctivo</option>
                                                                <option value="preventivo"> Preventivo</option>
                                                                <option value="extracanon"> Extracannon</option>
                                                            </select>
                                                  </div>
                                            </div>      
                                          
                                     
                                      <button class="btn btn-primary" onclick="generar_excel()">Generar Intervención</button>
                                      <button class="btn btn-primary" onclick="generar_excel_inventarios()">Generar Inventarios</button>


                          </li>
              

                        </ul>
                      </div>
                      <!--/ tabs -->

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>

</div>

<script src="js/app.js"></script>
<!-- <script src="js/app_add.js"></script> -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../dist/js/adminlte.js"></script>

<script>
function verificad(){
    var ini=$('#fecha_ini').val();
    var fin=$('#fecha_fin').val();

    console.log(ini+"  "+fin);
}

</script>
<!-- <script src="js/main.js"></script> -->
</body>
</html>
