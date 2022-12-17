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

              /*       $fecha1='17/11/2020 14:05';
                    $fecha=implode('-',explode('/',$fecha1));
                    $convertido=new DateTime($fecha);
 */


         $sql_form="SELECT * FROM tblFormulario"; 
        echo $sql_form; 
         $query_form=sqlsrv_query($con,$sql_form);
        while($row=sqlsrv_fetch_array($query_form)){
 
                     $formulario=$row['idFormulario']; 
                    $sql_pre="SELECT * FROM tblFormulario tf LEFT JOIN (select tf.idFormulario,tp.fechaInicio,tp.fechaFinal,tp.horaInicio from tblFormulario tf,tblPreventivo tp WHERE tp.idFormulario=tf.idFormulario AND tipo_formulario like 'preventivo') tmp1 on tmp1.idFormulario=tf.idFormulario where tf.idFormulario=$formulario AND tf.tipo_formulario like 'preventivo'";
                    $query_preventivo=sqlsrv_query($con,$sql_pre);
                    $count_preventivo=sqlsrv_has_rows($query_preventivo);  

                    $row_preventivo=sqlsrv_fetch_array($query_preventivo);       
                   
                       
                        $fecha_inicial=$row_preventivo['fechaInicio'];

                 /*        echo $fecha_inicial; */
                         if(!empty($fecha_inicial)){                            
                            $fecha_inicial=$row_preventivo['fechaInicio']->format('Y-m-d');
                            $hora_inicial=$row_preventivo['horaInicio'];
                            $fecha_final=$row_preventivo['fechaFinal']->format('Y-m-d'); 
                            $resultado=$fecha_inicial." ".$hora_inicial; 

                            $fin_intervalo=$row_preventivo['fin_intervalo'];
                            
                            $fin_intervalo=implode('-',explode('/',$fin_intervalo)); 
                            
                            echo $row['idFormulario']."  ".$fin_intervalo."<br>";
                            $date = new DateTime($fin_intervalo);
                            $sfecha=$date->format('Y-m-d H:s'); 
                          /*   echo $sfecha; */
                              
                            $t1 = StrToTime ($sfecha); 
                            $t2 = StrToTime ($resultado); 
                            $diff = $t1 - $t2; 
                            $hours = $diff/(60 * 60); 

                            echo $sfecha."<br>";
                            echo $resultado."<br>"; 
                            echo $hours."<br><br><br>"; 
                        }     
             } 

/*              echo $convertido->format('Y-m-d H:i:s');   */


     /*        $date = new DateTime('2000-01-01');
            echo $date->format('Y-m-d H:i:s');
 */
      /*       $sfecha=$fecha1->format('Y-m-d H:s');
             */

     /*        echo $fecha1; */

         /*    $t1 = StrToTime ('2006/04/12 13:00:00'); 
            $t2 = StrToTime ('2006/04/11 10:00:00'); 
            $diff = $t1 - $t2; 
            $hours = $diff/(60 * 60); 

            echo $hours; */
                
    ?>	
</body>
</html>

