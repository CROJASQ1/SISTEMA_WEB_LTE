<?php

/* 
    REPORTE DE TODOS LOS JUGADORES DEL SISTEMA
*/


include('conexion.php'); //CONEXION A LA BD

/* if (isset($_POST['fechaini'])) {
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
} */
// NOMBRE DEL ARCHIVO Y CHARSET
// header('Content-Type:application/vnd.ms-excel;charset=iso-8859-15');
// header('Content-Disposition: attachment; filename="Reportelapaz.xls"');

$filename = "REPORTE.xls";
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=' . $filename);

// SALIDA DEL ARCHIVO
/* 	$salida=fopen('php://output', 'w'); */
// ENCABEZADOS
// , 'fechaInicio'
/* fputcsv($salida, array('Nro', 'Codigo', 'Prestacion', 'N Prestaciones', 'Costo', 'Monto Total'), ";"); */

$resultado = "";

$maestro = "SELECT * FROM tblPlantillaMaestro ORDER BY descripcion";
$query_maestro = sqlsrv_query($con, $maestro);

while ($rowm = sqlsrv_fetch_array($query_maestro)) {

    $idplantilla = $rowm['idPlantilla']; 
    $sql = "SELECT tp.*,tc.campo from tblPlantillaDetalle tp,tblCampo tc where tc.idCampo=tp.idCampo AND tp.idPlantilla=$idplantilla ORDER BY tc.idCampo";
    $stmt = sqlsrv_query($con, $sql);

    
    $resultado.="ID:plantilla".$idplantilla;
    $resultado .= " <table class='table table-striped table-hover'>
                                <tr>
                                    <th>Nro</th>
                                    <th>Campo</th>
                                </tr>";
    while ($row = sqlsrv_fetch_array($stmt)) {
        $resultado .= ' <tr>';
        $resultado .= '<td>' . $row['idCampo'] . '</td>';
        $resultado .= '<td>' . utf8_decode($row['campo']) . '</td>';
        $resultado .= ' </tr>';
    }

    $resultado .= "</table>";
    $resultado .= "<br><br>"; 
}

echo $resultado;
