<?php

include("../conexion.php");
ob_start();
$texto=$_POST['texto'];
      
        $sql = "SELECT COUNT(idPlantilla) FROM tblPlantillaMaestro";

        if($texto!=""){
            
                    $sql= "SELECT COUNT((idPlantilla) FROM tblPlantillaMaestro WHERE (descripcion like '%".$texto."%')";
                
        }

        $ejecutar = sqlsrv_query($con,$sql);
        while ($row=sqlsrv_fetch_array($ejecutar)){
        $total_records = $row[0];
        }

        $total_pages = ceil($total_records / 10);

        $table= "<nav><ul class='pagination' style='margin:0'>";
   
        for ($i=1; $i<=$total_pages; $i++) {

            if($texto!=""){  
                $table.="
                    <li><a href='index3.php?page=".$i."&busqueda=".$texto."'>".$i."</a></li>";
            }else{
                $table.= "
                <li><a href='index3.php?page=".$i."'>".$i."</a></li>";
            }
        };
        $table.="</ul></nav>"; 
      
        $mensaje= array('tabla' => $table, 'records' => $total_records);
        ob_end_clean();
        echo json_encode($mensaje);
?>