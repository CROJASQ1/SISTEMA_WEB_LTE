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

    $id_formulario=$_POST['id_formulario'];

    $year = date("Y", time());
    $autor = "© STIS ".$year;
    $fechahoy = date("d-m-Y", time());

  require_once('../tcpdf/tcpdf.php'); 

  $width = 216; 
  $height = 260;
  $pageLayout = array($width, $height); // or array($height, $width) 

  $pdf = new TCPDF('P', 'mm', $pageLayout, true, 'UTF-8', false); 
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor($autor);
  $pdf->SetTitle("titulo");
 
  $pdf->setPrintHeader(false); 
  $pdf->setPrintFooter(false);
  $pdf->SetMargins(7, 7, 7, false); 
  $pdf->SetAutoPageBreak(true, 2); 
  $pdf->SetFont('times', '', 7);
  $pdf->addPage();


  $content = '';

 
    $pdf->writeHTML($content, true, 0, true, 0);
    $salto = 10;
  
    $detalle = "SELECT * FROM tblFormulario tf,tblEstaciones te WHERE te.idEstacion=tf.idEstacion AND idFormulario=$id_formulario";
    $cam_det=sqlsrv_query($con, $detalle);
    $contando_deta=sqlsrv_has_rows($cam_det);
    $row_form=sqlsrv_fetch_array($cam_det);
    
    $tipo=$row_form['tipo_formulario'];
    $estacion=$row_form['nombre_Estacion'];

    $descripcion ='ULTIMA INTERVENCIÓN "'.$tipo.'" '.$estacion.''; 
    $tam=strlen($descripcion)*2.1;
    $pdf->MultiCell($tam, 2, $descripcion, 0, 'L', 0, 1, 70, $salto, true);
    $sig=$tam+6;

    $salto += 3;


    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->setCellMargins(1, 1, 1, 1);
    $pdf->SetFillColor(255, 255, 127);

   
    $salto += 4;   

  

      $probando="SELECT DISTINCT(tc.idGrupo) FROM tblDetalleFormulario td,tblCampo tc WHERE td.idFormulario=$id_formulario AND tc.idCampo=td.idCampo and tc.idGrupo>5";
      $query_probando=sqlsrv_query($con,$probando);
      $count_probando=sqlsrv_has_rows($query_probando);

      if($count_probando===false){
          $mensaje = "No existen inventarios registrados";
          $pdf->MultiCell(80, 2, $mensaje, 0, 'L', 0, 1, 90, 20, true);
      }else{
                $tabla2="";
                              $consulta_grupos="SELECT DISTINCT(tc.idGrupo) FROM tblDetalleFormulario td,tblCampo tc WHERE td.idFormulario=$id_formulario AND tc.idCampo=td.idCampo";
                              $query_consulta_grupos=sqlsrv_query($con,$consulta_grupos);
                              $count_grupos=sqlsrv_has_rows($query_consulta_grupos);

                              if($count_grupos===false){
                                
                              }else{

                                

                                while($fila_grupos=sqlsrv_fetch_array($query_consulta_grupos)){

                                  $idGrupo=$fila_grupos['idGrupo'];
                                  if($idGrupo>5){
                              
                                          $consulta_x="SELECT max(tmp.res) from (SELECT COUNT(tc.linea) as res FROM tblDetalleFormulario td, tblCampo tc WHERE tc.idGrupo=$idGrupo AND td.idFormulario = $id_formulario AND td.idCampo = tc.idCampo GROUP BY tc.linea) tmp";
                                          $query_consultax=sqlsrv_query($con,$consulta_x);
                                          $incremento=6; $salto = 5;
                                          $row=sqlsrv_fetch_array($query_consultax);

                                          $tamaño_de_todo=$row[0];
                                          
                                          $guardar_consulta="SELECT DISTINCT(tc.linea) as res FROM tblDetalleFormulario td, tblCampo tc WHERE tc.idGrupo=$idGrupo AND td.idFormulario = $id_formulario AND td.idCampo = tc.idCampo GROUP BY tc.linea";
                                          $query_guardar_consulta=sqlsrv_query($con,$guardar_consulta);
                                          
                                          $count=0;
                                          $vector= array();
                                          while($row=sqlsrv_fetch_array($query_guardar_consulta)){
                                                $vector[$count]=$row['res'];
                                                $count++;
                                          }    
                                          $tamaño=sizeof($vector);
                                          $verificador=0;
                                          for($i=0;$i<$tamaño;$i++){

                                              $linea=$vector[$i];
                                              $vector_p=array();
                                              $vector_nombre=array();
                                              $vector_dato=array();
                                              $consulta_p="SELECT * FROM tblDetalleformulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo AND tc.linea=$linea and tc.idGrupo=$idGrupo AND td.idFormulario = $id_formulario AND td.idCampo = tc.idCampo ORDER BY tc.idCampo";
                                        
                                              $query_consultap=sqlsrv_query($con,$consulta_p);
                                              $count=0;
                                              while($row2=sqlsrv_fetch_array($query_consultap)){
                                                    $vector_p[$count]=$row2['campo'];
                                                    $vector_nombre[$count]=$row2['grupo'];   
                                                    $vector_dato[$count]=$row2['dato'];   
                                                    $count++;
                                              }
                                              $tamaño2=sizeof($vector_p);

                                              for($j=0;$j<$tamaño_de_todo;$j++){
                                                    if($vector_p[$j]==""){
                                                          $vector_p[$j]=" ";
                                                    }
                                              } 
                                              $var2_aux='<table border="1" style="font-size:6px;padding:0.5px">
                                              ';
                                              $num=1;
                                              $sw=1;
                                        
                                              for($j=0;$j<$tamaño_de_todo;$j++){

                                                $label=$vector_p[$j];
                                                $dato=$vector_dato[$j];

                                                          if($verificador==0){
                                                            $colspan=$tamaño_de_todo*2;
                                                            $nombre_grupo=$vector_nombre[$j]; 
                                                            $var2_aux.='<tr>
                                                                          <td colspan="'.$colspan.'" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                                                        </tr>';
                                                                $verificador=1;          
                                                          }

                                                          if($num==1){
                                                            $sw=0;
                                                            $var2_aux.="<tr>";
                                                            $var2_aux.='
                                                                          <td style="text-align:center">
                                                                              <label class="control-label">'.$label.'</label>
                                                                          </td>
                                                                          <td>
                                                                              <label class="control-label">'.$dato.'</label>
                                                                          </td>
                                                          ';
                                                          $num++;
                                                          }else if($num==$tamaño_de_todo){
                                                                  $var2_aux.='
                                                                          <td style="text-align:center">
                                                                              <label class="control-label">'.$label.'</label>
                                                                          </td>
                                                                          <td>
                                                                              <label class="control-label">'.$dato.'</label>
                                                                          </td>
                                                                      </tr>
                                                          ';
                                                          $num=1;    
                                                          }else{
                                                              $var2_aux.='
                                                                          <td style="text-align:center">
                                                                              <label class="control-label">'.$label.'</label>
                                                                          </td>
                                                                          <td>
                                                                              <label class="control-label">'.$dato.'</label>
                                                                          </td>
                                                                    ';
                                                          $num++;      
                                                          }
                                              }

                                              if($tamaño_de_todo==1){
                                                $var2_aux.="</tr>";
                                              }
                                            
                                              if($num-1!=$tamaño_de_todo && $num-1!=0){
                                                  $var2_aux.="</tr>";
                                              } 
                                              if($sw==0){
                                                
                                                $tabla2.=$var2_aux;    
                                              }

                                              $tabla2.=' </table> ';  
                                          }
                                    }
                                }
                            }
      }


    

    $pdf->WriteHTMLCell(0,0,'','',$tabla2,0,0);


    $pdf->Ln(4);
    $pdf->lastPage();
    $nom = "Reporte Ultima_intervencion.pdf";
    ob_end_clean();
    $pdf->output($nom, 'I');
?>