
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
                    foreach ($datos as $key){
                        $datax[] = $key['equipo'];
                        $datay[] = $key['total']; 
                    } 

                   /*  $datos2 = array(3, 4, 5, 6); */
                    $lineplot = new LinePlot($datay);
                    $lineplot->SetColor("green");
                    $lineplot->SetWeight(2);
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
            $datax = array();
            $datay = array();
            $dataz = array();

         /*    print_r($datos); */

            foreach ($datos as $key){   

                    $datax[]=$key['mes'];
                    $datay[]=$key['si'];
                    $dataz[]=$key['no'];

            } 


   /*          print_r($datax); 
            print_r($datay);
            print_r($dataz);  */

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
            $grupo1 = new BarPlot($datay);
            $grupo1->SetColor("#137549");
            $grupo1->SetLegend("CON CORTE");
            // $grupo1->SetFillGradient("red", "blue", GRAD_HOR);
            
            //crea una serie para el grafico de barras
            $grupo2 = new BarPlot($dataz);
            $grupo2->SetColor("red");
            $grupo2->SetLegend("SIN CORTE");
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

    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
    $regional = $_POST['regional'];


    if($regional>0){

        $nombre_regional=$_POST['regional_nombre'];

        $sql="SELECT tempo1.ano,tempo1.mes,tempo2.[no],tempo3.si from 
        (select DISTINCT(MONTH(tp.fechaInicio)) as mes,YEAR(tp.fechaInicio) as ano from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' AND te.idRegional=$regional
        AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        GROUP BY MONTH(tp.fechaInicio),YEAR(tp.fechaInicio)
        UNION
        select DISTINCT(MONTH(tex.fechaInicio)) as mes,YEAR(tex.fechaInicio) as ano from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' AND te.idRegional=$regional
        AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        GROUP BY MONTH(tex.fechaInicio) ,YEAR(tex.fechaInicio)) 
        tempo1,
        (SELECT x1.mes,x2.[no] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' AND te.idRegional=$regional
        AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        GROUP BY MONTH(tp.fechaInicio)
        UNION
        select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' AND te.idRegional=$regional
        AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as no from 
        (select tmp.mes,count(tmp.mes) no FROM 
        (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' AND te.idRegional=$regional AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        ) tmp GROUP BY tmp.mes
        UNION ALL
        select tmp.mes,count(tmp.mes) no FROM 
        (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' AND te.idRegional=$regional AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        ) tmp GROUP BY tmp.mes)
         tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) 
         tempo2,
         (SELECT x1.mes,x2.[si] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE  tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' AND te.idRegional=$regional
        AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        GROUP BY MONTH(tp.fechaInicio)
        UNION
        select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE  tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' AND te.idRegional=$regional
        AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as si from 
        (select tmp.mes,count(tmp.mes) no FROM 
        (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' AND te.idRegional=$regional AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        ) tmp GROUP BY tmp.mes
        UNION ALL
        select tmp.mes,count(tmp.mes) no FROM 
        (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
        WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' AND te.idRegional=$regional AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
        ) tmp GROUP BY tmp.mes)
         tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) tempo3 WHERE tempo1.mes=tempo2.mes and tempo1.mes=tempo3.mes";



        $query=sqlsrv_query($con,$sql);
        $listas = array();

        $count=sqlsrv_has_rows($query);

        if($count!=false){
                while($row =sqlsrv_fetch_array($query)) {
                    $listas[]=$row;  
                }

                $todos= array();
                $n=0;
                foreach ($listas as $key) {
                    
                    $auxiliar['mes'] = $key['mes']." - ".$key['ano'];
                    $auxiliar['si'] = $key['si'];
                    $auxiliar['no'] = $key['no'];
                    $todos[$n] = $auxiliar;
                    $n++;
                }
        }



        $pdf=new Reporte();
        $pdf->AddPage();
        $pdf->SetFont("Arial","B",14);
        $pdf->Cell(0,5,"GRAFICO:  ".$nombre_regional." Cortes por mora",0,1,'C');
        $pdf->SetFont("Times","",12);
        if (sizeof($listas)>0) {
                $pdf->barrasgraficoPDFAgrupadoPares($todos,'ReportePdf',array(50,30,120,70),'');
    
        }else{
            $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
        } 


    }else{

            $sql="SELECT tempo1.ano,tempo1.mes,tempo2.[no],tempo3.si from 
            (select DISTINCT(MONTH(tp.fechaInicio)) as mes,YEAR(tp.fechaInicio) as ano from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio),YEAR(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes,YEAR(tex.fechaInicio) as ano from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio),YEAR(tex.fechaInicio)) 
            
            tempo1,
            (SELECT x1.mes,x2.[no] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as no from 
            (select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes
            UNION ALL
            select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes)
             tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) tempo2,(SELECT x1.mes,x2.[si] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE  tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE  tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as si from 
            (select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tp.fechaInicio>=' $fechaini' and tp.fechaInicio<='$fechafin' AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes
            UNION ALL
            select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tex.fechaInicio>=' $fechaini' and tex.fechaInicio<='$fechafin' AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes)
             tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) tempo3 WHERE tempo1.mes=tempo2.mes and tempo1.mes=tempo3.mes";

        

            $query=sqlsrv_query($con,$sql);
            $listas = array();

            $count=sqlsrv_has_rows($query);

            if($count!=false){
                    while($row =sqlsrv_fetch_array($query)) {
                        $listas[]=$row;  
                    }

                    $todos= array();
                    $n=0;
                    foreach ($listas as $key) {
                        
                        $auxiliar['mes'] = $key['mes']." - ".$key['ano'];
                        $auxiliar['si'] = $key['si'];
                        $auxiliar['no'] = $key['no'];
                        $todos[$n] = $auxiliar;
                        $n++;
                    }
            }



            $pdf=new Reporte();
            $pdf->AddPage();
            $pdf->SetFont("Arial","B",14);
            $pdf->Cell(0,5,"GRAFICO: Todos los registros Cortes por mora",0,1,'C');
            $pdf->SetFont("Times","",12);
            if (sizeof($listas)>0) {
                    $pdf->barrasgraficoPDFAgrupadoPares($todos,'ReportePdf',array(50,30,120,70),'');
        
            }else{
                $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
            }  
    }


 
    $pdf->Output();  
}else{
    $pdf=new Reporte();//creamos el documento pdf
    $pdf->AddPage();//agregamos la pagina
    $pdf->SetFont("Arial","B",14);//establecemos propiedades del texto tipo de letra, negrita, tamaño
    $pdf->Cell(0,5," GRAFICO ",0,1,'C');
    $pdf->Cell(0,5,"SIN DATOS",0,1,'C');
    $pdf->Output(); 
}

?>


<!-- SELECT tempo1.mes,tempo2.[no],tempo3.si from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tp.fechaInicio>='2020-01-01' and tp.fechaInicio<='2020-01-02' 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tex.fechaInicio>='2020-01-01' and tex.fechaInicio<='2020-01-02' 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio) ) tempo1,(SELECT x1.mes,x2.[no] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tp.fechaInicio>='2020-01-01' and tp.fechaInicio<='2020-01-02' 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo AND tex.fechaInicio>='2020-01-01' and tex.fechaInicio<='2020-01-02' 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as no from 
            (select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tp.fechaInicio>='2020-01-01' and tp.fechaInicio<='2020-01-02' AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes
            UNION ALL
            select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tex.fechaInicio>='2020-01-01' and tex.fechaInicio<='2020-01-02' AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes)
             tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) tempo2,(SELECT x1.mes,x2.[si] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE  tc.idCampo=td.idCampo AND tp.fechaInicio>='2020-01-01' and tp.fechaInicio<='2020-01-02' 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE  tc.idCampo=td.idCampo AND tex.fechaInicio>='2020-01-01' and tex.fechaInicio<='2020-01-02' 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as si from 
            (select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tp.fechaInicio>='2020-01-01' and tp.fechaInicio<='2020-01-02' AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes
            UNION ALL
            select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tex.fechaInicio>='2020-01-01' and tex.fechaInicio<='2020-01-02' AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes)
             tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) tempo3 WHERE tempo1.mes=tempo2.mes and tempo1.mes=tempo3.mes -->


             <?php
             
    /*          
            $sql="SELECT tempo1.ano,tempo1.mes,tempo2.[no],tempo3.si from 
            (select DISTINCT(MONTH(tp.fechaInicio)) as mes,YEAR(tp.fechaInicio) as ano from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio),YEAR(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes,YEAR(tex.fechaInicio) as ano from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio),YEAR(tex.fechaInicio)) 
            
            tempo1,
            (SELECT x1.mes,x2.[no] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE tc.idCampo=td.idCampo 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as no from 
            (select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes
            UNION ALL
            select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes)
             tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) tempo2,(SELECT x1.mes,x2.[si] from (select DISTINCT(MONTH(tp.fechaInicio)) as mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE  tc.idCampo=td.idCampo 
            AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tp.fechaInicio)
            UNION
            select DISTINCT(MONTH(tex.fechaInicio)) as mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE  tc.idCampo=td.idCampo 
            AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            GROUP BY MONTH(tex.fechaInicio)) x1 LEFT JOIN (select tmp1.mes,sum(tmp1.[no]) as si from 
            (select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tp.fechaInicio,MONTH(tp.fechaInicio) AS mes from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes
            UNION ALL
            select tmp.mes,count(tmp.mes) no FROM 
            (select te.idRegional,td.dato,tex.fechaInicio,MONTH(tex.fechaInicio) AS mes from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
            WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
            ) tmp GROUP BY tmp.mes)
             tmp1 GROUP BY tmp1.mes) x2 ON x1.mes=x2.mes) tempo3 WHERE tempo1.mes=tempo2.mes and tempo1.mes=tempo3.mes"; */
             ?>