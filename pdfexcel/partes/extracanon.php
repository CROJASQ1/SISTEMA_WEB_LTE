<?php
 $contenido_tabla1="";
 $contenido_tabla2="";
 $contenido_tabla3="";
 
             $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.fechaInicio,tp.fechaFinal,tp.horaInicio from tblFormulario tf,tblExtraCanon tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'EXTRACANON') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$id_formulario  AND tf.tipo_formulario like 'EXTRACANON'";
             $query_extracanon=sqlsrv_query($con,$sql_pre);
             $count_extracanon=sqlsrv_has_rows($query_extracanon);  
             if($count_extracanon!=false){
                     while($row_extracanon=sqlsrv_fetch_array($query_extracanon)){
          
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
                                
                                
                                $contenido_tabla1.= "<td></td>";/* 1 */
                                $contenido_tabla1.= "<td></td>";/* 2 */
                                $contenido_tabla1.= "<td></td>";/* 3 */
                                $contenido_tabla1.= "<td></td>";/* 4 */ 
                                $contenido_tabla1.= "<td></td>";/* 5 */      /* preventivo */
                                $contenido_tabla1.= "<td></td>";/* 6 */
                                $contenido_tabla1.= "<td></td>";/* 7 */
                                $contenido_tabla1.= "<td></td>";/* 8 */
                                $contenido_tabla1.= "<td></td>";/* 9 */

                                $contenido_tabla1.= "<td></td>";/* 1 */
                                $contenido_tabla1.= "<td></td>";/* 2 */
                                $contenido_tabla1.= "<td></td>";/* 3 */  /* correctivo */
                                $contenido_tabla1.= "<td></td>";/* 4 */   
                                $contenido_tabla1.= "<td></td>";/* 5 */


                                
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
                                $contenido_tabla1.=$contenido_tipologia_grupo.$contenido_tipologia_subgrupo.$contenido_tipologia_rehabilitado;
                                
                                $contenido_tabla1.= "<td></td>";     
                                $contenido_tabla1.= "<td></td>";
                                $contenido_tabla1.= "<td></td>";
                                $contenido_tabla1.= "<td></td>";  
                                $contenido_tabla1.= "<td></td>"; 

                                $contenido_tabla2.= "<td>".$row_formulario['fecha_ini_intervalo']->format('Y-m-d');
                                $contenido_tabla2.= "<td></td>";
                                $contenido_tabla2.= "<td></td>";

                                

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
                                 echo $abrir_fila;
                                 echo $contenido_tabla1;
                                 echo $contenido_tabla2;  
                                 echo $cerrar_fila;
                  
                     }
             } 
?>