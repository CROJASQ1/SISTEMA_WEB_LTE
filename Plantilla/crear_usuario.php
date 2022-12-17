<?php
    include("../conexion.php");
    if(isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['nombres'])){


            $usuario=$_POST['usuario'];
            $password=$_POST['password'];
            $nombres=$_POST['nombres'];
       
                $insert="INSERT into tblUsuarios (usuario,password,nombres) VALUES ('$usuario','$password','$nombres')";
            

            $query=sqlsrv_query($con,$insert);

            if($query){

                echo 1;

            }else{
                echo 2;
            }

    
    }




?>