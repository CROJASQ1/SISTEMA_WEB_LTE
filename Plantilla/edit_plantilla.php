<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }

include("../conexion.php");
if(isset($_POST['idplantilla'])){
    $idplantilla = intval($_POST['idplantilla']);
    setcookie('idplantilla',$idplantilla, time()+18000,'/',false);
}else{
    $idplantilla = intval($_COOKIE['idplantilla']);
}
$listado_principal = "SELECT * FROM tblPlantillaMaestro WHERE idPlantilla = $idplantilla;";
$ejecutar=sqlsrv_query($con,$listado_principal);
$contando_filas=sqlsrv_has_rows($ejecutar);
if($contando_filas===false){
    $titulo = '';
    $caso = 'PREVENTIVO';
}else{
    $row=sqlsrv_fetch_array($ejecutar);
    $titulo = $row['descripcion'];
    $caso = $row['tipo'];
}

$listado_detalle = "SELECT * FROM tblPlantillaDetalle WHERE idPlantilla = $idplantilla;";
$ejecutar_deta=sqlsrv_query($con,$listado_detalle);
$contando_filas=sqlsrv_has_rows($ejecutar_deta);
$lista_campos = array();
if($contando_filas===false){
}else{
    while($row=sqlsrv_fetch_array($ejecutar_deta)){
        $lista_campos[] = $row['idCampo'];
    }
}
$campos = implode('|',$lista_campos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../images/lte.ico">
        <title>Adición</title>
        <!-- Bootstrap -->
    <style>
        .content {
            margin-top: 80px;
       }
    </style>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
   <!--  <link rel="stylesheet" href="../jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui.css" /> -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="./css/component.css">

    <script src="js/jquery-3.3.1.js"></script> 

 </head>
 <body class="hold-transition sidebar-mini">
 <div class="wrapper">
    
    <?php
    $plantilla=true;
    include("../nav/nav.php");
    ?>
    <div class="content-wrapper">
    <div class="container">
       <br>
            <h2>Editar: Plantilla</h2>
            <hr/>

            <div id="errores"></div>
            <form id="crear_plantilla">
                <div class="form-group row">
                    <input type="hidden" id="idplantilla_select" value="<?php echo $idplantilla?>">
                    <input type="hidden" id="id_campos_select" value="<?php echo $campos?>">
                    <label class="col-sm-1 control-label">T&iacute;tulo</label>
                    <div class="col-sm-4">
                        <input type="text" id="plantilla" class="form-control" placeholder="Escriba el plantilla..." autocomplete='off' value="<?php echo $titulo;?>" required >
                    </div>
                    <div class="col-sm-2">
                        <input type="hidden" id="tipo_select" value="<?php echo $caso?>">
                        <select class="form-control" id="plantilla_caso">
                            <option value="PREVENTIVO">PREVENTIVO</option>
                            <option value="EXTRACANON">EXTRACANON</option>
                            <option value="CORRECTIVO">CORRECTIVO</option>
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <input type="button" id="add_plantilla" class="btn btn-lg btn-success" onclick="guardarplantilla()" title="Guardar plantilla como nueva" value="G. Nuevo">
                        <input type="button" id="edit_plantilla" class="btn btn-lg btn-primary" onclick="editarplantilla()" title="Guardar la edici&oacute;n plantilla" value="G. Edici&oacute;n">
                        <a href="plantilla.php" class="btn btn-lg btn-danger">Volver al listado</a>
                    </div>
                </div>

                <?php
                // $listado_campos = "SELECT * FROM tblCampo tc, tblGrupo tg WHERE tc.idGrupo = tg.idGrupo ORDER BY tg.idGrupo, tc.campo DESC; ";
                $listado_campos = "SELECT *, CASE WHEN tc.idSubGrupo = 0 THEN 0 ELSE 1 END as valor FROM tblCampo tc LEFT JOIN tblSubGrupo ts ON tc.idSubGrupo = ts.idSubGrupo , tblGrupo tg WHERE tc.idGrupo = tg.idGrupo ORDER BY tg.idGrupo, tc.idCampo ASC;";
                $lista_campo = array(); $lista_grupo = array(); $indice = array();
                $ejecutar=sqlsrv_query($con,$listado_campos);
                $contando_filas=sqlsrv_has_rows($ejecutar);
                if($contando_filas===false){
                    
                }else{
                    $pun = 0;
                    while($row=sqlsrv_fetch_array($ejecutar)){
                        $lista_campo[] = $row;
                        if (!in_array($row['idGrupo'], $indice)) {
                            $lista_grupo[$pun]['idGrupo'] = $row['idGrupo'];
                            $lista_grupo[$pun]['grupo'] = $row['grupo'];
                            $indice[$pun] = $row['idGrupo'];
                            $pun += 1;
                        }
                    }
                }
                // print_r($lista_grupo);
                ?>
                <div class="col-lg-12">
                    <?php foreach ($lista_grupo as $key) {
                        $idgrupo = intval($key['idGrupo']);
                        $grupo = $key['grupo'];
                    ?>
                        <div class="row">
                            <div class="col-md-1">
                                <button type="button" id="cerrar<?php echo $idgrupo;?>" class="btn btn-lg btn-primary" onclick="contraer(<?php echo $idgrupo;?>)"><i class="fas fa-angle-double-down"></i></button>
                                <button type="button" id="abrir<?php echo $idgrupo;?>" class="btn btn-lg btn-danger"  onclick="mostrar(<?php echo $idgrupo;?>)" style="display: none;"><i class="fas fa-angle-double-right"></i></button>
                            </div>
                            <div class="col-md-11" style="display: none;" id="clasificacion<?php echo $idgrupo;?>">
                                <table class='table'>
                                    <tr>
                                        <th colspan="3">GRUPO: <?php echo $grupo;?></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-11" id="division<?php echo $idgrupo;?>">
                                <table class='table'>
                                    <tr>
                                        <th colspan="3">GRUPO: <?php echo $grupo;?></th>
                                    </tr>
                                    <tr>
                                        <th>Nº</th>
                                        <th>CAMPO</th>
                                        <th>ACTIVO</th>
                                    </tr>
                                    <?php
                                    if(sizeof($lista_campo) == 0){
                                            echo "<tr colspan='4'><td>Sin registro de Campo</td></tr>";
                                    }else{
                                        $no = 1;
                                        foreach ($lista_campo as $row) {
                                            if (intval($row['idGrupo']) == $idgrupo) {
                                                if(intval($row['idSubGrupo']) > 0){
                                                    $style = 'style="background-color: '.$row['color'].'"';
                                                }else{
                                                    $style = '';
                                                }
                                                echo '<tr '.$style.'>
                                                    <th>'.$no.'</th>
                                                    <th>'.$row['campo'].'</th>
                                                    <th><label class="switch">
                                                        <input type="checkbox" id="switch-'.$row['idCampo'].'" style="width:30px;height:30px" onclick="seleccionar('.$row['idCampo'].')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    </th>
                                                </tr>';
                                                $no += 1;
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    <?php }?>
                </div>

                <div class="form-group row">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-6">
                            <input type="button" id="edit_plantilla" class="btn btn-lg btn-primary" onclick="editarplantilla()" value="Editar datos">
                            <a href="plantilla.php" class="btn btn-lg btn-danger">Volver al listado</a>
                        </div>
                    </div> 

                <br>

            </form>


        
    </div>

            

    </div>

</div>  

    <?php
    // include("modal_respuesta.php");
    // include("modal_respuesta_usuario.php");
    ?>
        <script src="js/app.js"></script>
        <script src="js/app_edit.js"></script>
        <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../dist/js/adminlte.js"></script>

</body>
</html>
