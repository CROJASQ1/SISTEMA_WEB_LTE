
<?php
$filename = "Reporte anexo8.xls";
        // header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
        header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
        header('Content-Disposition: attachment; filename='.$filename);

        include ("../conexion.php"); 

        echo "<h2 style='font-weight:bold'>Reportes</h2>
                <table border='1'>
                        ";
         
		?>	
                        <tr>    
                                <td></td>
                                <td colspan='12' style="text-align:center;background-color:#3c8dbc;font-size:120%;font-weight:bold">DATOS DE LA ESTACION</td>
                                <td colspan='5' style="text-align:center;background-color:#17a2b8;font-size:120%;font-weight:bold">MANT PREVENTIVO</td>
                                <td colspan='2' style="text-align:center;background-color:#17a2b8;font-size:120%;font-weight:bold">EQUIPO RETIRADO</td>
                                <td colspan='2' style="text-align:center;background-color:#17a2b8;font-size:120%;font-weight:bold">EQUIPO INSTALADO</td>
                                <td colspan='5' style="text-align:center;background-color:#ffc107;font-size:120%;font-weight:bold">MANT. CORRECTIVOS</td>
                                <td colspan='3' style="text-align:center;background-color:#ffc107;font-size:120%;font-weight:bold">TIPOLOGIA DE FALLA</td>
                                <td colspan='2' style="text-align:center;background-color:#ffc107;font-size:120%;font-weight:bold">EQUIPO (Repuesto) RETIRADO</td>
                                <td colspan='3' style="text-align:center;background-color:#ffc107;font-size:120%;font-weight:bold">EQUIPO (Repuesto) INSTALADO</td>
                                <td colspan='3' style="text-align:center;background-color:orange;font-size:120%;font-weight:bold">EXTRACANON</td>
                                <td colspan='4' style="text-align:center;background-color:red;font-size:120%;font-weight:bold;color:white">INFORMACION DEL SITIO</td>
                        </tr>


			 <tr>
                                                                   
                            <th>Nro&#176;</th>
                          <!--   <th>id form&#176;</th> -->
                            <th style="background-color: yellow">ID del VSAT&#176;</th>
                            <th style="background-color: yellow">NOMBRE TLS&#176;</th>
                            <th style="background-color: yellow">PROYECTO (TSI 1 O TSI 2)&#176;</th>
                            <th style="background-color: yellow">DEPARTAMENTO</th>
                            <th style="background-color: yellow">PROVINCIA&#176;</th>
                            <th style="background-color: yellow">MUNICIPIO&#176;</th>
                            <th style="background-color: yellow">LOCALIDAD&#176;</th>
                            <th style="background-color: yellow">TIPO TECNOLOGIA HUB&#176;</th>
                            <th style="background-color: yellow">TIPO DE ENERGIA&#176;</th>
                            <th style="background-color: #3c8dbc">ESTADO COMERCIAL REFERENCIAL A FEB 2020&#176;</th>
                            <th style="background-color: #3c8dbc">FECHA INSTALACION&#176;</th>
                            <th style="background-color: #3c8dbc">FECHA DE BAJA&#176;</th> 
                            
                            <th style="background-color: #17a2b8">FECHA PROGRAMADA&#176;</th><!-- 1 -->
                            <th style="background-color: #17a2b8">FECHA EJECUTADA&#176;</th><!-- 2 -->
                            <th style="background-color: #17a2b8">TIEMPO DE EJECUCION (hrs)&#176;</th><!-- 3 -->
                            <th style="background-color: #17a2b8">EJECUTADO/NO EJECUTADO&#176;</th><!-- 4 -->
                            <th style="background-color: #17a2b8">OBS SOBRE NO EJECUTADOS&#176;</th><!-- 5 -->
                            <th style="background-color: #17a2b8">NOMBRE DEL REPUESTO&#176;</th><!-- 6 -->
                            <th style="background-color: #17a2b8">NRO DE SERIE&#176;</th><!-- 7 -->
                            <th style="background-color: #17a2b8">NOMBRE DEL REPUESTO&#176;</th><!-- 8 -->
                            <th style="background-color: #17a2b8">NRO DE SERIE&#176;</th>      <!-- 9 -->  
                           
                            <th style="background-color:#ffc107">FECHA DE INICIO&#176;</th> 
                            <th style="background-color:#ffc107">FECHA DE FIN&#176;</th>    
                            <th style="background-color:#ffc107">TIEMPO DE EJECUCION&#176;</th>
                            <th style="background-color:#ffc107">CANTIDAD DE VISITAS&#176;</th>
                            <th style="background-color:#ffc107">ESTADO FINAL&#176;</th>  

                            <th style="background-color:#ffc107">GRUPO&#176;</th> 
                            <th style="background-color:#ffc107">SUBGRUPO&#176;</th>   
                            <th style="background-color:#ffc107">REPUESTO(SI/NO)&#176;</th>  

                            <th style="background-color:#ffc107">EQUIPO&#176;</th>
                            <th style="background-color:#ffc107">NRO DE SERIE&#176;</th>

                            <th style="background-color:#ffc107">NOMBRE DEL REPUESTO&#176;</th>
                            <th style="background-color:#ffc107">NRO DE SERIE&#176;</th>
                            <th style="background-color:#ffc107">OBSERVACIONES&#176;</th>

                            <th style="background-color:orange">FECHA DE EJECUCION&#176;</th>
                            <th style="background-color:orange">TIPO DE TRABAJO EJECUTADO&#176;</th>
                            <th style="background-color:orange">OBSERVACIONES&#176;</th>

                            <th style="background-color:red;color:white">TIPO DE ACCESO AL SITIO&#176;</th>
                            <th style="background-color:red;color:white">TIEMPO DE VIAJE-IDA TRAMO1&#176;</th>
                            <th style="background-color:red;color:white">TIEMPO DE VIAJE-IDA TRAMO2&#176;</th>
                            <th style="background-color:red;color:white">OBSERVACIONES&#176;</th>
                           
                  

			</tr>

                        <?php

/* ----------------------------------------------------- */
                if(isset($_POST['fechaini']) && isset($_POST['fechafin'])){
                        set_time_limit(25);
                        $idregion = intval($_POST['idregion']);
                        $fechaini = $_POST['fechaini'];
                        $fechafin = $_POST['fechafin'];
                        $tipotrab = $_POST['tipotrab'];
                        $regional = $_POST['regional'];
                        $casogrup = intval($_POST['casogrup']);
                        $casopcio = intval($_POST['casopcio']);

                        $caso_por_region = '';
                        if($idregion > 0){
                                $caso_por_region = ' AND te.idRegional = '.$idregion;
                        }

                        switch ($tipotrab) {
                                case 'CORRECTIVO':
                             
                                $caso_por_grupo = '';
                                if($casogrup > 0){
                                        $caso_por_grupo = " AND tc.grupo = 'grupo".$casogrup."'";
                                }
                                switch ($casopcio) {
                                        case 1:
                                                $sql_consulta = "SELECT tc.*,te.*,tc.id as idcorec FROM tblSolicitudCorrectivos tc, tblEstaciones te WHERE (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                                                echo $sql_consulta;
                                        break;

                                        case 2:

                                                $sql_consulta = "SELECT tc.*,te.*,tc.id as idcorec FROM tblSolicitudCorrectivos tc, tblEstaciones te WHERE (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                        
                                        break;

                                        case 3:

                                                $sql_consulta = "SELECT tc.*,te.*,tc.id as idcorec FROM tblSolicitudCorrectivos tc, tblEstaciones te WHERE (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                        
                                        break;
                                        
                                        case 4:

                                                $sql_consulta = "SELECT tf.idFormulario,tc.idEstacion,tc.title,tc.idUsuarioEntel,tc.start,tc.hora,tc.justificativo,tf.ini_intervalo,tf.fin_intervalo,tc.grupo FROM tblSolicitudCorrectivos tc, tblEstaciones te, tblFormulario tf WHERE tc.idFormulario = tf.idFormulario AND (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";  

                                        break;
                                        default:

                                                /* CODE... */

                                        break;
                                }
                                break;
                                                case 'PREVENTIVO':
                                                
                                                if($casogrup > 0){
                                                        $caso_por_grupo = " AND tp.grupo = 'grupo".$casogrup."'";
                                                }else{
                                                        $caso_por_grupo = '';
                                                }
                                                switch ($casopcio) {
                                                        case 1:

                                                                $sql_consulta = "SELECT tp.*,te.* FROM tblPreventivo tp, tblEstaciones te WHERE (tp.fechaInicio BETWEEN '$fechaini' AND '$fechafin') AND tp.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tp.fechaInicio ASC;";
                                        
                                                        break;
                                                        default:

                                                                $sql_consulta = "SELECT tp.*,te.* FROM tblPreventivo tp, tblEstaciones te WHERE (tp.fechaInicio BETWEEN '$fechaini' AND '$fechafin') AND tp.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tp.fechaInicio ASC;";
                                        
                                                        break;
                                                }
                                                break;
                                case 'EXTRACANON':
                                # code...
                                break;
                                default:

                                                if($idregion > 0){
                                                        $sql_consulta = "SELECT temp.* FROM (SELECT tf.* FROM tblSolicitudCorrectivos tc, tblEstaciones te, tblFormulario tf WHERE tc.idFormulario = tf.idFormulario AND tc.idEstacion = te.idEstacion AND te.idRegional = $idregion UNION SELECT tf.* FROM tblPreventivo tp, tblEstaciones te, tblFormulario tf WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = $idregion UNION SELECT tf.* FROM tblExtraCanon tx, tblEstaciones te, tblFormulario tf WHERE tx.idFormulario = tf.idFormulario AND tx.idEstacion = te.idEstacion AND te.idRegional = $idregion) temp ORDER BY temp.fecha_ini_intervalo ASC;";  
                                                }else{
                                                        $sql_consulta="SELECT * FROM tblFormulario";
                                                }
                                break;
                        }

                }

/* -------------------------------------------------------- */

         /*        if($sql_consulta===false){
                       
                }else{
                        
                }  */


                        /* $arriba="SELECT * FROM tblFormulario"; */
                        // echo $sql_consulta;
                        $query_arriba=sqlsrv_query($con,$sql_consulta);
                        $count_consulta_g=sqlsrv_has_rows($query_arriba);

                        $num=1;
                        $abrir_fila="<tr>";
                        $cerrar_fila="</tr>";

                        
                        if($count_consulta_g!=false){
                                       
                                        while($row_arriba=sqlsrv_fetch_array($query_arriba)){
                                                set_time_limit(25);
                                                $contenido_tabla="";
                                                $contenido_tabla2="";
                                                $id_formulario=$row_arriba['idFormulario'];
                                                
                                                $consulta_formulario="SELECT te.idEstacion,te.nombre_Estacion,tf.tipo_est,tf.depto,tf.provincia,tf.mun_sec,tf.localidad,te.sistema FROM tblFormulario tf,tblEstaciones te WHERE tf.idEstacion=te.idEstacion AND tf.idFormulario=$id_formulario";
                                                $query_formulario=sqlsrv_query($con,$consulta_formulario);
                                                        

                                                while($row_formulario=sqlsrv_fetch_array($query_formulario)){  
                                                        set_time_limit(25);
                                                        $tsi= extraer($row_formulario['tipo_est']);
                                                        $tipo_tec=extraer2($row_formulario['tipo_est']);

                                                        $contenido_tabla.= "<td>".$num."</td>";
                                                      /*   $contenido_tabla.= "<td>".$id_formulario."</td>"; */
                                                        $contenido_tabla.= "<td>".utf8_decode($row_formulario['idEstacion'])."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($row_formulario['nombre_Estacion'])."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($tsi)."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($row_formulario['depto'])."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($row_formulario['provincia'])."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($row_formulario['mun_sec'])."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($row_formulario['localidad'])."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($row_formulario['sistema'])."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($tipo_tec)."</td>";
                                                        $contenido_tabla.= "<td></td>";
                                                        $contenido_tabla.= "<td></td>";
                                                        $contenido_tabla.= "<td></td>";
                                                        
                                                        
                                                }

                                        /* preventivos */
                                                $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.fechaInicio,tp.fechaFinal,tp.horaInicio from tblFormulario tf,tblPreventivo tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'preventivo') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$id_formulario  AND tf.tipo_formulario like 'preventivo'";
                                                $query_preventivo=sqlsrv_query($con,$sql_pre);
                                                $count_preventivo=sqlsrv_has_rows($query_preventivo);  
                                                if($count_preventivo!=false){
                                                        while($row_preventivo=sqlsrv_fetch_array($query_preventivo)){
                                                                set_time_limit(25);
                                                                $fecha_inicial=$row_preventivo['fechaInicio'];
                                                                $hora_inicial=$row_preventivo['horaInicio'];
                                                                
                                                                
                                                                if(!empty($fecha_inicial)){
                                                                                $fecha_inicial=$row_preventivo['fechaInicio']->format('Y-m-d');
                                                                                $hora_inicial=$row_preventivo['horaInicio'];
                                                                                $fecha_final=$row_preventivo['fechaFinal']->format('Y-m-d'); 
                                                                                $resultado=$fecha_inicial." ".$hora_inicial;
                                                                                if(isset($row_preventivo['fin_intervalo'])){
                                                                                        $fin_intervalo=$row_preventivo['fin_intervalo'];                    
                                                                                        $fin_intervalo=implode('-',explode('/',$fin_intervalo)); 
                                                                                        $date = new DateTime($fin_intervalo);
                                                                                        $sfecha=$date->format('Y-m-d H:i');
                                                                                        $t1 = StrToTime ($sfecha); 
                                                                                        $t2 = StrToTime ($resultado); 
                                                                                        $diff = $t1 - $t2; 
                                                                                        $hours = $diff/(60 * 60); 
                                                                                }else{
                                                                                        $fin_intervalo='';
                                                                                        $hours="";
                                                                                } 
                                                                                

                                                                }else{
                                                                        $fin_intervalo='';
                                                                        $fecha_inicial="";
                                                                        $fecha_final="";
                                                                        $fecha="";
                                                                        $hours="";
                                                                        $resultado="";
                                                                }
                        
                                                                $contenido_tabla.= "<td>".$resultado."</td>";
                                                                $contenido_tabla.= "<td>".$fin_intervalo."</td>";
                                                                $contenido_tabla.= "<td>".$hours."</td>";



                                                                if(!empty($fecha_final)){
                                                                        $contenido_tabla.= "<td>Ejecutado</td>";
                                                                }else{
                                                                        $contenido_tabla.= "<td>No ejecutado</td>";
                                                                }
                                                              
                                                                $contenido_tabla.= "<td>-------</td>";
                                                                $contenido_tabla.= "<td>".utf8_decode($row_preventivo['equipo_1']." - ".$row_preventivo['equipo_2']." - ".$row_preventivo['equipo_3']." - ".$row_preventivo['equipo_4']." - ".$row_preventivo['equipo_5'])."</td>";
                                                                $contenido_tabla.= "<td>".utf8_decode($row_preventivo['serie1_1']." - ".$row_preventivo['serie1_2']." - ".$row_preventivo['serie1_3']." - ".$row_preventivo['serie1_4']." - ".$row_preventivo['serie1_5'])."</td>";
                                                                $contenido_tabla.= "<td>".utf8_decode($row_preventivo['marca_modelo2_1']." - ".$row_preventivo['marca_modelo2_2']." - ".$row_preventivo['marca_modelo2_3']." - ".$row_preventivo['marca_modelo2_4']." - ".$row_preventivo['marca_modelo2_5'])."</td>";
                                                                $contenido_tabla.= "<td>".utf8_decode($row_preventivo['serie2_1']." - ".$row_preventivo['serie2_2']." - ".$row_preventivo['serie2_3']." - ".$row_preventivo['serie2_4']." - ".$row_preventivo['serie2_5'])."</td>";                           
                                                        }/* preventivos */
                                                }else{
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";  
                                                }    
                                                
                                                

                                                        
                                        


                                        /* correctivos */
                                                $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.start,tp.fechafin,tp.nro_visitas,tp.observacion from tblFormulario tf,tblSolicitudCorrectivos tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'correctivo') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$id_formulario  AND tf.tipo_formulario like 'correctivo'";
                                                $query_correctivo=sqlsrv_query($con,$sql_pre);
                                                $count_correctivo=sqlsrv_has_rows($query_correctivo);
                                                if($count_correctivo!=false){
                                                        while($row_correctivo=sqlsrv_fetch_array($query_correctivo)){
                                                                set_time_limit(25);
                                                                $fecha_inicial=$row_correctivo['start'];
                                                                if($fecha_inicial!=false){
                                                                        $fecha_inicial=$row_correctivo['start']->format('d-m-Y');
                                                                        $dia_i=$row_correctivo['start']->format('d');   
                                                                        $mes_i=$row_correctivo['start']->format('m');   
                                                                        $ano_i=$row_correctivo['start']->format('Y');   
                                                                        
                                                                        $fecha_final=$row_correctivo['fechafin']->format('d-m-Y'); 
                                                                        $dia_f=$row_correctivo['fechafin']->format('d');   
                                                                        $mes_f=$row_correctivo['fechafin']->format('m');   
                                                                        $ano_f=$row_correctivo['fechafin']->format('Y');   
                                                
                                                                        $timestamp1 = mktime(0,0,0,$mes_i,$dia_i,$ano_i);
                                                                        $timestamp2 = mktime(4,12,0,$mes_f,$dia_f,$ano_f);
                                                
                                                                        $segundos_diferencia = $timestamp1 - $timestamp2;
                                                                        $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
                                                                        $dias_diferencia = abs($dias_diferencia);   
                                                                        $dias_diferencia = floor($dias_diferencia);
                                                                        
                                                                        $tiempo_horas=$dias_diferencia*24;

                                                                }else{
                                                                        $fecha_inicial="";
                                                                        $fecha_final="";
                                                                        $tiempo_horas="";
                                                                }

                                                        $contenido_tabla.= "<td>".$fecha_inicial."</td>";
                                                        $contenido_tabla.= "<td>".$fecha_final."</td>";
                                                        $contenido_tabla.= "<td>".$tiempo_horas."</td>";
                                                        $contenido_tabla.= "<td>".utf8_decode($row_correctivo['nro_visitas'])."</td>";

                                                                /* buscar observacion en estado de estado de los servicios */

                                                        $contenido_tabla.= "<td>".utf8_decode($row_correctivo['observacion'])."</td>";                           
                                                }/* correctivos */
                                                } else{
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";
                                                        $contenido_tabla.= "<td>N/A</td>";   
                                                }   
                                                
                                                
                                                /* EXTRACANON */
                                                $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.fechaInicio,tp.fechaFinal,tp.horaInicio from tblFormulario tf,tblExtraCanon tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'EXTRACANON') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$id_formulario  AND tf.tipo_formulario like 'EXTRACANON'";
                                                $query_preventivo=sqlsrv_query($con,$sql_pre);
                                                $count_preventivo=sqlsrv_has_rows($query_preventivo);  
                                                if($count_preventivo!=false){
                                                        while($row_preventivo=sqlsrv_fetch_array($query_preventivo)){
                                                                set_time_limit(25);
                                                                $fecha_inicial=$row_preventivo['fechaInicio'];
                                                                $hora_inicial=$row_preventivo['horaInicio'];
                                                                if(isset($row_preventivo['fin_intervalo'])){
                                                                        $fin_intervalo=$row_preventivo['fin_intervalo'];
                                                                }else{
                                                                        $fin_intervalo='';
                                                                }
                                                                
                                                                
                                                                                
                                                                $contenido_tabla2.= "<td>".$resultado."</td>";
                                                                $contenido_tabla2.= "<td>".$fin_intervalo."</td>";
                                                                $contenido_tabla2.= "<td>".$hours."</td>";
                                                     
                                                        }/* EXTRACANON */
                                                }else{
                                                        $contenido_tabla2.= "<td>N/A</td>";
                                                        $contenido_tabla2.= "<td>N/A</td>";
                                                        $contenido_tabla2.= "<td>N/A</td>"; 
                                                }    
                                                
                                                
                                                
                
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
                                                }else{
                                                        $contenido_tabla2.= "<td>N/A</td>";
                                                        $contenido_tabla2.= "<td>N/A</td>";
                                                        $contenido_tabla2.= "<td>N/A</td>";
                                                        $contenido_tabla2.= "<td>N/A</td>";   
                                                }
                                        

                                                
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
                                                                        $tama_vector=0;
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
                                                                                echo $contenido_tabla;
                                                                                echo "<td>N/A</td>";
                                                                                echo "<td>N/A</td>";
                                                                                echo "<td>N/A</td>";
                                                                                echo "<td>N/A</td>";
                                                                                echo "<td>N/A</td>";
                                                                                echo "<td>N/A</td>";
                                                                                echo "<td>N/A</td>";
                                                                                echo "<td>N/A</td>";
                                                                                echo $contenido_tabla2;
                                                                                echo $cerrar_fila;
                                                                        }else{
                        
                                                                                for ($i=0; $i < $tama_vector; $i++) { 
                                                                                        echo $abrir_fila;
                                                                                        echo $contenido_tabla;
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
                                                
                                                                }/* correctivos_TIPOLOGIA */
                                                        }else{
                                                                echo $abrir_fila;
                                                                echo $contenido_tabla;
                                                                echo "<td>N/A</td>";
                                                                echo "<td>N/A</td>";
                                                                echo "<td>N/A</td>";
                                                                echo "<td>N/A</td>";
                                                                echo "<td>N/A</td>";
                                                                echo "<td>N/A</td>";
                                                                echo "<td>N/A</td>";
                                                                echo "<td>N/A</td>";
                                                                echo $contenido_tabla2;
                                                                echo $cerrar_fila;
                                                        }
                                                


                                        $num++;
                                                
                                        }/* fin recorrido */

                               }else{
                                       echo "asdasdsadasdsad".$sql_consulta;
                               }

                        // ?>
                 
        <?php

            echo "</table> 
            <br>";	  											
            
            


            function grupo($nom_sub ){

                if($nom_sub=="MODEM" || 
                $nom_sub=='BUC' || 
                $nom_sub=='LNB' || 
                $nom_sub=='ANTENA' || 
                $nom_sub=='CANISTER' || 
                $nom_sub=='FEED HORN' || 
                $nom_sub=='MODEM 4G' 
                || $nom_sub=='SES'
                || $nom_sub=='DECODIFICADOR'
                || $nom_sub=='ATA'
                || $nom_sub=='ROUTER'
                || $nom_sub=='HUB_SWITCH'
                || $nom_sub=='MICKROTIC'
                || $nom_sub=='TELEFONO'
                || $nom_sub=='BATERIAS'
                
                ){
                        return "SISTEMA DE TRANSMISION";
                }else{

                        if($nom_sub=="PANELES" 
                        || $nom_sub=='REGULADOR'
                        || $nom_sub=='RECTIFICADOR'
                        || $nom_sub=='INVERSOR'
                        || $nom_sub=='UPS'
                        || $nom_sub=='TRANSFORMADOR AISLADOR'
                        || $nom_sub=='BREAKER'
                        || $nom_sub=='PROTECTORES'
                        || $nom_sub=='HIBRIDO AC/DC'
                        || $nom_sub=='BREAKER(AC)'     
                        ){
        
                                return "SISTEMA DE ENERGIA";
        
                        }else{

                                if($nom_sub=="PCS" 
                                || $nom_sub=='MONITORES'
                                || $nom_sub=='IMPRESORA'           
                                ){
                
                                        return "LADO CLIENTE(RED LAN)";
                
                                }else{

                                        return "Sin grupo";
                                }

                        }

                }



         

            }
            
            function extraer($cadena){

                $tamaño=strlen($cadena);
                $palabra="";

                for ($i=0; $i < $tamaño; $i++) { 
                        
                        if($cadena[$i]!='/'){
                                $palabra.=$cadena[$i];
                        }else{
                                return $palabra;
                        }
                }
            }

            function extraer2($cadena){

                $tamaño=strlen($cadena);
                $palabra="";

                for ($i=$tamaño-1; $i >= 0; $i--) { 
                        
                        if($cadena[$i]!='/'){
                                $palabra.=$cadena[$i];
                        }else{
                                return strrev($palabra);
                        }

                }

            }
                        
    ?>	

	