<?php
if(!isset($_COOKIE['username']) || !isset($_COOKIE['userid'])){
  header('Location:../login/logout.php');
}
include("../conexion.php");
date_default_timezone_set('America/La_Paz');
$fecha = date("Y-m-d", time());
$mes_anterior  = date("Y-m-d",strtotime($fecha."- 1 month"));
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
  <link rel="shortcut icon" href="../images/ltebolivia.ico">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.1.0/css/font-awesome.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../css/tab.css">
  <link rel="stylesheet" href="../css/radio_button.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Chilanka&display=swap" rel="stylesheet">
  <script src="../js/jquery-3.3.1.js"></script> 
  <link rel="stylesheet" href="../dist_pagination/simplePagination.css">
  <script src="../dist_pagination/jquery.simplePagination.js"></script> 
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
  <script type="text/javascript" language="javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                        <label for="tab1" title="Graficas estadisticas en los reportes"><i class="icon-picture"></i> Gr&aacute;ficas y KPIs</label>
                        <input type="radio" name="pcss3t" id="tab2" class="tab-content-2">
                        <label for="tab2" title="Anexo 8"><i class="icon-globe"></i>Tipolog&iacute;a de fallas</label>
                        <input type="radio" name="pcss3t" id="tab3" class="tab-content-3">
                        <label for="tab3" title="LECTURAS TECNICAS SISTEMA DE ENERGIA SOLAR"><i class="icon-globe"></i> Diagramas de Pareto</label>
                        <input type="radio" name="pcss3t" id="tab4" class="tab-content-4">
                        <label for="tab4" title="CORTES POR MORA"><i class="icon-globe"></i> CORTES POR MORA</label>
                        <input type="radio" name="pcss3t" id="tab5" class="tab-content-5">
                        <label for="tab5" title="Disponibilidad de enlaces"><i class="icon-globe"></i> Disponibilidad de enlaces</label>
                        <input type="radio" name="pcss3t" id="tab6" class="tab-content-6">
                        <label for="tab6" title="Excel cargado"><i class="icon-file"></i> Base de datos</label>
                        <ul>
                          <li class="tab-content tab-content-first typography pcss3t-ul">
                            <div class="typography pcss3t-ul">
                                <h1>Filtrado generador de reportes</h1>
                                <div class="form-group row">
                                  <div class="col-sm-3">
                                        <div class="row">
                                          <label style="align-items: center;text-align:center" class="col-form-label">Regional</label>
                                          <select name="idregional_se" id="idregional_se" class="form-control" required>
                                            <?php
                                            echo '<option value="0"> TODOS </option>';
                                            $sql="SELECT * FROM tblRegional";
                                            $query_sql=sqlsrv_query($con,$sql);
                                            $count=sqlsrv_has_rows($query_sql);
                                            if($count!=false){
                                                while($row=sqlsrv_fetch_array($query_sql)){
                                                    echo "<option value='".$row['idRegional']."'>".$row['regional']."</option>";
                                                }  
                                            }
                                            ?>
                                          </select>
                                        </div>
                                        <div class="row">
                                          <h4><label style="align-items: center;text-align:center" class="col-form-label">Rango de Fechas</label></h4>
                                          <select name="tipo_ranqueo" id="tipo_ranqueo" class="form-control">
                                            <option value="1"> RANGOS</option>
                                            <option value="2"> MENSUAL</option>
                                            <option value="3"> TRIMESTRAL</option>
                                            <option value="4"> SEMESTRAL</option>
                                            <option value="5"> ANUAL</option>
                                          </select>
                                        </div>
                                        <div class="row">
                                          <label style="align-items: center;text-align:center" class="col-form-label">Fechas Inicial</label>
                                          <input type="date" class="form-control" id="fechainicial_se" value="<?php echo $mes_anterior?>"  onchange="cambiarfecha()">
                                        </div>
                                        <div class="row">
                                          <label style="align-items: center;text-align:center" class="col-form-label">Fechas Final</label>
                                          <input type="date" class="form-control" id="fechafinal_se" value="<?php echo $fecha?>">
                                        </div>
                                        <div class="row">
                                          <label style="align-items: center;text-align:center" class="col-form-label">Tipo trabajo</label>
                                          <select name="tipotrabajo_se" id="tipotrabajo_se" class="form-control">
                                            <option value="TODOS"> TODOS</option>
                                            <option value="PREVENTIVO"> PREVENTIVO</option>
                                            <option value="CORRECTIVO"> CORRECTIVO</option>
                                            <option value="EXTRACANON"> EXTRACANON</option>
                                          </select>
                                        </div>
                                        <div class="row">
                                          <label style="align-items: center;text-align:center" class="col-form-label">KPI</label>
                                        </div>
                                        <div class="row" id="solotodos">
                                          <select name="casopcion_se_todos" id="casopcion_se_todos" class="form-control">
                                            <option value="1"> DESEMPE&Ntilde;O DE CUADRILLAS</option>
                                            <option value="2"> MATERIALES UTILIZADOS</option>
                                            <option value="3"> TASA DE FALLAS</option>
                                            <option value="8"> CONSOLIDADO</option>
                                          </select>
                                        </div>
                                        <div class="row" id="solopreventivo" style="display: none;">
                                          <select name="casopcion_se_preven" id="casopcion_se_preven" class="form-control">
                                            <option value="1"> CANTIDAD DE MATENIMIENTOS</option>
                                            <option value="2"> CANTIDAD DE MATENIMIENTOS PROMEDIO</option>
                                            <option value="8"> CONSOLIDADO</option>
                                          </select>
                                        </div>
                                        <div class="row" id="solocorrectivo" style="display: none;">
                                          <select name="casopcion_se_correc" id="casopcion_se_correc" class="form-control">
                                            <option value="1"> CANTIDAD DE MATENIMIENTOS</option>
                                            <option value="2"> CANTIDAD DE MATENIMIENTOS PROMEDIO</option>
                                            <option value="3"> CANTIDAD DE MATENIMIENTOS REALIZADOS</option>
                                            <option value="4"> ESTADISTICAS DE MATENIMIENTOS ATENDIDOS</option>
                                            <option value="5"> ESTADISTICAS POR TIPO FALLA Y TIPO DE SISTEMA</option>
                                            <option value="6"> TOP POR TIPO FALLA Y TIPO DE SISTEMA MAS FRECUENTES</option>
                                            <option value="7"> TIEMPO PROMEDIO DE RESPUESTA</option>
                                            <option value="8"> CONSOLIDADO</option>
                                          </select>
                                        </div>
                                        <div class="row" id="soloextracanon" style="display: none;">
                                          <select name="casopcion_se_extra" id="casopcion_se_extra" class="form-control">
                                            <option value="1"> CANTIDAD DE MATENIMIENTOS</option>
                                            <option value="8"> CONSOLIDADO</option>
                                          </select>
                                        </div>
                                        <div class="row">
                                          <label style="align-items: center;text-align:center" class="col-form-label">Opciones</label>
                                          <select name="casogrupo_se" id="casogrupo_se" class="form-control">
                                            <option value="0"> TODOS LOS GRUPOS</option>
                                            <option value="1"> GRUPO 1</option>
                                            <option value="2"> GRUPO 2</option>
                                            <option value="3"> GRUPO 3</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-9" id="previsualizacion" type="application/pdf">
                                        <!-- <iframe width="100%" height="600" id="previsualizacion_reporte" src="../pdfjs/web/viewer.html?file=../../pdfexcel/LTE.pdf" title="Visualizaci&oacute;n de Reportes"></iframe> -->
                                        <iframe id="previsualizacion_reporte" type="application/pdf"  width="100%" height="600" src="../pdfexcel/LTE.pdf"></iframe>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <button class="btn btn-primary" onclick="generar_pdf_grafico_view()">Vizualizar</button>
                                    &nbsp;
                                     <!-- <button class="btn btn-success" onclick="generar_pdf_grafico()">Descargar Pdf</button> -->
                                     &nbsp; 
                                    <button class="btn btn-success" onclick="generar_excel_Anexo8(1)">Evaluaci&oacute;n de registro de fallas</button>
                                    &nbsp;
                                    <button class="btn btn-danger" onclick="generar_excel_fallas()" id="tasasfallas">Tasa de fallas</button>
                                    <!-- &nbsp;
                                    <button class="btn btn-success" onclick="generar_excel_correctivo()">Generar Excel</button> -->
                                  </div>
                          </li>
                          <li class="tab-content tab-content-2 typography pcss3t-ul" style="text-align:center">
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <h1>Regional</h1>
                                <div class="col-sm-12">
                                  <select name="idregional_anexo" id="idregional_anexo" class="form-control">
                                    <?php
                                      echo '<option value="0"> TODOS </option>';
                                      $sql="SELECT * FROM tblRegional";
                                      $query_sql=sqlsrv_query($con,$sql);
                                      while($row=sqlsrv_fetch_array($query_sql)){
                                        echo "<option value='".$row['idRegional']."'>".$row['regional']."</option>";
                                      }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-8">
                                <h1>Filtrado generador de reportes</h1>
                                <button class="btn btn-primary" onclick="generar_excel_Anexo8(2)">Generar anexo 8</button>
                              </div>
                            </div>  
                          </li>
                          <li class="tab-content tab-content-3 typography pcss3t-ul">
                            <h1>Diagramas de Pareto</h1>
                            <div class="form-group row">
                                        <label class="col-sm-1 control-label">Selecciona tipo</label>
                                            <div class="col-sm-4">
                                                      <select name="tipo_excel_2" id="tipo_excel_2" class="form-control" required>
                                                          <option value="CORRECTIVO"> CORRECTIVO</option>
                                                          <option value="PREVENTIVO"> PREVENTIVO</option>
                                                          <option value="EXTRACANNON"> EXTRACANNON</option>
                                                      </select>
                                        </div>
                                  </div>
                                  <div class="form-group row">
                                      <label class="col-sm-1 control-label">fecha inicial</label>
                                        <div class="col-sm-4">
                                            <input type="date" id='fecha_ini_2' class="form-control" value="<?php echo $mes_anterior?>">    
                                        </div>
                                        <label class="col-sm-1 control-label">fecha final</label>
                                        <div class="col-sm-4">
                                            <input type="date" id='fecha_fin_2' class="form-control" value="<?php echo $fecha?>">    
                                        </div>
                                  </div>

                            <button class="btn btn-primary" onclick="generar_5()">Generar PDF</button>
                          </li>
                        <!-- CORRTES POR MORA -->
                            <li class="tab-content tab-content-4 typography pcss3t-ul">
                              <h1>Cortes por mora</h1>
                              <div class="form-group row">
                                        <label class="col-sm-1 control-label">Selecciona fecha inicial</label>
                                          <div class="col-sm-3">
                                              <input type="date" id='intervalo1' value="<?php echo $fecha?>" class="form-control">    
                                          </div>
                                          <label class="col-sm-1 control-label">Selecciona fecha final</label>
                                          <div class="col-sm-3">
                                              <input type="date" id='intervalo2' value="<?php echo $fecha?>" class="form-control">    
                                          </div>
                                          <label class="col-sm-1 control-label">Selecciona regional</label>
                                          <div class="col-sm-3">
                                          <select name="tipo_regional_falla" id="tipo_regional_falla" class="form-control" required>
                                             <option value="0">TODOS</option>
                                                    <?php
                                                      $sql_regional="SELECT * FROM tblRegional";
                                                      $query_regional=sqlsrv_query($con,$sql_regional);
                                                      while($row=sqlsrv_fetch_array($query_regional)){
                                                            echo ' <option value="'.$row['idRegional'].'">'.$row['regional'].'</option>';
                                                      }
                                                    ?>
                                                    </select>
                                          </div>
                                    </div>
                                    <button class="btn btn-primary" onclick="generar_fallas()">Reporte</button>
                            </li>
                          <!-- //CORTES POR MORA -->
                            <!-- disponibilidad de enlace -->
                            <li class="tab-content tab-content-5 typography pcss3t-ul">
                              <h1>DISPONIBILIDAD DE ENLACES</h1>
                              <div class="form-group row">
                                        <label class="col-sm-1 control-label">Selecciona fecha inicial</label>
                                          <div class="col-sm-3">
                                              <input type="date" id='intervalo1' value="<?php echo $fecha?>" class="form-control">    
                                          </div>
                                          <label class="col-sm-1 control-label">Selecciona fecha final</label>
                                          <div class="col-sm-3">
                                              <input type="date" id='intervalo2' value="<?php echo $fecha?>" class="form-control">    
                                          </div>
                                          <label class="col-sm-1 control-label">Selecciona regional</label>
                                          <div class="col-sm-3">
                                          <select name="tipo_regional_falla" id="tipo_regional_falla" class="form-control" required>
                                             <option value="0">TODOS</option>
                                                    <?php
                                                      $sql_regional="SELECT * FROM tblRegional";
                                                      $query_regional=sqlsrv_query($con,$sql_regional);
                                                      while($row=sqlsrv_fetch_array($query_regional)){
                                                            echo ' <option value="'.$row['idRegional'].'">'.$row['regional'].'</option>';
                                                      }
                                                    ?>
                                                    </select>
                                          </div>
                                    </div>

                                    <button class="btn btn-primary" onclick="generar_disp_enlaces()">Reporte de disponibilidad de enlaces</button>
                            </li>
                            <!-- //disponibilidad de enlace -->
                            <li class="tab-content tab-content-6 typography pcss3t-ul">
                                <h1>EXCEL</h1>
                                <div class="form-group row">
                                          <div class="col-sm-4">
                                          </div>
                                          <label class="col-sm-1 control-label">Descargar Excel</label>
                                          <div class="col-sm-3">
                                            <a class="btn btn-lg btn-block btn-success" href="excels/excel.xlsm" download="Excel.xlsm" style="color: #ffffff;"><i class="icon-download"></i> Excel</a>
                                          </div>
                                          <div class="col-sm-4">
                                          </div>
                                    </div>
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
<script>
  // $(document).ready(() => {
  //   $("#previsualizacion_reporte").attr('src','../pdfjs/web/viewer.html?file=../../pdfexcel/LTE.pdf');
  // });

    function generar_fallas(){

        var fechaini = $('#intervalo1').val();
        var fechafin = $('#intervalo2').val();
        var regional = $('#tipo_regional_falla').val();
        var xx2=$('#tipo_regional_falla option:selected').text();

        var form = document.createElement("form");
        form.setAttribute("method","post")
        form.setAttribute("action","../pdfexcel/grafico_fallas.php")
        form.setAttribute("target","_blank")
        form.innerHTML=`
          <input type="hidden" name="fechaini" value="${fechaini}">
          <input type="hidden" name="fechafin" value="${fechafin}">
          <input type="hidden" name="regional" value="${regional}">
          <input type="hidden" name="regional_nombre" value="${xx2}">
          `;
          
        document.body.appendChild(form);
        form.submit();
        form.remove(); 
    }

      function generar_disp_enlaces(){

          var fechaini = $('#intervalo1').val();
          var fechafin = $('#intervalo2').val();
          var regional = $('#tipo_regional_falla').val();
          var xx2=$('#tipo_regional_falla option:selected').text();

          var form = document.createElement("form");
          form.setAttribute("method","post")
          form.setAttribute("action","../pdfexcel/grafico_disp_enlaces.php")
          form.setAttribute("target","_blank")
          form.innerHTML=`
            <input type="hidden" name="fechaini" value="${fechaini}">
            <input type="hidden" name="fechafin" value="${fechafin}">
            <input type="hidden" name="regional" value="${regional}">
            <input type="hidden" name="regional_nombre" value="${xx2}">
            `;
            
          document.body.appendChild(form);
          form.submit();
          form.remove(); 
      }
</script>
<script src="js/app.js"></script>
<!-- <script src="js/app_add.js"></script> -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../dist/js/adminlte.js"></script>
<!-- <script src="js/main.js"></script> -->
</body>
</html>
