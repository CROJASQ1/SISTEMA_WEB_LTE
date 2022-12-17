<?php
include("../conexion.php");

        if(isset($_POST['id_usuario_e']) 
        && isset($_POST['nombres_e']) 
        && isset($_POST['usuario_e']) 
        && isset($_POST['contraseña_e']) 
        && isset($_POST['rol_e']) 
        && isset($_POST['email_e'])
        && isset($_POST['regional_e'])){

                $id_usuario=$_POST['id_usuario_e'];
                $nombres=$_POST['nombres_e'];
                $usuario=$_POST['usuario_e'];
                $password=$_POST['contraseña_e'];
                $rol=$_POST['rol_e'];
                $email=$_POST['email_e'];
                $id_regional=$_POST['regional_e'];
                

                $sql="UPDATE tblUsuarios set usuario='$usuario',password='$password',nombres='$nombres',idRol=$rol,email='$email',idRegional=$id_regional WHERE idUsuario=$id_usuario";
            
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