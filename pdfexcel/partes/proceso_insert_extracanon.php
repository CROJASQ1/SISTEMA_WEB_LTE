<?php
$id_user=$_COOKIE['userid'];
/* include("conexion.php"); */
for ($i = 3; $i <= 93; $i++) {
    if ($i != 4 && $i != 11 && $i != 22) {
        if (isset($producto->$i)) {
            $valor_a_cambiar = $producto->$i;

            if ($i == 18 || $i == 19) {
                $date = new DateTime('1899-12-31');
                $date->modify("+$valor_a_cambiar day -1 day");
                $fecha_aux = $date->format('Y-m-d');
                $valor_a_cambiar = $fecha_aux;
            } else if ($i == 20 || $i == 21) {
                $valor = $valor_a_cambiar * 24;
                $hora = convertTime($valor);
                $valor_a_cambiar = $hora;
            }

            array_push($array_datos, $valor_a_cambiar);
        } else {
            array_push($array_datos, " ");
        }
    }
}

/* $posicion_id_estacion = 2;
$idestacion = $producto->$posicion_id_estacion;
*/

$valores_separados = implode(",", $array_info);
$datos_separados = implode("','", $array_datos);

$insert_formulario = "INSERT INTO tblFormulario (" . $valores_separados . ") VALUES ('" . $datos_separados . "')";
$query_para_insertar = sqlsrv_query($con, $insert_formulario);

if ($query_para_insertar) {

    array_push($array_ingresados,$excel);
    $total_formularios++;

    if(empty($plantilla)){
        $idPlantilla = 59;
    }else{
        $idPlantilla = $plantilla;
    }

   

    $sql_max = "SELECT MAX(idFormulario) FROM tblFormulario";
    $sql_query_max = sqlsrv_query($con, $sql_max);

    if ($sql_query_max) {
        $row_maximo = sqlsrv_fetch_array($sql_query_max);
        $id = $row_maximo[0];
        $cadena_valores = "";

        $tsi_tipo_energia=implode(',',$array_10);
        $update_extra1 = "UPDATE tblFormulario set tipo_est='$tsi_tipo_energia' WHERE idFormulario=$id";
        $query_extra1_update = sqlsrv_query($con, $update_extra1);


        $update_extra = "UPDATE tblFormulario set idPlantillaMaestro=$idPlantilla WHERE idFormulario=$id";
        $query_extra_update = sqlsrv_query($con, $update_extra);

        $update_extra = "UPDATE tblFormulario set estado='editar' WHERE idFormulario=$id";
        $query_extra_update = sqlsrv_query($con, $update_extra);

        $insert_detalle = "INSERT INTO tblDetalleFormulario (idFormulario,idPlantillaMaestro,idCampo,dato) VALUES ";

        for ($i = 104; $i <= 529; $i++) {
            $id_campo = $array_dinamicos[$i];
            if (isset($producto->$i)) {
                $dato = $producto->$i;
                $values = "($id,$idPlantilla,$id_campo,'$dato')";
                $cadena_valores .= $values . ",";
            }
        }

        $cadena_valores = substr($cadena_valores, 0, -1);
        $consulta_final = $insert_detalle . $cadena_valores;
        $query_insert = sqlsrv_query($con, $consulta_final);


        $num_campos = 0;
        $falla_sql="INSERT INTO tblTipologiaFallo (subgrupo,Grupo,idFormulario,observaciones) VALUES ";
        $array_auxiliar=array();

        for ($i = 530; $i <= 586; $i = $i + 2) {

            $grupo_fallas=$array_grupos[$num_campos];
            $posicion_grupo = $i;
            $observaciones_tipologia="";
            $subgrupo = "";
            
            if (isset($producto->$posicion_grupo)) {
                $subgrupo = $array_fallas[$num_campos];
                $posicion_observaciones = $i + 1;

                if (isset($producto->$posicion_observaciones)) {
                    $observaciones_tipologia = $producto->$posicion_observaciones;
                    
                }
            }
            
            if(!empty($subgrupo)){
                $values_fallas="('$subgrupo','$grupo_fallas','$id','$observaciones_tipologia')";
                array_push($array_auxiliar,$values_fallas);
            }
            $num_campos++;
        }


        $valores_separados_fallas = implode(",", $array_auxiliar);
        $sql_final_fallas=$falla_sql.$valores_separados_fallas;
        $query_fallas=sqlsrv_query($con,$sql_final_fallas);

            $sql_final = "";
            
                if ($tipo_formulario == 'CORRECTIVO') {

                    
                    $value_extra="";
                    for ($i = 94; $i <= 103; $i++) {
                        $dato_extra="";
                        if (isset($producto->$i)) {
                             $dato_extra = $producto->$i;
                             if ($i == 97 || $i == 100) {
                                $date_extra = new DateTime('1899-12-31');
                                $date_extra->modify("+$dato_extra day -1 day");
                                $fecha_aux_extra = $date_extra->format('Y-m-d');
                                $dato_extra = $fecha_aux_extra;
                            } else if ($i == 98 || $i == 101) {
                                $valor_extra = $dato_extra * 24;
                                $hora_extra = convertTime($valor_extra);
                                $dato_extra = $hora_extra;
                            }   
                        }
                          $value_extra.= " ,'$dato_extra' ";  
                    } 

 
                $sql_final = "INSERT INTO tblSolicitudCorrectivos (idEstacion,idUsuarioEntel,title,observacion,start,hora,fechafin,idAsignado,idFormulario,grupo,tipoSolucion,nro_ot,nro_tramite,correo_de
                                                                       ,fecha_reclamo_cliente,hora_reclamo_cliente,retiro_equipos_almacenes,fecha_retiro_equipo,hora_retiro_equipo,descripcion_reclamo,nro_visitas) 
                    VALUES ($id_estacion,1,'ENTEL Correctivo sitio particular','Atender solicitud de Correctivo','$fecha','$hora_ini','$fechaFin','$id_user','$id','$grupo','VISITA AL SITIO' $value_extra )";

                } else if ($tipo_formulario == 'PREVENTIVO') {
                    $sql_final = "INSERT INTO tblPreventivo (idEstacion,fechaInicio,fechaFinal,horaInicio,horaFinal,idFormulario,grupo) VALUES  ($id_estacion,'$fecha','$fechaFin','$hora_ini','$hora_final',$id,'$grupo')";
                } else if ($tipo_formulario == 'EXTRACANON') {
                    $sql_final = "INSERT INTO tblExtraCanon (idEstacion,fechaInicio,fechaFinal,horaInicio,horaFinal,idFormulario,grupo) VALUES  ($id_estacion,'$fecha','$fechaFin','$hora_ini','$hora_final',$id,'$grupo')";
                }
            $query_final = sqlsrv_query($con, $sql_final);

            if($query_final){
                    if($tipo_formulario == 'CORRECTIVO'){
                        $total_correctivos++;
                    }else if ($tipo_formulario == 'PREVENTIVO') {
                        $total_preventivos++;
                    } else if ($tipo_formulario == 'EXTRACANON') {
                        $total_extracanon++;
                    }
            }
    }
}else{
    $total_errores++;
    array_push($array_errors,$excel);
}
