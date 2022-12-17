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
require_once("../jpgraph-4.3.4/src/jpgraph_line.php");
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

                    $var=0;
                    $aux=0;
                    $aux2=0;
                    foreach ($datos as $key){
                        $datax[] = $key['equipo'];
                        $datay[] =$key['total'];                       
                    } 

                    $maximo=max($datay);
                    $tamaño=sizeof($datay);

                    for ($i=0; $i < $tamaño; $i++) { 

                            if($i==0){
                                $total=$maximo;
                                $datan[]=$total;
                            }else{

                                $total=$total+$datay[$i];
                                $datan[]=$total;

                            }
                    }


                    $lineplot = new LinePlot($datan);
                    $lineplot->SetColor("green");
                    $lineplot->SetWeight(2);
                    // print_r($datax);
                    // print_r($datay);
                    // $datax = array("Alemania", "España", "Francia", "Italia", "Reino Unido");
                    // $datay = array(43267, 22368, 37644, 32949, 39762);

                    // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

                    $graph = new Graph(500,300,"auto");
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
                    $graph->Add($lineplot);

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

if(isset($_POST['fechaini_2']) && isset($_POST['fechafin_2'])){
    $tipo_excel = $_POST['tipo_excel'];
    $fechaini = $_POST['fechaini_2'];
    $fechafin = $_POST['fechafin_2'];
    // $regional="prueba";
 
    if($tipo_excel=="CORRECTIVO"){

                    $sql="SELECT * FROM (
                                SELECT SUM(tmp.total) as total, tmp.equipos FROM (
                                SELECT tmp.marca_modelo2_1 as equipos,COUNT(tmp.marca_modelo2_1) as total 
                                from (select tf.marca_modelo2_1 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='$fechaini' and tsc.fechafin<='$fechafin') tmp
                                WHERE tmp.marca_modelo2_1 !='' GROUP BY tmp.marca_modelo2_1
                                UNION ALL
                                SELECT tmp.marca_modelo2_2 as equipos,COUNT(tmp.marca_modelo2_2) as total 
                                from (select tf.marca_modelo2_2 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='$fechaini' and tsc.fechafin<='$fechafin') tmp
                                WHERE tmp.marca_modelo2_2 !='' GROUP BY tmp.marca_modelo2_2
                                UNION ALL
                                SELECT tmp.marca_modelo2_3 as equipos,COUNT(tmp.marca_modelo2_3) as total 
                                from (select tf.marca_modelo2_3 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='$fechaini' and tsc.fechafin<='$fechafin') tmp
                                WHERE tmp.marca_modelo2_3 !='' GROUP BY tmp.marca_modelo2_3
                                UNION ALL
                                SELECT tmp.marca_modelo2_4 as equipos,COUNT(tmp.marca_modelo2_4) as total 
                                from (select tf.marca_modelo2_4 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='$fechaini' and tsc.fechafin<='$fechafin') tmp
                                WHERE tmp.marca_modelo2_4 !='' GROUP BY tmp.marca_modelo2_4
                                UNION ALL
                                SELECT tmp.marca_modelo2_5 as equipos,COUNT(tmp.marca_modelo2_5) as total 
                                from (select tf.marca_modelo2_5 from tblFormulario tf,tblSolicitudCorrectivos tsc where tf.idFormulario=tsc.idFormulario and tsc.start>='$fechaini' and tsc.fechafin<='$fechafin') tmp
                                WHERE tmp.marca_modelo2_5 !='' GROUP BY tmp.marca_modelo2_5) as tmp GROUP BY tmp.equipos
                                ) tmp ORDER BY tmp.total DESC
                        ";
    }else if($tipo_excel=="PREVENTIVO"){
                        $sql="SELECT * FROM (
                                    SELECT SUM(tmp.total) as total, tmp.equipos FROM (
                                    SELECT tmp.marca_modelo2_1 as equipos,COUNT(tmp.marca_modelo2_1) as total 
                                    from (select tf.marca_modelo2_1 from tblFormulario tf,tblPreventivo tp where tf.idFormulario=tp.idFormulario and tp.fechaInicio>='$fechaini' and tp.fechaFinal<='$fechafin') tmp
                                    WHERE tmp.marca_modelo2_1 !='' GROUP BY tmp.marca_modelo2_1
                                    UNION ALL
                                    SELECT tmp.marca_modelo2_2 as equipos,COUNT(tmp.marca_modelo2_2) as total 
                                    from (select tf.marca_modelo2_2 from tblFormulario tf,tblPreventivo tp where tf.idFormulario=tp.idFormulario and tp.fechaInicio>='$fechaini' and tp.fechaFinal<='$fechafin') tmp
                                    WHERE tmp.marca_modelo2_2 !='' GROUP BY tmp.marca_modelo2_2
                                    UNION ALL
                                    SELECT tmp.marca_modelo2_3 as equipos,COUNT(tmp.marca_modelo2_3) as total 
                                    from (select tf.marca_modelo2_3 from tblFormulario tf,tblPreventivo tp where tf.idFormulario=tp.idFormulario and tp.fechaInicio>='$fechaini' and tp.fechaFinal<='$fechafin') tmp
                                    WHERE tmp.marca_modelo2_3 !='' GROUP BY tmp.marca_modelo2_3
                                    UNION ALL
                                    SELECT tmp.marca_modelo2_4 as equipos,COUNT(tmp.marca_modelo2_4) as total 
                                    from (select tf.marca_modelo2_4 from tblFormulario tf,tblPreventivo tp where tf.idFormulario=tp.idFormulario and tp.fechaInicio>='$fechaini' and tp.fechaFinal<='$fechafin') tmp
                                    WHERE tmp.marca_modelo2_4 !='' GROUP BY tmp.marca_modelo2_4
                                    UNION ALL
                                    SELECT tmp.marca_modelo2_5 as equipos,COUNT(tmp.marca_modelo2_5) as total 
                                    from (select tf.marca_modelo2_5 from tblFormulario tf,tblPreventivo tp where tf.idFormulario=tp.idFormulario and tp.fechaInicio>='$fechaini' and tp.fechaFinal<='$fechafin') tmp
                                    WHERE tmp.marca_modelo2_5 !='' GROUP BY tmp.marca_modelo2_5) as tmp GROUP BY tmp.equipos
                            ) tmp ORDER BY tmp.total DESC
                            ";
     }else if($tipo_excel=="EXTRACANNON"){
                    $sql="SELECT * FROM (
                            SELECT SUM(tmp.total) as total, tmp.equipos FROM (
                            SELECT tmp.marca_modelo2_1 as equipos,COUNT(tmp.marca_modelo2_1) as total 
                            from (select tf.marca_modelo2_1 from tblFormulario tf,tblExtraCanon tex where tf.idFormulario=tex.idFormulario and tex.fechaInicio>='$fechaini' and tex.fechaFinal<='$fechafin') tmp
                            WHERE tmp.marca_modelo2_1 !='' GROUP BY tmp.marca_modelo2_1
                            UNION ALL
                            SELECT tmp.marca_modelo2_2 as equipos,COUNT(tmp.marca_modelo2_2) as total 
                            from (select tf.marca_modelo2_2 from tblFormulario tf,tblExtraCanon tex where tf.idFormulario=tex.idFormulario and tex.fechaInicio>='$fechaini' and tex.fechaFinal<='$fechafin') tmp
                            WHERE tmp.marca_modelo2_2 !='' GROUP BY tmp.marca_modelo2_2
                            UNION ALL
                            SELECT tmp.marca_modelo2_3 as equipos,COUNT(tmp.marca_modelo2_3) as total 
                            from (select tf.marca_modelo2_3 from tblFormulario tf,tblExtraCanon tex where tf.idFormulario=tex.idFormulario and tex.fechaInicio>='$fechaini' and tex.fechaFinal<='$fechafin') tmp
                            WHERE tmp.marca_modelo2_3 !='' GROUP BY tmp.marca_modelo2_3
                            UNION ALL
                            SELECT tmp.marca_modelo2_4 as equipos,COUNT(tmp.marca_modelo2_4) as total 
                            from (select tf.marca_modelo2_4 from tblFormulario tf,tblExtraCanon tex where tf.idFormulario=tex.idFormulario and tex.fechaInicio>='$fechaini' and tex.fechaFinal<='$fechafin') tmp
                            WHERE tmp.marca_modelo2_4 !='' GROUP BY tmp.marca_modelo2_4
                            UNION ALL
                            SELECT tmp.marca_modelo2_5 as equipos,COUNT(tmp.marca_modelo2_5) as total 
                            from (select tf.marca_modelo2_5 from tblFormulario tf,tblExtraCanon tex where tf.idFormulario=tex.idFormulario and tex.fechaInicio>='$fechaini' and tex.fechaFinal<='$fechafin') tmp
                            WHERE tmp.marca_modelo2_5 !='' GROUP BY tmp.marca_modelo2_5) as tmp GROUP BY tmp.equipos
                        ) tmp ORDER BY tmp.total DESC
                    ";
     }

          /*   $sql="SELECT equipo_1,COUNT(equipo_1) as total from tblFormulario WHERE equipo_1 !='' GROUP BY equipo_1 ORDER BY total DESC"; */
            $query=sqlsrv_query($con,$sql);
            $listas = array();
            while($row =sqlsrv_fetch_array($query)) {
                $listas[]=$row;  
            }
        
            $todos= array();
            $n=0;
            $auxiliar=[];
            foreach ($listas as $key) {

                    if($key['equipos']=="N/A"){

                    }else{
                        $auxiliar['equipo'] = $key['equipos'];
                        $auxiliar['total'] = $key['total'];
                        $todos[$n] = $auxiliar;
                        $n++;
                    }
                     
            }
            // print_r($todos);
            $pdf=new Reporte();//creamos el documento pdf
            $pdf->AddPage();//agregamos la pagina
            $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
            $pdf->Cell(0,5,"GRAFICO: ".$tipo_excel,0,1,'C');
            $pdf->SetFont("Times","",12);
            if(sizeof($auxiliar)>0){
                $pdf->barrasgraficoPDF($todos,'ReportePdf',array(50,30,100,50),'Barras');
            }else{
                $pdf->Cell(0,5,"SIN DATOS: ".$tipo_excel,0,0,'C');
            }

    
    $pdf->Output(); 
}else{

    $tipo_excel = intval($_POST['tipo_excel']);
    $fechaini = $_POST['fechaini_2'];
    $fechafin = $_POST['fechafin_2'];

    $pdf=new Reporte();//creamos el documento pdf
    $pdf->AddPage();//agregamos la pagina
    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
    $pdf->Cell(0,5," GRAFICO ",0,1,'C');
    $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
    $pdf->Output(); 
}

?>