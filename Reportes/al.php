<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

include ("../conexion.php"); 

echo "<h2 style='font-weight:bold'>Reportes</h2>
        <table border='1'>
		";
                    $consulta_formulario="SELECT * FROM tblFormulario tf,tblEstaciones te WHERE tf.idEstacion=te.idEstacion";
					$query_formulario=sqlsrv_query($con,$consulta_formulario);
					?>					
					 <tr>                               
                            <th>Nro&#176;</th>
                            <th>ID del VSAT&#176;</th>
                            <th>NOMBRE TLS&#176;</th>
                            <th>PROYECTO (TSI 1 O TSI 2)&#176;</th>
                            <th>DEPARTAMENTO</th>
                            <th>PROVINCIA&#176;</th>
                            <th>MUNICIPIO&#176;</th>
                            <th>LOCALIDAD&#176;</th>
                            <th>TIPO TECNOLOGIA HUB&#176;</th>
                            <th>TIPO DE ENERGIA&#176;</th>
                            <th>ESTADO COMERCIAL REFERENCIAL A FEB 2020&#176;</th>
                            <th>FECHA INSTALACION&#176;</th>
                            <th>FECHA DE BAJA&#176;</th> 
                            
                            <th>FECHA PROGRAMADA&#176;</th>
                    <!--         <th>FECHA EJECUTADA&#176;</th>
                            <th>TIEMPO DE EJECUCION (hrs)&#176;</th>
                            <th>EJECUTADO/NO EJECUTADO&#176;</th>
                            <th>OBS SOBRE NO EJECUTADOS&#176;</th>
                            <th>NOMBRE DEL REPUESTO&#176;</th>
                            <th>NRO DE SERIE&#176;</th>
                            <th>NOMBRE DEL REPUESTO&#176;</th>
                            <th>NRO DE SERIE&#176;</th>   -->                             
					</tr>

                        <?php
                      
                            $num=1;
                            while($row_formulario=sqlsrv_fetch_array($query_formulario)){
                                echo "<tr>";

                                    echo "<td>".$num."</td>";
                                    echo "<td>".utf8_decode($row_formulario['idEstacion'])."</td>";
                                    echo "<td>".utf8_decode($row_formulario['nombre_Estacion'])."</td>";
                                    echo "<td>proyecto tsi 1 o tsi 2</td>";
                                    echo "<td>".utf8_decode($row_formulario['depto'])."</td>";
                                    echo "<td>".utf8_decode($row_formulario['provincia'])."</td>";
                                    echo "<td>".utf8_decode($row_formulario['municipio'])."</td>";
                                    echo "<td>".utf8_decode($row_formulario['localidad'])."</td>";
                                    echo "<td>".utf8_decode($row_formulario['sistema'])."</td>";
                                    echo "<td>tipo tecnologia</td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    
                                    $num++;
                                echo "</tr>";    
                            }	


  /*                           $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.fechaInicio,tp.fechaFinal from tblFormulario tf,tblPreventivo tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'preventivo') tmp1 on tmp1.idFormulario=tf.idFormulario";
                            $query_preventivo=sqlsrv_query($con,$sql_pre);             
                            while($row_preventivo=sqlsrv_fetch_array($query_preventivo)){
                                echo "<tr>";
       
                                   echo "<td>asdsad</td>";
                                echo "</tr>";    
                            } */
                      
                            
                        ?>
                 
        <?php

            echo "</table> <br>";	  											
                        
                                    /*     
                                    echo "<td>".utf8_decode($row_preventivo['fechaInicial'])."</td>";
                                    echo "<td>".utf8_decode($row_preventivo['fechaFinal'])."</td>";
                                    echo "<td>tiempo de ejecucion</td>";
                                    echo "<td>ejecutado no ejecutado</td>";
                                    echo "<td>obs sobre no ejecutado</td>";
                                    echo "<td>".utf8_decode($row_preventivo['equipo_1']." - ".$row_preventivo['equipo_2']." - ".$row_preventivo['equipo_3']." - ".$row_preventivo['equipo_4']." - ".$row_preventivo['equipo_5'])."</td>";
                                    echo "<td>".utf8_decode($row_preventivo['serie1_1']." - ".$row_preventivo['serie1_2']." - ".$row_preventivo['serie1_3']." - ".$row_preventivo['serie1_4']." - ".$row_preventivo['serie1_5'])."</td>";
                                    echo "<td>".utf8_decode($row_preventivo['marca_modelo2_1']." - ".$row_preventivo['marca_modelo2_2']." - ".$row_preventivo['marca_modelo2_3']." - ".$row_preventivo['marca_modelo2_4']." - ".$row_preventivo['marca_modelo2_5'])."</td>";
                                    echo "<td>".utf8_decode($row_preventivo['serie2_1']." - ".$row_preventivo['serie2_2']." - ".$row_preventivo['serie2_3']." - ".$row_preventivo['serie2_4']." - ".$row_preventivo['serie2_5'])."</td>";
                            */              
    ?>	
</body>
</html>

