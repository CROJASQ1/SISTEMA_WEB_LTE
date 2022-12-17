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
             

                        $tsi="";
                        $tipo_energia="";
                        if(isset($row_formulario['tipo_est'])){
                                $array_datos=explode(',',$row_formulario['tipo_est']);
                                $tsi = $array_datos[0];
                                if(sizeof($array_datos)==2){
                                        $tipo_energia=$array_datos[1];
                                } 
                        }
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
                        $contenido_tabla1.= "<td>".utf8_decode($tipo_energia)."</td>";
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
                                
                        // 5 impresiones
                        include("correctivos.php");


                       
/*                         $contenido_tabla2.="<td></td>";
                        $contenido_tabla2.="<td></td>";
                        $contenido_tabla2.="<td></td>"; */
                        
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


                        $contenido_tabla3="";
                        $concat_equipo1="<td>";
                        $concat_serie1="<td>";
                        $concat_modelo="<td>";
                        $concat_serie2="<td>";
                        $concat_observaciones="<td>";

                        for ($i=1; $i <= 5; $i++) { 

                                        if(!empty($row_tipologia['marca_modelo2_'.$i]) 
                                                && !empty($row_tipologia['serie2_'.$i]) 
                                                && !empty($row_tipologia['marca_modelo1_'.$i])
                                                && !empty($row_tipologia['serie1_'.$i])
                                                && !empty($row_tipologia['observaciones_'.$i])
                                        ){
                                        $concat_equipo1.=utf8_decode($row_correctivo_tipo['marca_modelo2_'.$i])." - ";
                                        $concat_serie1.=utf8_decode($row_correctivo_tipo['serie2_'.$i])." - ";
                                        $concat_modelo.=utf8_decode($row_correctivo_tipo['marca_modelo1_'.$i])." - ";
                                        $concat_serie2.=utf8_decode($row_correctivo_tipo['serie1_'.$i])." - ";
                                        $concat_observaciones.=utf8_decode($row_correctivo_tipo['observaciones_'.$i])." - ";
                                }else{
                                        $concat_equipo1.=" ";
                                        $concat_serie1.=" ";
                                        $concat_modelo.=" ";
                                        $concat_serie2.=" ";
                                        $concat_observaciones.=" ";
                                }
                        }

                        $concat_equipo1.="</td>";
                        $concat_serie1.="</td>";
                        $concat_modelo.="</td>";
                        $concat_serie2.="</td>";
                        $concat_observaciones.="</td>";

                        $contenido_tabla3=$concat_equipo1.$concat_serie1.$concat_modelo.$concat_serie2.$concat_observaciones;

                        $sql_tipologia="SELECT * FROM tblTipologiaFallo WHERE idFormulario=$id_formulario ";
                        $query_tipologia=sqlsrv_query($con,$sql_tipologia);
                        $count_tipologia=sqlsrv_has_rows($query_tipologia);
                        $array_tipologia_grupo=array();
                        $array_tipologia_subgrupo=array();
                        $array_tipologia_rehabilitado=array();
                        if($count_tipologia){
                                while($row_tipologia=sqlsrv_fetch_array($query_tipologia)){
                                        if(!empty($row_tipologia['Grupo']) && !empty($row_tipologia['subgrupo'])){
                                                $var1= utf8_decode($row_tipologia['Grupo']);
                                                $var2= utf8_decode($row_tipologia['subgrupo']);
                                                $var3= "NO";
                                                array_push($array_tipologia_grupo,$var1);
                                                array_push($array_tipologia_subgrupo,$var2);
                                                array_push($array_tipologia_rehabilitado,$var3);
                                        }
                                }
                        }
                        $texto1=implode('-',$array_tipologia_grupo);
                        $texto2=implode('-',$array_tipologia_subgrupo);
                        $texto3=implode('-',$array_tipologia_rehabilitado);
                        
                        $contenido_tipologia_grupo='<td>'.$texto1."</td>"; 
                        $contenido_tipologia_subgrupo='<td>'.$texto2."</td>";
                        $contenido_tipologia_rehabilitado='<td>'.$texto3."</td>";
                        $contenido_tipologia=$contenido_tipologia_grupo.$contenido_tipologia_subgrupo.$contenido_tipologia_rehabilitado;
                        
                        
                        echo $abrir_fila;
                        echo $contenido_tabla1;
                        echo $contenido_tipologia;
                        echo $contenido_tabla3;
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo $contenido_tabla2;
                        echo $cerrar_fila;
                                        
                    }
            }

?>