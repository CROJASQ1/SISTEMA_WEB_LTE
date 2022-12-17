<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }
include("../conexion.php");
$table="";

$start_from=$_POST['start'];

    $consulta= "SELECT * FROM tblUsuarios tu,tblRegional tr,tblRoles tro WHERE tro.idRol=tu.idRol AND tu.idRegional=tr.idRegional ORDER BY idUsuario ASC offset $start_from ROWS FETCH NEXT 15 ROWS ONLY";
                  


            if($_POST["texto"] != ""){

                $texto=$_POST['texto'];
                $consulta = " SELECT * FROM tblUsuarios tu,tblRegional tr,tblRoles tro WHERE (tu.nombres like '%".$texto."%') AND tro.idRol=tu.idRol AND tu.idRegional=tr.idRegional ORDER BY tu.idUsuario ASC offset $start_from ROWS FETCH NEXT 15 ROWS ONLY";
               
            }
           
    $ejecutar=sqlsrv_query($con,$consulta);      
    $contando_filas=sqlsrv_has_rows($ejecutar);

    if($contando_filas===false){
            echo "<div style='text-align:center'><h1></div></h1><br><div style='text-align:center'><h2>Sin registro de Usuarios</h2></div>";
    }else{
        
            $table.="<div class='table-responsive'><table class='table'>

                                <tr>
                                    <td>Nro</td>
                                    <td>Nombres</td>
                                    <td>Usuario</td>
                                    <td>Password</td>
                                    <td>Rol</td>
                                    <td>Email</td>
                                    <td>Regional</td>
                                    
                                  
                                </tr>
                        ";
            $num=1;
            while($row=sqlsrv_fetch_array($ejecutar)){


                    $table.="
                            
                                <tr>
                                    <td>".$num."</td>
                                    <td>".$row['nombres']."</td>
                                    <td>".$row['usuario']."</td>
                                    <td>".$row['password']."</td>
                                    <td>".$row['rol']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['regional']."</td>
                                   
                            
                                    <td>
                                           <button class='btn btn-danger' data-toggle='modal' data-target='#modal_eliminar_usuarios' data-id='".$row['idUsuario']."'>Eliminar</button>
                                           <button class='btn btn-primary' data-idregional='".$row['idRegional']."' data-email='".$row['email']."' data-rol='".$row['idRol']."' data-password='".$row['password']."' data-usuario='".$row['usuario']."' data-nombres='".$row['nombres']."' data-id='".$row['idUsuario']."' data-toggle='modal' data-target='#modal_editar_usuario'>Editar</button>
                                    </td>
                                </tr>

                            


                            ";

                $num++;
            }


        $table.="</table></div>";
        echo $table;

    }
?>