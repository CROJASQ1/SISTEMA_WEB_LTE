<?php
    $contenido_tabla1="";
    $contenido_tabla2="";
    $contenido_tabla3="";
    /* preventivos */
        $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.fechaInicio,tp.fechaFinal,tp.horaInicio,tf.ejecutado from tblFormulario tf,tblPreventivo tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'preventivo') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$id_formulario  AND tf.tipo_formulario like 'preventivo'";
        $query_preventivo=sqlsrv_query($con,$sql_pre);
        $count_preventivo=sqlsrv_has_rows($query_preventivo);  
        if($count_preventivo!=false){
                while($row_preventivo=sqlsrv_fetch_array($query_preventivo)){
                        
                        set_time_limit(25);
                        $fecha_inicial=$row_preventivo['fechaInicio'];
                        $hora_inicial=$row_preventivo['horaInicio'];
                        $ejecutado=$row_preventivo['ejecutado'];

                        if(!empty($fecha_inicial)){
                                        $fecha_inicial=$row_preventivo['fechaInicio']->format('Y-m-d');
                                        $hora_ini_intervalo=$row_preventivo['hora_ini_intervalo'];
                                        $resultado=$fecha_inicial; 
                                        $fecha_fin_intervalo=$row_preventivo['fecha_fin_intervalo']->format('Y-m-d');   
                                        $hora_fin_intervalo=$row_preventivo['hora_fin_intervalo']; 
                                        
                                        $sfecha= $fecha_fin_intervalo;      

                                        $fecha1 = new DateTime($fecha_inicial." ".$hora_ini_intervalo);//fecha inicial
                                        $fecha2 = new DateTime($fecha_fin_intervalo." ".$hora_fin_intervalo);//fecha de cierre
                                        $intervalo = $fecha1->diff($fecha2);



                        }else{
                                $fecha_inicial="";
                                $sfecha="";
                                $fecha="";
                                $hours="";
                                $resultado="";
                        }

                        $tsi="";
                        $tipo_energia="";
                        if(isset($row_formulario['tipo_est'])){
                                $array_datos=explode(',',$row_formulario['tipo_est']);
                                $tsi = $array_datos[0];
                                if(sizeof($array_datos)==2){
                                        $tipo_energia=$array_datos[1];
                                } 
                        }


                        $contenido_tabla1.= "<td>".$num."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['id'])."  </td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['nombre_Estacion'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($tsi)."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['depto'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['provincia'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['mun_sec'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['localidad'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($row_formulario['sistema'])."</td>";
                        $contenido_tabla1.= "<td>".utf8_decode($tipo_energia)."</td>";
                        $contenido_tabla1.= "<td></td>";
                        $contenido_tabla1.= "<td></td>";
                        $contenido_tabla1.= "<td></td>";    

                                        $contenido_tabla1.= "<td>".$resultado."</td>";
                                        $contenido_tabla1.= "<td>".$sfecha."</td>";
                                        $contenido_tabla1.= "<td>".$intervalo->format('%d Dias %H horas con %i minutos')."</td>";
                                        $contenido_tabla1.= "<td>".$ejecutado."</td>";
                                        
                                        if($ejecutado=="NO EJECUTADO"){
                                                $sql_obs="SELECT dato FROM tblDetalleFormulario WHERE idFormulario=$id_formulario AND idCampo=13";
                                                $query_obs=sqlsrv_query($con,$sql_obs);
                                                $row_obs=sqlsrv_fetch_array($query_obs);
                                                $dato=$row_obs['dato'];
                                                $contenido_tabla1.= "<td>".$dato."</td>";      
                                        }else{
                                                $contenido_tabla1.= "<td>SIN OBS.</td>";
                                        }   


                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";  

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
                                        $contenido_tabla2.=$contenido_tipologia_grupo.$contenido_tipologia_subgrupo.$contenido_tipologia_rehabilitado;


                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>"; 
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";
                                        $contenido_tabla2.= "<td></td>";       

                                        $consulta_formulario_final="SELECT * FROM tblFormulario tf,tblEstaciones te WHERE tf.idEstacion=te.idEstacion AND tf.idFormulario=$id_formulario";
                                        $query_formulario_final=sqlsrv_query($con,$consulta_formulario_final);
                                        $count_formulario_final=sqlsrv_has_rows($query_formulario_final);
                                
                                        if($count_formulario_final!=""){
                                                while($row_formulario_final=sqlsrv_fetch_array($query_formulario_final)){  
                                                        set_time_limit(25);
                                                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['tipo_trayecto'])."</td>";
                                                        $contenido_tabla2.= "<td>".$row_formulario_final['tramo_1']."</td>";
                                                        $contenido_tabla2.= "<td>".$row_formulario_final['tramo_2']."</td>";
                                                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['observaciones_trayecto'])."</td>";                                        
                                                        
                                                }
                                        }

                                        $contador=0;  
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

                                        echo $contenido_tabla1;           
                                        echo $contenido_tabla3;   
                                        echo $contenido_tabla2;
                                        echo $cerrar_fila;


             
                }/* preventivos */
        }
?>