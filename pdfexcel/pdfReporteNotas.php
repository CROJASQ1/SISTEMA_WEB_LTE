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

    $idplantilla=$_POST['id_plantilla'];


    $detalle = "SELECT * FROM tblPlantillaDetalle tpd, tblCampo tc, tblGrupo tg WHERE tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo AND tc.idGrupo = tg.idGrupo ORDER BY tg.idGrupo, tc.idCampo ASC";
    $cam_det=sqlsrv_query($con, $detalle);
    $contando_deta=sqlsrv_has_rows($cam_det);
    $campos = array(); $pestanas = array();
    if($contando_deta===false){
      
    }else{
      while($row=sqlsrv_fetch_array($cam_det)){
        if(!in_array($row['idGrupo'], $pestanas)){
          $pestanas[]=$row['idGrupo'];
        }
        $campos[] = $row;
      }
    }


    $year = date("Y", time());
    $autor = "© STIS ".$year;
    $fechahoy = date("d-m-Y", time());

  require_once('../tcpdf/tcpdf.php'); 

  $width = 216; 
  $height = 265;
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
  
   /*  $salto += 3; */

   $sql_p="SELECT * FROM tblPlantillaMaestro WHERE idPlantilla=$idplantilla";
   $query_p=sqlsrv_query($con,$sql_p);
   $fila=sqlsrv_fetch_array($query_p);

   $tipo=$fila['tipo'];


    $descripcion = 'MANTENIMIENTO '.$tipo.''; 
    $tam=strlen($descripcion)*2.1;
    $pdf->MultiCell($tam, 2, $descripcion, 0, 'L', 0, 1, 80, $salto, true);
    $sig=$tam+6;
/* 
    $pdf->MultiCell(90, 2, "holi", 1, 'L', 0, 1, $sig, $salto, true);
    $pdf->MultiCell(14, 2, "holi121", 1, 'L', 0, 1, 186, $salto, true);
     */
    /* $pdf->MultiCell(180, 2, 'Lista de Estudiantes', 0, 'C', 0, 1, '', $salto, true); */
    $salto += 3;


    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->setCellMargins(1, 1, 1, 1);
    $pdf->SetFillColor(255, 255, 127);

   
      $salto += 4;   

          $tabla ='
        <br><br>
            <table  border="1" style="font-size:6px;padding:1px">
              <tr>
                  <td colspan="6"><h3 style="font-size:6px;font-weight:bold">DATOS GENERALES</h3></td>
              </tr>
              <tr>
                  <td  width="30"> I.D.</td>
                  <td width="50"></td>
                  <td width="57"> Tipo de est</td>
                  <td width="180"></td>
                  <td width="40"> Est. Hub.</td>
                  <td width="70"></td>
                  <td width="60"> Codigo</td>
                  <td width="70.5"> </td>
              </tr>

              <tr>
                  <td width="40"> Depto</td>
                  <td width="120"></td>
                  <td width="65"> Encargado</td>
                  <td width="167"></td>
                  <td width="30"> Cel</td>
                  <td width="136" > </td>
              </tr>

              <tr>
                  <td width="60"> Provincia</td>
                  <td width="102.5"></td>
                  <td width="50"> Lat(Dec)</td>
                  <td width="100"></td>
                  <td width="55"> Fecha Ini Interv</td>
                  <td width="70" ></td>
                  <td width="50"> Hora Ini Interv</td>
                  <td width="70" ></td>
                
              </tr>

              <tr>          
                  <td width="60"> Mun/Secc</td>
                  <td width="102.5"></td>
                  <td width="50"> Long(Dec)</td>
                  <td width="100"></td>
                  <td width="55"> Fecha fin Interv</td>
                  <td width="70" ></td>
                  <td width="50"> Hora fin Interv</td>
                  <td width="70" ></td>
            </tr>

             <tr>
                  <td width="60"> Localidad</td>
                  <td width="172.5"></td>
                  <td width="60"> Cober.Cel</td>
                  <td width="100"></td>
                  <td width="70"> Porcentaje de señal</td>
                  <td width="95" > </td>
             </tr>

            <tr>
                  <td width="83"> Nombre de la estacion</td>
                  <td width="196"></td>
                  <td width="83"> Ubicacion y/o direccion</td>
                  <td width="195.5"></td>
             </tr>

            <tr>
                <td width="100"> Tipo de trayecto</td>
                <td width="115"></td>
                <td width="65"> Tram-1 (Hr)</td>
                <td width="50"></td>
                <td width="50"> Tram-2 (Hr)</td>
                <td width="50"></td>
                <td width="70"> Distancia de viaje (Km)</td>
                <td width="58"></td>
            </tr>

             <tr>
                <td width="45">Trayecto</td>
                <td width="280"></td>
                <td width="90"> Tiempo de viaje(Hr)</td>
                <td width="98"></td>
            </tr>

            <tr>
                <td width="70">Observaciones del trayecto</td>
                <td width="340"></td>
                <td width="50"> Ejecutado </td>
                <td width="98"></td>
            </tr>

            ';
      function verifica($cadena){

          $longitud=strlen($cadena);   
          $palabra="";

          for ($i=0; $i < 4; $i++) { 
              $palabra.=$cadena[$i];
          }

          if($palabra=="Ping"){
              return true;
          }else{
            return false;
          }

      }
      $tabla .='</table>';
 

      if($tipo=="CORRECTIVO"){
     
    $tabla .='
          <table  border="1" style="font-size:6px;padding:1px">
            <tr>
                <td colspan="6"><h3 style="font-size:6px;font-weight:bold">DATOS EMISION ORDEN DE TRABAJO</h3></td>
            </tr>
            <tr>
                <td  width="50"> N° OT</td>
                <td width="60"></td>
                <td width="75"> N° Tramite</td>
                <td width="150"></td>
                <td width="70"> Correo de:</td>
                <td width="153"> </td>
            </tr>
            <tr>
                <td width="120"> Fecha/hora Recepcion de OT</td>
                <td width="169"></td>
                <td width="100"> Fecha/Hora Reclamo Cliente</td>
                <td width="169"></td>

            </tr>

            <tr>
                <td width="125"> ¿Se Requiere retiro de Equipos amacenes Entel?</td>
                <td width="170"></td>
                <td width="110"> Fecha/Hora Retiro equipos</td>
                <td width="153"></td>
            
            </tr>
            <tr>
                <td width="95"> Descripcion del reclamo</td>
                <td width="230"></td>
                <td width="80"> N° de visitas por OT</td>
                <td width="153"></td>
            
            </tr>
          ';
          
    $tabla .='</table>';

 } 
      $tabla.='     
                    <table  border="1" style="font-size:6px;padding:1px">
                        <tr>
                            <td colspan="6"  style="font-size:6px;font-weight:bold">REEMPLAZO DE EQUIPOS O PARTES</td>
                        </tr>
                        <tr>
                          <td colspan="3" style="text-align:center">Equipos instalados</td>
                          <td colspan="2"></td>   
                          <td rowspan="2" style="text-align:center;vertical-align:middle">Observaciones</td>   
                        </tr>
                            <tr style="text-align:center">
                              <td>Equipo</td>
                              <td>Marca/Modelo</td>
                              <td>Serie</td>
                              <td>Marca/modelo</td>
                              <td>Serie</td>
                            </tr>

                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                             <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                             <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                             <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr> 
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>

                            <tr style="text-align:center">
                              <td width="123.5">Item cambiado</td>
                              <td width="45">Cant.</td>
                              <td>Obs.</td>
                              <td  width="125">Item cambiado</td>
                              <td width="45">Cant.</td>
                              <td width="126.5">Obs.</td>
                            </tr>

                            <tr>
                              <td width="123.5"></td>
                              <td width="45"></td>
                              <td></td>
                              <td  width="125"></td>
                              <td width="45"></td>
                              <td></td>
                           </tr>

                           <tr>
                              <td width="123.5"></td>
                              <td width="45"></td>
                              <td></td>
                              <td  width="125"></td>
                              <td width="45"></td>
                              <td></td>
                            </tr>

                            <tr>
                              <td width="123.5"></td>
                              <td width="45"></td>
                              <td></td>
                              <td  width="125"></td>
                              <td width="45"></td>
                              <td></td>
                           </tr>
                           <tr>
                              <td width="123.5"></td>
                              <td width="45"></td>
                              <td></td>
                              <td  width="125"></td>
                              <td width="45"></td>
                              <td></td>
                           </tr>
                           <tr>
                              <td width="123.5"></td>
                              <td width="45"></td>
                              <td></td>
                              <td  width="125"></td>
                              <td width="45"></td>
                              <td></td>
                           </tr>
                    </table>
                  '; 
  
                  $var2_aux='<table border="1" style="font-size:6px;padding:0px">';
                          $sw=1;
                          $verificador=0;
                          foreach ($campos as $key) {
                            

                            $id = $key['idCampo'];
                            $label = $key['campo'];
                            $idgrupo = intval($key['idGrupo']);
                            if (intval($idgrupo) == 1) {
                              
                              if($verificador==0){
                                $nombre_grupo=$key['grupo']; 
                                $var2_aux.='<tr>
                                              <td colspan="2" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                            </tr>';
                                    $verificador=1;          
                              }

                              $sw=0;
                              $var2_aux.='
                                    <tr >
                                          <td width="100" style="text-align:center">
                                          
                                              <label class="control-label">'.$label.'</label><br>
                                          
                                          </td>
                                          <td  width="458">
                                          </td>
                                    </tr>';
                            }
                          }if($sw==0){
                            $tabla.=$var2_aux;    
                          }
                $tabla.=' 
                        </table>
                '; 
                
           
                $consulta_grupos="SELECT DISTINCT(idGrupo) FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo";
                $query_consulta_grupos=sqlsrv_query($con,$consulta_grupos);
                
                $count_grupos=sqlsrv_has_rows($query_consulta_grupos);

                if($count_grupos===false){

                }else{

                  while($fila_grupos=sqlsrv_fetch_array($query_consulta_grupos)){

                     $idGrupo=$fila_grupos['idGrupo'];
                     if($idGrupo>=2 && $idGrupo<=5){
                
                            $consulta_x="SELECT max(tmp.res) from (SELECT COUNT(tc.linea) as res FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tc.idGrupo=$idGrupo AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo GROUP BY linea) tmp";
                            $query_consultax=sqlsrv_query($con,$consulta_x);
                            $incremento=6; $salto = 5;
                            $row=sqlsrv_fetch_array($query_consultax);

                            $tamaño_de_todo=$row[0];
                            
                            $guardar_consulta="SELECT DISTINCT(tc.linea) as res FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tc.idGrupo=$idGrupo AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo GROUP BY linea";
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
                                $consulta_p="SELECT * FROM tblPlantillaDetalle tpd,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo AND tc.linea=$linea and tc.idGrupo=$idGrupo AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo ORDER BY tc.idCampo";
                          
                                $query_consultap=sqlsrv_query($con,$consulta_p);
                                $count=0;
                                while($row2=sqlsrv_fetch_array($query_consultap)){
                                      $vector_p[$count]=$row2['campo'];
                                      $vector_nombre[$count]=$row2['grupo'];      
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
                                                          </td>
                                            ';
                                            $num++;
                                            }else if($num==$tamaño_de_todo){
                                                    $var2_aux.='
                                                                <td style="text-align:center">
                                                                    <label class="control-label">'.$label.'</label>
                                                                </td>
                                                                <td>
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
                                  
                                  $tabla.=$var2_aux;    
                                }

                                $tabla.=' </table>   ';  
                            }
                      }
                  }

              } 

        $tabla2.="";
        $pdf->WriteHTMLCell(0,0,'','',$tabla,0,0);
        $salto=240;
        
        $linea="------------------------------------------------------";
        $linea2="-----------------------------------------";

        $pdf->MultiCell(40, 1, 'NOMBRE Y FIRMA TECNICO LTE BOLIVIA LTDA', 0, 'C', 0, 1, 10, $salto, true);
        $pdf->MultiCell(45, 1, $linea, 0, 'L', 0, 1, 10, $salto-3, true);
        $pdf->MultiCell(40, 1, 'CONFORMIDAD RESPONSABLE ENTEL', 0, 'C', 0, 1, 90, $salto, true);
        $pdf->MultiCell(50, 1, $linea, 0, 'L', 0, 1, 87, $salto-3, true);
        $pdf->MultiCell(30, 1, 'NOMBRE Y FIRMA CLIENTE', 0, 'C', 0, 1, 170, $salto, true);
        $pdf->MultiCell(45, 1, $linea2, 0, 'L', 0, 1, 167, $salto-3, true);
        $pdf->addPage();

        $consulta_grupos="SELECT DISTINCT(idGrupo) FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo";
        $query_consulta_grupos=sqlsrv_query($con,$consulta_grupos);
        
        $count_grupos=sqlsrv_has_rows($query_consulta_grupos);

        if($count_grupos===false){

        }else{

          while($fila_grupos=sqlsrv_fetch_array($query_consulta_grupos)){

            $idGrupo=$fila_grupos['idGrupo'];
            if($idGrupo>5){
        
                    $consulta_x="SELECT max(tmp.res) from (SELECT COUNT(tc.linea) as res FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tc.idGrupo=$idGrupo AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo GROUP BY linea) tmp";
                    $query_consultax=sqlsrv_query($con,$consulta_x);
                    $incremento=6; $salto = 5;
                    $row=sqlsrv_fetch_array($query_consultax);

                    $tamaño_de_todo=$row[0];
                    
                    $guardar_consulta="SELECT DISTINCT(tc.linea) as res FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tc.idGrupo=$idGrupo AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo GROUP BY linea";
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
                        $consulta_p="SELECT * FROM tblPlantillaDetalle tpd,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo AND tc.linea=$linea and tc.idGrupo=$idGrupo AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo ORDER BY tc.idCampo";
                  
                        $query_consultap=sqlsrv_query($con,$consulta_p);
                        $count=0;
                        while($row2=sqlsrv_fetch_array($query_consultap)){
                              $vector_p[$count]=$row2['campo'];
                              $vector_nombre[$count]=$row2['grupo'];      
                              $count++;
                        }
                        $tamaño2=sizeof($vector_p);

                        for($j=0;$j<$tamaño_de_todo;$j++){
                              if($vector_p[$j]==""){
                                    $vector_p[$j]=" ";
                              }
                        } 
                        $var2_aux='<table border="1" style="font-size:6px;padding:0.4px">
                        ';
                        $num=1;
                        $sw=1;
                  
                        for($j=0;$j<$tamaño_de_todo;$j++){
                        $label=$vector_p[$j];

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
                                                  </td>
                                    ';
                                    $num++;
                                    }else if($num==$tamaño_de_todo){
                                            $var2_aux.='
                                                        <td style="text-align:center">
                                                            <label class="control-label">'.$label.'</label>
                                                        </td>
                                                        <td>
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

                        $tabla2.=' </table>   ';  
                    }
              }
          }

      } 

    $pdf->WriteHTMLCell(0,0,'','',$tabla2,0,0);


    $pdf->Ln(4);
    $pdf->lastPage();
    $nom = "Reporte Notas.pdf";
    ob_end_clean();
    $pdf->output($nom, 'I');
?>