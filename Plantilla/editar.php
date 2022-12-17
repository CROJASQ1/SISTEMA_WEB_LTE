<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }
include "../conexion.php";
date_default_timezone_set('America/La_Paz');
$fechadehoy = date("Y-m-d", time()); $top = 0;
$avisos = "Sin acasos excepcionales";
if (isset($_POST) && isset($_POST['dato'])) {
	$datos_ventas = $_POST['dato'];
    $plantillas = json_decode($_POST['dato']);
	$titulo = strtoupper(trim($_POST['maestro']));
	$caso = trim($_POST['caso']);
	$idplantilla = intval($_POST['idplantilla']);
	$maestro="UPDATE tblPlantillaMaestro SET descripcion = '$titulo' ,tipo = '$caso' WHERE idPlantilla = $idplantilla;";
	$excut0 = sqlsrv_query($con, $maestro);
	if ($excut0 === false){
		die(json_encode(array('status' => 0,'result'=>false,',message'=>'Problemas al actualizar datos.','avisos'=>$avisos)));
	}
	$delete = "DELETE tblPlantillaDetalle WHERE idPlantilla = $idplantilla;";
	$excut_del = sqlsrv_query($con, $delete);
	if ($excut_del){
		$idplantilla = $idplantilla;
	}else{
		die(json_encode(array('status' => 0,'result'=>false,',message'=>'Problemas al actualizar los detalles de plantilla.','avisos'=>$avisos)));
	}
	$insert2="INSERT INTO tblPlantillaDetalle(idPlantilla,idCampo) VALUES";
	$sw_coma = 0; $coma = ""; $insert3 = "";
	foreach ($plantillas as $caso) {
		$idca = $caso->idca;
		$insert3 .= $coma."($idplantilla,$idca)";
		if ($sw_coma == 0) {
			$coma = ","; $sw_coma = 1;
		}
	}
	$detalle = $insert2.$insert3.";";
	// echo $detalle;
    $actualiza = sqlsrv_query($con, $detalle);
	set_time_limit(25);
	if ($actualiza) {
		$obj = json_encode(array('status' => 1,'result' => "Listo, actualizacion realizada.", 'message' => $idplantilla, 'avisos' => $avisos, ), true); 
	} else {
		$obj = json_encode(array('status' => 0,'result' => "Problemas al guardar los detalles de plantilla.", 'message' => $idplantilla, 'avisos' => $avisos, ), true); 
	}
}else{
	$obj = json_encode(array('status' => 0,'result' => "Error, no se envio los datos.", 'message' => $idplantilla, 'avisos' => $avisos, ), true); 
}
echo $obj;