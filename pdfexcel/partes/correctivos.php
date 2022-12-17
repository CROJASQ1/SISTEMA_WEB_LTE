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
                                        $hora_ini_intervalo=$row_correctivo['hora_ini_intervalo'];

                                        $resultado=$fecha_inicial; 

                                        $fecha_fin_intervalo=$row_correctivo['fecha_fin_intervalo']->format('Y-m-d');   
                                        $hora_fin_intervalo=$row_correctivo['hora_fin_intervalo']; 
                                        
                                        $cfecha= $fecha_fin_intervalo;
 
                                        $fecha_1 = new DateTime($fecha_inicial." ".$hora_ini_intervalo);//fecha inicial
                                        $fecha_2 = new DateTime($fecha_fin_intervalo." ".$hora_fin_intervalo);//fecha de cierre
                                        $intervalo = $fecha_1->diff($fecha_2); 
                                }else{
                                        $cfecha="";
                                        $fecha_inicial="";
                                        $fecha_final="";
                                        $tiempo_horas="";
                                }

                                $contenido_tabla1.= "<td>".$resultado."</td>";
                                $contenido_tabla1.= "<td>".$cfecha."</td>";
                                $contenido_tabla1.= "<td>".$intervalo->format('%d Dias %H horas con %i minutos')."</td>";
                                $contenido_tabla1.= "<td>".utf8_decode($row_correctivo['nro_visitas'])."</td>";
                                $contenido_tabla1.= "<td>".utf8_decode($row_correctivo['observacion'])."</td>"; 


                        }

                }

                    /* buscar observacion en estado de estado de los servicios */

?>


