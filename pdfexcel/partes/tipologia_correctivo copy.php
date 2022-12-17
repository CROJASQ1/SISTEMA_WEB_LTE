<?php
  $contenido_tabla1="";
  $contenido_tabla2="";
  $contenido_tabla3="";

            /* correctivos_TIPOLOGIA */
            $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.start,tp.fechafin,tp.nro_visitas,tp.observacion from tblFormulario tf,tblSolicitudCorrectivos tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'correctivo') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$id_formulario AND tf.tipo_formulario like 'correctivo'";
                    
            $query_correctivo_tipo=sqlsrv_query($con,$sql_pre);
            $count_correctivo_tipo=sqlsrv_has_rows($query_correctivo_tipo);

            if($count_correctivo_tipo!=false){
                    
                    $vector_equipo_reemplazo=array(); 
                    $vector_modelo_retirado=array(); 
                    $vector_modelo_reemplazo=array();
                    $vector_serie_reemplazo=array();
                    $vector_serie_retirado=array();  
                    $vector_observaciones=array(); 
                    while($row_correctivo_tipo=sqlsrv_fetch_array($query_correctivo_tipo)){
                            set_time_limit(25);
             

                        $tsi= extraer($row_formulario['tipo_est']);
                        $tipo_tec=extraer2($row_formulario['tipo_est']);
                        $estacionhub=$row_formulario['estacionHub'];
                        
                        if(!empty($estacionhub)){
                        $estacionhub="(".$estacionhub.")";
                        }

                        $contenido_tabla1.= "<td>".$num."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['idEstacion'])."  </td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['nombre_Estacion'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($tsi)."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['depto'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['provincia'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['mun_sec'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['localidad'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['sistema']).utf8_decode($estacionhub)."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($tipo_tec)."</td>";
                        $contenido_tabla1.= "<td></td>";
                        $contenido_tabla1.= "<td></td>";
                        $contenido_tabla1.= "<td></td>";  

                        $contenido_tabla1.= "<td></td>";
                        $contenido_tabla1.= "<td></td>";
                        $contenido_tabla1.= "<td></td>";  
                        $contenido_tabla1.= "<td></td>";     
                        $contenido_tabla1.= "<td></td>";

                        $contenido_tabla1.= "<td></td>";
                        $contenido_tabla1.= "<td></td>";  
                        $contenido_tabla1.= "<td></td>";     
                        $contenido_tabla1.= "<td></td>";
                                

                        include("correctivos.php");


                       
                        $contenido_tabla2.="<td></td>";
                        $contenido_tabla2.="<td></td>";
                        $contenido_tabla2.="<td></td>";
                        
                        $consulta_formulario_final="SELECT * FROM tblFormulario tf,tblEstaciones te WHERE tf.idEstacion=te.idEstacion AND tf.idFormulario=$id_formulario";
                        $query_formulario_final=sqlsrv_query($con,$consulta_formulario_final);
                        $count_formulario_final=sqlsrv_has_rows($query_formulario_final);
                        if($count_formulario_final!=""){
                                while($row_formulario_final=sqlsrv_fetch_array($query_formulario_final)){  
                                        set_time_limit(25);
                                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['tipo_trayecto'])."</td>";
                                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['tramo_1'])."</td>";
                                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['tramo_2'])."</td>";
                                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['observaciones_trayecto'])."</td>";                                        
                                        
                                }
                        }
                        
                        $tama_vector=0;
                        $concat_equipo="<td>";
                        $concat_serie="<td>";
                        $concat_modelo="<td>";
                        $concat_serieModelo="<td>";
                        for ($i=1; $i <= 5 ; $i++) {       
                                        $concat_equipo.= utf8_decode($row_preventivo['equipo_'.$i.''])."   ";  
                                        $concat_serie.= utf8_decode($row_preventivo['serie1_'.$i.''])."   ";
                                        $concat_modelo.= utf8_decode($row_preventivo['marca_modelo2_'.$i.''])."   ";
                                        $concat_serieModelo.= utf8_decode($row_preventivo['serie2_'.$i.''])."   "; 
                        }
                        
                        $concat_equipo.="</td>";
                        $concat_serie.="</td>";
                        $concat_modelo.="</td>";
                        $concat_serieModelo.="</td>";
                        $contenido_tabla3.=$concat_equipo.$concat_serie.$concat_modelo.$concat_serieModelo;
                        
                        for ($i=1; $i <= 5; $i++) { 

                                $nombre='marca_modelo2_'.$i;
                                $nombre_grupo='equipo_'.$i;
                                $nombre_modelo_reemplazo='marca_modelo1_'.$i;
                                $nombre_serie_reemplazo='serie1_'.$i;
                                $nombre_serie_retirado='serie2_'.$i;
                                $nombre_observaciones='observaciones_'.$i;


                                $dato_defectuoso=$row_correctivo_tipo[$nombre];
                                $dato_repuesto=$row_correctivo_tipo[$nombre_grupo];
                                $dato_serie1=$row_correctivo_tipo[$nombre_serie_reemplazo];
                                $dato_serie2=$row_correctivo_tipo[$nombre_serie_retirado];
                                $dato_modelo_reemplazo=$row_correctivo_tipo[$nombre_modelo_reemplazo];
                                $dato_observaciones=$row_correctivo_tipo[$nombre_observaciones];


                                if(!empty($dato_defectuoso)){
                                        $vector_modelo_retirado[$tama_vector]=$dato_defectuoso;
                                        $vector_equipo_reemplazo[$tama_vector]=$dato_repuesto;
                                        $vector_modelo_reemplazo[$tama_vector]=$dato_modelo_reemplazo;
                                        $vector_serie_reemplazo[$tama_vector]=$dato_serie1;
                                        $vector_serie_retirado[$tama_vector]=$dato_serie2;
                                        $vector_observaciones[$tama_vector]=$dato_observaciones;
                                        $tama_vector++;
                                }
                        }

                                        $tamaño_vector=sizeof($vector_modelo_retirado);
                                        
                                        if($tamaño_vector==0){
                                                echo $abrir_fila;
                                                echo $contenido_tabla1;
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo $contenido_tabla2;
                                                echo $cerrar_fila;
                                        }else{
                                                for ($i=0; $i < $tama_vector; $i++) { 
                                                        echo $abrir_fila;
                                                        echo $contenido_tabla1;
                                                        $grupito=grupo($vector_equipo_reemplazo[$i]);
                                                        echo "<td>".$grupito."</td>";
                                                        echo "<td>".$vector_equipo_reemplazo[$i]."</td>";
                                                        echo "<td>SI</td>";
                                                        echo "<td>".$vector_modelo_retirado[$i]."</td>";
                                                        echo "<td>".$vector_serie_retirado[$i]."</td>";
                                                        echo "<td>".$vector_modelo_reemplazo[$i]."</td>";
                                                        echo "<td>".$vector_serie_reemplazo[$i]."</td>";
                                                        echo "<td>".$vector_observaciones[$i]."</td>";
                                                        echo $contenido_tabla2;
                                                        echo $cerrar_fila;
                                                }         
                                        }   
                                        
                                        $sql_tipologia="SELECT * FROM tblTipologiaFallo WHERE idFormulario=$id_formulario ";
                                        $query_tipologia=sqlsrv_query($con,$sql_tipologia);
                                        $count_tipologia=sqlsrv_has_rows($query_tipologia);

                                        if($count_tipologia!=false){

                                                while($row_tipologia=sqlsrv_fetch_array($query_tipologia)){
                                                        echo $abrir_fila;
                                                        echo $contenido_tabla1;
                                                        echo "<td>".$row_tipologia['grupo']."</td>";
                                                        echo "<td>".$row_tipologia['subgrupo']."</td>";
                                                        echo "<td>NO</td>";
                                                        echo "<td></td>";
                                                        echo "<td></td>";
                                                        echo "<td></td>";
                                                        echo "<td></td>";
                                                        echo "<td>".$row_tipologia['observaciones']."</td>";
                                                        echo $contenido_tabla2;
                                                        echo $cerrar_fila;
                                                }

                                        }       
                                        
                    }
            }

?>