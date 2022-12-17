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

		$consulta_mayor="SELECT * FROM tblFormulario WHERE tipo_formulario='$tipo_excel'";
		$query_mayor=sqlsrv_query($con,$consulta_mayor);
		$count_mayor=sqlsrv_has_rows($query_mayor);

		if($count_mayor===false){

		}else{


			while($row_maestro=sqlsrv_fetch_array($query_mayor)){
				echo "<table border='1' cellpadding='2'>";
				$id_formulario=$row_maestro['idFormulario'];

					$consulta_formulario="SELECT * FROM tblFormulario WHERE idFormulario=$id_formulario";
					$query_formulario=sqlsrv_query($con,$consulta_formulario);
					$count_row=sqlsrv_has_rows($query_formulario); 


						$consulta_servicios="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=1";
						$query_servicios=sqlsrv_query($con,$consulta_servicios);
						$count_servicios=sqlsrv_has_rows($query_servicios); 

						$consulta_transmision="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=2";
						$query_transmision=sqlsrv_query($con,$consulta_transmision);
						$count_transmision=sqlsrv_has_rows($query_transmision); 

						$consulta_ecomercial="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=3";
						$query_ecomercial=sqlsrv_query($con,$consulta_ecomercial);
						$count_ecomercial=sqlsrv_has_rows($query_ecomercial); 

						$consulta_esolar="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=4";
						$query_esolar=sqlsrv_query($con,$consulta_esolar);
						$count_esolar=sqlsrv_has_rows($query_esolar); 

						$consulta_proteccion="SELECT * from tblFormulario tf,tblDetalleFormulario td,tblCampo tc,tblGrupo tg WHERE tg.idGrupo=tc.idGrupo and tc.idCampo=td.idCampo AND tf.idFormulario=td.idFormulario and tf.idFormulario=$id_formulario AND tg.idGrupo=5";
						$query_proteccion=sqlsrv_query($con,$consulta_proteccion);
						$count_proteccion=sqlsrv_has_rows($query_proteccion); 


					if($count_row===false){
					

					}else{

						if($count_servicios===false){
									$contenido_servicios="";
						}else{
								while($fila1=sqlsrv_fetch_array($query_servicios)){
									$contenido_servicios[]=$fila1;
								}
						}


						if($count_transmision===false){
									$contenido_transmision="";
						}else{
								while($fila=sqlsrv_fetch_array($query_transmision)){
									$contenido_transmision[]=$fila;
								}

						}

							if($count_ecomercial===false){
									$contenido_ecomercial="";
						}else{
								while($fila=sqlsrv_fetch_array($query_ecomercial)){
									$contenido_ecomercial[]=$fila;
								}

						}

							if($count_esolar===false){
									$contenido_esolar="";
						}else{
								while($fila=sqlsrv_fetch_array($query_esolar)){
									$contenido_esolar[]=$fila;
								}

						}

							if($count_proteccion===false){
									$contenido_proteccion="";
						}else{
								while($fila=sqlsrv_fetch_array($query_proteccion)){
									$contenido_proteccion[]=$fila;
								}

						}
					
					?>					
								<tr>
									<th>ID</th>
									<th>Tipo estacion&#176;</th> 
									<th>codigo&#176;</th> 
									<th>Departamento&#176;</th> 
									<th>Encargado&#176;</th>
									<th>Cel&#176;</th>
									<th>Provincia&#176;</th>
									<th>Latitud&#176;</th>
									<th>Ini. intervalo&#176;</th>
									<th>Mun/Sec&#176;</th>
									<th>Longitud&#176;</th>
									<th>Fin. intervalo&#176;</th>
									<th>Localidad&#176;</th>
									<th>Rdo&#176;</th>
									<th>Porcentaje señal&#176;</th>
									<th>Nombre estacion&#176;</th>
									<th>Ubi Direccion&#176;</th>
									<th>Tipo trayecto&#176;</th>
									<th>Tramo 1&#176;</th>
									<th>Tramo 2&#176;</th>
									<th>Distancia viaje&#176;</th>
									<th>Trayecto&#176;</th>
									<th>Tiempo viaje&#176;</th>

									<th>Equipo 1&#176;</th>
									<th>Marca/modelo 1&#176;</th>
									<th>Serie 1&#176;</th>
									<th>Marca/modelo 2_1&#176;</th>
									<th>Serie 2_2&#176;</th>
									<th>Observaciones 1&#176;</th>

									<th>Equipo 2&#176;</th>
									<th>Marca/modelo 2&#176;</th>
									<th>Serie 2&#176;</th>
									<th>Marca/modelo 2_1&#176;</th>
									<th>Serie 2_2&#176;</th>
									<th>Observaciones 1&#176;</th>

									<th>Equipo 3&#176;</th>
									<th>Marca/modelo 3&#176;</th>
									<th>Serie 3&#176;</th>
									<th>Marca/modelo 3_1&#176;</th>
									<th>Serie 3_2&#176;</th>
									<th>Observaciones 3&#176;</th>

									<th>Equipo 4&#176;</th>
									<th>Marca/modelo 4&#176;</th>
									<th>Serie 4&#176;</th>
									<th>Marca/modelo 4_1&#176;</th>
									<th>Serie 4_2&#176;</th>
									<th>Observaciones 4&#176;</th>

									<th>Equipo 5&#176;</th>
									<th>Marca/modelo 5&#176;</th>
									<th>Serie 5&#176;</th>
									<th>Marca/modelo 5_1&#176;</th>
									<th>Serie 5_2&#176;</th>
									<th>Observaciones 5&#176;</th>

									<th>Item cambiado 1&#176;</th>
									<th>Cant 1&#176;</th>
									<th>Obs 1&#176;</th>
									<th>Item cambiado 1_2&#176;</th>
									<th>Cant 1_2&#176;</th>
									<th>Obs 1_2&#176;</th>

									<th>Item cambiado 2&#176;</th>
									<th>Cant 2&#176;</th>
									<th>Obs 2&#176;</th>
									<th>Item cambiado 2_2&#176;</th>
									<th>Cant 2_2&#176;</th>
									<th>Obs 2_2&#176;</th>

									<th>Item cambiado 3&#176;</th>
									<th>Cant 3&#176;</th>
									<th>Obs 3&#176;</th>
									<th>Item cambiado 3_2&#176;</th>
									<th>Cant 3_2&#176;</th>
									<th>Obs 3_2&#176;</th>

									<th>Item cambiado 4&#176;</th>
									<th>Cant 4&#176;</th>
									<th>Obs 4&#176;</th>
									<th>Item cambiado 4_2&#176;</th>
									<th>Cant 4_2&#176;</th>
									<th>Obs 4_2&#176;</th>

									<th>Item cambiado 5&#176;</th>
									<th>Cant 5&#176;</th>
									<th>Obs 5&#176;</th>
									<th>Item cambiado 5_2&#176;</th>
									<th>Cant 5_2&#176;</th>
									<th>Obs 5_2&#176;</th>


									<?php
										
										if(is_array($contenido_servicios)){
	
											foreach($contenido_servicios as $row){

											echo "<th>".utf8_decode($row['campo'])."</th>";
											
											}
										}

										if(is_array($contenido_transmision)){
										
											foreach($contenido_transmision as $row){

											echo "<th>".utf8_decode($row['campo'])."</th>";
										
											}
										}

										if(is_array($contenido_ecomercial)){

											foreach($contenido_ecomercial as $row){

											echo "<th>".utf8_decode($row['campo'])."</th>";
										
											}
										}
										
									if(is_array($contenido_esolar)){

											foreach($contenido_esolar as $row){

											echo "<th>".utf8_decode($row['campo'])."</th>";
										
										}

									}

										if(is_array($contenido_proteccion)){
										
											foreach($contenido_proteccion as $row){

											echo "<th>".utf8_decode($row['campo'])."</th>";
										
										}
									}
							
									?>
								</tr>

		


									<?php
											while($row =sqlsrv_fetch_array($query_formulario)) {
											echo "<tr>
														<td>".utf8_decode($row['idEstacion'])."</td>
														<td>".utf8_decode($row['tipo_est'])."</td>
														<td>".utf8_decode($row['codigo'])."</td>
														<td>".utf8_decode($row['depto'])."</td>
														<td>".utf8_decode($row['encargado'])."</td>
														<td>".utf8_decode($row['cel'])."</td>
														<td>".utf8_decode($row['provincia'])."</td>
														<td>".utf8_decode($row['latitud'])."</td>
														<td>".utf8_decode($row['ini_intervalo'])."</td>
														<td>".utf8_decode($row['mun_sec'])."</td>
														<td>".utf8_decode($row['longitud'])."</td>
														<td>".utf8_decode($row['fin_intervalo'])."</td>
														<td>".utf8_decode($row['localidad'])."</td>
														<td>".utf8_decode($row['rdo'])."</td>
														<td>".utf8_decode($row['porcentaje_senal'])."</td>
														<td>".utf8_decode($row['nom_estacion'])."</td>
														<td>".utf8_decode($row['ubi_direccion'])."</td>
														<td>".utf8_decode($row['tipo_trayecto'])."</td>
														<td>".utf8_decode($row['tramo_1'])."</td>
														<td>".utf8_decode($row['tramo_2'])."</td>
														<td>".utf8_decode($row['distancia_viaje'])."</td>
														<td>".utf8_decode($row['trayecto'])."</td>
														<td>".utf8_decode($row['tiempoviaje'])."</td>

						

														<td>".utf8_decode($row['equipo_1'])."</td>
														<td>".utf8_decode($row['marca_modelo1_1'])."</td>
														<td>".utf8_decode($row['serie1_1'])."</td>
															<td>".utf8_decode($row['marca_modelo2_1'])."</td>
															<td>".utf8_decode($row['serie2_1'])."</td>
															<td>".utf8_decode($row['observaciones_1'])."</td>

															<td>".utf8_decode($row['equipo_2'])."</td>
															<td>".utf8_decode($row['marca_modelo1_2'])."</td>
															<td>".utf8_decode($row['serie1_2'])."</td>	  
															<td>".utf8_decode($row['marca_modelo2_2'])."</td>
															<td>".utf8_decode($row['serie2_2'])."</td>
															<td>".utf8_decode($row['observaciones_2'])."</td>	

															<td>".utf8_decode($row['equipo_3'])."</td>
															<td>".utf8_decode($row['marca_modelo1_3'])."</td>
															<td>".utf8_decode($row['serie1_3'])."</td>
															<td>".utf8_decode($row['marca_modelo2_3'])."</td>
															<td>".utf8_decode($row['serie2_3'])."</td>
															<td>".utf8_decode($row['observaciones_3'])."</td>

															<td>".utf8_decode($row['equipo_4'])."</td>
															<td>".utf8_decode($row['marca_modelo1_4'])."</td>
															<td>".utf8_decode($row['serie1_4'])."</td>
															<td>".utf8_decode($row['marca_modelo2_4'])."</td>
															<td>".utf8_decode($row['serie2_4'])."</td>
															<td>".utf8_decode($row['observaciones_4'])."</td>

															<td>".utf8_decode($row['equipo_5'])."</td>
															<td>".utf8_decode($row['marca_modelo1_5'])."</td>
															<td>".utf8_decode($row['serie1_5'])."</td>
															<td>".utf8_decode($row['marca_modelo2_5'])."</td>
															<td>".utf8_decode($row['serie2_5'])."</td>
															<td>".utf8_decode($row['observaciones_5'])."</td>


															<td>".utf8_decode($row['item_cambiado1_1'])."</td>
															<td>".utf8_decode($row['cant1_1'])."</td>
															<td>".utf8_decode($row['obs1_1'])."</td>
															<td>".utf8_decode($row['item_cambiado2_1'])."</td>
															<td>".utf8_decode($row['cant2_1'])."</td>
															<td>".utf8_decode($row['obs2_1'])."</td>

															<td>".utf8_decode($row['item_cambiado1_2'])."</td>
															<td>".utf8_decode($row['cant1_2'])."</td>
															<td>".utf8_decode($row['obs1_2'])."</td>
															<td>".utf8_decode($row['item_cambiado2_2'])."</td>
															<td>".utf8_decode($row['cant2_2'])."</td>
															<td>".utf8_decode($row['obs2_2'])."</td>

															<td>".utf8_decode($row['item_cambiado1_3'])."</td>
															<td>".utf8_decode($row['cant1_3'])."</td>
															<td>".utf8_decode($row['obs1_3'])."</td>
															<td>".utf8_decode($row['item_cambiado2_3'])."</td>
															<td>".utf8_decode($row['cant2_3'])."</td>
															<td>".utf8_decode($row['obs2_3'])."</td>

															<td>".utf8_decode($row['item_cambiado1_4'])."</td>
															<td>".utf8_decode($row['cant1_4'])."</td>
															<td>".utf8_decode($row['obs1_4'])."</td>
															<td>".utf8_decode($row['item_cambiado2_4'])."</td>
															<td>".utf8_decode($row['cant2_4'])."</td>
															<td>".utf8_decode($row['obs2_4'])."</td>

															<td>".utf8_decode($row['item_cambiado1_5'])."</td>
															<td>".utf8_decode($row['cant1_5'])."</td>
															<td>".utf8_decode($row['obs1_5'])."</td>
															<td>".utf8_decode($row['item_cambiado2_5'])."</td>
															<td>".utf8_decode($row['cant2_5'])."</td>
															<td>".utf8_decode($row['obs2_5'])."</td>
														";


														
															
													} 
														
													if(is_array($contenido_servicios)){
																	foreach($contenido_servicios as $row_servicio){

																		$dato=$row_servicio['dato'];

																		if($dato==""){

																				echo "<td style='text-align:center'>-</td>";
																		}else{
																				
																				echo "<td style='text-align:center'>".$dato."</td>";
																		}


																	}
													}
													

													if(is_array($contenido_transmision)){
																foreach($contenido_transmision as $row_transmision){

																	$dato=$row_transmision['dato'];

																		if($dato==""){

																				echo "<td style='text-align:center'>-</td>";
																		}else{
																				
																				echo "<td style='text-align:center'>".$dato."</td>";
																		}


																	}
														
													}
															
													if(is_array($contenido_ecomercial)){
																foreach($contenido_ecomercial as $row_comercial){

																	$dato=$row_comercial['dato'];

																		if($dato==""){

																				echo "<td style='text-align:center'>-</td>";
																		}else{
																				
																				echo "<td style='text-align:center'>".$dato."</td>";
																		}


																	}
																}				
													

													if(is_array($contenido_esolar)){
																foreach($contenido_esolar as $row_esolar){

																	$dato=$row_esolar['dato'];

																		if($dato==""){

																				echo "<td style='text-align:center'>-</td>";
																		}else{
																				
																				echo "<td style='text-align:center'>".$dato."</td>";
																		}


																	}
															}

													if(is_array($contenido_proteccion)){
																foreach($contenido_proteccion as $row_proteccion){

																	$dato=$row_proteccion['dato'];

																		if($dato==""){

																				echo "<td style='text-align:center'>-</td>";
																		}else{
																				
																				echo "<td style='text-align:center'>".$dato."</td>";
																		}


																	}
														}	
														
											echo "</tr>";


								}	

							echo "</table> <br>";				
									
						}				
									
									?>
								


			<?php

				}


			?>
						

		
