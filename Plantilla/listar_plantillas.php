<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }

include("../conexion.php");
$table="";
$start_from=$_POST['start'];
$limit = 10;
    $consulta= "SELECT * FROM tblPlantillaMaestro ORDER BY descripcion ASC offset $start_from ROWS FETCH NEXT $limit ROWS ONLY";
            if($_POST["texto"] != ""){
                $texto=$_POST['texto'];
                $consulta = "SELECT * FROM tblPlantillaMaestro WHERE (descripcion like '%".$texto."%') ORDER BY descripcion  ASC";
            }
    $ejecutar=sqlsrv_query($con,$consulta);
    $contando_filas=sqlsrv_has_rows($ejecutar);
    if($contando_filas===false){
            echo "<div style='text-align:center'><h1></div></h1><br><div style='text-align:center'><h2>Sin registro de Campo</h2></div>";
    }else{
            $table.="<div class='table-responsive'><table class='table'>
                    <tr>
                        <td>Nro</td>
                        <td>ID</td>
                        <td>TITULO</td>
                        <td>TIPO</td>
                        <td>ACCI&Oacute;N</td>
                    </tr>
                ";
            $num=1;
            while($row=sqlsrv_fetch_array($ejecutar)){
                    $table.="
                                <tr>
                                    <td>".$num."</td>
                                    <td>".$row['idPlantilla']."</td>
                                    <td>".$row['descripcion']."</td>
                                    <td>".$row['tipo']."</td>
                                    <td>
                                           <button class='btn btn-danger' data-toggle='modal' data-target='#modal_eliminar_plantilla' data-id='".$row['idPlantilla']."'>Eliminar</button>
                                           <button class='btn btn-primary' onclick='editarplantilla(".$row['idPlantilla'].")'>Editar</button>
                                           <button class='btn btn-info' onclick='reportes(".$row['idPlantilla'].")'>Generar reporte</button>
                                    </td>
                                </tr>
                            ";
                $num++;
            }
        $table.="</table></div>";
        echo $table;
    }
?>