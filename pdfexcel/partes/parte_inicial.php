<?php
           $consulta_formulario="SELECT tf.idFormulario,te.idEstacion,te.nombre_Estacion,tf.tipo_est,tf.depto,tf.provincia,tf.mun_sec,tf.localidad,te.sistema,tf.estacionHub,tf.tipo_formulario FROM tblFormulario tf,tblEstaciones te WHERE tf.idEstacion=te.idEstacion AND tf.idFormulario=$id_formulario";
           $query_formulario=sqlsrv_query($con,$consulta_formulario);           

                  
             while($row_formulario=sqlsrv_fetch_array($query_formulario)){  
                set_time_limit(25);
             
                $tsi= extraer($row_formulario['tipo_est']);
                $tipo_tec=extraer2($row_formulario['tipo_est']);
                
                $estacionhub=$row_formulario['estacionHub'];
                
                if(!empty($estacionhub)){
                        $estacionhub="(".$estacionhub.")";
                }
        
                $contenido_tabla.= "<td>".$num."</td>";
                $contenido_tabla.= "<td>".utf8_decode($row_formulario['idEstacion'])."</td>";
                $contenido_tabla.= "<td>".utf8_decode($row_formulario['nombre_Estacion'])."</td>";
                $contenido_tabla.= "<td>".utf8_decode($tsi)."</td>";
                $contenido_tabla.= "<td>".utf8_decode($row_formulario['depto'])."</td>";
                $contenido_tabla.= "<td>".utf8_decode($row_formulario['provincia'])."</td>";
                $contenido_tabla.= "<td>".utf8_decode($row_formulario['mun_sec'])."</td>";
                $contenido_tabla.= "<td>".utf8_decode($row_formulario['localidad'])."</td>";
                $contenido_tabla.= "<td>".utf8_decode($row_formulario['sistema']).utf8_decode($estacionhub)."</td>";
                $contenido_tabla.= "<td>".utf8_decode($tipo_tec)."</td>";
                $contenido_tabla.= "<td></td>";
                $contenido_tabla.= "<td></td>";
                $contenido_tabla.= "<td></td>";  
                
        } 
?>