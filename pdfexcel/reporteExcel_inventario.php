<?php

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
$tipo_excel=$_POST['tipo_excel'];
$filename = "Reporte ".$tipo_excel.".xls";
// header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header('Content-Disposition: attachment; filename='.$filename);
session_start(); 
include ("../conexion.php"); 



echo "<h2 style='font-weight:bold'>Reportes ".$tipo_excel."</h2>
        <table border='1'>
		";

                    $consulta_formulario="SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblFormulario tf,tblDetalleFormulario td,tblCampo tc WHERE tc.idCampo=td.idCampo AND td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=6 or tc.idGrupo=7 or tc.idGrupo=8 or tc.idGrupo=9 or tc.idGrupo=10) ORDER BY tc.idGrupo";
		    $query_formulario=sqlsrv_query($con,$consulta_formulario);
                    $count_row=sqlsrv_has_rows($query_formulario); 
					
				?>					
					 <tr>
                                                        <th>ID formulario&#176;</th>     
                                                         <th>Nombre estacion&#176;</th>
							 <th>ID</th>
 
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
                                                                        <td>".utf8_decode($row['idFormulario'])."</td>
                                                                        <td>".utf8_decode($row['nom_estacion'])."</td>
                                                                        <td>".utf8_decode($row['idEstacion'])."</td>
                                                                        
                                                                        ";
                                                            } 
                                                            
                                                            
                                                            $nueva_consultita="SELECT * FROM (SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblDetalleFormulario td,tblFormulario tf,tblCampo tc WHERE td.idCampo=tc.idCampo and td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=6 or tc.idGrupo=7 or tc.idGrupo=8 or tc.idGrupo=9 or tc.idGrupo=10)) tmp1
                                                                                   LEFT JOIN (SELECT td.dato,td.idCampo FROM tblDetalleFormulario td,tblCampo tc where td.idCampo=tc.idCampo and idFormulario=$id_formulario) tmp2 on tmp1.idCampo = tmp2.idCampo ORDER BY tmp1.idGrupo,tmp1.idCampo";
                                                            $query_nueva_consulta=sqlsrv_query($con,$nueva_consultita);


                                                            while($rowi=sqlsrv_fetch_array($query_nueva_consulta)){

                                                                    $dato=$rowi['dato'];
                                                                    if(empty($dato)){
                                                                            echo "<td style='text-align:center'>N/A</td>";
                                                                    }else{   
                                                                            echo "<td style='text-align:center'>".utf8_decode($dato)."</td>";
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
                                                                        <td>".utf8_decode($row['idFormulario'])."</td>
                                                                        <td>".utf8_decode($row['nom_estacion'])."</td>
                                                                        <td>".utf8_decode($row['idEstacion'])."</td>
                                                                        
                                                                        ";
                                                            } 
                                                            
                                                            
                                                            $nueva_consultita="SELECT * FROM (SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblDetalleFormulario td,tblFormulario tf,tblCampo tc WHERE td.idCampo=tc.idCampo and td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=6 or tc.idGrupo=7 or tc.idGrupo=8 or tc.idGrupo=9 or tc.idGrupo=10)) tmp1
                                                                                   LEFT JOIN (SELECT td.dato,td.idCampo FROM tblDetalleFormulario td,tblCampo tc where td.idCampo=tc.idCampo and idFormulario=$id_formulario) tmp2 on tmp1.idCampo = tmp2.idCampo ORDER BY tmp1.idGrupo,tmp1.idCampo";
                                                            $query_nueva_consulta=sqlsrv_query($con,$nueva_consultita);


                                                            while($rowi=sqlsrv_fetch_array($query_nueva_consulta)){

                                                                  
                                                                    if(empty($rowi['dato'])){
                                                                            echo "<td style='text-align:center'>N/A</td>";
                                                                    }else{   
                                                                            echo "<td style='text-align:center'>".utf8_decode($rowi['dato'])."</td>";
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
                                                                        <td>".utf8_decode($row['idFormulario'])."</td>
                                                                        <td>".utf8_decode($row['nom_estacion'])."</td>
                                                                        <td>".utf8_decode($row['idEstacion'])."</td>
                                                                        
                                                                        ";
                                                            } 
                                                            
                                                            
                                                            $nueva_consultita="SELECT * FROM (SELECT DISTINCT(tc.campo),tc.idGrupo,tc.idCampo FROM tblDetalleFormulario td,tblFormulario tf,tblCampo tc WHERE td.idCampo=tc.idCampo and td.idFormulario=tf.idFormulario AND tf.tipo_formulario='$tipo_excel' and (tc.idGrupo=6 or tc.idGrupo=7 or tc.idGrupo=8 or tc.idGrupo=9 or tc.idGrupo=10)) tmp1
                                                                                   LEFT JOIN (SELECT td.dato,td.idCampo FROM tblDetalleFormulario td,tblCampo tc where td.idCampo=tc.idCampo and idFormulario=$id_formulario) tmp2 on tmp1.idCampo = tmp2.idCampo ORDER BY tmp1.idGrupo,tmp1.idCampo";
                                                            $query_nueva_consulta=sqlsrv_query($con,$nueva_consultita);


                                                            while($rowi=sqlsrv_fetch_array($query_nueva_consulta)){

                                                                    $dato=$rowi['dato'];
                                                                    if(empty($dato)){
                                                                            echo "<td style='text-align:center'>N/A</td>";
                                                                    }else{   
                                                                            echo "<td style='text-align:center'>".utf8_decode($dato)."</td>";
                                                                    }

                                                            }								
							echo "</tr>";

                                }
                        }
	echo "</table> <br>";												
									
        ?>	
		

		
