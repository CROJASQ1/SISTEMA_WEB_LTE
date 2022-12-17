<?php

$tipo_excel=$_POST['tipo_excel'];

$fec_ini=$_POST['ini'];
$fec_fin=$_POST['fin'];

        if($fec_ini=="" && $fec_fin==""){

        }else{
                if($fec_ini==""){
                $fec_ini=$fec_fin;
                }else if($fec_fin==""){
                        $fec_fin=$fec_ini;
                }
        }

$filename = "Reporte ".$tipo_excel.".xls";
// header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header('Content-Disposition: attachment; filename='.$filename);
session_start(); 
include ("../conexion.php"); 

echo "<h2 style='font-weight:bold'>Reportes</h2>
        <table border='1'>
		";

                                        $consulta_formulario="SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblFormulario tf,tblDetalleFormulario td,tblCampo tc WHERE tc.idCampo=td.idCampo AND td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=1 or tc.idGrupo=2 or tc.idGrupo=3 or tc.idGrupo=4 or tc.idGrupo=5) ORDER BY tc.idGrupo";                    
                                        $query_formulario=sqlsrv_query($con,$consulta_formulario);
                                        $count_row=sqlsrv_has_rows($query_formulario); 
					
?>					
								<tr>
                                                                        <th>Nombre estacion&#176;</th>
									<th>ID</th>
                                                                        <th>Departamento&#176;</th>
                                                                        <th>Provincia&#176;</th>
                                                                        <th>Mun/Sec&#176;</th>
                                                                        <th>Localidad&#176;</th>
                                                                        <th>Latitud&#176;</th>
                                                                        <th>Longitud&#176;</th>
                                                                        <th>Distancia viaje&#176;</th>
									<th>Tipo estacion&#176;</th> 
									<th>codigo&#176;</th> 
									<th>Encargado&#176;</th>
									<th>Cel&#176;</th>
									<th>Inicio de internecion&#176;</th>								
									<th>Fin de intervencion&#176;</th>
									<th>Rdo&#176;</th>
									<th><?php echo utf8_decode("Porcentaje de señal")?></th>
									<th>Ubi Direccion&#176;</th>
									<th>Tipo trayecto&#176;</th>
									<th>Tramo 1&#176;</th>
									<th>Tramo 2&#176;</th>
									<th>Trayecto&#176;</th>
									<th>Tiempo viaje&#176;</th>

    

									<?php
                                                                                while($row_formulario=sqlsrv_fetch_array($query_formulario)){
                                                                                        echo "<th>".utf8_decode($row_formulario['campo'])."</th>";
                                                                                }
                                                                                
                                                                 
                                                                        ?>
								</tr>



					<?php

                                if($tipo_excel=='correctivo'){

                                    if($fec_ini=="" && $fec_fin==""){
                                        $corriendo_formularios="SELECT * from tblFormulario WHERE tipo_formulario='$tipo_excel'";
                                    }else{  
                                        $corriendo_formularios="SELECT * from tblFormulario tf,tblSolicitudCorrectivos tsc WHERE tsc.start >= '$fec_ini' AND tsc.start <= '$fec_fin' and tsc.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel'";
                                    } 
                     
                                           $query_corriendo_formularios=sqlsrv_query($con,$corriendo_formularios);
                                           while($row_c_form=sqlsrv_fetch_array($query_corriendo_formularios)){

                                            $id_formulario=$row_c_form['idFormulario'];

                                                $consulta_formulario2="SELECT * FROM tblFormulario WHERE idFormulario=$id_formulario";
                                                $query_formulario2=sqlsrv_query($con,$consulta_formulario2);

                                                while($row =sqlsrv_fetch_array($query_formulario2)) {
                                                    echo "<tr>

                                                                <td>".utf8_decode($row['nom_estacion'])."</td>
                                                                <td>".utf8_decode($row['idEstacion'])."</td>
                                                                <td>".utf8_decode($row['depto'])."</td>
                                                                <td>".utf8_decode($row['provincia'])."</td>
                                                                <td>".utf8_decode($row['mun_sec'])."</td>
                                                                <td>".utf8_decode($row['localidad'])."</td>
                                                                <td>".utf8_decode($row['latitud'])."</td>
                                                                <td>".utf8_decode($row['longitud'])."</td>
                                                                <td>".utf8_decode($row['distancia_viaje'])."</td>
                                                                <td>".utf8_decode($row['tipo_est'])."</td>
                                                                <td>".utf8_decode($row['codigo'])."</td>                                                    
                                                                <td>".utf8_decode($row['encargado'])."</td>
                                                                <td>".utf8_decode($row['cel'])."</td>
                                                                <td>".date_format($row['fecha_ini_intervalo'],'d/m/Y')."</td>
                                                                <td>".date_format($row['fecha_fin_intervalo'],'d/m/Y')."</td>       
                                                                <td>".utf8_decode($row['rdo'])."</td>
                                                                <td>".utf8_decode($row['porcentaje_senal'])."</td>
                                                                <td>".utf8_decode($row['ubi_direccion'])."</td>
                                                                <td>".utf8_decode($row['tipo_trayecto'])."</td>
                                                                <td>".utf8_decode($row['tramo_1'])."</td>
                                                                <td>".utf8_decode($row['tramo_2'])."</td>
                                                                <td>".utf8_decode($row['trayecto'])."</td>
                                                                <td>".utf8_decode($row['tiempoviaje'])."</td>

                                                                ";                                                                    
                                                            }                      
                                                            
                                                            $nueva_consultita="SELECT * FROM (SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblDetalleFormulario td,tblFormulario tf,tblCampo tc WHERE td.idCampo=tc.idCampo and td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=1 or tc.idGrupo=2 or tc.idGrupo=3 or tc.idGrupo=4 or tc.idGrupo=5)) tmp1
                                                                                    LEFT JOIN (SELECT td.dato,td.idCampo,tsc.start FROM tblDetalleFormulario td,tblCampo tc,tblSolicitudCorrectivos tsc where td.idFormulario=tsc.idFormulario AND td.idCampo=tc.idCampo and td.idFormulario=$id_formulario) tmp2 on tmp1.idCampo = tmp2.idCampo ORDER BY tmp1.idGrupo,tmp1.idCampo";



                                                            $query_nueva_consulta=sqlsrv_query($con,$nueva_consultita);

                                                            $sw=true;
                                                            $fecha="";
                                                            $rest_table="";
                                                            while($rowi=sqlsrv_fetch_array($query_nueva_consulta)){

                                                                   if($sw){ 
                                                                        $fecha=$rowi['start'];
                                                                        if($fecha!=false){

                                                                                $fecha=$rowi['start']->format('d-m-Y');
                                                                                $sw=false;         
                                                                        }       
                                                                   }  

                                                                    $dato=$rowi['dato'];
                                                                    if($dato==""){
                                                                            echo "<td style='text-align:center'>N/A</td>";
                                                                    }else{   
                                                                            echo "<td style='text-align:center'>".$dato."</td>";
                                                                    }

                                                            } 
										 				
                                                echo "</tr>";
 
                                            }

                                 }else if($tipo_excel=='preventivo'){

                                        if($fec_ini=="" && $fec_fin==""){
                                                $corriendo_formularios="SELECT * from tblFormulario WHERE tipo_formulario='$tipo_excel'";
                                            }else{  
                                                $corriendo_formularios="SELECT * from tblFormulario tf,tblPreventivo tp WHERE tp.fechaInicio >= '$fec_ini' AND tp.fechaInicio <= '$fec_fin' and tp.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel'";
                                            } 
                             
                                                   $query_corriendo_formularios=sqlsrv_query($con,$corriendo_formularios);
                                                   while($row_c_form=sqlsrv_fetch_array($query_corriendo_formularios)){
        
                                                    $id_formulario=$row_c_form['idFormulario'];
        
                                                        $consulta_formulario2="SELECT * FROM tblFormulario WHERE idFormulario=$id_formulario";
                                                        $query_formulario2=sqlsrv_query($con,$consulta_formulario2);
        
                                                        while($row =sqlsrv_fetch_array($query_formulario2)) {
                                                            echo "<tr>
        
                                                                        <td>".utf8_decode($row['nom_estacion'])."</td>
                                                                        <td>".utf8_decode($row['idEstacion'])."</td>
                                                                        <td>".utf8_decode($row['depto'])."</td>
                                                                        <td>".utf8_decode($row['provincia'])."</td>
                                                                        <td>".utf8_decode($row['mun_sec'])."</td>
                                                                        <td>".utf8_decode($row['localidad'])."</td>
                                                                        <td>".utf8_decode($row['latitud'])."</td>
                                                                        <td>".utf8_decode($row['longitud'])."</td>
                                                                        <td>".utf8_decode($row['distancia_viaje'])."</td>
                                                                        <td>".utf8_decode($row['tipo_est'])."</td>
                                                                        <td>".utf8_decode($row['codigo'])."</td>                                                    
                                                                        <td>".utf8_decode($row['encargado'])."</td>
                                                                        <td>".utf8_decode($row['cel'])."</td>
                                                                        <td>".date_format($row['fecha_ini_intervalo'],'d/m/Y')."</td>
                                                                        <td>".date_format($row['fecha_fin_intervalo'],'d/m/Y')."</td>       
                                                                        <td>".utf8_decode($row['rdo'])."</td>
                                                                        <td>".utf8_decode($row['porcentaje_senal'])."</td>
                                                                        <td>".utf8_decode($row['ubi_direccion'])."</td>
                                                                        <td>".utf8_decode($row['tipo_trayecto'])."</td>
                                                                        <td>".utf8_decode($row['tramo_1'])."</td>
                                                                        <td>".utf8_decode($row['tramo_2'])."</td>
                                                                        <td>".utf8_decode($row['trayecto'])."</td>
                                                                        <td>".utf8_decode($row['tiempoviaje'])."</td>
        
                                                                        ";                                                                    
                                                                    }                      
                                                                    
                                                                    $nueva_consultita="SELECT * FROM (SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblDetalleFormulario td,tblFormulario tf,tblCampo tc WHERE td.idCampo=tc.idCampo and td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=1 or tc.idGrupo=2 or tc.idGrupo=3 or tc.idGrupo=4 or tc.idGrupo=5)) tmp1
                                                                                            LEFT JOIN (SELECT td.dato,td.idCampo,tp.fechaInicio FROM tblDetalleFormulario td,tblCampo tc,tblPreventivo tp where td.idFormulario=tp.idFormulario AND td.idCampo=tc.idCampo and td.idFormulario=$id_formulario) tmp2 on tmp1.idCampo = tmp2.idCampo ORDER BY tmp1.idGrupo,tmp1.idCampo";
        
        
        
                                                                    $query_nueva_consulta=sqlsrv_query($con,$nueva_consultita);
        
                                                                    $sw=true;
                                                                    $fecha="";
                                                                    $rest_table="";
                                                                    while($rowi=sqlsrv_fetch_array($query_nueva_consulta)){
        
                                                                           if($sw){ 
                                                                                $fecha=$rowi['start'];
                                                                                if($fecha!=false){
        
                                                                                        $fecha=$rowi['start']->format('d-m-Y');
                                                                                        $sw=false;         
                                                                                }       
                                                                           }  
        
                                                                            $dato=$rowi['dato'];
                                                                            if($dato==""){
                                                                                    echo "<td style='text-align:center'>N/A</td>";
                                                                            }else{   
                                                                                    echo "<td style='text-align:center'>".$dato."</td>";
                                                                            }
        
                                                                    } 
                                                                                                                         
                                                        echo "</tr>";
         
                                                    }

                                 }else if($tipo_excel=='extracanon'){


                                        if($fec_ini=="" && $fec_fin==""){
                                                $corriendo_formularios="SELECT * from tblFormulario WHERE tipo_formulario='$tipo_excel'";
                                            }else{  
                                                $corriendo_formularios="SELECT * from tblFormulario tf,tblExtraCanon tec WHERE tec.fechaInicio >= '$fec_ini' AND tec.fechaInicio <= '$fec_fin' and tec.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel'";
                                            } 
                             
                                                   $query_corriendo_formularios=sqlsrv_query($con,$corriendo_formularios);
                                                   while($row_c_form=sqlsrv_fetch_array($query_corriendo_formularios)){
        
                                                    $id_formulario=$row_c_form['idFormulario'];
        
                                                        $consulta_formulario2="SELECT * FROM tblFormulario WHERE idFormulario=$id_formulario";
                                                        $query_formulario2=sqlsrv_query($con,$consulta_formulario2);
        
                                                        while($row =sqlsrv_fetch_array($query_formulario2)) {
                                                            echo "<tr>
        
                                                                        <td>".utf8_decode($row['nom_estacion'])."</td>
                                                                        <td>".utf8_decode($row['idEstacion'])."</td>
                                                                        <td>".utf8_decode($row['depto'])."</td>
                                                                        <td>".utf8_decode($row['provincia'])."</td>
                                                                        <td>".utf8_decode($row['mun_sec'])."</td>
                                                                        <td>".utf8_decode($row['localidad'])."</td>
                                                                        <td>".utf8_decode($row['latitud'])."</td>
                                                                        <td>".utf8_decode($row['longitud'])."</td>
                                                                        <td>".utf8_decode($row['distancia_viaje'])."</td>
                                                                        <td>".utf8_decode($row['tipo_est'])."</td>
                                                                        <td>".utf8_decode($row['codigo'])."</td>                                                    
                                                                        <td>".utf8_decode($row['encargado'])."</td>
                                                                        <td>".utf8_decode($row['cel'])."</td>
                                                                        <td>".date_format($row['fecha_ini_intervalo'],'d/m/Y')."</td>
                                                                        <td>".date_format($row['fecha_fin_intervalo'],'d/m/Y')."</td>       
                                                                        <td>".utf8_decode($row['rdo'])."</td>
                                                                        <td>".utf8_decode($row['porcentaje_senal'])."</td>
                                                                        <td>".utf8_decode($row['ubi_direccion'])."</td>
                                                                        <td>".utf8_decode($row['tipo_trayecto'])."</td>
                                                                        <td>".utf8_decode($row['tramo_1'])."</td>
                                                                        <td>".utf8_decode($row['tramo_2'])."</td>
                                                                        <td>".utf8_decode($row['trayecto'])."</td>
                                                                        <td>".utf8_decode($row['tiempoviaje'])."</td>
        
                                                                        ";                                                                    
                                                                    }                      
                                                                    
                                                                    $nueva_consultita="SELECT * FROM (SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblDetalleFormulario td,tblFormulario tf,tblCampo tc WHERE td.idCampo=tc.idCampo and td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=1 or tc.idGrupo=2 or tc.idGrupo=3 or tc.idGrupo=4 or tc.idGrupo=5)) tmp1
                                                                                            LEFT JOIN (SELECT td.dato,td.idCampo,tec.fechaInicio FROM tblDetalleFormulario td,tblCampo tc,tblExtraCanon tec where td.idFormulario=tec.idFormulario AND td.idCampo=tc.idCampo and td.idFormulario=$id_formulario) tmp2 on tmp1.idCampo = tmp2.idCampo ORDER BY tmp1.idGrupo,tmp1.idCampo";
        
        
        
                                                                    $query_nueva_consulta=sqlsrv_query($con,$nueva_consultita);
        
                                                                    $sw=true;
                                                                    $fecha="";
                                                                    $rest_table="";
                                                                    while($rowi=sqlsrv_fetch_array($query_nueva_consulta)){
        
                                                                           if($sw){ 
                                                                                $fecha=$rowi['start'];
                                                                                if($fecha!=false){
        
                                                                                        $fecha=$rowi['start']->format('d-m-Y');
                                                                                        $sw=false;         
                                                                                }       
                                                                           }  
        
                                                                            $dato=$rowi['dato'];
                                                                            if($dato==""){
                                                                                    echo "<td style='text-align:center'>N/A</td>";
                                                                            }else{   
                                                                                    echo "<td style='text-align:center'>".$dato."</td>";
                                                                            }
        
                                                                    } 
                                                                                                                         
                                                        echo "</tr>";
         
                                                    }

                                 }    
	
        echo "</table> <br>";				
                                                                                             
?>


                                                   <!--                                                                  
									<th>Equipo 1&#176;</th>
									<th>Marca/modelo 1&#176;</th>
									<th>Serie 1&#176;</th>
									<th>Marca/modelo 2_1&#176;</th>
									<th>Serie 2_2&#176;</th>
									<th>Observaciones 1&#176;</th>
									<th>Equipo 2&#176;</th>
									<th>Marca/modelo 2&#176;</th>
									<th>Serie 2&#176;</th>
									<th>Marca/modelo 2_1&#176;</th>
									<th>Serie 2_2&#176;</th>
									<th>Observaciones 1&#176;</th>
									<th>Equipo 3&#176;</th>
									<th>Marca/modelo 3&#176;</th>
									<th>Serie 3&#176;</th>
									<th>Marca/modelo 3_1&#176;</th>
									<th>Serie 3_2&#176;</th>
									<th>Observaciones 3&#176;</th>

									<th>Equipo 4&#176;</th>
									<th>Marca/modelo 4&#176;</th>
									<th>Serie 4&#176;</th>
									<th>Marca/modelo 4_1&#176;</th>
									<th>Serie 4_2&#176;</th>
									<th>Observaciones 4&#176;</th>

									<th>Equipo 5&#176;</th>
									<th>Marca/modelo 5&#176;</th>
									<th>Serie 5&#176;</th>
									<th>Marca/modelo 5_1&#176;</th>
									<th>Serie 5_2&#176;</th>
									<th>Observaciones 5&#176;</th>

									<th>Item cambiado 1&#176;</th>
									<th>Cant 1&#176;</th>
									<th>Obs 1&#176;</th>
									<th>Item cambiado 1_2&#176;</th>
									<th>Cant 1_2&#176;</th>
									<th>Obs 1_2&#176;</th>

									<th>Item cambiado 2&#176;</th>
									<th>Cant 2&#176;</th>
									<th>Obs 2&#176;</th>
									<th>Item cambiado 2_2&#176;</th>
									<th>Cant 2_2&#176;</th>
									<th>Obs 2_2&#176;</th>

									<th>Item cambiado 3&#176;</th>
									<th>Cant 3&#176;</th>
									<th>Obs 3&#176;</th>
									<th>Item cambiado 3_2&#176;</th>
									<th>Cant 3_2&#176;</th>
									<th>Obs 3_2&#176;</th>

									<th>Item cambiado 4&#176;</th>
									<th>Cant 4&#176;</th>
									<th>Obs 4&#176;</th>
									<th>Item cambiado 4_2&#176;</th>
									<th>Cant 4_2&#176;</th>
									<th>Obs 4_2&#176;</th>

									<th>Item cambiado 5&#176;</th>
									<th>Cant 5&#176;</th>
									<th>Obs 5&#176;</th>
									<th>Item cambiado 5_2&#176;</th>
									<th>Cant 5_2&#176;</th>
									<th>Obs 5_2&#176;</th>
 -->


                                <!--               <td>".utf8_decode($row['equipo_1'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo1_1'])."</td>
                                                                <td>".utf8_decode($row['serie1_1'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo2_1'])."</td>
                                                                <td>".utf8_decode($row['serie2_1'])."</td>
                                                                <td>".utf8_decode($row['observaciones_1'])."</td>

                                                                <td>".utf8_decode($row['equipo_2'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo1_2'])."</td>
                                                                <td>".utf8_decode($row['serie1_2'])."</td>	  
                                                                <td>".utf8_decode($row['marca_modelo2_2'])."</td>
                                                                <td>".utf8_decode($row['serie2_2'])."</td>
                                                                <td>".utf8_decode($row['observaciones_2'])."</td>	

                                                                <td>".utf8_decode($row['equipo_3'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo1_3'])."</td>
                                                                <td>".utf8_decode($row['serie1_3'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo2_3'])."</td>
                                                                <td>".utf8_decode($row['serie2_3'])."</td>
                                                                <td>".utf8_decode($row['observaciones_3'])."</td>

                                                                <td>".utf8_decode($row['equipo_4'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo1_4'])."</td>
                                                                <td>".utf8_decode($row['serie1_4'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo2_4'])."</td>
                                                                <td>".utf8_decode($row['serie2_4'])."</td>
                                                                <td>".utf8_decode($row['observaciones_4'])."</td>

                                                                <td>".utf8_decode($row['equipo_5'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo1_5'])."</td>
                                                                <td>".utf8_decode($row['serie1_5'])."</td>
                                                                <td>".utf8_decode($row['marca_modelo2_5'])."</td>
                                                                <td>".utf8_decode($row['serie2_5'])."</td>
                                                                <td>".utf8_decode($row['observaciones_5'])."</td>


                                                                <td>".utf8_decode($row['item_cambiado1_1'])."</td>
                                                                <td>".utf8_decode($row['cant1_1'])."</td>
                                                                <td>".utf8_decode($row['obs1_1'])."</td>
                                                                <td>".utf8_decode($row['item_cambiado2_1'])."</td>
                                                                <td>".utf8_decode($row['cant2_1'])."</td>
                                                                <td>".utf8_decode($row['obs2_1'])."</td>

                                                                <td>".utf8_decode($row['item_cambiado1_2'])."</td>
                                                                <td>".utf8_decode($row['cant1_2'])."</td>
                                                                <td>".utf8_decode($row['obs1_2'])."</td>
                                                                <td>".utf8_decode($row['item_cambiado2_2'])."</td>
                                                                <td>".utf8_decode($row['cant2_2'])."</td>
                                                                <td>".utf8_decode($row['obs2_2'])."</td>

                                                                <td>".utf8_decode($row['item_cambiado1_3'])."</td>
                                                                <td>".utf8_decode($row['cant1_3'])."</td>
                                                                <td>".utf8_decode($row['obs1_3'])."</td>
                                                                <td>".utf8_decode($row['item_cambiado2_3'])."</td>
                                                                <td>".utf8_decode($row['cant2_3'])."</td>
                                                                <td>".utf8_decode($row['obs2_3'])."</td>

                                                                <td>".utf8_decode($row['item_cambiado1_4'])."</td>
                                                                <td>".utf8_decode($row['cant1_4'])."</td>
                                                                <td>".utf8_decode($row['obs1_4'])."</td>
                                                                <td>".utf8_decode($row['item_cambiado2_4'])."</td>
                                                                <td>".utf8_decode($row['cant2_4'])."</td>
                                                                <td>".utf8_decode($row['obs2_4'])."</td>

                                                                <td>".utf8_decode($row['item_cambiado1_5'])."</td>
                                                                <td>".utf8_decode($row['cant1_5'])."</td>
                                                                <td>".utf8_decode($row['obs1_5'])."</td>
                                                                <td>".utf8_decode($row['item_cambiado2_5'])."</td>
                                                                <td>".utf8_decode($row['cant2_5'])."</td>
                                                                <td>".utf8_decode($row['obs2_5'])."</td> -->	


		
