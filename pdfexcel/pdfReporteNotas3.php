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
  $fechahoy = date("d-m-Y", time());
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

  $width = 220; 
  $height = 280;
  $pageLayout = array($width, $height); // or array($height, $width) 

  $pdf = new TCPDF('P', 'mm', $pageLayout, true, 'UTF-8', false); 
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor($autor);
  $pdf->SetTitle("titulo");
 
  $pdf->setPrintHeader(false); 
  $pdf->setPrintFooter(false);
  $pdf->SetMargins(5, 5, 5, false); 
  $pdf->SetAutoPageBreak(true, 2); 
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->addPage();


  $content = '';
  $linea = '__________________________________________________________________________________________';
 
    $pdf->writeHTML($content, true, 0, true, 0);
    $salto = 15;
    $pdf->MultiCell(180, 1, $linea, 0, 'C', 0, 1, '', $salto-2, true);
    $salto += 3;
    $descripcion = 'Mantenimiento PREVENTIVO/CORRECTIVO'; 
    $pdf->MultiCell(180, 2, $descripcion, 0, 'L', 0, 1, '', $salto, true);
    /* $pdf->MultiCell(180, 2, 'Lista de Estudiantes', 0, 'C', 0, 1, '', $salto, true); */
    $salto += 3;
    $pdf->MultiCell(180, 1, $linea, 0, 'C', 0, 1, '', $salto-2, true);

    $salto += 3;
    $pdf->MultiCell(25, 1, "texto auxiliar", 55, 'C', 0, 1, '', $salto, true);
    
    $pdf->MultiCell(65, 1, "texto auxiliar", 0, 'C', 0, 1, '', $salto, true);

    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->setCellMargins(1, 1, 1, 1);
    $pdf->SetFillColor(255, 255, 127);

   
      $salto += 4;

      

          $tabla ='
        
            <table  border="1" style="font-size:6px;padding:1px">
              <tr>
                  <td colspan="6"><h3 style="font-size:10px;font-weight:bold">Datos Generales</h3></td>
              </tr>
              <tr>
                  <td  width="30"> I.D.</td>
                  <td width="50"></td>
                  <td width="65"> Tipo de est</td>
                  <td width="140"></td>
                  <td width="60"> Codigo</td>
                  <td width="168"> </td>
              </tr>

              <tr>
                  <td width="40"> Depto</td>
                  <td width="100"></td>
                  <td width="65"> Encargado</td>
                  <td width="140"></td>
                  <td width="60"> Cel</td>
                  <td width="108" > </td>
              </tr>

              <tr>
                  <td width="60"> Provincia</td>
                  <td width="145"></td>
                  <td width="60"> Lat(Dec)</td>
                  <td width="80"></td>
                  <td width="90"> Fecha/Hora Ini Interv</td>
                  <td width="78" > </td>
              </tr>

              <tr>
                  <td width="60"> Mun/Secc</td>
                  <td width="145"></td>
                  <td width="60"> Long(Dec)</td>
                  <td width="80"></td>
                  <td width="90"> Fecha/Hora Fin Interv</td>
                  <td width="78" > </td>
             </tr>

             <tr>
                  <td width="60"> Localidad</td>
                  <td width="145"></td>
                  <td width="60"> Cober.Cel</td>
                  <td width="80"></td>
                  <td width="90"> Porcentaje de señal</td>
                  <td width="78" > </td>
             </tr>

            <tr>
                  <td width="95"> Nombre de la estacion</td>
                  <td width="160"></td>
                  <td width="95"> Ubicacion y/o direccion</td>
                  <td width="163"></td>
             </tr>

            <tr>
                <td width="70"> Tipo de trayecto</td>
                <td width="115"></td>
                <td width="55"> Tram-1 (Hr)</td>
                <td width="50"></td>
                <td width="55"> Tram-2 (Hr)</td>
                <td width="50"></td>
                <td width="60"> Distancia de viaje (Km)</td>
                <td width="58"></td>
            </tr>

             <tr>
                <td width="45">Trayecto</td>
                <td width="280"></td>
                <td width="90"> Tiempo de viaje(Hr)</td>
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
 
      $sql_p="SELECT * FROM tblPlantillaMaestro WHERE idPlantilla=$idplantilla";
      $query_p=sqlsrv_query($con,$sql_p);
      $fila=sqlsrv_fetch_array($query_p);

      $tipo=$fila['tipo'];

      if($tipo=="CORRECTIVO"){
     
    $tabla .='
          <table  border="1" style="font-size:6px;padding:1px">
            <tr>
                <td colspan="6"><h3 style="font-size:10px;font-weight:bold">Datos Emision orden de trabajo</h3></td>
            </tr>
            <tr>
                <td  width="40"> N° OT</td>
                <td width="50"></td>
                <td width="65"> N° Tramite</td>
                <td width="140"></td>
                <td width="60"> Correo de:</td>
                <td width="152.5"> </td>
            </tr>
            <tr>
                <td width="120"> Fecha/hora Recepcion de OT</td>
                <td width="134"></td>
                <td width="120"> Fecha/Hora Reclamo Cliente</td>
                <td width="133.5"></td>

            </tr>

            <tr>
                <td width="190"> ¿Se Requiere retiro de Equipos amacenes Entel?</td>
                <td width="100"></td>
                <td width="110"> Fecha/Hora Retiro equipos</td>
                <td width="107.5"></td>
            
            </tr>
            <tr>
                <td width="95"> Descripcion del reclamo</td>
                <td width="230"></td>
                <td width="80"> N° de visitas por OT</td>
                <td width="102.5"></td>
            
            </tr>
          ';
          
    $tabla .='</table>';

 } 
      $tabla.='     
                    <table  border="1" style="font-size:6px;padding:1px">
                        <tr>
                            <td colspan="6"  style="font-size:10px;font-weight:bold">Reemplazo de equipos o partes</td>
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
                              <td>Obs.</td>
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
        /*   $pdf->WriteHTMLCell(0,0,'','',$tabla,0,0);
          $tabla="";
          $pdf->addPage(); */
           $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                   ';
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
                                    <td width="80" style="text-align:center">
                                    
                                       <label class="control-label">'.$label.'</label><br>
                                   
                                    </td>
                                    <td  width="504">
                                    </td>
                              </tr>';
                      }
                    }if($sw==0){
                      $tabla.=$var2_aux;    
                    }
          $tabla.=' 
                 </table>
          ';   

 /*          $pdf->WriteHTMLCell(0,0,'','',$tabla,0,0);
 */

          $nombre_grupo="";
          $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                     ';
                     $sw=1;
                     $num=1;
                     $verificador=0;
                      foreach ($campos as $key) {
                        $id = $key['idCampo'];
                        $label = $key['campo'];
                        $idgrupo = intval($key['idGrupo']);

                        if (intval($idgrupo) == 2) {
                          
                          if($verificador==0){
                                $nombre_grupo=$key['grupo']; 
                                $var2_aux.='<tr>
                                              <td colspan="8" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
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
                            }else if($num==4){
                                    $var2_aux.='
                                                <td style="text-align:center">
                                                    <label class="control-label">'.$label.'</label>
                                                </td>
                                                <td>
                                                </td>
                                                ';
                                               
                              $var2_aux.='</tr>';
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
                      
                      }
                      if($num-1!=4 && $num-1!=0){
  
                        $var2_aux.="</tr>";
                     } 

                      if($sw==0){
                     
                        $tabla.=$var2_aux;    
                      }
            
            $tabla.=' 
                   </table>  
            ';

          
                      
            $nombre_grupo="";
            $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                       ';
                       $sw=1;
                       $num=1;
                       $verificador=0;
                        foreach ($campos as $key) {
                          $id = $key['idCampo'];
                          $label = $key['campo'];
                          $idgrupo = intval($key['idGrupo']);
  
                          if (intval($idgrupo) == 3) {
                          
                            if($verificador==0){
                              $nombre_grupo=$key['grupo']; 
                              $var2_aux.='<tr>
                                            <td colspan="6" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
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
                              }else if($num==3){
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
                        
                        }
                         if($num-1!=3 && $num-1!=0){
  
                           $var2_aux.="</tr>";
                        } 
  
                        if($sw==0){
                         
                          $tabla.=$var2_aux;    
                        }
              
              $tabla.=' 
                     </table> 
              ';  

            $calcular = "SELECT MAX (tmp.res) FROM (SELECT COUNT(tc.linea) as res FROM tblPlantillaDetalle tpd, tblCampo tc, tblGrupo tg WHERE tc.idGrupo=4 AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo AND tc.idGrupo = tg.idGrupo GROUP BY linea) tmp";
            $query_calcular=sqlsrv_query($con,$calcular);
            $resultado_fila=sqlsrv_fetch_array($query_calcular);
            $total=$resultado_fila[0];
            $titulo=$total*2;          
            $nombre_grupo="";
            $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                       ';
                       $sw=1;
                       $num=1;
                       $verificador=0;
                        foreach ($campos as $key) {
                          $id = $key['idCampo'];
                          $label = $key['campo'];
                          $idgrupo = intval($key['idGrupo']);
                     
                                      if (intval($idgrupo) == 4) {
                                      
                                                  if($verificador==0){
                                                    $nombre_grupo=$key['grupo']; 
                                                    $var2_aux.='<tr>
                                                                  <td colspan="'.$titulo.'" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
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
                                                    }else if($num==$total){
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
                        
                        }
                         if($num-1!=$total && $num-1!=0){
                           $var2_aux.="</tr>";
                        } 
  
                        if($sw==0){
                          $tabla.=$var2_aux;    
                        }
              
              $tabla.=' 
                     </table> 
              ';
              
              $nombre_grupo="";
              $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                         ';
                         $sw=1;
                         $num=1;
                         $verificador=0;

                          foreach ($campos as $key) {
                            $id = $key['idCampo'];
                            $label = $key['campo'];
                            $idgrupo = intval($key['idGrupo']);
       

                                      if (intval($idgrupo) == 5 ) {
      
                                                  if($verificador==0){
                                                    $nombre_grupo=$key['grupo']; 
                                                    $var2_aux.='<tr>
                                                                  <td colspan="6" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                                                </tr>';
                                                        $verificador=1;          
                                                  }

                                                  if($num==1){
                                                        $sw=0;
                                                        $var2_aux.="<tr>";
                                                        $var2_aux.='
                                                                    <td style="text-align:center">
                                                                        <label class="control-label">'.$id_campo.' --- '.$label.'</label>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                      ';
                                                      $num++;
                                                    }else if($num==3){
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
                              
                          }
                           if($num-1!=3 && $num-1!=0){
    
                             $var2_aux.="</tr>";
                          } 
    
                          if($sw==0){
                           
                            $tabla.=$var2_aux;    
                          }
                
                $tabla.=' 
                       </table> 
                '; 
                
    

                $nombre_grupo="";
                $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                           ';
                           $sw=1;
                           $num=1;
                           $verificador=0;
                            foreach ($campos as $key) {
                              $id = $key['idCampo'];
                              $label = $key['campo'];
                              $idgrupo = intval($key['idGrupo']);
      
                              if (intval($idgrupo) == 6) {

                                if($verificador==0){
                                  $nombre_grupo=$key['grupo']; 
                                  $var2_aux.='<tr>
                                                <td colspan="6" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                              </tr>';
                                      $verificador=1;          
                                }
                              
                                if($num==1){
                                      $sw=0;
                                      $var2_aux.="<tr>";
                                      $var2_aux.='
                                                  <td style="text-align:center;font-size:6px">
                                                      <label class="control-label">'.$label.'</label>
                                                  </td>
                                                  <td>
                                                  </td>
                                    ';
                                    $num++;
                                  }else if($num==3){
                                          $var2_aux.='
                                                      <td style="text-align:center;font-size:6px">
                                                          <label class="control-label">'.$label.'</label>
                                                      </td>
                                                      <td>
                                                      </td>
                                               </tr>
                                        ';
                                    $num=1;    
                                  }else{
                                      $var2_aux.='
                                                  <td style="text-align:center;font-size:6px">
                                                      <label class="control-label">'.$label.'</label>
                                                  </td>
                                                  <td>
                                                  </td>
                                            ';
                                    $num++;      
                                  }
                                  
                              }
                            
                            }
                             if($num-1!=3 && $num-1!=0){
      
                               $var2_aux.="</tr>";
                            } 
      
                            if($sw==0){
                             
                              $tabla.=$var2_aux;    
                            }
                  
                  $tabla.=' 
                         </table> 
                  ';
                  
                  
                  $nombre_grupo="";
                  $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                             ';
                             $sw=1;
                             $num=1;
                             $verificador=0;
                              foreach ($campos as $key) {
                                $id = $key['idCampo'];
                                $label = $key['campo'];
                                $idgrupo = intval($key['idGrupo']);
        
                                if (intval($idgrupo) == 7) {
                                
                                  if($verificador==0){
                                    $nombre_grupo=$key['grupo']; 
                                    $var2_aux.='<tr>
                                                  <td colspan="6" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                                </tr>';
                                        $verificador=1;          
                                  }


                                  if($num==1){
                                        $sw=0;
                                        $var2_aux.="<tr>";
                                        $var2_aux.='
                                                    <td style="text-align:center;font-size:6px">
                                                        <label class="control-label">'.$label.'</label>
                                                    </td>
                                                    <td>
                                                    </td>
                                      ';
                                      $num++;
                                    }else if($num==3){
                                            $var2_aux.='
                                                        <td style="text-align:center;font-size:6px">
                                                            <label class="control-label">'.$label.'</label>
                                                        </td>
                                                        <td>
                                                        </td>
                                                 </tr>
                                          ';
                                      $num=1;    
                                    }else{
                                        $var2_aux.='
                                                    <td style="text-align:center;font-size:6px">
                                                        <label class="control-label">'.$label.'</label>
                                                    </td>
                                                    <td>
                                                    </td>
                                              ';
                                      $num++;      
                                    }
                                    
                                }
                              
                              }
                               if($num-1!=3 && $num-1!=0){
        
                                 $var2_aux.="</tr>";
                              } 
        
                              if($sw==0){
                               
                                $tabla.=$var2_aux;    
                              }
                    
                    $tabla.=' 
                           </table>  
                    ';
                    
                    $nombre_grupo="";
                    $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                               ';
                               $sw=1;
                               $num=1;
                               $verificador=0;
                                foreach ($campos as $key) {
                                  $id = $key['idCampo'];
                                  $label = $key['campo'];
                                  $idgrupo = intval($key['idGrupo']);
                                  $id_campo=$key['idCampo'];

                                  if($id_campo>=240 && $id_campo<=254){

                                  }else{
                                            if (intval($idgrupo) == 8) {           
                                              if($verificador==0){
                                                $nombre_grupo=$key['grupo']; 
                                                $var2_aux.='<tr>
                                                              <td colspan="8" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                                            </tr>';
                                                    $verificador=1;          
                                              }

                                              if($num==1){
                                                    $sw=0;
                                                    $var2_aux.="<tr>";
                                                    $var2_aux.='
                                                                <td style="text-align:center;font-size:6px">
                                                                    <label class="control-label">'.$label.'</label>
                                                                </td>
                                                                <td>
                                                                </td>
                                                  ';
                                                  $num++;
                                                }else if($num==4){
                                                        $var2_aux.='
                                                                    <td style="text-align:center;font-size:6px">
                                                                        <label class="control-label">'.$label.'</label>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                            </tr>
                                                      ';
                                                  $num=1;    
                                                }else{
                                                    $var2_aux.='
                                                                <td style="text-align:center;font-size:6px">
                                                                    <label class="control-label">'.$label.'</label>
                                                                </td>
                                                                <td>
                                                                </td>
                                                          ';
                                                  $num++;      
                                                }  
                                            }
                                      }
                                }
                                 if($num-1!=4 && $num-1!=0){
          
                                   $var2_aux.="</tr>";
                                } 
          
                                if($sw==0){
                                 
                                  $tabla.=$var2_aux;    
                                }
                      
                      $tabla.=' 
                             </table> 
                              <table border="1" style="font-size:6px;padding:1px">
                                  <tr>
                                    <td style="text-align:center">Detalle</td>
                                    <td style="text-align:center">Cant.r</td>
                                    <td style="text-align:center">Estado</td>
                                    <td style="text-align:center">Observaciones</td>
                                  </tr>
                                  <tr>
                                    <td>Inversor</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>Regulador</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>Timer</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                      <td>Gabinete</td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td>Protector DC</td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                  </tr>
                              </table> 
                      ';


                      $nombre_grupo="";
                      $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                                 ';
                                 $sw=1;
                                 $num=1;
                                 $verificador=0;
                                  foreach ($campos as $key) {
                                    $id = $key['idCampo'];
                                    $label = $key['campo'];
                                    $idgrupo = intval($key['idGrupo']);
                                    $id_campo=$key['idCampo'];
                                    
                                    if($id_campo>=353 && $id_campo<=376){

                                    }else{
                                          if (intval($idgrupo) == 9) {
                                          
                                                  if($verificador==0){
                                                    $nombre_grupo=$key['grupo']; 
                                                    $var2_aux.='<tr>
                                                                  <td colspan="8" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                                                </tr>';
                                                        $verificador=1;          
                                                  }

                                                  if($num==1){
                                                        $sw=0;
                                                        $var2_aux.="<tr>";
                                                        $var2_aux.='
                                                                    <td style="text-align:center;font-size:6px">
                                                                        <label class="control-label">'.$label.'</label>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                      ';
                                                      $num++;
                                                    }else if($num==4){
                                                            $var2_aux.='
                                                                        <td style="text-align:center;font-size:6px">
                                                                            <label class="control-label">'.$label.'</label>
                                                                        </td>
                                                                        <td>
                                                                        </td>
                                                                </tr>
                                                          ';
                                                      $num=1;    
                                                    }else{
                                                        $var2_aux.='
                                                                    <td style="text-align:center;font-size:6px">
                                                                        <label class="control-label">'.$label.'</label>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                              ';
                                                      $num++;      
                                                    }
                                              
                                          }
                                      }
                                  }
                                   if($num-1!=4 && $num-1!=0){
            
                                     $var2_aux.="</tr>";
                                  } 
            
                                  if($sw==0){
                                   
                                    $tabla.=$var2_aux;    
                                  }
                        
                        $tabla.=' 
                               </table>
                               <table border="1" style="font-size:6px;padding:1px">
                                    <tr>
                                      <td style="text-align:center">Detalle</td>
                                      <td style="text-align:center">CANT.</td>
                                      <td style="text-align:center">Estado</td>
                                      <td style="text-align:center">OBSERVACIONES</td>
                                    </tr>
                                    <tr>
                                      <td>Teclado</td>
                                      <td></td>
                                      <td>Oper  Defec</td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td>Mouse</td>
                                      <td></td>
                                      <td>Oper  Defec</td>
                                      <td></td>
                                   </tr>
                                    <tr>
                                      <td>Camaras</td>
                                      <td></td>
                                      <td>Oper  Defec</td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                        <td>Audifonos</td>
                                        <td></td>
                                        <td>Oper  Defec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Parlantes</td>
                                        <td></td>
                                        <td>Oper  Defec</td>
                                        <td></td>
                                    </tr>
                               </table> 
                        ';

                      
                    
                        $nombre_grupo="";
                        $var2_aux='<table border="1" style="font-size:6px;padding:1px">
                                   ';
                                   $sw=1;
                                   $num=1;
                                   $verificador=0;
                                    foreach ($campos as $key) {
                                      $id = $key['idCampo'];
                                      $label = $key['campo'];
                                      $idgrupo = intval($key['idGrupo']);
              
                                      if (intval($idgrupo) == 10) {
                                      
                                        if($verificador==0){
                                          $nombre_grupo=$key['grupo']; 
                                          $var2_aux.='<tr>
                                                        <td colspan="6" style="font-weight:bold;font-size:6px">'.$nombre_grupo.'</td>
                                                      </tr>';
                                              $verificador=1;          
                                        }

                                        if($num==1){
                                              $sw=0;
                                              $var2_aux.="<tr>";
                                              $var2_aux.='
                                                          <td style="text-align:center;font-size:6px">
                                                              <label class="control-label">'.$label.'</label>
                                                          </td>
                                                          <td>
                                                          </td>
                                            ';
                                            $num++;
                                          }else if($num==3){
                                                  $var2_aux.='
                                                              <td style="text-align:center;font-size:6px">
                                                                  <label class="control-label">'.$label.'</label>
                                                              </td>
                                                              <td>
                                                              </td>
                                                       </tr>
                                                ';
                                            $num=1;    
                                          }else{
                                              $var2_aux.='
                                                          <td style="text-align:center;font-size:6px">
                                                              <label class="control-label">'.$label.'</label>
                                                          </td>
                                                          <td>
                                                          </td>
                                                    ';
                                            $num++;      
                                          }
                                          
                                      }
                                    
                                    }
                                     if($num-1!=3 && $num-1!=0){
              
                                       $var2_aux.="</tr>";
                                    } 
              
                                    if($sw==0){
                                     
                                      $tabla.=$var2_aux;    
                                    }
                          
                          $tabla.=' 
                                 </table> 
                          ';
                                    


  
    $pdf->WriteHTMLCell(0,0,'','',$tabla,0,0);
    $pdf->Ln(4);
    $pdf->lastPage();
    $nom = "Reporte Notas.pdf";
    ob_end_clean();
    $pdf->output($nom, 'I');
?>