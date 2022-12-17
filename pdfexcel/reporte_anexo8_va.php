
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
                          <!--   <th style="background-color: yellow">idForm&#176;</th> -->
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
                            <th style="background-color:#ffc107">REHABILITADO(SI/NO)&#176;</th>  

                            <th style="background-color:#ffc107">NOMBRE DEL REPUESTO&#176;</th>
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
                            <th style="background-color:red;color:white">OBSERVACIONES&#176; DEL TRAYECTO</th>
                           
                  

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
                                                $sql_consulta = "SELECT tf.idFormulario,tc.idEstacion,tc.title,tc.idUsuarioEntel,tc.start,tc.hora,tc.justificativo,tf.fecha_ini_intervalo,tf.fecha_fin_intervalo,tc.grupo FROM tblSolicitudCorrectivos tc, tblEstaciones te, tblFormulario tf WHERE tc.idFormulario = tf.idFormulario AND (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";  
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
                                                 $sql_consulta="SELECT * FROM tblFormulario";
                                break;
                        }

                }
/* -------------------------------------------------------- */

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
                                                $consulta_formulario="SELECT tf.idFormulario,te.idEstacion,te.nombre_Estacion,tf.tipo_est,tf.depto,tf.provincia,tf.mun_sec,tf.localidad,te.sistema,tf.estacionHub,tf.tipo_formulario,tf.fecha_ini_intervalo,tf.hora_ini_intervalo FROM tblFormulario tf,tblEstaciones te WHERE tf.idEstacion=te.idEstacion AND tf.idFormulario=$id_formulario";
                                                $query_formulario=sqlsrv_query($con,$consulta_formulario);           

                                                       
                                                                while($row_formulario=sqlsrv_fetch_array($query_formulario)){  
                                                                        set_time_limit(25);
                                                                        $tipo_formulario=$row_formulario['tipo_formulario'];

                                                                        if($tipo_formulario=="PREVENTIVO"){

                                                                                include('partes/preventivos.php'); 

                                                                        }else if($tipo_formulario=="CORRECTIVO"){
                                                                      
                                                                                include('partes/tipologia_correctivo.php');  

                                                                        }else if($tipo_formulario=="EXTRACANON"){

                                                                                include('partes/extracanon.php');    
                                                                        }
                                                        
                                                                }                                                       
                                                
                                        $num++;
                                                
                                        }

                               }

                        ?>
                 
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

	