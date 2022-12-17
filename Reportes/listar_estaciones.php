<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }

include("../conexion.php");
$table="";

$start_from=$_POST['start'];

    $consulta= "SELECT * FROM tblEstaciones te,tblRegional tr WHERE te.idRegional=tr.idRegional ORDER BY te.idEstacion ASC offset $start_from ROWS FETCH NEXT 10 ROWS ONLY";
                  


            if($_POST["texto"] != ""){

                $texto=$_POST['texto'];
                $consulta = "SELECT * FROM tblEstaciones te,tblRegional tr WHERE te.idRegional=tr.idRegional AND (te.nombre_Estacion like '%".$texto."%') ORDER BY te.idUsuario  ASC";
                   
            }
            
    $ejecutar=sqlsrv_query($con,$consulta);      
    $contando_filas=sqlsrv_has_rows($ejecutar);

    if($contando_filas===false){
            echo "<div style='text-align:center'><h1></div></h1><br><div style='text-align:center'><h2>Sin registro de estaciones</h2></div>";
    }else{
        
            $table.="<div class='table-responsive'><table class='table table-hover'>

                                <tr>
                                    <td>Nro</td>
                                    <td>Nombre</td>
                                    <td>Regional</td>
                                    <td>Provincia</td>
                                    <td>Localidad</td>
                                    <td>Municipio</td>      
                                    <td>I.D.</td>
                                    <td>sistema</td>
                                    <td>Acciones</td>
                                </tr>
                        ";
            $num=1;
            while($row=sqlsrv_fetch_array($ejecutar)){


                    $table.="     
                                <tr>
                                    <td>".$num."</td>
                                    <td>".$row['nombre_Estacion']."</td>
                                    <td>".$row['regional']."</td>
                                    <td>".$row['provincia']."</td>
                                    <td>".$row['localidad']."</td>
                                    <td>".$row['municipio']."</td>
                                    <td>".$row['id']."</td>
                                    <td>".$row['sistema']."</td>
                            
                                    <td>
                                           <button class='btn btn-danger' data-toggle='modal' data-target='#modal_eliminar_estacion' data-id='".$row['idEstacion']."'>Eliminar</button>
                                           <button class='btn btn-primary' data-nombre='".$row['nombre_Estacion']."' data-localidad='".$row['localidad']."' data-idreg='".$row['idRegional']."' data-ruteo='".$row['ruteo']."' data-distancia='".$row['distancia_km']."' data-longitud='".$row['longitud']."' data-latitud='".$row['latitud']."' data-sistema='".$row['sistema']."' data-id='".$row['id']."' data-ubi='".$row['ubicacion_ambiente_tele']."' data-municipio='".$row['municipio']."' data-provincia='".$row['provincia']."' data-ides='".$row['idEstacion']."' data-toggle='modal' data-target='#modal_editar_estacion'>Editar</button>
                                    </td>
                                </tr>
                            ";

                $num++;
            }


        $table.="</table></div>";
        echo $table;

    }
?>