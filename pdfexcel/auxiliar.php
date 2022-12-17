<?php 
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }
ob_start();
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
  require_once('../conexion.php');
  date_default_timezone_set('America/La_Paz');

    $year = date("Y", time());
    $autor = "© STIS ".$year;
    $fechahoy = date("d-m-Y", time());

  require_once('../tcpdf/tcpdf.php'); 
  $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); 
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor($autor);
  $pdf->SetTitle("titulo");
 
  $pdf->setPrintHeader(false); 
  $pdf->setPrintFooter(false);
  $pdf->SetMargins(15, 10, 10, false); 
  $pdf->SetAutoPageBreak(true, 2); 
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->addPage();


  $content = '';
  $linea = '__________________________________________________________________________________________';
  $content .= '
              <h2 style="text-align:center;">Datos Generales</h2>
  ';
    $pdf->writeHTML($content, true, 0, true, 0);
    $salto = 15;
    $pdf->MultiCell(180, 1, $linea, 0, 'C', 0, 1, '', $salto-2, true);
    $salto += 3;
    $descripcion = 'Fecha de Emisión:'.$fechahoy; 
    $pdf->MultiCell(180, 2, $descripcion, 0, 'L', 0, 1, '', $salto, true);
    $pdf->MultiCell(180, 2, 'Lista de Estudiantes', 0, 'C', 0, 1, '', $salto, true);
    $salto += 3;
    $pdf->MultiCell(180, 1, $linea, 0, 'C', 0, 1, '', $salto-2, true);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->setCellMargins(1, 1, 1, 1);
    $pdf->SetFillColor(255, 255, 127);

   
      $salto += 4; $no = 1;
      $tabla ='<h1 style="display:inline">Datos Generales</h1><pre style="display:inline"> 	

                <div class="form-group row">
                      
                      <label style="align-items: center;text-align:center" class="col-sm-1 col-form-label">I.D.</label>
                      <div class="col-sm-2" >
                        <input type="text" style="width:100%" id="id" name="id"  autocomplete="off" class="form-control"  placeholder="ID" required>
                      </div>
                  
                      <label style="align-items: center;text-align:center" class="col-sm-1 col-form-label">Tipo de est.</label>
                      <div class="col-sm-4">
                        <input type="text" style="width:100%" id="tipo_est" name="tipo_est"  autocomplete="off" class="form-control"  placeholder="Escriba el campo" required>
                      </div>

                      <label style="align-items: center;text-align:center" class="col-sm-1 col-form-label">Codigo</label>
                      <div class="col-sm-3">
                        <input type="text" style="width:100%" id="codigo" name="codigo" autocomplete="off" class="form-control"  placeholder="Escriba el campo" required>
                      </div>
                      
                </div>';
      
  $tabla .='';
  $pdf->WriteHTMLCell(0,0,'','',$tabla,0,0);

    $pdf->Ln(4);
    $pdf->lastPage();
    $nom = "Reporte Notas.pdf";
    ob_end_clean();
    $pdf->output($nom, 'I');
?>