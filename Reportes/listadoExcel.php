<?php
$filename = "Listado de Estudiantes.xls";
// header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header('Content-Disposition: attachment; filename='.$filename);
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }
include ("../conexion.php"); 
if (isset($_POST['idmateria']) && isset($_POST['materia'])) {
	if (isset($_POST['idmateria'])) { $idmateria = $_POST['idmateria']; } else { $idmateria =''; }; if ($idmateria=='undefined'){ $idmateria=0; }
	if (isset($_POST['materia'])) { $materia = $_POST['materia']; } else { $materia =''; }; if ($materia=='undefined'){ $materia=''; }
	$consulta = "SELECT * FROM tblEstudiantes WHERE idMateria = $idmateria ORDER BY nombre ASC;";
}
?>
<table border="1" cellpadding="2">
		<tr>
			<th>N&#176;</th>
			<th>Apellidos y nombres</th>
			<th>CI</th>
			<th>Paralelo</th>
			<th>Carrera</th>
		</tr>
				<?php
					$ejecutar = sqlsrv_query($con, $consulta);
					$row_count = sqlsrv_has_rows( $ejecutar);
                if ($row_count === false){
                    echo '<tr><td colspan="8">No hay datos.</td></tr>';
                }else{
					$no = 1;
					while($row =sqlsrv_fetch_array($ejecutar)) {
					echo "<tr>
							<td>".$no."</td>
							<td>".utf8_decode($row['nombre'])."</td>
							<td style=' text-align: left;'>".$row['ci']."</td>
							<td>".utf8_decode($row['paralelo'])."</td>
							<td>".utf8_decode($row['carrera'])."</td></tr>";
					$no += 1;
					} 
				}
				?>
</table> 