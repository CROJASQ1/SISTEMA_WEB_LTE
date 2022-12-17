<?php
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }
include "../conexion.php";
if (!isset($_COOKIE['username'])) {
    header('Location:../index.php');
}
date_default_timezone_set('America/La_Paz');
$fechadehoy = date("Y-m-d", time()); $top = 0;
$avisos = "Sin acasos excepcionales";
if (isset($_POST) && isset($_POST['dato'])) {
	$datos_ventas = $_POST['dato'];
    $plantillas = json_decode($_POST['dato']);
	$titulo = strtoupper(trim($_POST['maestro']));
	$caso = trim($_POST['caso']);
	$maestro="INSERT INTO tblPlantillaMaestro (descripcion,tipo) VALUES ('$titulo', '$caso');";
	// echo $maestro;
	$excut0 = sqlsrv_query($con, $maestro);
	if ($excut0 === false){
		// echo "Error in statement preparation/execution.\n";
		die(json_encode(array('status' => 0,'result'=>false,',message'=>'Problemas al guardar plantilla principal.','avisos'=>$avisos)));
	}
	$ids_plantillas = "SELECT TOP 1 * FROM tblPlantillaMaestro WHERE descripcion = '$titulo' AND tipo = '$caso' ORDER BY idPlantilla DESC";
	$excut = sqlsrv_query($con, $ids_plantillas);
	$row_count = sqlsrv_has_rows($excut);
	if ($row_count === false){
		// echo "Error in retrieving row.\n";
		die(json_encode(array('status' => 0,'result'=>false,',message'=>'Problemas al obtener id de la plantilla principal.','avisos'=>$avisos)));
	}else{
		$sele = sqlsrv_fetch_array($excut);
		$top = intval($sele['idPlantilla']);
	}
	$insert2="INSERT INTO tblPlantillaDetalle(idPlantilla,idCampo) VALUES";
	$sw_coma = 0; $coma = ""; $insert3 = "";
	foreach ($plantillas as $caso) {
		$idca = $caso->idca;
		$insert3 .= $coma."($top,$idca)";
		if ($sw_coma == 0) {
			$coma = ","; $sw_coma = 1;
		}
	}
    $detalle = $insert2.$insert3.";";
    $actualiza = sqlsrv_query($con, $detalle);
	set_time_limit(25);
	if ($actualiza) {
		$obj = json_encode(array('status' => 1,'result' => "Listo, registro realizado.", 'message' => $top, 'avisos' => $avisos, ), true); 
	} else {
		$obj = json_encode(array('status' => 0,'result' => "Problemas al guardar los detalles de plantilla.", 'message' => $top, 'avisos' => $avisos, ), true); 
	}
}else{
	$obj = json_encode(array('status' => 0,'result' => "Error, no se envio los datos.", 'message' => $top, 'avisos' => $avisos, ), true); 
}
echo $obj;