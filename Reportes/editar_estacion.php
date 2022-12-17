<?php
include("../conexion.php");

        if(isset($_POST['provincia_e']) 
        && isset($_POST['municipio_e']) 
        && isset($_POST['ubicacion_e']) 
        && isset($_POST['id_e']) 
        && isset($_POST['sistema_e']) 
        && isset($_POST['latitud_e']) 
        && isset($_POST['longitud_e']) 
        && isset($_POST['distancia_e']) 
        && isset($_POST['ruteo_e'])
        && isset($_POST['nombre_estacion_e'])
        && isset($_POST['id_regional_e'])
        && isset($_POST['localidad_e'])
        && isset($_POST['id_estacion'])){
                $id_estacion=$_POST['id_estacion'];
                $provincia=$_POST['provincia_e'];
                $municipio=$_POST['municipio_e'];
                $ubicacion=$_POST['ubicacion_e'];
                $id=$_POST['id_e'];
                $sistema=$_POST['sistema_e'];
                $latitud=$_POST['latitud_e'];
                $longitud=$_POST['longitud_e'];
                $distancia=$_POST['distancia_e'];
                $ruteo=$_POST['ruteo_e'];
                $nombre_estacion=$_POST['nombre_estacion_e'];
                $localidad=$_POST['localidad_e'];
                $id_regional=$_POST['id_regional_e'];

                $sql="UPDATE tblEstaciones set idRegional=$id_regional,localidad='$localidad',nombre_Estacion='$nombre_estacion',provincia='$provincia',municipio='$municipio',ubicacion_ambiente_tele='$ubicacion',id=$id,sistema='$sistema',latitud=$latitud,longitud=$longitud,distancia_km=$distancia,ruteo='$ruteo' WHERE idEstacion=$id_estacion";
                $query_sql=sqlsrv_query($con,$sql);

                if($query_sql){
                    echo 1;
                }else{
                    echo 2;
                }


        }else{
            echo 10;
        }
?>