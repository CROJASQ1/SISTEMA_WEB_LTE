<?php
$filename = "Listado de Correctivos.xls";
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header('Content-Disposition: attachment; filename='.$filename);
if(!isset($_COOKIE['username'])){
    header('Location:../index.php');
  }

function quemes($mesactual){
	switch (intval($mesactual)) {
		case 1:
			$mesactual = "ENERO";
			break;
		case 2:
			$mesactual = "FEBRERO";
			break;
		case 3:
			$mesactual = "MARZO";
			break;
		case 4:
			$mesactual = "ABRIL";
			break;
		case 5:
			$mesactual = "MAYO";
			break;
		case 6:
			$mesactual = "JUNIO";
			break;
		case 7:
			$mesactual = "JULIO";
			break;
		case 8:
			$mesactual = "AGOSTO";
			break;
		case 9:
			$mesactual = "SEPTIEMBRE";
			break;
		case 10:
			$mesactual = "OCTUBRE";
			break;
		case 11:
			$mesactual = "NOVIEMBRE";
			break;
		case 12:
			$mesactual = "DICIEMBRE";
			break;
	}
	return $mesactual;
}
$gestiones = array();
$meses = array();
if(isset($_POST['fechaini']) && isset($_POST['fechafin'])){
    $idregion = intval($_POST['idregion']);
	$fechaini = $_POST['fechaini'];
	$vec_inicial = explode('-',$fechaini);
	$fechafin = $_POST['fechafin'];
	$vec_final = explode('-',$fechafin);
    $tipotrab = $_POST['tipotrab'];
    $regional = $_POST['regional'];
    $tiporang = intval($_POST['tiporang']);
    $casogrup = intval($_POST['casogrup']);
    $casopcio = intval($_POST['casopcio']);
    switch ($tiporang) {
            case 2:
              $caso_meses = 'MES';
              break;
            case 3:
              $caso_meses = 'TRIMESTRE';
              break;
            case 4:
              $caso_meses = 'SEMESTRAL';
              break;
            case 5:
              $caso_meses = 'ANUAL';
              break;
            default:
              $caso_meses = 'ENTRE FECHAS';
              break;
	}

	for ($i=$vec_inicial[0]; $i <= $vec_final[0] ; $i++) { 
		$gestiones[] = $i;
	}
	// print_r($gestiones);
	// echo "<br>";
	$mes_ini = intval($vec_inicial[1]); $mes_fin = intval($vec_final[1]);

	foreach ($gestiones as $key) {
		if(intval(end($gestiones)) == intval($key)){
			// echo "year tope <br>";
			$top = $mes_fin;
		}else{
			// echo "year fluit <br>";
			$top = 12;
		}
		// echo 'iniciando mes: '.$mes_ini."<br>";
		for ($i=$mes_ini; $i <= $top; $i++) { 
			$auxi['mes']=$i;
			$auxi['ani']=$key;
			$meses[]=$auxi;
		}
		if ($i == 13) {
			$mes_ini = 1;
		}
		
	}
	// print_r($meses);
}

include ("../conexion.php");

		$consulta = "SELECT tr.*, te.numestaciones FROM tblRegional tr, (SELECT COUNT(idRegional) as numestaciones, idRegional FROM tblEstaciones GROUP BY idRegional) te WHERE tr.idRegional = te.idRegional";
		// echo $consulta;
		$ejecutar = sqlsrv_query($con, $consulta);
		$row_count = sqlsrv_has_rows( $ejecutar);
		$regionales = array();
		if ($row_count === false){
		}else{
			while($row =sqlsrv_fetch_array($ejecutar)) {
				$regionales[]=$row;
			} 
		}
		$tam = (sizeof($meses)+1)*2;
?>
<style>
	#subtitulo {
		padding: 8px; 
		text-align: center; 
		border-bottom: 1px solid #000; 
		background-color: green;
		color:white;
	}
	#pies {
		padding: 8px; 
		text-align: center; 
		border-bottom: 1px solid #000; 
		background-color: blue;
		color:white;
	}
</style>
<table border="1" cellpadding="2">
<tr><th colspan="<?php echo $tam+2;?>">TASA DE FALLAS</th></tr>
		<tr>
			<th>SISTEMA</th>
			<th>N&#176; De Estaciones en Servicio</th>
			<th>TOTAL DE FALLAS</th>
			<th>Tasa de Fallas sobre el N&#176; de Estaciones en Servicio</th>
			<?php 
				foreach ($meses as $mes) {
					echo '<th>'.quemes($mes['mes']).'</th>';
					echo '<th>Tasa de Fallas</th>';
				}
			?>
		</tr>
			<?php
				if (sizeof($regionales)>0) {
					foreach ($regionales as $key) {
						echo '<tr>
							<td id="subtitulo">'.$key['regional'].'</td>
							<td id="subtitulo">'.$key['numestaciones'].'</td>
							<td id="subtitulo" colspan="'.$tam.'"></td></tr>';
							$sqlsistema = "SELECT COUNT(sistema) as numsistema ,sistema FROM tblEstaciones WHERE idRegional = ".$key['idRegional']." GROUP BY sistema";
							$sistemas = sqlsrv_query($con, $sqlsistema);
							$row_count = sqlsrv_has_rows($sistemas);
							$idRegional = $key['idRegional'];
							if ($row_count === false){
							}else{
								$pormeses = array();
								foreach ($meses as $mes) {
									$pormeses[$mes['mes']] = 0;
								}
								// print_r($pormeses);
								$numfa = 0;
								foreach ($gestiones as $gestion) {
									// $sistema = $row['sistema'];
									$totsis = "EXEC total_sistema @sistema = 'sistema', @idregional = ".$idRegional.", @gestion = ".$gestion;
									$excuta = sqlsrv_query($con, $totsis); $tiposistema = array();
									if ($excuta){
										while($res = sqlsrv_fetch_array($excuta)){
											$tiposistema[$res['sistema']] = $res['numtotalsistema'];
										}
									}
									// print_r($tiposistema);									
									
									while($row =sqlsrv_fetch_array($sistemas)) {
										echo '<tr>
										<td>'.$row['sistema'].'</td>
										<td>'.$row['numsistema'].'</td>';
										if(isset($tiposistema[$row['sistema']])){
											$valor = $tiposistema[$row['sistema']];
										}else{
											$valor = 0;
										}
										$numfa += $valor;
										$porce = round((intval($valor)/intval($row['numsistema'])),2)*100;
										echo '<td>'.$valor.'</td>';
										echo '<td>'.$porce.' &#37;</td>';
										foreach ($meses as $mes) {
											$totsismes = "EXEC total_sistema_mes @sistema = 'sistema', @idregional = ".$key['idRegional'].", @gestion = ".$gestion.", @mes = ".$mes['mes'];
											$excutado = sqlsrv_query($con, $totsismes); $tiposistemames = array();
											if ($excutado){
												while($resm = sqlsrv_fetch_array($excutado)){
													$tiposistemames[$resm['sistema']] = $resm['numtotalsistemames'];
												}
											}
											if(isset($tiposistemames[$row['sistema']])){
												$valorm = $tiposistemames[$row['sistema']];
											}else{
												$valorm = 0;
											}
											$pormeses[$mes['mes']] += $valorm;
											$porcem = round((intval($valorm)/intval($row['numsistema'])),2)*100;
											echo '<td>'.$valorm.'</td>';
											echo '<td>'.$porcem.' &#37;</td>';
										}
										echo '
										</tr>';
									} 
								}
								// print_r($pormeses);
							}
							echo '<tr>
							<td colspan="2" id="pies"></td>';
							$totalporcen = round((intval($numfa)/intval($key['numestaciones'])),2)*100;
							echo '<td id="pies">'.$numfa.'</td><td id="pies">'.$totalporcen.' &#37;</td>';
							foreach ($meses as $mes) {
								echo '<td id="pies">'.$pormeses[$mes['mes']].'</td>';
								$totalmes = round((intval($pormeses[$mes['mes']])/intval($key['numestaciones'])),2)*100;
								echo '<td id="pies">'.$totalmes.' &#37;</td>';
							}
							echo '</tr>';
							
						}
				}
			?>
</table> 