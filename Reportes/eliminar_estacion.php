<?php
include("../conexion.php");

    if(isset($_POST['id_estacion'])){
   
        $id_estacion=$_POST['id_estacion'];
        $delete="DELETE FROM tblEstaciones WHERE idEstacion=$id_estacion";
        $query_delete=sqlsrv_query($con,$delete);
       
        if($query_delete){
            echo 1;
        }else{
            echo 2;
        }
    }else{
        echo 10;
    }


?>