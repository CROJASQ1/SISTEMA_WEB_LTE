<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }
include("../conexion.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../images/lte.ico">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Pragma" CONTENT="no-cache">

  <title>Admin</title>

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
  
</head>

<body class="hold-transition sidebar-mini" onload="listar_plantillas()">

<div class="wrapper">
  <!-- Navbar -->
 

  <?php
  $plantilla=true;
  include("../nav/nav.php");
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
            <div style="width: 100%;text-align: center;" id="anuncio_servidor"></div>
          </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark" style="font-family: 'Chilanka', cursive;">Lista de plantillas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php    
                  $filter="";
                  $buscar1="";
                  $page="";
      
                  if (isset($_GET['buscar'])) {
                      $buscar  = $_GET['buscar']; 
                 } else { $buscar  =''; };
      
                 if ($buscar=='undefined'){
                     $buscar='';
                 }
                  $limit = 10;
      
                  if (isset($_GET['page'])) {
                       $page  = $_GET['page']; 
                      
                  } else {
                       $page=1; 
                   
                  };
                  if ($page==""){
                      $page=1; 
                    
                  }      
                  $start_from = ($page-1) * $limit;
                  echo '<input type="hidden" value="'.$start_from.'" id="start">';
                  echo '<input type="hidden" value="'.$page.'" id="page">';   
      
    ?>
    <!-- Main content -->
                 <div class="content">
                             <div class="container-fluid">
                                          <div class="row">      
                                                      <div class="col-lg-12">
                                                                  <div class="card">
                                                                                      <div id="resultado">               
                                                                                      </div> 

                                                                                      <div id="paginacion_1">
                                                                                      </div>          
                                                                  </div>
                                                        <!-- /.card -->
                                                      </div>
                                            </div>
                                            <!-- /.row -->
                              </div>
                            <!-- /.container-fluid -->
                 </div>
                <!-- /.content -->
        </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>

</div>

<?php

  include("modal_editar.php");
  include("modal_eliminar_plantilla.php");

?>

<script src="js/app.js"></script>
<!-- <script src="js/app_add.js"></script>
<script src="js/app_edit.js"></script> -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../dist/js/adminlte.js"></script>
<!-- <script src="js/main.js"></script> -->
    <script>
				function reportes(id_plantilla){
          console.log(id_plantilla);
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
		</script>

</body>
</html>
