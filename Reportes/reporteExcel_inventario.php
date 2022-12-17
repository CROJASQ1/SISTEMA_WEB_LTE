<?php
$filename = "Reporte de materias.xls";
// header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
 header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header('Content-Disposition: attachment; filename='.$filename);
session_start(); 
include ("../conexion.php"); 

$tipo_excel=$_POST['tipo_excel'];

echo "<h2 style='font-weight:bold'>Reportes</h2>

		";

		$consulta_mayor="SELECT DISTINCT(tf.idFormulario),tf.idEstacion FROM tblFormulario tf,tblDetalleFormulario td WHERE td.idFormulario=tf.idFormulario AND tipo_formulario='$tipo_excel'";
		$query_mayor=sqlsrv_query($con,$consulta_mayor);
		$count_mayor=sqlsrv_has_rows($query_mayor);

		if($count_mayor===false){

		}else{


			while($row_maestro=sqlsrv_fetch_array($query_mayor)){
				echo "<table border='1' cellpadding='2'>";
				$id_formulario=$row_maestro['idFormulario'];


						$consulta_trx="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=6";
						$query_trx=sqlsrv_query($con,$consulta_trx);
						$count_trx=sqlsrv_has_rows($query_trx); 

						$consulta_ienergia="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=7";
						$query_ienergia=sqlsrv_query($con,$consulta_ienergia);
						$count_ienergia=sqlsrv_has_rows($query_ienergia); 

						$consulta_psolares="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=8";
						$query_psolares=sqlsrv_query($con,$consulta_psolares);
						$count_psolares=sqlsrv_has_rows($query_psolares); 

						$consulta_einformatico="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=9";
						$query_einformatico=sqlsrv_query($con,$consulta_einformatico);
						$count_einformatico=sqlsrv_has_rows($query_einformatico); 

						$consulta_moviliario="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=10";
						$query_moviliario=sqlsrv_query($con,$consulta_moviliario);
						$count_moviliario=sqlsrv_has_rows($query_moviliario); 

						if($count_trx===false){
								$contenido_trx="";
						}else{
								while($fila=sqlsrv_fetch_array($query_trx)){
									$contenido_trx[]=$fila;
								}

						}

						if($count_ienergia===false){
									$contenido_ienergia="";
						}else{
								while($fila=sqlsrv_fetch_array($query_ienergia)){
									$contenido_ienergia[]=$fila;
								}

						}

							if($count_psolares===false){
									$contenido_psolares="";
						}else{
								while($fila=sqlsrv_fetch_array($query_psolares)){
									$contenido_psolares[]=$fila;
								}

						}

							if($count_einformatico===false){
									$contenido_einformatico="";
						}else{
								while($fila=sqlsrv_fetch_array($query_einformatico)){
									$contenido_einformatico[]=$fila;
								}

						}

							if($count_moviliario===false){
									$contenido_moviliario="";
						}else{
								while($fila=sqlsrv_fetch_array($query_moviliario)){
									$contenido_moviliario[]=$fila;
								}

						}

						
					
					?>	
							<tr>
								<?php
									
									echo "<th>I.D</th>";

										
									if(is_array($contenido_trx)){

										foreach($contenido_trx as $row){

											echo "<th>".utf8_decode($row['campo'])."</th>";
										
										}
									}

									if(is_array($contenido_ienergia)){
									
									foreach($contenido_ienergia as $row){

										echo "<th>".utf8_decode($row['campo'])."</th>";
									
										}
									}

									if(is_array($contenido_psolares)){

									foreach($contenido_psolares as $row){

										echo "<th>".utf8_decode($row['campo'])."</th>";
									
										}
									}
										
									if(is_array($contenido_einformatico)){

										foreach($contenido_einformatico as $row){

											echo "<th>".utf8_decode($row['campo'])."</th>";
										
										}

									}

									if(is_array($contenido_moviliario)){
									
									foreach($contenido_moviliario as $row){

										echo "<th>".utf8_decode($row['campo'])."</th>";
									
										}
									}
							
									?>

							</tr>


							<?php

										echo "<th>".$row_maestro['idEstacion']."</th>";
														
										if(is_array($contenido_trx)){
														foreach($contenido_trx as $row_trx){

															$dato=$row_trx['dato'];

															if($dato==""){

																	echo "<td style='text-align:center'>-</td>";
															}else{
																	
																	echo "<td style='text-align:center'>".$dato."</td>";
															}


														}
										}
										

										if(is_array($contenido_ienergia)){
													foreach($contenido_ienergia as $row_ienergia){

														$dato=$row_ienergia['dato'];

															if($dato==""){

																	echo "<td style='text-align:center'>-</td>";
															}else{
																	
																	echo "<td style='text-align:center'>".$dato."</td>";
															}


														}
											
										}
												
										if(is_array($contenido_psolares)){
													foreach($contenido_psolares as $row_psolares){

														$dato=$row_psolares['dato'];

															if($dato==""){

																	echo "<td style='text-align:center'>-</td>";
															}else{
																	
																	echo "<td style='text-align:center'>".$dato."</td>";
															}


														}
													}				
										

										if(is_array($contenido_einformatico)){
													foreach($contenido_einformatico as $row_einformatico){

														$dato=$row_einformatico['dato'];

															if($dato==""){

																	echo "<td style='text-align:center'>-</td>";
															}else{
																	
																	echo "<td style='text-align:center'>".$dato."</td>";
															}


														}
												}

										if(is_array($contenido_moviliario)){
													foreach($contenido_moviliario as $row_moviliario){

														$dato=$row_moviliario['dato'];

															if($dato==""){

																	echo "<td style='text-align:center'>-</td>";
															}else{
																	
																	echo "<td style='text-align:center'>".$dato."</td>";
															}


														}
											}	
											
								echo "</tr>";


							

							echo "</table> <br>";				
									
						}				
									
									?>
								


			<?php

				}


			?>
						

		
