<?php
 
                $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.start,tp.hora,tp.fechafin,tp.nro_visitas,tp.observacion from tblFormulario tf,tblSolicitudCorrectivos tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'correctivo') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$id_formulario  AND tf.tipo_formulario like 'correctivo'";
                $query_correctivo=sqlsrv_query($con,$sql_pre);
                $count_correctivo=sqlsrv_has_rows($query_correctivo);
                if($count_correctivo!=false){
                        while($row_correctivo=sqlsrv_fetch_array($query_correctivo)){

                                set_time_limit(25);
                                $fecha_inicial=$row_correctivo['start'];
                                if($fecha_inicial!=false){
                                                    
                                        $fecha_inicial=$row_correctivo['start']->format('d-m-Y');
                                        $hora_inicial=$row_correctivo['hora'];

                                        $resultado=$fecha_inicial." ".$hora_inicial; 

                                        $fecha_fin_intervalo=$row_correctivo['fecha_fin_intervalo']->format('Y-m-d');   
                                        $hora_fin_intervalo=$row_correctivo['hora_fin_intervalo']; 
                                        
                                        $cfecha= $fecha_fin_intervalo." ".$hora_fin_intervalo;
 
                                        $t1 = StrToTime ($cfecha); 
                                        $t2 = StrToTime ($resultado); 
                                        $diff = $t1 - $t2; 
                                        $hours = $diff/(60 * 60); 
                                }else{
                                        $cfecha="";
                                        $fecha_inicial="";
                                        $fecha_final="";
                                        $tiempo_horas="";
                                }

                                $contenido_tabla1.= "<td>".$resultado."</td>";
                                $contenido_tabla1.= "<td>".$cfecha."</td>";
                                $contenido_tabla1.= "<td>".$hours."</td>";
                                $contenido_tabla1.= "<td>".utf8_decode($row_correctivo['nro_visitas'])."</td>";
                                $contenido_tabla1.= "<td>".utf8_decode($row_correctivo['observacion'])."</td>"; 


                        }

                }

                    /* buscar observacion en estado de estado de los servicios */

?>


