<?php
/*Datos de conexion a la base de datos*/
//  $serverName = "198.38.83.33";
//  $connectionInfo = array("Database"=>"rodolfo1_historialmedico", "Uid"=>"rodolfo1_historialmedico", "PWD"=>"rodolfo1_medico", "CharacterSet"=>"UTF-8");
/* 192.168.10.108 */
// $serverName = "198.38.94.75";
$serverName = "localhost";
$connectionInfo = array("Database"=>"db_entel_prueba", "Uid"=>"saenglish", "PWD"=>"matematica123---", "CharacterSet"=>"UTF-8");
 $con=sqlsrv_connect($serverName,$connectionInfo);
 if ($con){
 }
 else
 {
  echo 'No puede conectarse con la base de datos';
 }
?>
