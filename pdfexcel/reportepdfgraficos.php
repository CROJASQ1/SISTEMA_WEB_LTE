<?php
for ($i=0; $i <25 ; $i++) { 
    if($i == 0){
        if (file_exists('ReportePdf.png')) {
            unlink("ReportePdf.png");
        }
    }elseif($i>0 && $i<10){
        if (file_exists('ReportePdf0'.$i.'.png')) {
            unlink("ReportePdf0".$i.".png");
        }
    }else{
        if (file_exists('ReportePdf'.$i.'.png')) {
            unlink("ReportePdf".$i.".png");
        }
    }
}

if (file_exists('ReportePdf_01.png')) {
    unlink("ReportePdf_01.png");
}

date_default_timezone_set('America/La_Paz');
$fechahoy = date("d/m/Y", time());
include('../conexion.php');
require_once("../fpdf182/fpdf.php");
require_once('../jpgraph-4.3.4/src/jpgraph.php');
require_once('../jpgraph-4.3.4/src/jpgraph_pie.php');
require_once("../jpgraph-4.3.4/src/jpgraph_pie3d.php");
require_once("../jpgraph-4.3.4/src/jpgraph_bar.php");

include('funciones_graficas.php');

if(isset($_POST['fechaini']) && isset($_POST['fechafin'])){
    $idregion = intval($_POST['idregion']);
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
    $tipotrab = $_POST['tipotrab'];
    $regional = $_POST['regional'];
    $tiporang = intval($_POST['tiporang']);
    $casogrup = intval($_POST['casogrup']);
    $casopcio = intval($_POST['casopcio']);

    if($regional == 'TODOS'){
        $regional = 'TODAS LAS REGIONALES';
    }
    if($tipotrab == 'TODOS'){
        $tipotrab= '';
    }
    switch ($tiporang) {
            case 2:
              $caso_meses = 'MENSUAL';
              break;
            case 3:
              $caso_meses = 'TRIMESTRAL';
              break;
            case 4:
              $caso_meses = 'SEMESTRAL';
              break;
            case 5:
              $caso_meses = 'ANUAL';
              break;
            default:
              $caso_meses = '';
              break;
    }

$grupos_existentes = array('grupo1','grupo2','grupo3');
    $caso_por_region = '';
    if($idregion > 0){
        $caso_por_region = ' AND te.idRegional = '.$idregion;
    }
    switch ($tipotrab) {
        case 'CORRECTIVO':
            $caso_por_grupo = '';
            if($casogrup > 0){
                $caso_por_grupo = " AND tc.grupo = 'grupo".$casogrup."'";
            }
            switch ($casopcio) {
                case 1:
                    $sql_consulta = "SELECT tc.*,te.*,tc.id as idcorec,tr.regional FROM tblSolicitudCorrectivos tc, tblEstaciones te,tblRegional tr WHERE (tc.start BETWEEN '$fechaini' AND '$fechafin') AND te.idRegional = tr.idRegional AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                    // echo $sql_consulta;
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        } 
                    }
                    $todos= array();
                    $contador = array();

                    $todos_dep = array();
                    $contador_dep = array();

                    $n = 0; $ni = 0;
                    // print_r($listas);
                    // echo "<br>";
                        foreach ($listas as $key) {
                            $meye = date_format($key['start'],'m-Y');
                            $idre = $key['idRegional'];
                            
                            if(intval($key['idFormulario'])>0){

                                $valor = $meye;
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    $contador[$n] = $valor;
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] = 1;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }

                                $valor = $meye.'-'.$key['regional'];
                                $valoraux = $meye.'-'.$key['regional'];
                                if(in_array($valor,$contador_dep)){
                                    $clave = array_search($valor, $contador_dep);
                                    $auxiliar_dep['mes'] = date_format($key['start'],'m');
                                    $auxiliar_dep['ani'] = date_format($key['start'],'Y');
                                    $auxiliar_dep['num'] = $todos_dep[$clave]['num'] + 1;
                                    $auxiliar_dep['dep'] = $key['regional'];
                                    $auxiliar_dep['lor'] = $valoraux;
                                    $todos_dep[$clave] = $auxiliar_dep;
                                }else{
                                    $contador_dep[$ni] = $valor;
                                    $auxiliar_dep['mes'] = date_format($key['start'],'m');
                                    $auxiliar_dep['ani'] = date_format($key['start'],'Y');
                                    $auxiliar_dep['num'] = 1;
                                    $auxiliar_dep['dep'] = $key['regional'];
                                    $auxiliar_dep['lor'] = $valoraux;
                                    $todos_dep[$ni] = $auxiliar_dep;
                                    $ni += 1;
                                }
                            }
                        }


                        $sql_consulta = "SELECT tc.*,te.*,tc.id as idcorec,tr.regional FROM tblSolicitudCorrectivos tc, tblEstaciones te,tblRegional tr WHERE te.idRegional = tr.idRegional AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                        $ejecutar = sqlsrv_query($con, $sql_consulta);
                        $row_count = sqlsrv_has_rows( $ejecutar);
                        $listas = array();
                        if ($row_count === false){
                
                        }else{
                            while($row =sqlsrv_fetch_array($ejecutar)) {
                                $listas[]=$row;
                            } 
                        }
    
                        $todos_dep_acu = array();
                        $contador_dep_acu = array();
                        $nd = 0;
                        // print_r($listas);
                        // echo "<br>";
                            foreach ($listas as $key) {
                                $meye = date_format($key['start'],'m-Y');
                                $idre = $key['idRegional'];
                                
                                if(intval($key['idFormulario'])>0){
    
                                    $valor = $key['regional'];
                                    if(in_array($valor,$contador_dep_acu)){
                                        $clave = array_search($valor, $contador_dep_acu);
                                        $auxiliar_acu['num'] = $todos_dep_acu[$clave]['num'] + 1;
                                        $auxiliar_acu['dep'] = $key['regional'];
                                        $todos_dep_acu[$clave] = $auxiliar_acu;
                                    }else{
                                        $contador_dep_acu[$nd] = $valor;
                                        $auxiliar_acu['num'] = 1;
                                        $auxiliar_acu['dep'] = $key['regional'];
                                        $todos_dep_acu[$nd] = $auxiliar_acu;
                                        $nd += 1;
                                    }
                                }
                            }


                        $sql_consulta = "SELECT * FROM tblRegional;";
                        $ejecutar = sqlsrv_query($con, $sql_consulta);
                        $deptos = array();
                            while($row =sqlsrv_fetch_array($ejecutar)) {
                                $deptos[]=$row;
                            } 

                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO ESTADíSTICO: ".$tipotrab.", ".$regional,0,1,'C');
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            // $pdf->Cell(0,10,"Cantidad de preventivos realizados por ".$caso_meses.".",0,1);
                            $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                            
                            if(sizeof($todos)>0 && sizeof($todos_dep)>0 && sizeof($todos_dep_acu)>0 && sizeof($deptos)>0){
                                $pdf->barrasgraficoPDF3($todos,$todos_dep,$todos_dep_acu,$deptos,'ReportePdf',array(15,30,200,100),'Realizado por mes','Realizados por mes y Regional','Acumulado por regional');
                            }else{
                                $pdf->Cell(0,5,"DATOS INCOMPLETOS ",0,1,'C');
                            }
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS: ",0,1,'C');
                        }
                break;

                case 2:
                    $ini = explode('-',$fechaini);
                    $fin = explode('-',$fechafin);
                    $numcasos = intval($fin[1]) - intval($ini[1]);
                    $sql_consulta = "SELECT tc.*,te.*,tc.id as idcorec FROM tblSolicitudCorrectivos tc, tblEstaciones te WHERE (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                    // echo $sql_consulta;
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        } 
                    }
                    $todos= array();
                    $contador = array();
                    $n = 0;
                    $grupos = array();

                        foreach ($listas as $key) {
                            $meye = date_format($key['start'],'m-Y');
                            $idre = $key['idRegional'];
                            $grupo = $key['grupo'];
                            $valor = $meye.'-'.$grupo;
                            $valoraux = $meye.'-'.$grupo;
                            if(intval($key['idFormulario'])>0){
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['gru'] = $grupo;
                                    $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                    $auxiliar['lor'] = $valoraux;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    $contador[$n] = $valor;
                                    $valor = $meye.'-'.$grupo;
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['gru'] = $grupo;
                                    $auxiliar['num'] = 1;
                                    $auxiliar['lor'] = $valoraux;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }
                                if(!in_array($grupo,$grupos) && strlen(trim($grupo))>0){
                                    $grupos[] = $grupo;
                                }
                            }
                        }
                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        // $pdf->Cell(0,8,"$sql_consulta",0,1);
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            // $pdf->Cell(0,10,"Cantidad de correctivos realizados por ".$caso_meses." promedio",0,1);
                            $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                            if(sizeof($grupos) == 3){
                                $pdf->barrasgraficoPDFPromedioAgrupadosTres($todos,'ReportePdf',array(15,30,200,100),'Cantidad de correctivos realizados promedio.',$numcasos);
                            }elseif(sizeof($grupos) == 2){
                                $pdf->barrasgraficoPDFPromedioAgrupadosPares($todos,$grupos,'ReportePdf',array(15,30,200,100),'Cantidad de correctivos realizados promedio.',$numcasos);
                            }else{
                                $pdf->barrasgraficoPDF($todos,'ReportePdf',array(15,30,200,100),'Cantidad de correctivos realizados promedio.','Promedio');
                            }
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS ",0,1,'C');
                        }

                break;

                case 3:
                    $sql_consulta = "SELECT tc.*,te.*,tc.id as idcorec FROM tblSolicitudCorrectivos tc, tblEstaciones te WHERE (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        } 
                    }
                    $todos= array();
                    $contador = array();
                    $casos = array();
                    $n = 0;
                    
                        foreach ($listas as $key) {
                            $meye = date_format($key['start'],'m-Y');
                            $idre = $key['idRegional'];
                            $valor = $meye.'-'.$key['tipoSolucion'];
                            $valorauxi = $meye.'-'.$key['tipoSolucion'];
                            if(intval($key['idFormulario'])>0){
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                    $auxiliar['tip'] = $key['tipoSolucion'];
                                    $auxiliar['lor'] = $valorauxi;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    $contador[$n] = $valor;
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] = 1;
                                    $auxiliar['tip'] = $key['tipoSolucion'];
                                    $auxiliar['lor'] = $valorauxi;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }
                            }
                            if(!in_array($key['tipoSolucion'], $casos) && strlen(trim($key['tipoSolucion']))>0){
                                $casos[] = $key['tipoSolucion'];
                            }
                        }
                        // print_r($casos);
                        // echo "<br>";
                        // print_r($todos);
                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        $pdf->SetFont("Times","",12);
                        if (sizeof($listas)>0) {
                            // $pdf->Cell(0,10,utf8_decode("Cantidad de correctivos realizados por tipo de solución ").$caso_meses,0,1);
                            $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                            if(sizeof($casos) == 2){

                                if (sizeof($todos)>0 && sizeof($casos)>0) {
                                    $pdf->barrasgraficoPDFAgrupadoPares($todos,'ReportePdf',array(15,30,200,100),$casos,'Soluciones con VISITA Y REMOTAS','Nº de soluciones');
                                }else{
                                    $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                } 

                            }else{
                                if($casos[0] == 'REMOTO'){
                                    $pdf->barrasgraficoPDF($todos,'ReportePdf',array(15,30,200,100),$casos[0].' sin visitas al sitio.','NO');
                                }else{
                                    $pdf->barrasgraficoPDF($todos,'ReportePdf',array(15,30,200,100),$casos[0].' sin soluciones remotas.','NO');
                                }
                            }
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                        }
                break;
                    
                case 4:

                    $sql_consulta = "SELECT tc.idEstacion,tc.title,tc.idUsuarioEntel,tc.start,tc.hora,tc.justificativo,tf.fecha_ini_intervalo,tf.fecha_fin_intervalo,tf.hora_ini_intervalo,tf.hora_fin_intervalo,tc.grupo FROM tblSolicitudCorrectivos tc, tblEstaciones te, tblFormulario tf WHERE tc.idFormulario = tf.idFormulario AND (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                    // echo $sql_consulta;
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        } 
                    }
                    // print_r($listas);

                    $n_j = 0; $n_ep = 0; $n_fp = 0;
                    foreach ($listas as $key) {
                        $meye = date_format($key['start'],'m-Y');
                        $tiempo = $key['title'];
                        $justi = $key['justificativo'];
                        $valor = $meye;

                        $FechaP = date_format($key['start'], 'd-m-Y').' '.$key['hora'];
                        $FechaP = str_replace("/", "-", $FechaP);
                        $FechaI = date_format($key['fecha_ini_intervalo'], 'd-m-Y').' '.$key['hora_ini_intervalo'];
                        $FechaF =  date_format($key['fecha_fin_intervalo'], 'd-m-Y').' '.$key['hora_fin_intervalo'];
                        
                            if(strlen($justi)>0){
                                $n_j += 1;
                            }else{
                                $fecah_prog = new DateTime($FechaP);
                                $fecah_fina = new DateTime($FechaF);
                                $diff = $fecah_prog->diff($fecah_fina);
                                $diff = $fecah_prog->diff($fecah_fina);
                                // print_r($diff);
                                $dias = $diff->days;
                                // echo $dias."<br>";
                                $hora = $diff->h;
                                // echo $hora."<br>";
                                $diferencia = intval($dias*24)+intval($hora);
                                switch ($tiempo) {
                                    case 'ENTEL Correctivo sitio corporativo':
                                        $disponible = 24;
                                        if($diferencia <= $disponible){
                                            $n_ep += 1;
                                        }else{
                                            $n_fp += 1;
                                        }
                                        break;
                                    case 'ENTEL Correctivo sitio particular':
                                        $disponible = 72;
                                        if($diferencia <= $disponible){
                                            $n_ep += 1;
                                        }else{
                                            $n_fp += 1;
                                        }
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
                    }

                    $pdf=new Reporte();
                    $pdf->AddPage();
                    $pdf->SetFont("Arial","B",14);
                    $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                    $pdf->SetFont("Times","",12);
                    // $pdf->Cell(0,10,"Correctivos atendidos en plazo y fuera de plazo ".$caso_meses,0,1);
                    $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                    if(($n_j+$n_ep+$n_fp)>0){
                        $pdf->graficoPDF(array('Con justificación ('.$n_j.')'=>array($n_j,'red'),'En el plazo ('.$n_ep.')'=>array($n_ep,'blue'),'Fuera del plazo ('.$n_fp.')'=>array($n_fp,'gray')),'ReportePdf',array(15,30,120,100),'Gráfica estadistica de correctivos realizados.');
                    }else{
                        $pdf->Cell(0,5,"DATOS INCOMPLETOS ",0,1,'C');
                    }
                    
                break;

                case 5:

                    $color = array('AntiqueWhite2','aqua','aquamarine2','azure3','bisque3','blue','brown2','blueviolet','burlywood1','burlywood4','cadetblue','cadetblue3','chartreuse','chartreuse4','chocolate','chocolate4','coral','cornflowerblue','cyan3','darkblue','darkgoldenrod','darkgoldenrod4','darkkhaki','darkorange');

                    $sql_consulta = "SELECT SUM(tmp.total) as total_fallas, tmp.equipos FROM (SELECT tmp.equipo_1 as equipos,COUNT(tmp.equipo_1) as total from (select tf.equipo_1 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_1 !='' GROUP BY tmp.equipo_1 UNION  SELECT tmp.equipo_2 as equipos,COUNT(tmp.equipo_2) as total from (select tf.equipo_2 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_2 !='' GROUP BY tmp.equipo_2 UNION  SELECT tmp.equipo_3 as equipos,COUNT(tmp.equipo_3) as total from (select tf.equipo_3 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_3 !='' GROUP BY tmp.equipo_3 UNION  SELECT tmp.equipo_4 as equipos,COUNT(tmp.equipo_4) as total from (select tf.equipo_4 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_4 !='' GROUP BY tmp.equipo_4 UNION  SELECT tmp.equipo_5 as equipos,COUNT(tmp.equipo_5) as total from (select tf.equipo_5 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_5 !='' GROUP BY tmp.equipo_5) as tmp GROUP BY tmp.equipos;";
                    // echo $sql_consulta.'<br>';
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    
                    if ($row_count === false){
                    }else{
                        $no = 0;
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            if($no == 24){
                                $no = 0;
                            }
                            $equipo = $row['equipos'];
                            $auxiliar[0] = $row['total_fallas'];
                            $auxiliar[1] = $color[$no];
                            $auxiliar[2] = $equipo.' ('.$row['total_fallas'].')';
                            $listas[]=$auxiliar;
                            $no += 1;
                        } 
                    }
                    // print_r($listas);
                    // echo "<br> lista 1 <br>";
                    $sql_consulta_tres = "SELECT COUNT(te.sistema) as numero, te.sistema FROM tblEstaciones te, tblSolicitudCorrectivos tc WHERE te.idEstacion = tc.idEstacion $caso_por_region $caso_por_grupo GROUP BY te.sistema";
                    // echo $sql_consulta_tres.'<br>';
                    $ejecutar_tres = sqlsrv_query($con, $sql_consulta_tres);
                    $row_count_tres = sqlsrv_has_rows( $ejecutar_tres);
                    $listas_tres = array();
                    if ($row_count_tres === false){
                    }else{
                        $no = 0;
                        while($row =sqlsrv_fetch_array($ejecutar_tres)) {
                            $sistem = $row['sistema'];
                            $auxiliar[0] = $row['numero'];
                            $auxiliar[1] = $color[$no];
                            $auxiliar[2] = $sistem.' ('.$row['numero'].')';
                            $listas_tres[]=$auxiliar;
                        } 
                    }

                    $sql_consulta_dos = "SELECT tf.Grupo, tf.subgrupo as idCampo, tf.subgrupo as campo,tfo.fecha_ini_intervalo,tfo.fecha_fin_intervalo FROM tblTipologiaFallo tf, tblFormulario tfo WHERE tf.idFormulario = tfo.idFormulario AND tfo.fecha_ini_intervalo>='$fechaini' and tfo.fecha_fin_intervalo<='$fechafin'";
                    // echo $sql_consulta_dos;
                    $ejecutar = sqlsrv_query($con, $sql_consulta_dos);
                    $row_count = sqlsrv_has_rows($ejecutar);
                    $listas_dos = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas_dos[]=$row;
                        } 
                    }

                    $todos_dep = array();
                    $contador_dep = array();
                    $campos_equipos = array();
                    $n = 0; $ni = 0;
                        foreach ($listas_dos as $key) {
                            $meye = date_format($key['fecha_ini_intervalo'],'m-Y');
                                $valor = $meye.'-'.$key['campo'].'-'.$key['Grupo'];
                                $valoraux = $meye.'-'.$key['campo'].'-'.$key['Grupo'];
                                if(in_array($valor,$contador_dep)){
                                    $clave = array_search($valor, $contador_dep);
                                    $auxiliar_dep['mes'] = date_format($key['fecha_ini_intervalo'],'m-Y');
                                    $auxiliar_dep['cam'] = $key['campo'];
                                    $auxiliar_dep['num'] = $todos_dep[$clave]['num'] + 1;
                                    $auxiliar_dep['dep'] = $key['Grupo'];
                                    $auxiliar_dep['lor'] = $valoraux;
                                    $auxiliar_dep['idc'] = $key['campo'];
                                    $todos_dep[$clave] = $auxiliar_dep;
                                }else{
                                    $contador_dep[$ni] = $valor;
                                    $auxiliar_dep['mes'] = date_format($key['fecha_ini_intervalo'],'m-Y');
                                    $auxiliar_dep['cam'] = $key['campo'];
                                    $auxiliar_dep['num'] = 1;
                                    $auxiliar_dep['dep'] = $key['Grupo'];
                                    $auxiliar_dep['lor'] = $valoraux;
                                    $auxiliar_dep['idc'] = $key['campo'];
                                    $todos_dep[$ni] = $auxiliar_dep;
                                    $ni += 1;
                                }
                                if(!in_array($key['campo'], $campos_equipos)){
                                    $campos_equipos[] = $key['campo'];
                                }
                        }
                        $listas_dos = $todos_dep;
                        // print_r($campos_equipos);
                    $pdf=new Reporte();//creamos el documento pdf
                    $pdf->AddPage();//agregamos la pagina
                    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                    $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                    $pdf->SetFont("Times","",12);
                    // $pdf->Cell(0,8,"Grafica de fallas en el sistema y tipos ".$caso_meses,0,1);
                    $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                    // print_r($listas);
                    // echo '<br>';
                    // print_r($listas_dos);
                    // if(sizeof($listas_dos) > 0){
                        $pdf->SetFont("Times","",12);
                        $pdf->graficoPDFunico($listas_tres,'ReportePdf',array(15,30,130,100),'Tipos de sistemas con fallas');
                    // }else{
                    //     $pdf->SetFont("Times","",12);
                    //     $pdf->graficoPDFunico($listas_tres,'ReportePdf',array(15,110,130,100),'Tipos de sistemas con fallas');
                    // }
                    if(sizeof($listas)>0 && sizeof($listas_dos)>0){
                        $pdf->graficoPDFdos($listas,$listas_dos,'ReportePdf',array(10,130,170,150),'Tipos de fallas en equipos cambiados','Tipos de fallas en equipos no cambiados');
                            $no = 1;
                            $pdf->SetFont("Times","",10);
                            for ($i=0; $i < 32 ; $i++) { 
                                if($i == 15 && sizeof($listas_dos) == 0){
                                    $pdf->Cell(0,8,'Tipos de fallas en equipos no cambiados, resgistros vacios.',0,1,'C');
                                }else{
                                    $pdf->Cell(0,5,'',0,1);
                                }
                            }
                        //     $cadenas=''; $coma='';
                        // foreach ($campos_equipos as $key) {
                        //     $cadenas .= $coma.$no.'.- '.$key;
                        //     $no += 1;
                        //     $coma=', ';
                        // } 
                        // $pdf->SetXY(15,250);
                        // $pdf->MultiCell(180,5,$cadenas,10);
                    }
                    // $pdf->AddPage();                    
                    
                break;

                case 6:

                    $sql_consulta = "SELECT SUM(tmp.total) as total_fallas, tmp.equipos FROM (  SELECT tmp.equipo_1 as equipos,COUNT(tmp.equipo_1) as total from (select tf.equipo_1 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_1 !='' GROUP BY tmp.equipo_1 UNION  SELECT tmp.equipo_2 as equipos,COUNT(tmp.equipo_2) as total from (select tf.equipo_2 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_2 !='' GROUP BY tmp.equipo_2 UNION  SELECT tmp.equipo_3 as equipos,COUNT(tmp.equipo_3) as total from (select tf.equipo_3 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_3 !='' GROUP BY tmp.equipo_3 UNION  SELECT tmp.equipo_4 as equipos,COUNT(tmp.equipo_4) as total from (select tf.equipo_4 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_4 !='' GROUP BY tmp.equipo_4 UNION  SELECT tmp.equipo_5 as equipos,COUNT(tmp.equipo_5) as total from (select tf.equipo_5 from tblFormulario tf,tblSolicitudCorrectivos tc, tblEstaciones te where tc.idEstacion = te.idEstacion AND tf.idFormulario=tc.idFormulario $caso_por_region $caso_por_grupo and tc.start>='$fechaini' and tc.fechafin<='$fechafin') tmp WHERE tmp.equipo_5 !='' GROUP BY tmp.equipo_5) as tmp GROUP BY tmp.equipos;";
                    // echo $sql_consulta;
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $equipo = $row['equipos'];
                            $auxiliar[0] = $row['total_fallas'];
                            $auxiliar[1] = $equipo.' ('.$row['total_fallas'].')';
                            $listas[]=$auxiliar;
                        } 
                    }
                    arsort($listas);

                    $sql_consulta_dos = "SELECT COUNT(te.sistema) as numero, te.sistema FROM tblEstaciones te, tblSolicitudCorrectivos tc WHERE te.idEstacion = tc.idEstacion $caso_por_region $caso_por_grupo GROUP BY te.sistema";
                    // echo $sql_consulta_dos;
                    $ejecutar_dos = sqlsrv_query($con, $sql_consulta_dos);
                    $row_count_dos = sqlsrv_has_rows( $ejecutar_dos);
                    $listas_dos = array();
                    if ($row_count_dos === false){
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar_dos)) {
                            $sistem = $row['sistema'];
                            $auxiliar[0] = $row['numero'];
                            $auxiliar[1] = $sistem.' ('.$row['numero'].')';
                            $listas_dos[]=$auxiliar;
                        } 
                    }
                    arsort($listas_dos);

                    // print_r
                    $pdf=new Reporte();//creamos el documento pdf
                    $pdf->AddPage();//agregamos la pagina
                    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                    $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                    $pdf->SetFont("Times","",10);
                    // $pdf->Cell(0,8,"Grafica de fallas en el sistema y tipos ".$caso_meses.".",0,1);
                    $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);

                    // $pdf->graficoPDFdos($listas,$listas_dos,'ReportePdf',array(15,30,170,200),'Grafica tipo falla','Grafica tipo sistema');
                    if (sizeof($listas)>0 && sizeof($listas_dos)>0) {
                        $pdf->barrasgraficoPDF2($listas,$listas_dos,'ReportePdf',array(15,25,180,250),'Tipos de fallas','Tipo de sistema con fallas');
                    }else{
                        $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                    } 
                    
                break;

                case 8:
                    switch ($tiporang) {
                        case 4:
                          $caso_meses = 'SEMESTRAL';

                          $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from (SELECT COUNT(MONTH(start)) as total,MONTH(start) as meses,YEAR(start) as ano from tblSolicitudCorrectivos WHERE idFormulario != 0 AND start >= '$fechaini' AND start <= '$fechafin' GROUP BY MONTH(start),YEAR(start)) tmp GROUP BY tmp.meses,tmp.ano;";

                          $query=sqlsrv_query($con,$sql_total);
                          $listas = array();
                          $count=sqlsrv_has_rows($query);

                          if($count!=false){
                                  while($row =sqlsrv_fetch_array($query)) {
                                      $listas[]=$row;  
                                  }

                                  $n=0;
                                  $todos= array();
                                  $tamaño=sizeof($listas);             

                                  if($tamaño>3){

                                      $total=0;
                                      $cadena = array();
                                      for ($i=0; $i < $tamaño ; $i++) {    
                                        $key=$listas[$i];  
                                              if($i<=2){
                                                  $total=$total+$key['total'];
                                                  $cadena[]=$key['meses'];
                                              }else{
                                                  if($i==3){
                                                      $auxiliar['total']=$total;
                                                      $auxiliar['meses']=implode('-',$cadena);
                                                      $todos[0] = $auxiliar;

                                                      $total=0;
                                                      $cadena = array();
                                                      $total=$total+$key['total'];
                                                      $cadena[]=$key['meses'];
                                                  } elseif($i==$tamaño-1){
                                                      $total=$total+$key['total'];
                                                      $cadena[]=$key['meses'];
                                                      $auxiliar['total']=$total;
                                                      $auxiliar['meses']=implode('-',$cadena);
                                                      $todos[1] = $auxiliar;
                                                  }else{
                                                      $total=$total+$key['total'];
                                                      $cadena[]=$key['meses'];
                                                  }

                                                  
                                              }
                                      }

                                  }else{
                                      $total=0;
                                      $cadena = array();
                                      foreach ($listas as $key) {
                                           
                                          $total=$total+$key['total'];
                                          $cadena[]=$key['meses']."    ";
                                      }
                                      
                                      $auxiliar['total']=$total;
                                      $auxiliar['meses']=implode('-',$cadena);

                                      $todos[0] = $auxiliar;
                                  }

                                 
                          }

                          $pdf=new Reporte();
                          $pdf->AddPage();
                          $pdf->SetFont("Arial","B",14);
                          $pdf->Cell(0,5,"GRAFICO: Correctivos semestrales",0,1,'C');
                          $pdf->SetFont("Times","",12);
                          if (sizeof($listas)>0) {
                                $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de correctivos en el rango de fechas');
                          }else{
                              $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                          } 

                            

                          break;
                        case 5:
                          $caso_meses = 'ANUAL';

                          $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from (SELECT COUNT(MONTH(start)) as total,MONTH(start) as meses,YEAR(start) as ano from tblSolicitudCorrectivos WHERE idFormulario != 0 AND start >= '$fechaini' AND start <= '$fechafin' GROUP BY MONTH(start),YEAR(start)) tmp GROUP BY tmp.meses,tmp.ano;";

                                         $query=sqlsrv_query($con,$sql_total);
                                            $listas = array();
                                            $count=sqlsrv_has_rows($query);

                                            if($count!=false){
                                                    while($row =sqlsrv_fetch_array($query)) {
                                                        $listas[]=$row;  
                                                    }

                                                    $n=0;
                                                    $todos= array();
                                                    $tamaño=sizeof($listas);             

                                                    if($tamaño>6){

                                                        $total=0;
                                                        $cadena = array();
                                                        for ($i=0; $i < $tamaño ; $i++) {     
                                                            $key=$listas[$i]; 
                                                                if($i<=5){
                                                                    $total=$total+$key['total'];
                                                                    $cadena[]=$key['meses'];
                                                                }else{
                                                                    if($i==6){
                                                                        $auxiliar['total']=$total;
                                                                        $auxiliar['meses']=implode('-',$cadena);
                                                                        $todos[0] = $auxiliar;

                                                                        $total=0;
                                                                        $cadena = array();
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]=$key['meses'];
                                                                    } elseif($i==$tamaño-1){
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]=$key['meses'];
                                                                        $auxiliar['total']=$total;
                                                                        $auxiliar['meses']=implode('-',$cadena);
                                                                        $todos[1] = $auxiliar;
                                                                    }else{
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]=$key['meses'];
                                                                    }
    
                                                                }
                                                        }

                                                    }else{
                                                        $total=0;
                                                        $cadena = array();
                                                        foreach ($listas as $key) {
                                                            
                                                            $total=$total+$key['total'];
                                                            $cadena[]=$key['meses'];
                                                        }
                                                        
                                                        $auxiliar['total']=$total;
                                                        $auxiliar['meses']=implode('-',$cadena);

                                                        $todos[0] = $auxiliar;
                                                    }                                                
                                            }

                                            $pdf=new Reporte();
                                            $pdf->AddPage();
                                            $pdf->SetFont("Arial","B",14);
                                            $pdf->Cell(0,5,"GRAFICO: Correctivos anuales",0,1,'C');
                                            $pdf->SetFont("Times","",12);
                                            if (sizeof($listas)>0) {
                                                $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de correctivos en el rango de fechas');
                                            }else{
                                                $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                            } 


                          break;
                        default:
                            $caso_meses = '';

                                $sql_total="SELECT COUNT(MONTH(start)) as total,MONTH(start) as meses,YEAR(start) as ano
                                from tblSolicitudCorrectivos 
                                WHERE idFormulario != 0 AND start >= '$fechaini' AND start <= '$fechafin' GROUP BY MONTH(start),YEAR(start)";
                          
                                    $query=sqlsrv_query($con,$sql_total);
                                    $listas = array();

                                    $count=sqlsrv_has_rows($query);

                                    if($count!=false){
                                            while($row =sqlsrv_fetch_array($query)) {
                                                $listas[]=$row;  
                                            }

                                            $todos= array();
                                            $n=0;
                                            foreach ($listas as $key) {
                                                
                                                $auxiliar['meses'] = $key['meses'];
                                                $auxiliar['ano'] = $key['ano'];
                                                $auxiliar['total'] = $key['total'];
                                                $todos[$n] = $auxiliar;
                                                $n++;
                                            }
                                    }

                                    $pdf=new Reporte();
                                    $pdf->AddPage();
                                    $pdf->SetFont("Arial","B",14);
                                    $pdf->Cell(0,5,"GRAFICO: Correctivos en general",0,1,'C');
                                    $pdf->SetFont("Times","",12);
                                    if (sizeof($listas)>0) {
                                                    $pdf->barrasgraficoPDF_v2($todos,'ReportePdf',array(15,30,200,100),'Cantidad de correctivo en el rango de fechas');
                                    }else{
                                        $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                    }                 
                        break;
                    }

                break;

                default:
                    $sql_consulta = "SELECT tc.idEstacion,tc.title,tc.idUsuarioEntel,tc.start,tc.hora,tc.justificativo,tf.fecha_ini_intervalo,tf.fecha_fin_intervalo,tf.hora_ini_intervalo,tf.hora_fin_intervalo,tc.grupo FROM tblSolicitudCorrectivos tc, tblEstaciones te, tblFormulario tf WHERE tc.idFormulario = tf.idFormulario AND (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
                    // echo $sql_consulta;
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        } 
                    }
                    // print_r($listas);

                    $n_j = 0; $n_ep = 0; $n_fp = 0;
                    $todos = array();
                    $contador = array();
                    $n = 0;
                    foreach ($listas as $key) {
                        $meye = date_format($key['start'],'m-Y');
                        $tiempo = $key['title'];
                        $justi = $key['justificativo'];
                        $FechaP = date_format($key['start'], 'd-m-Y').' '.$key['hora'];
                        $FechaP = str_replace("/", "-", $FechaP);
                        $FechaI = date_format($key['fecha_ini_intervalo'], 'd-m-Y').' '.$key['hora_ini_intervalo'];
                        $FechaF =  date_format($key['fecha_fin_intervalo'], 'd-m-Y').' '.$key['hora_fin_intervalo'];
                        // echo "<br>";
                        // print_r($key);
                        // echo "<br>";
                            if(isset($FechaI) && isset($FechaF)){
                                $fecah_prog = new DateTime($FechaI);
                                $fecah_inic = new DateTime($FechaF);
                                $diff = $fecah_prog->diff($fecah_inic);
                                // $diff = $fecah_prog->diff($fecah_inic);
                                // print_r($diff);
                                // echo "<br>";
                                $dias = $diff->days;
                                // echo $dias."<br>";
                                $hora = $diff->h;
                                // echo $hora."<br>";
                                $minu = $diff->i;
                                // echo $minu."<br>";
                                $diferencia = intval($dias)*24*60+intval($hora)*60+intval($minu);
                                switch ($tiempo) {
                                    case 'ENTEL Correctivo sitio corporativo':
                                        $disponible = 24;
                                        $tipo = 'Sitio Corporativo';
                                        break;
                                    default:
                                        $disponible = 72;
                                        $tipo = 'Sitio Particular';
                                        break;
                                }
                                $valor = $meye."-".$tipo;
                                // echo $valor."<br>";
                                if(in_array($valor,$contador)){
                                    // echo "SI <br>";
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                    $auxiliar['tot'] += $diferencia;
                                    $auxiliar['tip'] = $tipo;
                                    $auxiliar['lor'] = $valor;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    // echo "NO <br>";
                                    $contador[$n] = $valor;
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] = 1;
                                    $auxiliar['tot'] = $diferencia;
                                    $auxiliar['tip'] = $tipo;
                                    $auxiliar['lor'] = $valor;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }
                            }else{

                            }
                    }
                    // echo "<br>";
                    // print_r($todos);
                    for ($i=0; $i < sizeof($todos); $i++) { 
                        $todos[$i]['num'] = $todos[$i]['tot'] / $todos[$i]['num'];
                    }
                    $casos = array('Sitio Corporativo','Sitio Particular');
                    // echo "<br>";
                    // print_r($todos);
                    $pdf=new Reporte();
                    $pdf->AddPage();
                    $pdf->SetFont("Arial","B",14);
                    $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                    $pdf->SetFont("Times","",12);
                    // $pdf->Cell(0,10,"Correctivos atendidos en plazo y fuera de plazo ".$caso_meses,0,1);
                    $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                    if (sizeof($todos)>0 && sizeof($casos)>0) {
                        $pdf->barrasgraficoPDFAgrupadoPares($todos,'ReportePdf',array(15,30,200,100),$casos,'Tiempo de respuesta promedio en correctivos (min)','Promedios (min)');
                    }else{
                        $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                    } 
                    
                break;
            }
        break;
        case 'PREVENTIVO':
            $caso_por_grupo = '';
            if($casogrup > 0){
                $caso_por_grupo = " AND tp.grupo = 'grupo".$casogrup."'";
            }
            switch ($casopcio) {
                case 1:
                    $sql_consulta = "SELECT tp.*,te.*,tr.regional FROM tblPreventivo tp, tblEstaciones te, tblRegional  tr WHERE (tp.fechaInicio BETWEEN '$fechaini' AND '$fechafin') AND te.idRegional = tr.idRegional AND tp.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tp.fechaInicio ASC;";
                    // echo $sql_consulta;
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        } 
                    }
                    $todos= array();
                    $contador = array();

                    $todos_dep = array();
                    $contador_dep = array();

                    $n = 0; $ni = 0;
                    // print_r($listas);
                    // echo "<br>";
                        foreach ($listas as $key) {
                            $meye = date_format($key['fechaInicio'],'m-Y');
                            $idre = $key['idRegional'];
                        
                            if(intval($key['idFormulario'])>0){
                                $valor = $meye;
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    $contador[$n] = $valor;
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['num'] = 1;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }
                                $valor = $meye.'-'.$key['regional'];
                                $valoraux = $meye.'-'.$key['regional'];
                                if(in_array($valor,$contador_dep)){
                                    $clave = array_search($valor, $contador_dep);
                                    $auxiliar_dep['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar_dep['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar_dep['num'] = $todos_dep[$clave]['num'] + 1;
                                    $auxiliar_dep['dep'] = $key['regional'];
                                    $auxiliar_dep['lor'] = $valoraux;
                                    $todos_dep[$clave] = $auxiliar_dep;
                                }else{
                                    $contador_dep[$ni] = $valor;
                                    $auxiliar_dep['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar_dep['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar_dep['num'] = 1;
                                    $auxiliar_dep['dep'] = $key['regional'];
                                    $auxiliar_dep['lor'] = $valoraux;
                                    $todos_dep[$ni] = $auxiliar_dep;
                                    $ni += 1;
                                }
                            }
                        }


                        $sql_consulta_dos = "SELECT tp.*,te.*,tr.regional FROM tblPreventivo tp, tblEstaciones te, tblRegional  tr WHERE  te.idRegional = tr.idRegional AND tp.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tp.fechaInicio ASC;";
                        // echo $sql_consulta_dos;
                        $ejecutar_dos = sqlsrv_query($con, $sql_consulta_dos);
                        $row_count = sqlsrv_has_rows( $ejecutar_dos);
                        $listas = array();
                        if ($row_count === false){
                
                        }else{
                            while($row =sqlsrv_fetch_array($ejecutar_dos)) {
                                $listas[]=$row;
                            } 
                        }
    
                        $todos_dep_acu = array();
                        $contador_dep_acu = array();
                        $nd = 0;
                        // print_r($listas);
                        // echo "<br>";
                            foreach ($listas as $key) {
                                $meye = date_format($key['fechaInicio'],'m-Y');
                                $idre = $key['idRegional'];
                                if(intval($key['idFormulario'])>0){
                                    $valor = $key['regional'];
                                    if(in_array($valor,$contador_dep_acu)){
                                        $clave = array_search($valor, $contador_dep_acu);
                                        $auxiliar_acu['num'] = $todos_dep_acu[$clave]['num'] + 1;
                                        $auxiliar_acu['dep'] = $key['regional'];
                                        $todos_dep_acu[$clave] = $auxiliar_acu;
                                    }else{
                                        $contador_dep_acu[$nd] = $valor;
                                        $auxiliar_acu['num'] = 1;
                                        $auxiliar_acu['dep'] = $key['regional'];
                                        $todos_dep_acu[$nd] = $auxiliar_acu;
                                        $nd += 1;
                                    }
                                }
                            }

                        $sql_consulta = "SELECT * FROM tblRegional;";
                        $ejecutar = sqlsrv_query($con, $sql_consulta);
                        $deptos = array();
                            while($row =sqlsrv_fetch_array($ejecutar)) {
                                $deptos[]=$row;
                            } 

                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            // $pdf->Cell(0,10,"Cantidad de preventivos realizados por ".$caso_meses.".",0,1);
                            $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                            
                            if(sizeof($todos)>0 && sizeof($todos_dep)>0 && sizeof($todos_dep_acu)>0 && sizeof($deptos)>0){
                                $pdf->barrasgraficoPDF3($todos,$todos_dep,$todos_dep_acu,$deptos,'ReportePdf',array(15,30,200,100),'Realizado por mes','Realizados por mes y Regional','Acumulado por regional');
                            }else{
                                $pdf->Cell(0,5,"DATOS INCOMPLETOS ",0,1,'C');
                            }
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS: ",0,1,'C');
                        }
                break;
                case 8:
                    switch ($tiporang) {
                            case 4:
                            $caso_meses = 'SEMESTRAL';

                            $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from ( SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblPreventivo tp WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' $caso_por_grupo GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)) tmp GROUP BY tmp.meses,tmp.ano;";

                            $query=sqlsrv_query($con,$sql_total);
                            $listas = array();
                            $count=sqlsrv_has_rows($query);

                            if($count!=false){
                                    while($row =sqlsrv_fetch_array($query)) {
                                        $listas[]=$row;  
                                    }

                                    $n=0;
                                    $todos= array();
                                    $tamaño=sizeof($listas);             

                                    if($tamaño>3){

                                        $total=0;
                                        $cadena = array();
                                        for ($i=0; $i < $tamaño ; $i++) {   
                                            $key=$listas[$i];  
                                                if($i<=2){
                                                    $total=$total+$key['total'];
                                                    $cadena[]=$key['meses'];
                                                }else{
                                                    if($i==3){
                                                        $auxiliar['total']=$total;
                                                        $auxiliar['meses']=implode('-',$cadena);
                                                        $todos[0] = $auxiliar;
                                                        $total=0;
                                                        $cadena = array();
                                                        $total=$total+$key['total'];
                                                        $cadena[]=$key['meses'];
                                                    } elseif($i==$tamaño-1){
                                                        $total=$total+$key['total'];
                                                        $cadena[]=$key['meses'];
                                                        $auxiliar['total']=$total;
                                                        $auxiliar['meses']=implode('-',$cadena);
                                                        $todos[1] = $auxiliar;
                                                    }else{
                                                        $total=$total+$key['total'];
                                                        $cadena[]=$key['meses'];
                                                    }
                                                }
                                        }
                                    }else{
                                        $total=0;
                                        $cadena = array();
                                        foreach ($listas as $key) {
                                            $total=$total+$key['total'];
                                            $cadena[]=$key['meses'];
                                        }
                                        $auxiliar['total']=$total;
                                        $auxiliar['meses']=implode('-',$cadena);
                                        $todos[0] = $auxiliar;
                                    }

                                   
                            }

                            $pdf=new Reporte();
                            $pdf->AddPage();
                            $pdf->SetFont("Arial","B",14);
                            $pdf->Cell(0,5,"GRAFICO: Total preventivos semestrales",0,1,'C');
                            $pdf->SetFont("Times","",12);
                            if (sizeof($listas)>0) {
                                            $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de preventivos en el rango de fechas');
                            }else{
                                $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                            } 


                            break;

                            case 5:
                                        /* aqui va la cosa */
                                        $listas = array();
                                        $caso_meses = 'ANUAL';                 
                                        $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from ( SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblPreventivo tp WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' $caso_por_grupo GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)) tmp GROUP BY tmp.meses,tmp.ano;";
                                        // echo $sql_total;
                                        $query=sqlsrv_query($con, $sql_total);
                                        $count=sqlsrv_has_rows($query);

                                        if($count!=false){
                                                while($row =sqlsrv_fetch_array($query)) {
                                                    $listas[]=$row;  
                                                }

                                                $n=0;
                                                $todos= array();
                                                $tamaño=sizeof($listas);             

                                                if($tamaño>6){

                                                    $total=0;
                                                    $cadena = array();
                                                    for ($i=0; $i < $tamaño ; $i++) {    
                                                        $key=$listas[$i];  
                                                            if($i<=5){
                                                                $total=$total+$key['total'];
                                                                $cadena[]=$key['meses'];
                                                            }else{
                                                                if($i==6){
                                                                    $auxiliar['total']=$total;
                                                                    $auxiliar['meses']=implode('-',$cadena);
                                                                    $todos[0] = $auxiliar;

                                                                    $total=0;
                                                                    $cadena = array();
                                                                    $total=$total+$key['total'];
                                                                    $cadena[]=$key['meses'];
                                                                }elseif($i==$tamaño-1){
                                                                    $total=$total+$key['total'];
                                                                    $cadena[]=$key['meses'];
                                                                    $auxiliar['total']=$total;
                                                                    $auxiliar['meses']=implode('-',$cadena);
                                                                    $todos[1] = $auxiliar;
                                                                }else{
                                                                    $total=$total+$key['total'];
                                                                    $cadena[]=$key['meses'];
                                                                }

                                                            }
                                                    }

                                                }else{
                                                    $total=0;
                                                    $cadena = array();
                                                    foreach ($listas as $key) {
                                                        
                                                        $total=$total+$key['total'];
                                                        $cadena[]=$key['meses'];
                                                    }
                                                    
                                                    $auxiliar['total']=$total;
                                                    $auxiliar['meses']=implode('-',$cadena);

                                                    $todos[0] = $auxiliar;
                                                }                                                
                                        }

                                        $pdf=new Reporte();
                                        $pdf->AddPage();
                                        $pdf->SetFont("Arial","B",14);
                                        $pdf->Cell(0,5,"GRAFICO: Total preventivos anuales",0,1,'C');
                                        $pdf->SetFont("Times","",12);
                                        if (sizeof($listas)>0) {
                                                        $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de preventivos en el rango de fechas');
                                        }else{
                                            $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                        } 

                            break;
                            default:
                                    $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from ( SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblPreventivo tp WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' $caso_por_grupo GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)) tmp
                                    GROUP BY tmp.meses,tmp.ano;";

                                    $query=sqlsrv_query($con,$sql_total);
                                    $listas = array();

                                    $count=sqlsrv_has_rows($query);

                                    if($count!=false){
                                            while($row =sqlsrv_fetch_array($query)) {
                                                $listas[]=$row;  
                                            }

                                            $todos= array();
                                            $n=0;
                                            foreach ($listas as $key) {
                                                
                                                $auxiliar['meses'] = $key['meses'];
                                                $auxiliar['ano'] = $key['ano'];
                                                $auxiliar['total'] = $key['total'];
                                                $todos[$n] = $auxiliar;
                                                $n++;
                                            }
                                    }

                                    $pdf=new Reporte();
                                    $pdf->AddPage();
                                    $pdf->SetFont("Arial","B",14);
                                    $pdf->Cell(0,5,"GRAFICO: Total preventivos generales",0,1,'C');
                                    $pdf->SetFont("Times","",12);
                                    if (sizeof($listas)>0) {
                                                    $pdf->barrasgraficoPDF_v2($todos,'ReportePdf',array(15,30,200,100),'Cantidad de preventivos en el rango de fechas');
                                    }else{
                                        $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                    }  
                            break;
                    }
                break;
                default:
                    $ini = explode('-',$fechaini);
                    $fin = explode('-',$fechafin);
                    $numcasos = intval($fin[1]) - intval($ini[1]);
                    $sql_consulta = "SELECT tp.*,te.* FROM tblPreventivo tp, tblEstaciones te WHERE (tp.fechaInicio BETWEEN '$fechaini' AND '$fechafin') AND tp.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tp.fechaInicio ASC;";
                    // echo $sql_consulta;
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
            
                    }else{
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        } 
                    }
                    $todos= array();
                    $contador = array();
                    $n = 0;
                    $grupos = array();
                    
                        foreach ($listas as $key) {
                            $meye = date_format($key['fechaInicio'],'m-Y');
                            $idre = $key['idRegional'];
                            $grupo = $key['grupo'];
                            $valor = $meye.'-'.$grupo;
                            $valoraux = $meye.'-'.$grupo;
                            if(intval($key['idFormulario'])>0){
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['gru'] = $grupo;
                                    $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                    $auxiliar['lor'] = $valoraux;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    $contador[$n] = $valor;
                                    $valor = $meye.'-'.$grupo;
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['gru'] = $grupo;
                                    $auxiliar['num'] = 1;
                                    $auxiliar['lor'] = $valoraux;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }
                                if(!in_array($grupo,$grupos) && strlen(trim($grupo))>0){
                                    $grupos[] = $grupo;
                                }
                            }
                        }
                        // echo "<br>";
                        // print_r($todos);
                        // echo "<br>";
                        // print_r($grupos);
                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        // $pdf->Cell(0,8,"$sql_consulta",0,1);
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                            if(sizeof($grupos) == 3){
                                // $pdf->Cell(0,10,"Cantidad de preventivos realizados por ".$caso_meses.". promedio",0,1);
                                $pdf->barrasgraficoPDFPromedioAgrupadosTres($todos,'ReportePdf',array(15,30,200,100),'Cantidad de preventivos realizados promedio.',$numcasos);
                            }elseif(sizeof($grupos) == 2){
                                $pdf->barrasgraficoPDFPromedioAgrupadosPares($todos,$grupos,'ReportePdf',array(15,30,200,100),'Cantidad de preventivos realizados promedio.',$numcasos);
                            }else{
                                $pdf->barrasgraficoPDF($todos,'ReportePdf',array(15,30,200,100),implode($grupos),'promedio');
                                // $pdf->Cell(0,5,"FALTAN DATOS: ",0,1,'C');
                            }
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS: ",0,1,'C');
                        }
                break;
            }
        break;
        case 'EXTRACANON':

                        switch ($casopcio) {

                            case 1:
                                $caso_por_grupo = '';
                                if($casogrup > 0){
                                    $caso_por_grupo = " AND tx.grupo = 'grupo".$casogrup."'";
                                }
                                        $sql_consulta = "SELECT tx.*,te.*,tr.regional FROM tblExtraCanon tx, tblEstaciones te, tblRegional  tr WHERE (tx.fechaInicio BETWEEN '$fechaini' AND '$fechafin') AND te.idRegional = tr.idRegional AND tx.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tx.fechaInicio ASC;";
                                        // echo $sql_consulta;
                                        $ejecutar = sqlsrv_query($con, $sql_consulta);
                                        $row_count = sqlsrv_has_rows( $ejecutar);
                                        $listas = array();
                                        if ($row_count === false){
                                        }else{
                                            while($row =sqlsrv_fetch_array($ejecutar)) {
                                                $listas[]=$row;
                                            } 
                                        }
                                        $todos= array();
                                        $contador = array();
                    
                                        $todos_dep = array();
                                        $contador_dep = array();
                    
                                        $todos_dep_acu = array();
                                        $contador_dep_acu = array();
                                        $n = 0; $ni = 0; $nd = 0;
                                        // print_r($listas);
                                        // echo "<br>";
                                            foreach ($listas as $key) {
                                                $meye = date_format($key['fechaInicio'],'m-Y');
                                                $idre = $key['idRegional'];
                                                
                                                if(intval($key['idFormulario'])>0){
                    
                                                    $valor = $meye;
                                                    if(in_array($valor,$contador)){
                                                        $clave = array_search($valor, $contador);
                                                        $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                                        $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                                        $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                                        $todos[$clave] = $auxiliar;
                                                    }else{
                                                        $contador[$n] = $valor;
                                                        $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                                        $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                                        $auxiliar['num'] = 1;
                                                        $todos[$n] = $auxiliar;
                                                        $n += 1;
                                                    }
                    
                                                    $valor = $meye.'-'.$key['regional'];
                                                    $valoraux = $meye.'-'.$key['regional'];
                                                    if(in_array($valor,$contador_dep)){
                                                        $clave = array_search($valor, $contador_dep);
                                                        $auxiliar_dep['mes'] = date_format($key['fechaInicio'],'m');
                                                        $auxiliar_dep['ani'] = date_format($key['fechaInicio'],'Y');
                                                        $auxiliar_dep['num'] = $todos_dep[$clave]['num'] + 1;
                                                        $auxiliar_dep['dep'] = $key['regional'];
                                                        $auxiliar_dep['lor'] = $valoraux;
                                                        $todos_dep[$clave] = $auxiliar_dep;
                                                    }else{
                                                        $contador_dep[$ni] = $valor;
                                                        $auxiliar_dep['mes'] = date_format($key['fechaInicio'],'m');
                                                        $auxiliar_dep['ani'] = date_format($key['fechaInicio'],'Y');
                                                        $auxiliar_dep['num'] = 1;
                                                        $auxiliar_dep['dep'] = $key['regional'];
                                                        $auxiliar_dep['lor'] = $valoraux;
                                                        $todos_dep[$ni] = $auxiliar_dep;
                                                        $ni += 1;
                                                    }
                    
                                                    $valor = $key['regional'];
                                                    if(in_array($valor,$contador_dep_acu)){
                                                        $clave = array_search($valor, $contador_dep_acu);
                                                        $auxiliar_acu['num'] = $todos_dep_acu[$clave]['num'] + 1;
                                                        $auxiliar_acu['dep'] = $key['regional'];
                                                        $todos_dep_acu[$clave] = $auxiliar_acu;
                                                    }else{
                                                        $contador_dep_acu[$nd] = $valor;
                                                        $auxiliar_acu['num'] = 1;
                                                        $auxiliar_acu['dep'] = $key['regional'];
                                                        $todos_dep_acu[$nd] = $auxiliar_acu;
                                                        $nd += 1;
                                                    }
                                                }
                                            }
                    
                    
                    
                                            $sql_consulta = "SELECT tx.*,te.*,tr.regional FROM tblExtraCanon tx, tblEstaciones te, tblRegional  tr WHERE te.idRegional = tr.idRegional AND tx.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tx.fechaInicio ASC;";
                                            // echo $sql_consulta;
                                            $ejecutar = sqlsrv_query($con, $sql_consulta);
                                            $row_count = sqlsrv_has_rows( $ejecutar);
                                            $listas = array();
                                            if ($row_count === false){
                                            }else{
                                                while($row =sqlsrv_fetch_array($ejecutar)) {
                                                    $listas[]=$row;
                                                } 
                                            }
                    
                                            $todos_dep_acu = array();
                                            $contador_dep_acu = array();
                                            $nd = 0;
                                            
                                            // echo "<br>";
                                                foreach ($listas as $key) {
                                                    $meye = date_format($key['fechaInicio'],'m-Y');
                                                    $idre = $key['idRegional'];
                                                    
                                                    if(intval($key['idFormulario'])>0){   
                                                        $valor = $key['regional'];
                                                        if(in_array($valor,$contador_dep_acu)){
                                                            $clave = array_search($valor, $contador_dep_acu);
                                                            $auxiliar_acu['num'] = $todos_dep_acu[$clave]['num'] + 1;
                                                            $auxiliar_acu['dep'] = $key['regional'];
                                                            $todos_dep_acu[$clave] = $auxiliar_acu;
                                                        }else{
                                                            $contador_dep_acu[$nd] = $valor;
                                                            $auxiliar_acu['num'] = 1;
                                                            $auxiliar_acu['dep'] = $key['regional'];
                                                            $todos_dep_acu[$nd] = $auxiliar_acu;
                                                            $nd += 1;
                                                        }
                                                    }
                                                }
                    
                                            $sql_consulta = "SELECT * FROM tblRegional;";
                                            $ejecutar = sqlsrv_query($con, $sql_consulta);
                                            $deptos = array();
                                                while($row =sqlsrv_fetch_array($ejecutar)) {
                                                    $deptos[]=$row;
                                                } 
                                            $pdf=new Reporte();//creamos el documento pdf
                                            $pdf->AddPage();//agregamos la pagina
                                            $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                                            $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                                            $pdf->SetFont("Times","",12);
                                            // print_r($listas);
                                            if(sizeof($listas)>0){
                                                // $pdf->Cell(0,10,"Cantidad de preventivos realizados por ".$caso_meses.".",0,1);
                                                
                                                $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                                                
                                                if(sizeof($todos)>0 && sizeof($todos_dep)>0 && sizeof($todos_dep_acu)>0 && sizeof($deptos)>0){
                                                    $pdf->barrasgraficoPDF3($todos,$todos_dep,$todos_dep_acu,$deptos,'ReportePdf',array(15,30,200,100),'Realizados por meses','Realizados por mes y Regional','Acumulado por regional');
                                                }else{
                                                    $pdf->Cell(0,5,"DATOS INCOMPLETOS ",0,1,'C');
                                                }
                                            }else{
                                                $pdf->Cell(0,5,"SIN DATOS: ",0,1,'C');
                                            }
                            break;

                            case 8:
                                switch ($tiporang) {
                                    case 4:
                                    $caso_meses = 'SEMESTRAL';
    
                                    $sql_total="SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano
                                    from tblExtraCanon 
                                    WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)";
                                    // echo $sql_total;
                                    $query=sqlsrv_query($con,$sql_total);
                                    $listas = array();
                                    $count=sqlsrv_has_rows($query);
    
                                    if($count!=false){
                                            while($row =sqlsrv_fetch_array($query)) {
                                                $listas[]=$row;  
                                            }
    
                                            $n=0;
                                            $todos= array();
                                            $tamaño=sizeof($listas);             
    
                                            if($tamaño>3){
    
                                                $total=0;
                                                $cadena = array();
                                                for ($i=0; $i < $tamaño ; $i++) {    
                                                    $key=$listas[$i];  
                                                        if($i<=2){
                                                            $total=$total+$key['total'];
                                                            $cadena[]=$key['meses'];
                                                        }else{
                                                            if($i==3){
                                                                $auxiliar['total']=$total;
                                                                $auxiliar['meses']=implode('-',$cadena);
                                                                $todos[0] = $auxiliar;
    
                                                                $total=0;
                                                                $cadena = array();
                                                                $total=$total+$key['total'];
                                                                $cadena[]=$key['meses'];
                                                            } elseif($i==$tamaño-1){
                                                                $total=$total+$key['total'];
                                                                $cadena[]=$key['meses'];
                                                                $auxiliar['total']=$total;
                                                                $auxiliar['meses']=implode('-',$cadena);
                                                                $todos[1] = $auxiliar;
                                                            }else{
                                                                $total=$total+$key['total'];
                                                                $cadena[]=$key['meses'];
                                                            }
    
                                                            
                                                        }
                                                }
    
                                            }else{
                                                $total=0;
                                                $cadena = array();
                                                foreach ($listas as $key) {
                                                    $total=$total+$key['total'];
                                                    $cadena[]=$key['meses']."    ";
                                                }
                                                
                                                $auxiliar['total']=$total;
                                                $auxiliar['meses']=implode('-',$cadena);
    
                                                $todos[0] = $auxiliar;
                                            }
    
                                           
                                    }
    
                                     $pdf=new Reporte();
                                    $pdf->AddPage();
                                    $pdf->SetFont("Arial","B",14);
                                    $pdf->Cell(0,5,"GRAFICO: Total extracanon semestral",0,1,'C');
                                    $pdf->SetFont("Times","",12);
                                    if (sizeof($todos)>0) {
                                                    $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de extracanon en el rango de fechas');
                                    }else{
                                        $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                    } 
     
    
                                    break;
    
                                    case 5:
                                                /* aqui va la cosa */
                                                $caso_meses = 'ANUAL';                 
                                                $sql_total="SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano
                                                from tblExtraCanon 
                                                WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)";
                                                // echo $sql_total;
     
                                                $query=sqlsrv_query($con,$sql_total);
                                                $listas = array();
                                                $count=sqlsrv_has_rows($query);
                                                $todos= array();
                                                if($count!=false){
                                                        while($row =sqlsrv_fetch_array($query)) {
                                                            $listas[]=$row;  
                                                        }
                                                        $n=0;
                                                        $tamaño=sizeof($listas);             
                                                        if($tamaño>6){
                                                            $total=0;
                                                            $cadena = array();
                                                            for ($i=0; $i < $tamaño ; $i++) {   
                                                                $key=$listas[$i];   
                                                                    if($i<=5){
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]=$key['meses'];
                                                                    }else{
                                                                        if($i==6){
                                                                            $auxiliar['total']=$total;
                                                                            $auxiliar['meses']=implode('-',$cadena);
                                                                            $todos[0] = $auxiliar;
    
                                                                            $total=0;
                                                                            $cadena = array();
                                                                            $total=$total+$key['total'];
                                                                            $cadena[]=$key['meses'];
                                                                        } else if($i==$tamaño-1){
                                                                            $total=$total+$key['total'];
                                                                            $cadena[]=$key['meses'];
                                                                            $auxiliar['total']=$total;
                                                                            $auxiliar['meses']=implode('-',$cadena);
                                                                            $todos[1] = $auxiliar;
                                                                        }else{
                                                                            $total=$total+$key['total'];
                                                                            $cadena[]=$key['meses'];
                                                                        }
        
                                                                    }
                                                            }
    
                                                        }else{
                                                            $total=0;
                                                            $cadena = array();
                                                            foreach ($listas as $key) {
                                                                
                                                                $total=$total+$key['total'];
                                                                $cadena[]=$key['meses']."    ";
                                                            }
                                                            
                                                            $auxiliar['total']=$total;
                                                            $auxiliar['meses']=implode('-',$cadena);
    
                                                            $todos[0] = $auxiliar;
                                                        }                                                
                                                }
    
                                                 $pdf=new Reporte();
                                                $pdf->AddPage();
                                                $pdf->SetFont("Arial","B",14);
                                                $pdf->Cell(0,5,"GRAFICO: Total extracanon anual",0,1,'C');
                                                $pdf->SetFont("Times","",12);
                                                if (sizeof($todos)>0) {
                                                    $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de extracanon en el rango de fechas');
                                                }else{
                                                    $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                                }   
    
                                    break;
                                    default:
                                            $sql_total="SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano
                                            from tblExtraCanon 
                                            WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)";
                                            // echo $sql_total;
                                             $query=sqlsrv_query($con,$sql_total);
                                            $listas = array();
    
                                            $count=sqlsrv_has_rows($query);
                                            $todos= array();
                                            if($count!=false){
                                                    while($row =sqlsrv_fetch_array($query)) {
                                                        $listas[]=$row;  
                                                    }
                                                    $n=0;
                                                    foreach ($listas as $key) {
                                                        
                                                        $auxiliar['meses'] = $key['meses'];
                                                        $auxiliar['ano'] = $key['ano'];
                                                        $auxiliar['total'] = $key['total'];
                                                        $todos[$n] = $auxiliar;
                                                        $n++;
                                                    }
                                            }
    
                                            $pdf=new Reporte();
                                            $pdf->AddPage();
                                            $pdf->SetFont("Arial","B",14);
                                            $pdf->Cell(0,5,"GRAFICO: Total extracanon general",0,1,'C');
                                            $pdf->SetFont("Times","",12);
                                            if (sizeof($todos)>0){
                                                $pdf->barrasgraficoPDF_v2($todos,'ReportePdf',array(15,30,200,100),'Cantidad de extracanon en el rango de fechas');
                                            }else{
                                                $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                            }    
                                    break;
                            }
                            break;

                        }
        break;
        default:
            $caso_por_grupo = '';
            if($casogrup > 0){
                $caso_por_grupo = " AND tp.grupo = 'grupo".$casogrup."'";
            }
            switch ($casopcio) {
                case 1:
                    $sql_consulta = "SELECT tp.idPreventivo as id,tp.fechaInicio,tp.fechaFinal,tr.regional,tr.idRegional,tf.tipo_formulario,tf.idFormulario,tf.fecha_ini_intervalo,tf.fecha_fin_intervalo,tf.hora_fin_intervalo,tf.hora_ini_intervalo,'OTRO' as title,tp.horaInicio,tp.horaFinal,tp.grupo FROM tblPreventivo tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional $caso_por_region $caso_por_grupo UNION SELECT tp.id,tp.start as fechaInicio,tp.fechafin as fechaFinal,tr.regional,tr.idRegional,tf.tipo_formulario,tf.idFormulario,tf.fecha_ini_intervalo,tf.fecha_fin_intervalo,tf.hora_fin_intervalo,tf.hora_ini_intervalo,tp.title,tp.hora as horaInicio,tp.hora as horaFinal,tp.grupo FROM tblSolicitudCorrectivos tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional $caso_por_region $caso_por_grupo UNION SELECT tp.idExtraCanon as id,tp.fechaInicio,tp.fechaFinal,tr.regional,tr.idRegional,tf.tipo_formulario,tf.idFormulario,tf.fecha_ini_intervalo,tf.fecha_fin_intervalo,tf.hora_fin_intervalo,tf.hora_ini_intervalo,'OTRO' as title,tp.horaInicio,tp.horaFinal,tp.grupo FROM tblExtraCanon tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional $caso_por_region $caso_por_grupo";
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
                    }else{
                        while($row = sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                        }
                    }
                    $todos_informes = array();
                    $disponible = 0;
                    $grupos = array();
                    $meses = array();
                    $regionales = array(); $numero = 1;
                    foreach ($listas as $key) {
                        set_time_limit(25);
                        $meye = date_format($key['fechaInicio'],'m-Y');
                        $FechaP = date_format($key['fechaInicio'], 'd-m-Y').' '.$key['horaInicio'];
                        $FechaI = date_format($key['fecha_ini_intervalo'], 'd-m-Y').' '.$key['hora_ini_intervalo'];
                        $FechaF = date_format($key['fecha_fin_intervalo'], 'd-m-Y').' '.$key['hora_fin_intervalo'];
                        $grupo = $key['grupo']; $auxiliar=array();
                            if(strlen(trim($FechaI)) > 5 && strlen(trim($FechaF)) > 5 ){
                                $fecha_prog = new DateTime($FechaP);
                                $fecha_inic = new DateTime($FechaI);
                                $fecha_final = new DateTime($FechaF);
                                $tipo = trim($key['tipo_formulario']);
                                $id = $key['id'];
                                if ($tipo == 'CORRECTIVO') {
                                    $title = trim($key['title']);
                                    switch ($title) {
                                        case 'ENTEL Correctivo sitio corporativo':
                                            $disponible = 1;
                                            break;
                                        default:
                                            $disponible = 3;
                                            break;
                                    }
                                    $FechaE = date("d-m-Y",strtotime($FechaP."+ $disponible days")); 
                                }else{
                                    $disponible =0;
                                    $FechaE = date_format($key['fechaFinal'], 'd-m-Y').' '.$key['horaFinal'];
                                }
                                $fecha_finish = new DateTime($FechaE);
                                if(($fecha_prog <= $fecha_inic) && ($fecha_finish >= $fecha_final)){
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['num'] = 1;
                                    $auxiliar['reg'] = $key['regional'];
                                    $auxiliar['tot'] = 'OPTIMO';
                                    $auxiliar['gru'] = $key['grupo'];
                                }else{
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['num'] = 1;
                                    $auxiliar['reg'] = $key['regional'];
                                    $auxiliar['tot'] = 'MORA';
                                    $auxiliar['gru'] = $key['grupo'];
                                }
                            }
                            $todos_informes[] = $auxiliar;
                            $numero += 1;
                    }
                    foreach ($todos_informes as $sel ) {
                        $meye = $sel['mes'].'-'.$sel['ani'];
                        if(!in_array($meye,$meses)){
                            $meses[] = $meye;
                        }
                        if(!in_array($sel['reg'],$regionales)){
                            $regionales[] = $sel['reg'];
                        }
                    }
                    $por_grupos= array();
                    $contador = array();
                    $n = 0;
                        foreach ($listas as $key) {
                            $meye = date_format($key['fechaInicio'],'m-Y');
                            $grupo = $key['grupo'];
                            $valor = $meye.'-'.$grupo;
                            $valoraux = $meye.'-'.$grupo;
                            if(intval($key['idFormulario'])>0){
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $aux['mes'] = date_format($key['fechaInicio'],'m');
                                    $aux['ani'] = date_format($key['fechaInicio'],'Y');
                                    $aux['gru'] = $grupo;
                                    $aux['num'] = $por_grupos[$clave]['num']+ 1;
                                    $aux['lor'] = $valoraux;
                                    $por_grupos[$clave] = $aux;
                                }else{
                                    $contador[$n] = $valor;
                                    $valor = $meye.'-'.$grupo;
                                    $aux['mes'] = date_format($key['fechaInicio'],'m');
                                    $aux['ani'] = date_format($key['fechaInicio'],'Y');
                                    $aux['gru'] = $grupo;
                                    $aux['num'] = 1;
                                    $aux['lor'] = $valoraux;
                                    $por_grupos[$n] = $aux;
                                    $n += 1;
                                }
                            }
                        }
                        $por_regiones= array();
                        $contador = array();
                        $n = 0;
                            foreach ($todos_informes as $key) {
                                $meye = $key['tot'];
                                $regio = $key['reg'];
                                $valor = $regio.'-'.$meye;
                                $valoraux = $regio.'-'.$meye;
                                    if(in_array($valor,$contador)){
                                        $clave = array_search($valor, $contador);
                                        $auxi['mes'] = $key['mes'];
                                        $auxi['ani'] = $key['ani'];
                                        $auxi['gru'] = $regio;
                                        $auxi['num'] = $por_regiones[$clave]['num']+1;
                                        $auxi['lor'] = $valoraux;
                                        $por_regiones[$clave] = $auxi;
                                    }else{
                                        $contador[$n] = $valor;
                                        $auxi['mes'] = $key['mes'];
                                        $auxi['ani'] = $key['ani'];
                                        $auxi['gru'] = $regio;
                                        $auxi['num'] = 1;
                                        $auxi['lor'] = $valoraux;
                                        $por_regiones[$n] = $auxi;
                                        $n += 1;
                                    }
                            }
                            $por_decen= array();
                            $contador = array();
                            $n = 0;
                            foreach ($todos_informes as $key) {
                                $meye = $key['mes'].'-'.$key['ani'];
                                $decen = $key['tot'];
                                $valor = $meye.'-'.$decen;
                                $valoraux = $meye.'-'.$decen;
                                    if(in_array($valor,$contador)){
                                        $clave = array_search($valor, $contador);
                                        $auxil['mes'] = $key['mes'];
                                        $auxil['ani'] = $key['ani'];
                                        $auxil['gru'] = $decen;
                                        $auxil['num'] = $por_decen[$clave]['num']+1;
                                        $auxil['lor'] = $valoraux;
                                        $por_decen[$clave] = $auxil;
                                    }else{
                                        $contador[$n] = $valor;
                                        $auxil['mes'] = $key['mes'];
                                        $auxil['ani'] = $key['ani'];
                                        $auxil['gru'] = $decen;
                                        $auxil['num'] = 1;
                                        $auxil['lor'] = $valoraux;
                                        $por_decen[$n] = $auxil;
                                        $n += 1;
                                    }
                            }
                            $sql_consulta = "SELECT * FROM tblRegional;";
                            $ejecutar = sqlsrv_query($con, $sql_consulta);
                            $deptos = array();
                                while($row =sqlsrv_fetch_array($ejecutar)) {
                                    $deptos[]=$row['regional'];
                                } 
                    $pdf=new Reporte();//creamos el documento pdf
                    $pdf->AddPage();//agregamos la pagina
                    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                    $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                    $pdf->SetFont("Times","",12);
                    if(sizeof($listas)>0){
                        // $pdf->Cell(0,10,utf8_decode('Desempeño de las cuadrillas ').$caso_meses.".",0,1);
                        $pdf->Cell(0,10,"Reporte en rango de fechas: ".date("d-m-Y", strtotime($fechaini))." al ".date("d-m-Y", strtotime($fechafin)).", ".$caso_meses.".",0,1);
                        
                        if(sizeof($todos_informes)>0 && sizeof($regionales)>0 && sizeof($grupos_existentes)>0 && sizeof($meses)>0 && sizeof($por_regiones)>0 && sizeof($deptos)>0 && sizeof($por_grupos)>0 && sizeof($por_decen)>0){
                            $pdf->barrasgraficoPDF3_1($todos_informes,$regionales,$grupos_existentes,$meses,$por_regiones,$por_grupos,$por_decen,$deptos,'ReportePdf',array(15,30,200,100),'Por meses','Por grupo');
                        }else{
                            $pdf->Cell(0,5,"DATOS INCOMPLETOS ",0,1,'C');
                        }
                    }else{
                        $pdf->Cell(0,5,"SIN DATOS: ",0,1,'C');
                    }
                break;
                case 2:
                    $sql_consulta = "SELECT tp.idPreventivo as id,tp.fechaInicio,tf.item_cambiado1_1,tf.cant1_1,tf.item_cambiado2_1,tf.cant2_1,tf.item_cambiado1_2,tf.cant1_2,tf.item_cambiado2_2,tf.cant2_2,tf.item_cambiado1_3,tf.cant1_3,tf.item_cambiado2_3,tf.cant2_3,tf.item_cambiado1_4,tf.cant1_4,tf.item_cambiado2_4,tf.cant2_4,tf.item_cambiado1_5,tf.cant1_5,tf.item_cambiado2_5,tf.cant2_5,tr.regional,tr.idRegional,tf.tipo_formulario FROM tblPreventivo tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional $caso_por_region $caso_por_grupo
                    UNION
                    SELECT tp.id,tp.start as fechaInicio,tf.item_cambiado1_1,tf.cant1_1,tf.item_cambiado2_1,tf.cant2_1,tf.item_cambiado1_2,tf.cant1_2,tf.item_cambiado2_2,tf.cant2_2,tf.item_cambiado1_3,tf.cant1_3,tf.item_cambiado2_3,tf.cant2_3,tf.item_cambiado1_4,tf.cant1_4,tf.item_cambiado2_4,tf.cant2_4,tf.item_cambiado1_5,tf.cant1_5,tf.item_cambiado2_5,tf.cant2_5,tr.regional,tr.idRegional,tf.tipo_formulario FROM tblSolicitudCorrectivos tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional $caso_por_region $caso_por_grupo
                    UNION
                    SELECT tp.idExtraCanon as id,tp.fechaInicio,tf.item_cambiado1_1,tf.cant1_1,tf.item_cambiado2_1,tf.cant2_1,tf.item_cambiado1_2,tf.cant1_2,tf.item_cambiado2_2,tf.cant2_2,tf.item_cambiado1_3,tf.cant1_3,tf.item_cambiado2_3,tf.cant2_3,tf.item_cambiado1_4,tf.cant1_4,tf.item_cambiado2_4,tf.cant2_4,tf.item_cambiado1_5,tf.cant1_5,tf.item_cambiado2_5,tf.cant2_5,tr.regional,tr.idRegional,tf.tipo_formulario FROM tblExtraCanon tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional $caso_por_region $caso_por_grupo";
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $row_count = sqlsrv_has_rows( $ejecutar);
                    $listas = array();
                    if ($row_count === false){
                    }else{
                        $pun = 0; $items = array();
                        while($row = sqlsrv_fetch_array($ejecutar)) {
                            $listas[]=$row;
                            
                            if(strlen(trim($row['item_cambiado1_1'])) > 0 && !in_array($row['item_cambiado1_1'],$items)){
                                $items[$pun] = trim($row['item_cambiado1_1']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado1_2'])) > 0 && !in_array($row['item_cambiado1_2'],$items)){
                                $items[$pun] = trim($row['item_cambiado1_2']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado2_1'])) > 0 && !in_array($row['item_cambiado2_1'],$items)){
                                $items[$pun] = trim($row['item_cambiado2_1']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado2_2'])) > 0 && !in_array($row['item_cambiado2_2'],$items)){
                                $items[$pun] = trim($row['item_cambiado2_2']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado1_3'])) > 0 && !in_array($row['item_cambiado1_3'],$items)){
                                $items[$pun] = trim($row['item_cambiado1_3']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado2_3'])) > 0 && !in_array($row['item_cambiado2_3'],$items)){
                                $items[$pun] = trim($row['item_cambiado2_3']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado1_4'])) > 0 && !in_array($row['item_cambiado1_4'],$items)){
                                $items[$pun] = trim($row['item_cambiado1_4']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado2_4'])) > 0 && !in_array($row['item_cambiado2_4'],$items)){
                                $items[$pun] = trim($row['item_cambiado2_4']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado1_5'])) > 0 && !in_array($row['item_cambiado1_5'],$items)){
                                $items[$pun] = trim($row['item_cambiado1_5']);
                                $pun += 1;
                            }
                            if(strlen(trim($row['item_cambiado2_5'])) > 0 && !in_array($row['item_cambiado2_5'],$items)){
                                $items[$pun] = trim($row['item_cambiado2_5']);
                                $pun += 1;
                            }
                        } 
                    }
                    // echo "<br>";
                    // print_r($items);
                    // echo "<br>";
                    $items_campos = array('item_cambiado1_1','item_cambiado1_2','item_cambiado2_1','item_cambiado2_2','item_cambiado1_3','item_cambiado2_3','item_cambiado1_4','item_cambiado2_4','item_cambiado1_5','item_cambiado2_5');

                    $todos= array();
                    $contador = array();

                    $todos_dep = array();
                    $contador_dep = array();

                    $n = 0; $ni = 0; $nd = 0;
                    // print_r($listas);
                    // echo "<br>";
                        foreach ($listas as $key) {
                            $meye = date_format($key['fechaInicio'],'m-Y');
                            $idre = $key['idRegional'];

                            foreach ($items_campos as $ite) {
                                if (strlen(trim($key[$ite])) > 0) {
                                    $valor = $meye.'-'.$key[$ite];
                                    if(in_array($valor,$contador)){
                                        $clave = array_search($valor, $contador);
                                        $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                        $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                        $auxiliar['num'] = $todos[$clave]['num'] + 1;
                                        $todos[$clave] = $auxiliar;
                                    }else{
                                        $contador[$n] = $valor;
                                        $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                        $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                        $auxiliar['num'] = 1;
                                        $todos[$n] = $auxiliar;
                                        $n += 1;
                                    }
    
                                    $valor = $key[$ite];
                                    $valoraux = $key[$ite];
                                    if(in_array($valor,$contador_dep)){
                                        $clave = array_search($valor, $contador_dep);
                                        $auxiliar_dep['num'] = $todos_dep[$clave]['num'] + 1;
                                        $auxiliar_dep['ite'] = $key[$ite];
                                        $todos_dep[$clave] = $auxiliar_dep;
                                    }else{
                                        $contador_dep[$ni] = $valor;
                                        $auxiliar_dep['num'] = 1;
                                        $auxiliar_dep['ite'] = $key[$ite];
                                        $todos_dep[$ni] = $auxiliar_dep;
                                        $ni += 1;
                                    }
                                }
                            }
                        }
                        $sql_consulta_dos = "SELECT tp.idPreventivo as id,tp.fechaInicio,tf.item_cambiado1_1,tf.cant1_1,tf.item_cambiado2_1,tf.cant2_1,tf.item_cambiado1_2,tf.cant1_2,tf.item_cambiado2_2,tf.cant2_2,tf.item_cambiado1_3,tf.cant1_3,tf.item_cambiado2_3,tf.cant2_3,tf.item_cambiado1_4,tf.cant1_4,tf.item_cambiado2_4,tf.cant2_4,tf.item_cambiado1_5,tf.cant1_5,tf.item_cambiado2_5,tf.cant2_5,tr.regional,tr.idRegional,tf.tipo_formulario FROM tblPreventivo tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional
                        UNION
                        SELECT tp.id,tp.start as fechaInicio,tf.item_cambiado1_1,tf.cant1_1,tf.item_cambiado2_1,tf.cant2_1,tf.item_cambiado1_2,tf.cant1_2,tf.item_cambiado2_2,tf.cant2_2,tf.item_cambiado1_3,tf.cant1_3,tf.item_cambiado2_3,tf.cant2_3,tf.item_cambiado1_4,tf.cant1_4,tf.item_cambiado2_4,tf.cant2_4,tf.item_cambiado1_5,tf.cant1_5,tf.item_cambiado2_5,tf.cant2_5,tr.regional,tr.idRegional,tf.tipo_formulario FROM tblSolicitudCorrectivos tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional
                        UNION
                        SELECT tp.idExtraCanon as id,tp.fechaInicio,tf.item_cambiado1_1,tf.cant1_1,tf.item_cambiado2_1,tf.cant2_1,tf.item_cambiado1_2,tf.cant1_2,tf.item_cambiado2_2,tf.cant2_2,tf.item_cambiado1_3,tf.cant1_3,tf.item_cambiado2_3,tf.cant2_3,tf.item_cambiado1_4,tf.cant1_4,tf.item_cambiado2_4,tf.cant2_4,tf.item_cambiado1_5,tf.cant1_5,tf.item_cambiado2_5,tf.cant2_5,tr.regional,tr.idRegional,tf.tipo_formulario FROM tblExtraCanon tp, tblFormulario tf, tblEstaciones te,tblRegional tr WHERE tp.idFormulario = tf.idFormulario AND tp.idEstacion = te.idEstacion AND te.idRegional = tr.idRegional";
                        $ejecutar2 = sqlsrv_query($con, $sql_consulta_dos);
                        $row_count = sqlsrv_has_rows( $ejecutar2);
                        $listas = array();
                        if ($row_count === false){
                        }else{
                            $pun = 0; $items = array();
                            while($row = sqlsrv_fetch_array($ejecutar2)) {
                                $listas[]=$row;
                                
                                if(strlen(trim($row['item_cambiado1_1'])) > 0 && !in_array($row['item_cambiado1_1'],$items)){
                                    $items[$pun] = trim($row['item_cambiado1_1']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado1_2'])) > 0 && !in_array($row['item_cambiado1_2'],$items)){
                                    $items[$pun] = trim($row['item_cambiado1_2']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado2_1'])) > 0 && !in_array($row['item_cambiado2_1'],$items)){
                                    $items[$pun] = trim($row['item_cambiado2_1']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado2_2'])) > 0 && !in_array($row['item_cambiado2_2'],$items)){
                                    $items[$pun] = trim($row['item_cambiado2_2']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado1_3'])) > 0 && !in_array($row['item_cambiado1_3'],$items)){
                                    $items[$pun] = trim($row['item_cambiado1_3']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado2_3'])) > 0 && !in_array($row['item_cambiado2_3'],$items)){
                                    $items[$pun] = trim($row['item_cambiado2_3']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado1_4'])) > 0 && !in_array($row['item_cambiado1_4'],$items)){
                                    $items[$pun] = trim($row['item_cambiado1_4']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado2_4'])) > 0 && !in_array($row['item_cambiado2_4'],$items)){
                                    $items[$pun] = trim($row['item_cambiado2_4']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado1_5'])) > 0 && !in_array($row['item_cambiado1_5'],$items)){
                                    $items[$pun] = trim($row['item_cambiado1_5']);
                                    $pun += 1;
                                }
                                if(strlen(trim($row['item_cambiado2_5'])) > 0 && !in_array($row['item_cambiado2_5'],$items)){
                                    $items[$pun] = trim($row['item_cambiado2_5']);
                                    $pun += 1;
                                }
                            } 
                        }
    
                        $todos_dep_acu = array();
                        $contador_dep_acu = array();
                        $n = 0; $ni = 0; $nd = 0;
                        // print_r($listas);
                        // echo "<br>";
                            foreach ($listas as $key) {
                                $meye = date_format($key['fechaInicio'],'m-Y');
                                $idre = $key['idRegional'];
                                foreach ($items_campos as $ite) {
                                    if (strlen(trim($key[$ite])) > 0) {
                                        $valor = $key['regional'].'-'.$key[$ite];
                                        if(in_array($valor,$contador_dep_acu)){
                                            $clave = array_search($valor, $contador_dep_acu);
                                            $auxiliar_acu['num'] = $todos_dep_acu[$clave]['num']+1;
                                            $auxiliar_acu['dep'] = $key['regional'];
                                            $todos_dep_acu[$clave] = $auxiliar_acu;
                                        }else{
                                            $contador_dep_acu[$nd] = $valor;
                                            $auxiliar_acu['num'] = 1;
                                            $auxiliar_acu['dep'] = $key['regional'];
                                            $todos_dep_acu[$nd] = $auxiliar_acu;
                                            $nd += 1;
                                        }
                                    }
                                }
                            }
                    // print_r($todos_dep_acu);
                    $sql_consulta = "SELECT * FROM tblRegional;";
                    $ejecutar = sqlsrv_query($con, $sql_consulta);
                    $deptos = array();
                        while($row =sqlsrv_fetch_array($ejecutar)) {
                            $deptos[]=$row;
                        } 

                    $pdf=new Reporte();//creamos el documento pdf
                    $pdf->AddPage();//agregamos la pagina
                    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                    $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                    $pdf->SetFont("Times","",12);
                    if(sizeof($listas)>0){
                        // $pdf->Cell(0,10,"Materiales utilizados por ".$caso_meses.".",0,1);
                        $pdf->Cell(0,10,utf8_decode('Inventario de equipos, fecha de impresión ').$fechahoy,0,1);
                        if(sizeof($todos)>0 && sizeof($todos_dep)>0 && sizeof($todos_dep_acu)>0 && sizeof($deptos)>0){
                            $pdf->barrasgraficoPDF3v2($todos,$todos_dep,$todos_dep_acu,$deptos,'ReportePdf',array(15,30,200,100),'Barras');
                        }else{
                            $pdf->Cell(0,5,"DATOS INCOMPLETOS ",0,1,'C');
                        }
                    }else{
                        $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                    }
                break;
                case 3:
                    $pdf=new Reporte();//creamos el documento pdf
                    $pdf->AddPage();//agregamos la pagina
                    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                    $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                    $pdf->SetFont("Times","",12);
                    $pdf->Cell(0,5,"Informe solo en Excel",0,1,'C');
                    
                break;
                    
                        case 8;
                            switch ($tiporang) {
                                case 4:
                                    $caso_meses = 'SEMESTRAL';
                                    $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from ( 
                                    SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblPreventivo WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)
                                    union all
                                    SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblExtraCanon WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)
                                    union ALL
                                    SELECT COUNT(MONTH(start)) as total,MONTH(start) as meses,YEAR(start) as ano from tblSolicitudCorrectivos WHERE idFormulario != 0 AND start >= '$fechaini' AND start <= '$fechafin' GROUP BY MONTH(start),YEAR(start)) tmp
                                    GROUP BY tmp.meses,tmp.ano";

                                            $query=sqlsrv_query($con,$sql_total);
                                            $listas = array();
                                            $count=sqlsrv_has_rows($query);

                                            if($count!=false){
                                                    while($row =sqlsrv_fetch_array($query)) {
                                                        $listas[]=$row;  
                                                    }

                                                    $n=0;
                                                    $todos= array();
                                                    $tamaño=sizeof($listas);             
                                                    $total=0; $cadena = array();
                                                    if($tamaño>3){
                                                        for ($i=0; $i < $tamaño ; $i++) {   
                                                                $key = $listas[$i];
                                                                // print_r($key);
                                                                if($i<=2){
                                                                    $total=$total+$key['total'];
                                                                    $cadena[]= $key['meses'];
                                                                }else{
                                                                    if($i==3){
                                                                        $auxiliar['total']=$total;
                                                                        $auxiliar['meses']=implode('-',$cadena);
                                                                        $todos[0] = $auxiliar;
                                                                        $total=0;
                                                                        $cadena= array();
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]= $key['meses'];
                                                                    } else if($i==$tamaño-1){
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]= $key['meses'];
                                                                        $auxiliar['total']=$total;
                                                                        $auxiliar['meses']=implode('-',$cadena);
                                                                        $todos[1] = $auxiliar;
                                                                    }else{
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]= $key['meses'];
                                                                    }
                                                                }
                                                                
                                                        }

                                                    }else{
                                                        foreach ($listas as $key) {
                                                            $total=$total+$key['total'];
                                                            $cadena[]= $key['meses']."";
                                                        }
                                                        $auxiliar['total']=$total;
                                                        $auxiliar['meses']=implode('-',$cadena);
                                                        $todos[0] = $auxiliar;
                                                    }

                                            }

                                            $pdf=new Reporte();
                                            $pdf->AddPage();
                                            $pdf->SetFont("Arial","B",14);
                                            $pdf->Cell(0,5,"GRAFICO: Total semestrales",0,1,'C');
                                            $pdf->SetFont("Times","",12);
                                            if (sizeof($listas)>0) {
                                                $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de intervenciones en el rango de fechas');
                                            }else{
                                                $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                            } 



                                break;
                                case 5:
                                    $caso_meses = 'ANUAL';

                                    $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from ( 
                                        SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblPreventivo WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)
                                        union all
                                        SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblExtraCanon WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)
                                        union ALL
                                        SELECT COUNT(MONTH(start)) as total,MONTH(start) as meses,YEAR(start) as ano from tblSolicitudCorrectivos WHERE idFormulario != 0 AND start >= '$fechaini' AND start <= '$fechafin' GROUP BY MONTH(start),YEAR(start)) tmp
                                        GROUP BY tmp.meses,tmp.ano";

                                        $query=sqlsrv_query($con,$sql_total);
                                            $listas = array();
                                            $count=sqlsrv_has_rows($query);

                                            if($count!=false){
                                                    while($row =sqlsrv_fetch_array($query)) {
                                                        $listas[]=$row;  
                                                    }

                                                    $n=0;
                                                    $todos= array();
                                                    $tamaño=sizeof($listas);             

                                                    if($tamaño>6){

                                                        $total=0;
                                                        $cadena = array();
                                                        for ($i=0; $i < $tamaño ; $i++) {     
                                                                if($i<=5){
                                                                    $total=$total+$key['total'];
                                                                    $cadena[]=$key['meses'];
                                                                }else{
                                                                    if($i==6){
                                                                        $auxiliar['total']=$total;
                                                                        $auxiliar['meses']=implode('-',$cadena);
                                                                        $todos[0] = $auxiliar;

                                                                        $total=0;
                                                                        $cadena = array();
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]=$key['meses'];
                                                                    }else if($i==$tamaño-1){
                                                                        $total=$total+$key['total'];
                                                                        $cadena[]=$key['meses'];
                                                                        $auxiliar['total']=$total;
                                                                        $auxiliar['meses']=implode('-',$cadena);
                                                                        $todos[1] = $auxiliar;
                                                                    }else{
                                                                        $total=$total+$key['total'];
                                                                        $cadena[] =$key['meses'];
                                                                    }

                                                                }
                                                        }

                                                    }else{
                                                        $total=0;
                                                        $cadena = array();
                                                        foreach ($listas as $key) {
                                                            
                                                            $total=$total+$key['total'];
                                                            $cadena[] =$key['meses']."";
                                                        }
                                                        
                                                        $auxiliar['total']=$total;
                                                        $auxiliar['meses']=implode('-',$cadena);

                                                        $todos[0] = $auxiliar;
                                                    }                                                
                                            }

                                            $pdf=new Reporte();
                                            $pdf->AddPage();
                                            $pdf->SetFont("Arial","B",14);
                                            $pdf->Cell(0,5,"GRAFICO: Total anuales",0,1,'C');
                                            $pdf->SetFont("Times","",12);
                                            if (sizeof($listas)>0) {
                                                            $pdf->barrasgraficoPDF_v3($todos,'ReportePdf',array(15,30,200,100),'Cantidad de intervenciones en el rango de fechas');
                                            }else{
                                                $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                            } 

                                break;
                                default:
                                    /* caso de que de de por meses o trimestral */
                                    $caso_meses = '';

                                        $sql_total="SELECT tmp.ano,tmp.meses,sum(tmp.total) as total from ( 
                                            SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblPreventivo WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)
                                            union all
                                            SELECT COUNT(MONTH(fechaInicio)) as total,MONTH(fechaInicio) as meses,YEAR(fechaInicio) as ano from tblExtraCanon WHERE idFormulario != 0 AND fechaInicio >= '$fechaini' AND fechaInicio <= '$fechafin' GROUP BY MONTH(fechaInicio),YEAR(fechaInicio)
                                            union ALL
                                            SELECT COUNT(MONTH(start)) as total,MONTH(start) as meses,YEAR(start) as ano from tblSolicitudCorrectivos WHERE idFormulario != 0 AND start >= '$fechaini' AND start <= '$fechafin' GROUP BY MONTH(start),YEAR(start)) tmp
                                            GROUP BY tmp.meses,tmp.ano";

                                            $query=sqlsrv_query($con,$sql_total);
                                            $listas = array();
                                            $count=sqlsrv_has_rows($query);
                                            if($count!=false){
                                                    while($row =sqlsrv_fetch_array($query)) {
                                                        $listas[]=$row;  
                                                    }
                                                    $todos= array();
                                                    $n=0;
                                                    foreach ($listas as $key) {
                                                        
                                                        $auxiliar['meses'] = $key['meses'];
                                                        $auxiliar['ano'] = $key['ano'];
                                                        $auxiliar['total'] = $key['total'];
                                                        $todos[$n] = $auxiliar;
                                                        $n++;
                                                    }
                                            }
                                            $pdf=new Reporte();
                                            $pdf->AddPage();
                                            $pdf->SetFont("Arial","B",14);
                                            $pdf->Cell(0,5,"GRAFICO: Total general",0,1,'C');
                                            $pdf->SetFont("Times","",12);
                                            if (sizeof($listas)>0) {
                                                $pdf->barrasgraficoPDF_v2($todos,'ReportePdf',array(15,30,200,100),'Cantidad de intervenciones en el rango de fechas');
                                            }else{
                                                $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                                            }  

                                break;                
                            }
                        break;
                default:
                break;
            }
        break;
    }
    // $pdf=new Reporte();//creamos el documento pdf
    // $pdf->AddPage();//agregamos la pagina
    // $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
    // $pdf->Cell(0,5," GRAFICO ",0,1,'C');
    // $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
    $pdfString = $pdf->Output('Reporte con graficos.pdf','I');
    
    $pdfBase64 = base64_encode($pdfString);
    echo 'data:application/pdf;base64,' . $pdfBase64;
}else{
  
    $pdf=new Reporte();//creamos el documento pdf
    $pdf->AddPage();//agregamos la pagina
    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
    $pdf->Cell(0,5," GRAFICO ",0,1,'C');
    $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
    $pdfString = $pdf->Output('Archivo pdf vacio.pdf','I');
    $pdfBase64 = base64_encode($pdfString);
    echo 'data:application/pdf;base64,' . $pdfBase64;
}

?>