$vector2= array();
                $calculo2="SELECT DISTINCT(linea) as res FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tc.idGrupo=4 AND tpd.idPlantilla = 7 AND tpd.idCampo = tc.idCampo order by linea DESC";
                $query_calculo2=sqlsrv_query($con,$calculo2);

                $cont = 0;
                while($row2=sqlsrv_fetch_array($query_calculo2)){
                  $vector2[$cont] = $row2['res'];
                  $cont++;
                }

                $longitud2=sizeof($vector2);



                foreach($campos2 as $value){
                      $linea=$value['res'];
                      $ultima_consulta="SELECT * FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tc.linea=$linea and tc.idGrupo=4 AND tpd.idPlantilla = 7 AND tpd.idCampo = tc.idCampo ORDER BY tc.linea DESC";
                      $query_ultima=sqlsrv_query($con,$ultima_consulta);
                      while($row_u=sqlsrv_fetch_array($query_ultima)){

                        $pdf->MultiCell(90, 2, "holi", 1, 'L', 0, 1, $sig, $salto, true);
                        
                      }
                }



                $dir = array();
                $calcular = "SELECT COUNT(tc.linea) as res,linea FROM tblPlantillaDetalle tpd, tblCampo tc WHERE tc.idGrupo=4 AND tpd.idPlantilla = $idplantilla AND tpd.idCampo = tc.idCampo GROUP BY linea order by linea DESC";
                $query_calcular=sqlsrv_query($con,$calcular);

                               
                $cont = 0;
                while ($row = sqlsrv_fetch_array($query_calcular)) {
                  $dir[$cont] = $row['res'];
                  $cont++;
                }
                $longitud=sizeof($dir);
                