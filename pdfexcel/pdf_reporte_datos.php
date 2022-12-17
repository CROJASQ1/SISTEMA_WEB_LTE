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
  
    $detalle = "SELECT * FROM tblFormulario WHERE idFormulario=$id_formulario";
    $cam_det=sqlsrv_query($con, $detalle);
    $contando_deta=sqlsrv_has_rows($cam_det);
    $row_form=sqlsrv_fetch_array($cam_det);
    
    $tipo=$row_form['tipo_formulario'];

    $descripcion = 'MANTENIMIENTO '.$tipo.''; 
    $tam=strlen($descripcion)*2.1;
    $pdf->MultiCell($tam, 2, $descripcion, 0, 'L', 0, 1, 80, $salto, true);
    $sig=$tam+6;

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
                            <td width="50">'.$row_form['idEstacion'].'</td>
                            <td width="57"> Tipo de est</td>
                            <td width="180">'.$row_form['tipo_est'].'</td>
                            <td width="40"> Est. Hub.</td>
                            <td width="70">'.$row_form['estacionHub'].'</td>
                            <td width="60"> Codigo</td>
                            <td width="70.5"> '.$row_form['codigo'].' </td>
                        </tr>

                        <tr>
                            <td width="40"> Depto</td>
                            <td width="120">'.$row_form['depto'].'</td>
                            <td width="65"> Encargado</td>
                            <td width="167">'.$row_form['encargado'].'</td>
                            <td width="30"> Cel</td>
                            <td width="136" >'.$row_form['cel'].'</td>
                        </tr>

                        <tr>
                            <td width="60"> Provincia</td>
                            <td width="102.5">'.$row_form['provincia'].'</td>
                            <td width="50"> Lat(Dec)</td>
                            <td width="100">'.$row_form['latitud'].'</td>
                            <td width="55"> Fecha Ini Interv</td>
                            <td width="70" >'.$row_form['fecha_ini_intervalo']->format('Y-m-d').'</td>
                            <td width="50"> Hora Ini Interv</td>
                            <td width="70" >'.$row_form['hora_ini_intervalo'].'</td>
                           
                        </tr>

                        <tr>
                           
                            <td width="60"> Mun/Secc</td>
                            <td width="102.5">'.$row_form['mun_sec'].'</td>
                            <td width="50"> Long(Dec)</td>
                            <td width="100">'.$row_form['longitud'].'</td>
                            <td width="55"> Fecha fin Interv</td>
                            <td width="70" >'.$row_form['fecha_fin_intervalo']->format('Y-m-d').'</td>
                            <td width="50"> Hora fin Interv</td>
                            <td width="70" >'.$row_form['hora_fin_intervalo'].'</td>
                      </tr>

                      <tr>
                            <td width="60"> Localidad</td>
                            <td width="172.5">'.$row_form['localidad'].'</td>
                            <td width="60"> Cober.Cel</td>
                            <td width="100">'.$row_form['tipo_formulario'].'</td>
                            <td width="70"> Porcentaje de señal</td>
                            <td width="95" >'.$row_form['porcentaje_senal'].'</td>
                      </tr>

                      <tr>
                            <td width="83"> Nombre de la estacion</td>
                            <td width="196">'.$row_form['nom_estacion'].'</td>
                            <td width="83"> Ubicacion y/o direccion</td>
                            <td width="195.5">'.$row_form['ubi_direccion'].'</td>
                      </tr>

                      <tr>
                          <td width="100"> Tipo de trayecto</td>
                          <td width="115">'.$row_form['tipo_trayecto'].'</td>
                          <td width="65"> Tram-1 (Hr)</td>
                          <td width="50">'.$row_form['tramo_1'].'</td>
                          <td width="50"> Tram-2 (Hr)</td>
                          <td width="50">'.$row_form['tramo_2'].'</td>
                          <td width="70"> Distancia de viaje (Km)</td>
                          <td width="58">'.$row_form['distancia_viaje'].'</td>
                      </tr>

                      <tr>
                          <td width="45">Trayecto</td>
                          <td width="280">'.$row_form['trayecto'].'</td>
                          <td width="90"> Tiempo de viaje(Hr)</td>
                          <td width="98">'.$row_form['tiempoviaje'].'</td>
                      </tr>

                      <tr>
                      <td width="70">Observaciones del trayecto</td>
                      <td width="340">'.$row_form['observaciones_trayecto'].'</td>
                      <td width="50"> Ejecutado </td>
                      <td width="98">'.$row_form['ejecutado'].'</td>
                  </tr>
            ';
      $tabla .='</table>';
 


   if($tipo=="CORRECTIVO"){

        $sql="SELECT * FROM tblSolicitudCorrectivos WHERE idFormulario=$id_formulario";
        $query_sql=sqlsrv_query($con,$sql);
        $row_correctivos=sqlsrv_fetch_array($query_sql);

        $fecha_retiro_equipo=$row_correctivo['fecha_retiro_equipo'];
        $fecha_reclamo_cliente=$row_correctivo['fecha_reclamo_cliente'];

        $start=$row_correctivo['start'];

        if(!empty($fecha_retiro_equipo)){
              $fecha_retiro_equipo=$fecha_retiro_equipo->format('Y-m-d');
        }
        
        if(!empty($fecha_reclamo_cliente)){
          $fecha_reclamo_cliente=$fecha_reclamo_cliente->format('Y-m-d');
        }

        if(!empty($start)){
          $start=$start->format('Y-m-d');
        }


        $tabla .='
              <table  border="1" style="font-size:6px;padding:1px">
                <tr>
                    <td colspan="6"><h3 style="font-size:6px;font-weight:bold">DATOS EMISION ORDEN DE TRABAJO</h3></td>
                </tr>
                <tr>
                    <td  width="50"> N° OT</td>
                    <td width="60">'.$row_correctivo['nro_ot'].'</td>
                    <td width="75"> N° Tramite</td>
                    <td width="150">'.$row_correctivo['nro_tramite'].'</td>
                    <td width="70"> Correo de:</td>
                    <td width="153">'.$row_correctivo['correo_de'].'</td>
                </tr>
                <tr>
                    <td width="120"> Fecha/hora Recepcion de OT</td>
                    <td width="169">'.$start.' : '.$row_correctivo['hora'].'</td>
                    <td width="100"> Fecha/Hora Reclamo Cliente</td>
                    <td width="169">'.$fecha_reclamo_cliente.' : '.$row_correctivo['hora_reclamo_cliente'].'</td>
                </tr>

                <tr>
                    <td width="125"> ¿Se Requiere retiro de Equipos amacenes Entel?</td>
                    <td width="170">'.$row_correctivo['retiro_equipo_almacenes'].'</td>
                    <td width="110"> Fecha/Hora Retiro equipos</td>
                    <td width="153">'.$fecha_retiro_equipo.' : '.$row_correctivo['hora_retiro_equipo'].'</td>
                </tr>
                <tr>
                    <td width="95"> Descripcion del reclamo</td>
                    <td width="230">'.$row_correctivo['descripcion_reclamo'].'</td>
                    <td width="80"> N° de visitas por OT</td>
                    <td width="153">'.$row_correctivo['nro_visitas'].'</td>
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
                              <td>'.$row_form['equipo_1'].'</td>
                              <td>'.$row_form['marca_modelo1_1'].'</td>
                              <td>'.$row_form['serie1_1'].'</td>
                              <td>'.$row_form['marca_modelo2_1'].'</td>
                              <td>'.$row_form['serie2_1'].'</td>
                              <td>'.$row_form['observaciones_1'].'</td>
                            </tr>
                             <tr>
                              <td>'.$row_form['equipo_2'].'</td>
                              <td>'.$row_form['marca_modelo1_2'].'</td>
                              <td>'.$row_form['serie1_2'].'</td>
                              <td>'.$row_form['marca_modelo2_2'].'</td>
                              <td>'.$row_form['serie2_2'].'</td>
                              <td>'.$row_form['observaciones_2'].'</td>
                            </tr>
                             <tr>
                                <td>'.$row_form['equipo_3'].'</td>
                                <td>'.$row_form['marca_modelo1_3'].'</td>
                                <td>'.$row_form['serie1_3'].'</td>
                                <td>'.$row_form['marca_modelo2_3'].'</td>
                                <td>'.$row_form['serie2_3'].'</td>
                                <td>'.$row_form['observaciones_3'].'</td>
                            </tr>
                             <tr>
                                <td>'.$row_form['equipo_4'].'</td>
                                <td>'.$row_form['marca_modelo1_4'].'</td>
                                <td>'.$row_form['serie1_4'].'</td>
                                <td>'.$row_form['marca_modelo2_4'].'</td>
                                <td>'.$row_form['serie2_4'].'</td>
                                <td>'.$row_form['observaciones_4'].'</td>
                            </tr> 
                            <tr>
                                <td>'.$row_form['equipo_5'].'</td>
                                <td>'.$row_form['marca_modelo1_5'].'</td>
                                <td>'.$row_form['serie1_5'].'</td>
                                <td>'.$row_form['marca_modelo2_5'].'</td>
                                <td>'.$row_form['serie2_5'].'</td>
                                <td>'.$row_form['observaciones_5'].'</td>
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
                                <td width="123.5">'.$row_form['item_cambiado1_1'].'</td>
                                <td width="45">'.$row_form['cant1_1'].'</td>
                                <td>'.$row_form['obs1_1'].'</td>
                                <td  width="125">'.$row_form['item_cambiado2_1'].'</td>
                                <td width="45">'.$row_form['cant2_1'].'</td>
                                <td>'.$row_form['obs2_1'].'</td>
                           </tr>

                           <tr>
                              <td width="123.5">'.$row_form['item_cambiado1_2'].'</td>
                              <td width="45">'.$row_form['cant1_2'].'</td>
                              <td>'.$row_form['obs1_2'].'</td>
                              <td  width="125">'.$row_form['item_cambiado2_2'].'</td>
                              <td width="45">'.$row_form['cant2_2'].'</td>
                              <td>'.$row_form['obs2_2'].'</td>
                            </tr>

                            <tr>
                                <td width="123.5">'.$row_form['item_cambiado1_3'].'</td>
                                <td width="45">'.$row_form['cant1_3'].'</td>
                                <td>'.$row_form['obs1_3'].'</td>
                                <td  width="125">'.$row_form['item_cambiado2_3'].'</td>
                                <td width="45">'.$row_form['cant2_3'].'</td>
                                <td>'.$row_form['obs2_3'].'</td>
                           </tr>
                           <tr>
                                <td width="123.5">'.$row_form['item_cambiado1_4'].'</td>
                                <td width="45">'.$row_form['cant1_4'].'</td>
                                <td>'.$row_form['obs1_4'].'</td>
                                <td  width="125">'.$row_form['item_cambiado2_4'].'</td>
                                <td width="45">'.$row_form['cant2_4'].'</td>
                                <td>'.$row_form['obs2_4'].'</td>
                           </tr>
                           <tr>
                                <td width="123.5">'.$row_form['item_cambiado1_5'].'</td>
                                <td width="45">'.$row_form['cant1_5'].'</td>
                                <td>'.$row_form['obs1_5'].'</td>
                                <td  width="125">'.$row_form['item_cambiado2_5'].'</td>
                                <td width="45">'.$row_form['cant2_5'].'</td>
                                <td>'.$row_form['obs2_5'].'</td>
                           </tr>
                    </table>
                  '; 

 
        $detalle = "SELECT td.dato,tc.campo,tc.idGrupo,tc.linea,tg.grupo FROM tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE td.idFormulario=$id_formulario AND tc.idCampo=td.idCampo AND tc.idGrupo=tg.idGrupo";
        $cam_det=sqlsrv_query($con, $detalle);
        $contando_deta=sqlsrv_has_rows($cam_det);
        $campos = array(); 
        $campos_detalle = array();
        if($contando_deta===false){
          
        }else{
          while($row=sqlsrv_fetch_array($cam_det)){
            $campos_detalle[] = $row;
          }
        }



        $var2_aux='<table border="1" style="font-size:6px;padding:0px">';
        $sw=1;
        $verificador=0;
        foreach ($campos_detalle as $key) {
          

                    $id = $key['idCampo'];
                    $label = $key['campo'];
                    $dato_s = $key['dato'];
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
                                        <label class="control-label">'.$dato_s.'</label><br>
                                  </td>
                            </tr>';
                    }
                  }if($sw==0){
                    $tabla.=$var2_aux;    
                  }
        $tabla.=' 
                </table>
        '; 






        $consulta_grupos="SELECT DISTINCT(tc.idGrupo) FROM tblDetalleFormulario td,tblCampo tc WHERE td.idFormulario=$id_formulario AND tc.idCampo=td.idCampo";
        $query_consulta_grupos=sqlsrv_query($con,$consulta_grupos);
        $count_grupos=sqlsrv_has_rows($query_consulta_grupos);

        if($count_grupos===false){

        }else{

          while($fila_grupos=sqlsrv_fetch_array($query_consulta_grupos)){

             $idGrupo=$fila_grupos['idGrupo'];
             if($idGrupo>=2 && $idGrupo<=5){
        
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
                          
                          $tabla.=$var2_aux;    
                        }

                        $tabla.=' </table> ';  
                    }
              }
          }

      } 



      $pdf->WriteHTMLCell(0,0,'','',$tabla,0,0);

      $probando="SELECT DISTINCT(tc.idGrupo) FROM tblDetalleFormulario td,tblCampo tc WHERE td.idFormulario=$id_formulario AND tc.idCampo=td.idCampo and tc.idGrupo>5";
      $query_probando=sqlsrv_query($con,$probando);
      $count_probando=sqlsrv_has_rows($query_probando);

      if($count_probando===false){

      }else{
                $pdf->addPage();
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
    $nom = "Reporte Notas.pdf";
    ob_end_clean();
    $pdf->output($nom, 'I');
?>