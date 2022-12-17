<?php
    include("../conexion.php");

        if(isset($_POST['usuario']) 
        && isset($_POST['contraseña']) 
        && isset($_POST['regional'])
        && isset($_POST['rol'])  
        && isset($_POST['email']) 
        && isset($_POST['nombres'])){

                $usuario=$_POST['usuario'];
                $password=$_POST['contraseña'];
                $nombres=$_POST['nombres'];
                $id_regional=$_POST['regional'];
                $rol=$_POST['rol'];
                $email=$_POST['email'];
        
                $insert="INSERT INTO tblUsuarios (usuario,password,nombres,idRol,email,idRegional) VALUES ('$usuario','$password','$nombres',$rol,'$email','$id_regional')";
                $query=sqlsrv_query($con,$insert);

                if($query){

                    echo 1;

                }else{
                    echo 2;
                }
    }else{
        echo 10;
    }




?>