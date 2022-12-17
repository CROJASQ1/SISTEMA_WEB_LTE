<?php
include("../conexion.php");

    if(isset($_POST['id_plantilla'])){
   
        $id_plantilla=$_POST['id_plantilla'];
        $delete="DELETE FROM tblPlantillaMaestro WHERE idPlantilla = $id_plantilla; DELETE FROM tblPlantillaDetalle WHERE idPlantilla = $id_plantilla;";
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