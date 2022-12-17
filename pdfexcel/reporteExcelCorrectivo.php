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
include ("../conexion.php");
$mes = 1;
if (isset($_POST['gestion']) && isset($_POST['mes'])) {
		$gestion = intval($_POST['gestion']);
		$mes = intval($_POST['mes']);
		$consulta = "SELECT tr.*, te.numestaciones FROM tblRegional tr, (SELECT COUNT(idRegional) as numestaciones, idRegional FROM tblEstaciones GROUP BY idRegional) te WHERE tr.idRegional = te.idRegional";
		$ejecutar = sqlsrv_query($con, $consulta);
		$row_count = sqlsrv_has_rows( $ejecutar);
		$regionales = array();
		if ($row_count === false){
		}else{
			while($row =sqlsrv_fetch_array($ejecutar)) {
				$regionales[]=$row;
			} 
		}
}
$mesaux = $mes;
?>
<style>
	#rotate {
		-moz-transform: rotate(-90.0deg);  /* FF3.5+ */
		-o-transform: rotate(-90.0deg);  /* Opera 10.5 */
		-webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
				filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
			-ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
	}
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
		<tr>
			<th>SISTEMA</th>
			<th id="rotate">N&#176; De Estaciones en Servicio</th>
			<th id="rotate">Tasa de Fallas sobre el N&#176; de Estaciones en Servicio</th>
			<th id="rotate">TOTAL DE FALLAS</th>
			<?php 
				for ($i=0; $i < 12 ; $i++) { 
					echo '<th id="rotate">'.quemes($mes).'</th>';
					echo '<th id="rotate">Tasa de Fallas</th>';
					$mes += 1;
					if($mes == 13){
						$mes = 1;
					}
				}
			?>
		</tr>
			<?php
				if (sizeof($regionales)>0) {
					foreach ($regionales as $key) {
						echo '<tr id="subtitulo">
							<td>'.$key['regional'].'</td>
							<td>'.$key['numestaciones'].'</td>
							<td colspan="27"></td></tr>';
							$sqlsistema = "SELECT COUNT(sistema) as numsistema ,sistema FROM tblEstaciones WHERE idRegional = ".$key['idRegional']." GROUP BY sistema";
							$sistemas = sqlsrv_query($con, $sqlsistema);
							$row_count = sqlsrv_has_rows($sistemas);
							$idRegional = $key['idRegional'];
							if ($row_count === false){
							}else{
								$sistema = $row['sistema'];
								$totsis = "EXEC total_sistema @sistema = 'sistema', @idregional = ".$idRegional.", @gestion = ".$gestion;
								$excuta = sqlsrv_query($con, $totsis); $tiposistema = array();
								if ($excuta){
									while($res = sqlsrv_fetch_array($excuta)){
										$tiposistema[$res['sistema']] = $res['numtotalsistema'];
									}
								}
								// print_r($tiposistema); 
								$numfa = 0; $pormeses = array(0, 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0);
								while($row =sqlsrv_fetch_array($sistemas)) {
									echo '<tr>
									<td>'.$row['sistema'].'</td>
									<td>'.$row['numsistema'].'</td>';
									if(isset($tiposistema[$row['sistema']])){
										$valor = $tiposistema[$row['sistema']];
										$numfa += $valor;
									}else{
										$valor = 0;
									}
									$porce = round((intval($valor)/intval($row['numsistema'])),2)*100;
									echo '<td>'.$valor.'</td>';
									echo '<td>'.$porce.' &#37;</td>';
									for ($i=0; $i < 12 ; $i++) {
										$totsismes = "EXEC total_sistema_mes @sistema = 'sistema', @idregional = ".$key['idRegional'].", @gestion = ".$gestion.", @mes = ".$mes;
										$excutado = sqlsrv_query($con, $totsismes); $tiposistemames = array();
										if ($excutado){
											while($resm = sqlsrv_fetch_array($excutado)){
												$tiposistemames[$resm['sistema']] = $resm['numtotalsistemames'];
											}
										}
										if(isset($tiposistemames[$row['sistema']])){
											$valorm = $tiposistemames[$row['sistema']];
											$pormeses[$mes] += $valorm;
										}else{
											$valorm = 0;
										}
										$porcem = round((intval($valorm)/intval($row['numsistema'])),2)*100;
										echo '<td>'.$valorm.'</td>';
										echo '<td>'.$porcem.' &#37;</td>';
										$mes += 1;
										if($mes == 13){
											$mes = 1;
										}
									}
									echo '
									</tr>';
								} 
							}
							echo '<tr id="pies">
							<td colspan="2"></td>';
							echo '<td>'.$numfa.'</td><td></td>';
							for ($i=0; $i < 12 ; $i++) {
								echo '<td>'.$pormeses[$mesaux].'</td>';
								echo '<td></td>';
								$mesaux += 1;
								if($mesaux == 13){
									$mesaux = 1;
								}
							}
							echo '</tr>';
							
						}
				}
			?>
</table> 