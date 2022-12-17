<?php
include("../conexion.php");

    if(isset($_POST['id_usuario'])){
   
        $id_usuario=$_POST['id_usuario'];
        $delete="DELETE FROM tblUsuarios WHERE idUsuario=$id_usuario";
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