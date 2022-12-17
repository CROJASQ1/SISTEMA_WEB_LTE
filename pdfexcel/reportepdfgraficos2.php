<?php
if (file_exists('ReportePdf.png')) {
   unlink("ReportePdf.png");
}
include('../conexion.php');
require_once("../fpdf182/fpdf.php");
require_once('../jpgraph-4.3.4/src/jpgraph.php');
require_once('../jpgraph-4.3.4/src/jpgraph_pie.php');
require_once("../jpgraph-4.3.4/src/jpgraph_pie3d.php");
require_once("../jpgraph-4.3.4/src/jpgraph_bar.php");
class Reporte extends FPDF{
    public function __construct($orientation='P', $unit='mm', $format='A4'){
        parent::__construct($orientation, $unit, $format);
    }
    public function graficoPDF($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos) || !is_array($ubicacionTamamo)){
        echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
        echo "debe indicar el nombre del grafico a crear";
        } else{
        #obtenemos los datos del grafico 
        //    print_r($datos);

        foreach ($datos as $key => $value){
            $data[] = $value[0];
            $nombres[] = $key; 
            $color[] = $value[1];
        } 
        $x = $ubicacionTamamo[0];
        $y = $ubicacionTamamo[1]; 
        $ancho = $ubicacionTamamo[2];  
        $altura = $ubicacionTamamo[3];  
        #Creamos un grafico vacio
        $graph = new PieGraph(600,400,'auto');
        #indicamos titulo del grafico si lo indicamos como parametro
        if(!empty($titulo)){
            $graph->title->Set($titulo);
        }
        //Creamos el plot de tipo tarta
        $p1 = new PiePlot3D($data);
        // $size = 0.0;
        // $p1->SetSize($size);
        $p1->SetCenter(0.65,0.32);
        $p1->SetSliceColors($color);
        #indicamos la leyenda para cada porcion de la tarta
        $p1->value->SetFont(FF_FONT1,FS_BOLD);
        $p1->value->SetColor("darkred");
        $p1->SetLabelPos(0.6);
        $p1->SetLegends($nombres);
        $graph->legend->Pos(0.05,0.65);
        $graph->legend->SetShadow(false);
        //Añadirmos el plot al grafico
        $graph->Add($p1);
        $p1->ExplodeSlice(1);
        //mostramos el grafico en pantalla
        $graph->Stroke("$nombreGrafico.png");
        $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
        } 
    } 
    public function barrasgraficoPDF($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
                //construccion de los arrays de los ejes x e y
                if(!is_array($datos) || !is_array($ubicacionTamamo)){
                    echo "los datos del grafico y la ubicacion deben de ser arreglos";
                }
                elseif($nombreGrafico == NULL){
                    echo "debe indicar el nombre del grafico a crear";
                } else{
                    #obtenemos los datos del grafico 
                    //    print_r($datos);
                    foreach ($datos as $key){
                        $datax[] = $key['mes'].'-'.$key['ani'];
                        $datay[] = $key['num']; 
                    } 
                    // print_r($datax);
                    // print_r($datay);
                    // $datax = array("Alemania", "España", "Francia", "Italia", "Reino Unido");
                    // $datay = array(43267, 22368, 37644, 32949, 39762);

                    // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

                    $graph = new Graph(500,200,"auto");
                    $graph->SetScale("textlin");

                    // Establecemos los márgenes del gráfico y le añadimos una sombra por detrás:

                    // $graph->img->SetMargin($ubicacionTamamo);
                    $graph->img->SetMargin(50,100,20,40);
                    $graph->SetShadow();
                    $x = $ubicacionTamamo[0];
                    $y = $ubicacionTamamo[1]; 
                    $ancho = $ubicacionTamamo[2];  
                    $altura = $ubicacionTamamo[3];  
                    // Creamos un objeto de gráfica de barras, decimos que su color sea naranja, que se muestre la leyenda y que añada esa gráfica al objeto general.

                    $barra = new BarPlot($datay);
                    $barra->SetFillColor("orange");
                    // $barra->SetLegend($titulo);
                    // $graph->legend->Pos(0.05,0.90);
                    // $graph->legend->SetShadow(false);
                    $graph->Add($barra);

                    // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

                    $graph->title->Set("Reporte por meses");
                    $graph->xaxis->title->Set("Mes - Gestion");
                    $graph->title->SetFont(FF_FONT1,FS_BOLD);
                    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

                    // Añadimos el texto del eje x y finalmente lo mostramos:

                    $graph->xaxis->SetTickLabels($datax);
                    $graph->Stroke("$nombreGrafico.png");
                    $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
                }
    }
    public function barrasgraficoPDFPromedioSepados($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL,$num){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            #obtenemos los datos del grafico 
            //    print_r($datos);
            foreach ($datos as $key){
                $datax[] = $key['mes'].'-'.$key['ani'];
                $datay[] = round(intval($key['num'])/intval($num),3);
                $dataz[] = $key['gru'];
            } 
            // print_r($datax);
            // print_r($datay);
            // $datax = array("Alemania", "España", "Francia", "Italia", "Reino Unido");
            // $datay = array(43267, 22368, 37644, 32949, 39762);

            // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

            $graph = new Graph(500,200,"auto");
            $graph->SetScale("textlin");

            // Establecemos los márgenes del gráfico y le añadimos una sombra por detrás:

            // $graph->img->SetMargin($ubicacionTamamo);
            $graph->img->SetMargin(50,100,20,40);
            $graph->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3];  
            // Creamos un objeto de gráfica de barras, decimos que su color sea naranja, que se muestre la leyenda y que añada esa gráfica al objeto general.

            $barra = new BarPlot($datay);
            // $barra1 = new BarPlot($dataz);
            $barra->SetFillColor("orange");
            $barra->SetLegend(implode(',',$dataz));
            $graph->legend->Pos(0.50,0.90);
            $graph->legend->SetShadow(false);
            $graph->Add($barra);
            // $graph->Add($barra1);
            // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

            $graph->title->Set("Reporte por meses");
            $graph->xaxis->title->Set("Mes - Gestion");
            $graph->title->SetFont(FF_FONT1,FS_BOLD);
            $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

            // Añadimos el texto del eje x y finalmente lo mostramos:

            $graph->xaxis->SetTickLabels($datax);
            // $graph->xaxis->SetTickLabels($dataz);
            $graph->Stroke("$nombreGrafico.png");
            $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
        }
    }
    public function barrasgraficoPDFPromedioAgrupadosTres($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL,$num){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            #obtenemos los datos del grafico 
            //    print_r($datos);
            $datax = array(); $dataz = array();
            foreach ($datos as $key){
                if(!in_array($key['mes'].'-'.$key['ani'], $datax)){
                    $datax[] = $key['mes'].'-'.$key['ani'];
                }
                if(!in_array($key['gru'], $dataz)){
                    $dataz[] = $key['gru'];
                }
            } 
            // echo "<br>";
            asort($dataz);
            // echo "<br>";
            // print_r($datax);
            $completos = array();
            foreach ($datax as $keyx) {
                foreach ($dataz as $keyz) {
                    $auxiliark['llave'] = $keyx.'-'.$keyz;
                    $auxiliark['valor'] = 0;
                    $completos[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($completos); 
            $comval = array();
            foreach ($completos as $keyc) {
                $sw = 0;
                foreach ($datos as $key) {
                    if(in_array($keyc['llave'], $key)){
                        $auxiliark['llave'] = $keyc['llave'];
                        $auxiliark['valor'] = $key['num'];
                        $comval[] = $auxiliark;
                        $sw = 1;
                        break;
                    }
                }
                if($sw == 0){
                    $auxiliark['llave'] = $keyc['llave'];
                    $auxiliark['valor'] = 0;
                    $comval[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($comval); 
            $sw1 = true;  $sw2 = false;
            for ($i=0; $i < sizeof($comval) ; $i++) { 
                if($sw1){
                    $data1[] = $comval[$i]['valor']; $sw1 = false; $sw2 = true;
                }elseif($sw2){
                    $data2[] = $comval[$i]['valor']; $sw1 = false; $sw2 = false;
                }else{
                    $data3[] = $comval[$i]['valor']; $sw1 = true;  $sw2 = false;
                }
            }
            // echo "<br>";
            // print_r($data1);
            // echo "<br>";
            // print_r($data2);
            // echo "<br>";
            // print_r($data3);
            // print_r($dataz);
            // $datax = array("Alemania", "España", "Francia", "Italia", "Reino Unido");
            // $datay = array(43267, 22368, 37644, 32949, 39762);

            // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

            $grafica = new Graph(500, 400);
            $grafica->img->SetMargin(50,50,20,10);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");

            //Asigna el titulo al grafico
            $grafica->title->Set($titulo);

            //Asigna el titulo al eje x
            $grafica->xaxis->SetTitle("Mes - Gestion","middle");

            //Asigna el titulo y alineacion al eje y
            $grafica->yaxis->SetTitle("Promedios","middle");


            //Asigna las etiquetas para los valores del eje x
            $grafica->xaxis->SetTickLabels($datax);

            //crea una serie para un grafico de barras
            $grupo1 = new BarPlot($data1);

            //asigna la leyenda para la serie grupo1
            $grupo1->SetLegend("Grupo 1");

            //asigna el color de relleno de las barras en formato hexadecimal
            $grupo1->SetFillColor("#E234A9");

            //crea una serie para el grafico de barras
            $grupo2 = new BarPlot($data2);

            //asigna la leyenda para la serie grupo2
            $grupo2->SetLegend("Grupo 2");

            //asigna el color de relleno de las barras con el nombre del color
            $grupo2->SetFillColor("blue");

            //crea una serie para el grafico de barras
            $grupo3 = new BarPlot($data3);

            //asigna la leyenda para la serie grupo3
            $grupo3->SetLegend("Grupo 3");

            /*asigna el color de relleno de las barras, en este caso un relleno
            degradado vertical que va de naranja a rojo, los tipos de degradado
            los encuentras en la documentación*/
            $grupo3->SetFillgradient('orange','red',GRAD_VER); 

            // agrupa las series del grafico
            $materias = new GroupBarPlot(array($grupo1,$grupo2,$grupo3));

            //agrega al grafico el grupo de series
            $grafica->Add($materias);
            // $graph->xaxis->SetTickLabels($dataz);
            $grafica->Stroke("$nombreGrafico.png");
            $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
        }
    }
    public function barrasgraficoPDFAgrupadoPares($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            #obtenemos los datos del grafico 
            //    print_r($datos);
            $datax = array(); $dataz = array();
            foreach ($datos as $key){
                if(!in_array($key['mes'].'-'.$key['ani'], $datax)){
                    $datax[] = $key['mes'].'-'.$key['ani'];
                }
                if(!in_array($key['tip'], $dataz)){
                    $dataz[] = $key['tip'];
                }
            } 
            // echo "<br>";
            asort($dataz);
            // echo "<br>";
            // print_r($datax);
            $completos = array();
            foreach ($datax as $keyx) {
                foreach ($dataz as $keyz) {
                    $auxiliark['llave'] = $keyx.'-'.$keyz;
                    $auxiliark['valor'] = 0;
                    $completos[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($completos); 
            $comval = array();
            foreach ($completos as $keyc) {
                $sw = 0;
                foreach ($datos as $key) {
                    if(in_array($keyc['llave'], $key)){
                        $auxiliark['llave'] = $keyc['llave'];
                        $auxiliark['valor'] = $key['num'];
                        $comval[] = $auxiliark;
                        $sw = 1;
                        break;
                    }
                }
                if($sw == 0){
                    $auxiliark['llave'] = $keyc['llave'];
                    $auxiliark['valor'] = 0;
                    $comval[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($comval); 
            $sw1 = true;
            for ($i=0; $i < sizeof($comval) ; $i++) { 
                if($sw1){
                    $data1[] = $comval[$i]['valor']; $sw1 = false;
                }else{
                    $data2[] = $comval[$i]['valor']; $sw1 = true;
                }
            }

            $grafica = new Graph(700, 500);
            $grafica->img->SetMargin(50,50,20,10);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");
            //Asigna el titulo al grafico
            $grafica->title->Set($titulo);
            //Asigna el titulo al eje x
            $grafica->xaxis->SetTitle("Mes - Gestion","middle");
            //Asigna el titulo y alineacion al eje y
            $grafica->yaxis->SetTitle("Nº de Soluciones","middle");
            //Asigna las etiquetas para los valores del eje x
            $grafica->xaxis->SetTickLabels($datax);
            //crea una serie para un grafico de barras
            $grupo1 = new BarPlot($data1);
            $grupo1->SetColor("red");
            $grupo1->SetLegend("Remoto");
            // $grupo1->SetFillGradient("red", "blue", GRAD_HOR);
            
            //crea una serie para el grafico de barras
            $grupo2 = new BarPlot($data2);
            $grupo2->SetColor("#137549");
            $grupo2->SetLegend("Visita al sitio");
            // $grupo2->SetFillGradient("#137549", "green", GRAD_HOR);

            $materias = new GroupBarPlot(array($grupo1,$grupo2));

            //agrega al grafico el grupo de series
            $grafica->Add($materias);
            // $graph->xaxis->SetTickLabels($dataz);
            $grafica->legend->SetFrameWeight(1);
            $grafica->Stroke("$nombreGrafico.png");
            $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
        }
    }
}

if(isset($_POST['fechaini']) && isset($_POST['fechafin'])){
    $idregion = intval($_POST['idregion']);
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
    $tipotrab = $_POST['tipotrab'];
    $regional = $_POST['regional'];
    $casogrup = intval($_POST['casogrup']);
    $casopcio = intval($_POST['casopcio']);
// echo $idregion."<>".$fechaini."<>".$fechafin."<>".$tipotrab."<>".$regional."<>".$casogrup."<>".$casopcio;
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
                    $n = 0;

                        foreach ($listas as $key) {
                            $meye = date_format($key['start'],'m-Y');
                            $idre = $key['idRegional'];
                            $valor = $meye;
                            if(intval($key['idFormulario'])>0){
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] += 1;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    $contador[$n] = $valor;
                                    $auxiliar['mes'] = date_format($key['start'],'m');
                                    $auxiliar['ani'] = date_format($key['start'],'Y');
                                    $auxiliar['num'] = 1;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }
                            }
                        }
                        // print_r($todos);
                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            $pdf->Cell(0,10,"Cantidad de correctivos realizados por mes",0,1);
                            $pdf->barrasgraficoPDF($todos,'ReportePdf',array(50,30,100,50),'Barras');
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
                                    $auxiliar['num'] += 1;
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
                        // print_r($grupos);
                        // print_r($contador);
                        // print_r($todos);
                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        // $pdf->Cell(0,8,"$sql_consulta",0,1);
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            $pdf->Cell(0,10,"Cantidad de correctivos realizados por mes promedio",0,1);
                            if(sizeof($grupos) == 3){
                                $pdf->barrasgraficoPDFPromedioAgrupadosTres($todos,'ReportePdf',array(50,30,120,70),'Barras',$numcasos);
                            }else{
                                $pdf->Cell(0,5,"FALTAN DATOS DE LOS GRUPOS: ",0,1,'C');
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
                                    $auxiliar['num'] += 1;
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
                            $pdf->Cell(0,10,"Cantidad de correctivos realizados por tipo de solución",0,1);
                            if(sizeof($casos) == 2){
                                $pdf->barrasgraficoPDFAgrupadoPares($todos,'ReportePdf',array(50,30,120,70),'VISITA Y REMOTO');
                            }else{
                                if($casos[0] == 'REMOTO'){
                                    $pdf->barrasgraficoPDF($todos,'ReportePdf',array(50,30,120,70),$casos[0]);
                                }else{
                                    $pdf->barrasgraficoPDF($todos,'ReportePdf',array(50,30,120,70),$casos[0]);
                                }
                            }
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
                        }
                break;
                    
                case 4:

                    $sql_consulta = "SELECT tc.idEstacion,tc.title,tc.idUsuarioEntel,tc.start,tc.hora,tc.justificativo,tf.ini_intervalo,tf.fin_intervalo,tc.grupo FROM tblSolicitudCorrectivos tc, tblEstaciones te, tblFormulario tf WHERE tc.idFormulario = tf.idFormulario AND (tc.start BETWEEN '$fechaini' AND '$fechafin') AND tc.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tc.start ASC;";
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
                        $FechaI = $key['ini_intervalo'];
                        $FechaI = str_replace("/", "-", $FechaI);
                        $FechaF =  $key['fin_intervalo'];
                        $FechaF = str_replace("/", "-", $FechaF);
                        
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
                    $pdf->Cell(0,10,"Correctivos atendidos en plazo y fuera de plazo",0,1);
                    $pdf->graficoPDF(array('Con justificacion ('.$n_j.')'=>array($n_j,'red'),'En el plazo ('.$n_ep.')'=>array($n_ep,'blue'),'Fuera del plazo ('.$n_fp.')'=>array($n_fp,'gray')),'ReportePdf',array(20,30,120,80),'Grafica % correctivos');
                break;
                default:

                // $sql_consulta = "SELECT SUM(tmp.total) as total_fallas, tmp.equipos FROM (
                //     SELECT tmp.equipo_1 as equipos,COUNT(tmp.equipo_1) as total 
                //     from (select tf.equipo_1 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='2020-08-01' and tsc.fechafin<='2020-12-30') tmp
                //     WHERE tmp.equipo_1 !='' GROUP BY tmp.equipo_1
                //     UNION
                //     SELECT tmp.equipo_2 as equipos,COUNT(tmp.equipo_2) as total 
                //     from (select tf.equipo_2 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='2020-08-01' and tsc.fechafin<='2020-12-30') tmp
                //     WHERE tmp.equipo_2 !='' GROUP BY tmp.equipo_2
                //     UNION
                //     SELECT tmp.equipo_3 as equipos,COUNT(tmp.equipo_3) as total 
                //     from (select tf.equipo_3 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='2020-08-01' and tsc.fechafin<='2020-12-30') tmp
                //     WHERE tmp.equipo_3 !='' GROUP BY tmp.equipo_3
                //     UNION
                //     SELECT tmp.equipo_4 as equipos,COUNT(tmp.equipo_4) as total 
                //     from (select tf.equipo_4 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='2020-08-01' and tsc.fechafin<='2020-12-30') tmp
                //     WHERE tmp.equipo_4 !='' GROUP BY tmp.equipo_4
                //     UNION
                //     SELECT tmp.equipo_5 as equipos,COUNT(tmp.equipo_5) as total 
                //     from (select tf.equipo_5 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='2020-08-01' and tsc.fechafin<='2020-12-30') tmp
                //     WHERE tmp.equipo_5 !='' GROUP BY tmp.equipo_5) as tmp GROUP BY tmp.equipos;";

                // echo $sql_consulta;
                // $ejecutar = sqlsrv_query($con, $sql_consulta);
                // $row_count = sqlsrv_has_rows( $ejecutar);
                // $listas = array();
                // if ($row_count === false){
        
                // }else{
                //     while($row =sqlsrv_fetch_array($ejecutar)) {
                //         $listas[]=$row;
                //     } 
                // }
                // $todos= array();
                // $contador = array();
                // $n = 0;
                // foreach ($listas as $key) {
                //     $meye = date_format($key['start'],'m-Y');
                //     $idre = $key['idRegional'];
                //     $grupo = $key['grupo'];
                //     $valor = $meye.'-'.$idre.$grupo;
                //     $valoraux = $meye.'-'.$grupo;
                //     if(intval($key['idFormulario'])>0){
                //         if(in_array($valor,$contador)){
                //             $clave = array_search($valor, $contador);
                //             $auxiliar['mes'] = date_format($key['start'],'m');
                //             $auxiliar['ani'] = date_format($key['start'],'Y');
                //             $auxiliar['gru'] = $grupo;
                //             $auxiliar['num'] += 1;
                //             $auxiliar['lor'] = $valoraux;
                //             $todos[$clave] = $auxiliar;
                //         }else{
                //             $contador[$n] = $valor;
                //             $valor = $meye.'-'.$grupo;
                //             $auxiliar['mes'] = date_format($key['start'],'m');
                //             $auxiliar['ani'] = date_format($key['start'],'Y');
                //             $auxiliar['gru'] = $grupo;
                //             $auxiliar['num'] = 1;
                //             $auxiliar['lor'] = $valoraux;
                //             $todos[$n] = $auxiliar;
                //             $n += 1;
                //         }
                //     }
                // }
                // // print_r($contador);
                // // print_r($todos);
                // $pdf=new Reporte();//creamos el documento pdf
                // $pdf->AddPage();//agregamos la pagina
                // $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                // $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                // // $pdf->Cell(0,8,"$sql_consulta",0,1);
                // $pdf->SetFont("Times","",12);
                // $pdf->barrasgraficoPDFPromedioAgrupadosTres($todos,'ReportePdf',array(50,30,120,70),'Barras',$numcasos);
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
                    
                        foreach ($listas as $key) {
                            $meye = date_format($key['fechaInicio'],'m-Y');
                            $idre = $key['idRegional'];
                            $valor = $meye;
                            if(intval($key['idFormulario'])>0){
                                if(in_array($valor,$contador)){
                                    $clave = array_search($valor, $contador);
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['num'] += 1;
                                    $todos[$clave] = $auxiliar;
                                }else{
                                    $contador[$n] = $valor;
                                    $auxiliar['mes'] = date_format($key['fechaInicio'],'m');
                                    $auxiliar['ani'] = date_format($key['fechaInicio'],'Y');
                                    $auxiliar['num'] = 1;
                                    $todos[$n] = $auxiliar;
                                    $n += 1;
                                }
                            }
                            
                        }
                        // print_r($todos);
                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            $pdf->Cell(0,10,"Cantidad de preventivos realizados por mes",0,1);
                            $pdf->barrasgraficoPDF($todos,'ReportePdf',array(50,30,100,50),'Barras');
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS: ",0,1,'C');
                        }
                break;
                default:
                    $ini = explode('-',$fechaini);
                    $fin = explode('-',$fechafin);
                    $numcasos = intval($fin[1]) - intval($ini[1]);
                    $sql_consulta = "SELECT tp.*,te.* FROM tblPreventivo tp, tblEstaciones te WHERE (tp.fechaInicio BETWEEN '$fechaini' AND '$fechafin') AND tp.idEstacion = te.idEstacion $caso_por_region $caso_por_grupo ORDER BY tp.fechaInicio ASC;";
                    echo $sql_consulta;
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
                                    $auxiliar['num'] += 1;
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
                        // print_r($contador);
                        // print_r($todos);
                        $pdf=new Reporte();//creamos el documento pdf
                        $pdf->AddPage();//agregamos la pagina
                        $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
                        $pdf->Cell(0,5,"GRAFICO: ".$tipotrab.", ".$regional,0,1,'C');
                        // $pdf->Cell(0,8,"$sql_consulta",0,1);
                        $pdf->SetFont("Times","",12);
                        if(sizeof($listas)>0){
                            if(sizeof($grupos) == 3){
                                $pdf->Cell(0,10,"Cantidad de preventivos realizados por mes promedio",0,1);
                                $pdf->barrasgraficoPDFPromedioAgrupadosTres($todos,'ReportePdf',array(50,30,120,70),'Barras',$numcasos);
                            }else{
                                $pdf->Cell(0,5,"FALTAN DATOS: ",0,1,'C');
                            }
                        }else{
                            $pdf->Cell(0,5,"SIN DATOS: ",0,1,'C');
                        }
                break;
            }
            break;
        case 'EXTRACANON':
            # code...
            break;
        default:
            # code...
            break;
    }
    // $pdf=new Reporte();//creamos el documento pdf
    // $pdf->AddPage();//agregamos la pagina
    // $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
    $pdfString = $pdf->Output();
    $pdfBase64 = base64_encode($pdfString);
    echo 'data:application/pdf;base64,' . $pdfBase64;
}else{
    $pdf=new Reporte();//creamos el documento pdf
    $pdf->AddPage();//agregamos la pagina
    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
    $pdf->Cell(0,5," GRAFICO ",0,1,'C');
    $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
    // $pdf->Output(); 
    $pdfString = $pdf->Output();
    $pdfBase64 = base64_encode($pdfString);
    echo 'data:application/pdf;base64,' . $pdfBase64;
}

?>