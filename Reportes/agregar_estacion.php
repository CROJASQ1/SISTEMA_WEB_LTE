<?php
include("../conexion.php");

    if(isset($_POST['provincia']) 
    && isset($_POST['municipio']) 
    && isset($_POST['ubicacion']) 
    && isset($_POST['id']) 
    && isset($_POST['sistema']) 
    && isset($_POST['latitud']) 
    && isset($_POST['longitud']) 
    && isset($_POST['distancia']) 
    && isset($_POST['nombre_estacion'])
    && isset($_POST['id_regional'])
    && isset($_POST['localidad'])
    && isset($_POST['ruteo'])){

            $provincia=$_POST['provincia'];
            $municipio=$_POST['municipio'];
            $ubicacion=$_POST['ubicacion'];
            $id=$_POST['id'];
            $sistema=$_POST['sistema'];
            $latitud=$_POST['latitud'];
            $longitud=$_POST['longitud'];
            $distancia=$_POST['distancia'];
            $ruteo=$_POST['ruteo'];
            $nombre_estacion=$_POST['nombre_estacion'];
            $localidad=$_POST['localidad'];
            $id_regional=$_POST['id_regional'];

            $sql="INSERT INTO tblEstaciones (provincia,municipio,ubicacion_ambiente_tele,id,sistema,latitud,longitud,distancia_km,ruteo,idRegional,localidad,nombre_Estacion) VALUES ('$provincia','$municipio','$ubicacion',$id,'$sistema',$latitud,$longitud,$distancia,'$ruteo',$id_regional,'$localidad','$nombre_estacion')";
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