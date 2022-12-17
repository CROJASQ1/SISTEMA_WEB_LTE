<?php
         
        $consulta_formulario_final="SELECT * FROM tblFormulario tf,tblEstaciones te WHERE tf.idEstacion=te.idEstacion AND tf.idFormulario=$id_formulario";
        $query_formulario_final=sqlsrv_query($con,$consulta_formulario_final);
        $count_formulario_final=sqlsrv_has_rows($query_formulario_final);

        if($count_formulario_final!=""){
                while($row_formulario_final=sqlsrv_fetch_array($query_formulario_final)){  
                        set_time_limit(25);
                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['tipo_trayecto'])."</td>";
                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['tramo_1'])."</td>";
                        $contenido_tabla2.= "<td>".utf8_decode($row_formulario_final['tramo_2'])."</td>";
                        $contenido_tabla2.= "<td>Obs en trabajo</td>";                                        
                        
                }
        }
        
        else{
                $contenido_tabla2.= "<td>N/A</td>";
                $contenido_tabla2.= "<td>N/A</td>";
                $contenido_tabla2.= "<td>N/A</td>";
                $contenido_tabla2.= "<td>N/A</td>";   
        }
?>