<?php
function que_mes($valor){
    switch (intval($valor)) {
        case 1:
                $mes = "ENERO";
            break;
        case 2:
                $mes = "FEBRERO";
            break;
        case 3:
                $mes = "MARZO";
            break;
        case 4:
                $mes = "ABRIL";
            break;
        case 5:
                $mes = "MAYO";
            break;
        case 6:
                $mes = "JUNIO";
            break;
        case 7:
                $mes = "JULIO";
            break;
        case 8:
                $mes = "AGOSTO";
            break;
        case 9:
                $mes = "SEPTIEMBRE";
            break;
        case 10:
                $mes = "OCTUBRE";
            break;
        case 11:
                $mes = "NOVIEMBRE";
            break;
        case 12:
                $mes = "DICIEMBRE";
            break;
        default:
                $mes = "ND DIFINIDO";
            break;
    }
    return $mes;
}
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
    public function barrasgraficoPDF($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL,$valorp = NULL){
                //construccion de los arrays de los ejes x e y
                if(!is_array($datos) || !is_array($ubicacionTamamo)){
                    echo "los datos del grafico y la ubicacion deben de ser arreglos";
                }
                elseif($nombreGrafico == NULL){
                    echo "debe indicar el nombre del grafico a crear";
                } else{
                    #obtenemos los datos del grafico 
                    //    print_r($datos);
                    $nombreGrafico01 = 'ReportePdf01';
                    $casos = 0;
                    $promedioy = array(); $promediox = array(); $valor = 0;
                    foreach ($datos as $key){
                        $datax[] = $key['mes'].'-'.$key['ani'];
                        $datay[] = $key['num'];
                        $casos += $key['num'];
                        if($valor < intval($key['num']) && $valorp == 'promedio'){
                            $promedioy[0] = $key['num'];
                            $valor = $key['num'];
                        }
                    } 
                    if($valorp == 'promedio'){
                        $promediox[0] = round(floatval($casos / sizeof($datax)),3);
                    }
                    
                    // print_r($datax);
                    // print_r($datay);
                    // $datax = array("Alemania", "España", "Francia", "Italia", "Reino Unido");
                    // $datay = array(43267, 22368, 37644, 32949, 39762);

                    // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

                    $graph = new Graph(800,650,"auto");
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
                    // $graph->legend->Pos(0.03,0.90);
                    // $graph->legend->SetShadow(false);
                    $graph->Add($barra);

                    // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

                    $graph->title->Set($titulo);
                    $graph->xaxis->title->Set("Mes - Gestion");
                    $graph->title->SetFont(FF_FONT1,FS_BOLD);
                    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

                    // Añadimos el texto del eje x y finalmente lo mostramos:

                    $graph->xaxis->SetTickLabels($datax);
                    $graph->Stroke("$nombreGrafico.png");
                    if($valorp == 'promedio'){
                        // grafico # 2
                        $graph01 = new Graph(800,650,"auto");
                        $graph01->SetScale("textlin");

                        // Establecemos los márgenes del gráfico y le añadimos una sombra por detrás:

                        // $graph->img->SetMargin($ubicacionTamamo);
                        $graph01->img->SetMargin(50,100,20,40);
                        $graph01->SetShadow();
                        $x = $ubicacionTamamo[0];
                        $y = $ubicacionTamamo[1]; 
                        $ancho = $ubicacionTamamo[2];
                        $altura = $ubicacionTamamo[3];
                        // Creamos un objeto de gráfica de barras, decimos que su color sea naranja, que se muestre la leyenda y que añada esa gráfica al objeto general.

                        $barra01 = new BarPlot($promedioy);
                        $barra01->SetFillColor("orange");
                        // $barra->SetLegend($titulo);
                        // $graph->legend->Pos(0.03,0.90);
                        // $graph->legend->SetShadow(false);
                        $graph01->Add($barra01);

                        // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

                        $graph01->title->Set($titulo);
                        $graph01->xaxis->title->Set("Promedio");
                        $graph01->title->SetFont(FF_FONT1,FS_BOLD);
                        $graph01->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

                        // Añadimos el texto del eje x y finalmente lo mostramos:

                        $graph01->xaxis->SetTickLabels($promediox);
                        $graph01->Stroke("$nombreGrafico01.png");
                    }
                    $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
                    if($valorp == 'promedio'){
                        $this->Image("$nombreGrafico01.png",$x,$y+130,$ancho,$altura);
                    }
                    
                }
    }
    public function barrasgraficoPDF_v2($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
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
                        $datax[] = $key['meses'].'-'.$key['ano'];
                        $datay[] = $key['total']; 
                    } 

                    $graph = new Graph(900,650,"auto");
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
                    $barra->value->Show();

                    // Must use TTF fonts if we want text at an arbitrary angle
                    $barra->value->SetFont(FF_ARIAL,FS_BOLD);
                    $barra->value->SetAngle(45);

                    // Black color for positive values and darkred for negative values
                    $barra->value->SetColor("black","darkred");

                    $barra->SetFillColor("orange");
                    // $barra->SetLegend($titulo);
                    // $graph->legend->Pos(0.03,0.90);
                    // $graph->legend->SetShadow(false);
                    $graph->Add($barra);

                    // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

                    $graph->title->Set($titulo);
                    $graph->xaxis->title->Set("Mes - Gestion");
                    $graph->title->SetFont(FF_FONT1,FS_BOLD);
                    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
                    // Añadimos el texto del eje x y finalmente lo mostramos:
                    $graph->xaxis->SetTickLabels($datax);

                    $graph->Stroke("$nombreGrafico.png");
                    $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
                }
    }
    public function barrasgraficoPDF_v3($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
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
                    $datax[] = $key['meses'];
                    $datay[] = $key['total']; 
                } 

                $graph = new Graph(800,650,"auto");
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
                // $graph->legend->Pos(0.03,0.90);
                // $graph->legend->SetShadow(false);
                $graph->Add($barra);

                // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

                $graph->title->Set($titulo);
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
            $nombreGrafico01 = 'ReportePdf01';
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
            $valor01 = 0; $valor02 = 0; $valor03 = 0; $valorsuma01 = 0; $valorsuma02 = 0; $valorsuma03 = 0; $promedioy = array(); $promediox = array(); $puntero02 = 0; $puntero01 = 0; $puntero03 = 0;
            for ($i=0; $i < sizeof($comval) ; $i++) { 
                if($sw1){
                    $data1[] = $comval[$i]['valor']; $sw1 = false; $sw2 = true;

                    $valorsuma01 += $comval[$i]['valor'];
                    if($valor01 < intval($comval[$i]['valor'])){
                        $promedioy[0] = $comval[$i]['valor'];
                        $valor01 = $comval[$i]['valor'];
                    }
                    if(intval($comval[$i]['valor']) >0){
                        $puntero01 += 1;
                    }
                }elseif($sw2){
                    $data2[] = $comval[$i]['valor']; $sw1 = false; $sw2 = false;

                    $valorsuma02 += $comval[$i]['valor'];
                    if($valor02 < intval($comval[$i]['valor'])){
                        $promedioy[1] = $comval[$i]['valor'];
                        $valor02 = $comval[$i]['valor'];
                    }
                    if(intval($comval[$i]['valor']) >0){
                        $puntero02 += 1;
                    }
                }else{
                    $data3[] = $comval[$i]['valor']; $sw1 = true;  $sw2 = false;

                    $valorsuma03 += $comval[$i]['valor'];
                    if($valor03 < intval($comval[$i]['valor'])){
                        $promedioy[2] = $comval[$i]['valor'];
                        $valor03 = $comval[$i]['valor'];
                    }
                    if(intval($comval[$i]['valor']) >0){
                        $puntero03 += 1;
                    }
                }
            }
            // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

            $promediox[0] = round(floatval($valorsuma01 / $puntero01),3);
            $promediox[1] = round(floatval($valorsuma02 / $puntero02),3);
            $promediox[2] = round(floatval($valorsuma03 / $puntero03),3);

            $grafica = new Graph(800, 650);
            $grafica->img->SetMargin(80,100,20,60);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");

            $grafica->title->Set($titulo);
            $grafica->xaxis->SetTitle("Mes - Gestion");
            $grafica->yaxis->SetTitle("Promedios","middle");

            $grafica->xaxis->SetTickLabels($datax);
            $grupo1 = new BarPlot($data1);
            $grupo1->SetLegend("Grupo 1");
            $grupo1->SetFillColor("#E234A9");
            $grupo2 = new BarPlot($data2);
            $grupo2->SetLegend("Grupo 2");
            $grupo2->SetFillColor("blue");
            $grupo3 = new BarPlot($data3);
            $grupo3->SetLegend("Grupo 3");
            $grupo3->SetFillgradient('orange','red',GRAD_VER); 
            $materias = new GroupBarPlot(array($grupo1,$grupo2,$grupo3));
            $grafica->legend->SetFrameWeight(1);
            $grafica->legend->SetPos(0.3,0.99,'center','bottom');
            $grafica->Add($materias);
            // $graph->xaxis->SetTickLabels($dataz);
            $grafica->Stroke("$nombreGrafico.png");

            if(true){
                // grafico # 2
                $graph01 = new Graph(800,650,"auto");
                $graph01->SetScale("textlin");

                // Establecemos los márgenes del gráfico y le añadimos una sombra por detrás:

                // $graph->img->SetMargin($ubicacionTamamo);
                $graph01->img->SetMargin(50,100,20,40);
                $graph01->SetShadow();
                $x = $ubicacionTamamo[0];
                $y = $ubicacionTamamo[1]; 
                $ancho = $ubicacionTamamo[2];
                $altura = $ubicacionTamamo[3];
                // Creamos un objeto de gráfica de barras, decimos que su color sea naranja, que se muestre la leyenda y que añada esa gráfica al objeto general.

                $barra01 = new BarPlot($promedioy);
                $barra01->SetFillColor("orange");
                // $barra->SetLegend($titulo);
                // $graph->legend->Pos(0.03,0.90);
                // $graph->legend->SetShadow(false);
                $graph01->Add($barra01);

                // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

                $graph01->title->Set($titulo);
                $graph01->xaxis->title->Set("Promedio");
                $graph01->title->SetFont(FF_FONT1,FS_BOLD);
                $graph01->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

                // Añadimos el texto del eje x y finalmente lo mostramos:

                $graph01->xaxis->SetTickLabels($promediox);
                $graph01->Stroke("$nombreGrafico01.png");
            }
            $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
            if(true){
                $this->Image("$nombreGrafico01.png",$x,$y+120,$ancho,$altura);
            }
        }
    }
    public function barrasgraficoPDFAgrupadoPares($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$casos = array(),$titulo = NULL,$subtitulo = NULL){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            #obtenemos los datos del grafico 
            // print_r($datos);
            $datax = array(); $dataz = array();
            foreach ($datos as $key){
                if(!in_array($key['mes'].'-'.$key['ani'], $datax)){
                    $datax[] = $key['mes'].'-'.$key['ani'];
                }
            } 
            // echo "<br>";
            $dataz = $casos;
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
            asort($comval);
            // print_r($comval); 
            $data1 = array();
            $data2 = array();
            $sw1 = true;
            for ($i=0; $i < sizeof($comval) ; $i++) { 
                if($sw1){
                    $data1[] = $comval[$i]['valor']; $sw1 = false;
                }else{
                    $data2[] = $comval[$i]['valor']; $sw1 = true;
                }
            }

            $grafica = new Graph(800, 650);
            $grafica->img->SetMargin(50,100,20,50);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");
            $grafica->title->Set($titulo);
            $grafica->xaxis->SetTitle("Mes - Gestion");
            $grafica->yaxis->SetTitle($subtitulo,"middle");
            $grafica->xaxis->SetTickLabels($datax);
            $grupo1 = new BarPlot($data1);
            $grupo1->SetColor("red");
            $grupo1->SetLegend($dataz[1]);
            $grupo2 = new BarPlot($data2);
            $grupo2->SetColor("#137549");
            $grupo2->SetLegend($dataz[0]);
            $materias = new GroupBarPlot(array($grupo1,$grupo2));
            $grafica->Add($materias);
            $grafica->legend->SetFrameWeight(1);
            $grafica->legend->SetPos(0.3,0.99,'center','bottom');
            $grafica->Stroke("$nombreGrafico.png");
            $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
        }
    }
    public function graficoPDFdos($datos1 = array(),$datos2 = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo1 = NULL,$titulo2 = NULL){
        //construccion de los arrays de los ejes x e y
        if((!is_array($datos1) && !is_array($datos2) ) || !is_array($ubicacionTamamo)){
        echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
        echo "debe indicar el nombre del grafico a crear";
        } else{
            $nombre_graficos = array();
            for ($i=0; $i <25 ; $i++) { 
                if($i == 0){
                    $nombre_graficos[$i] = "ReportePdf.png";
                }elseif($i>0 && $i<10){
                    $nombre_graficos[$i] = "ReportePdf0".$i.".png";
                }else{
                    $nombre_graficos[$i] = "ReportePdf".$i.".png";
                }
            }
            // $grafica1 = $nombreGrafico.'01.png';
            // $grafica2 = $nombreGrafico.'02.png';

            foreach ($datos1 as $key){
                $data1[] = $key[0];
                $nombres1[] = $key[2]; 
                $color1[] = $key[1];
            } 

            $datax = array(); // fechas
            $deptos = array(); // tipos de fallas
            $idcamps = array(); // tipos de id campos
            $campos = array(); // tipos de id campos
            // echo '<br>';
            // print_r($datos2);
            foreach ($datos2 as $key){
                if(!in_array($key['mes'], $datax)){
                    $datax[] = $key['mes'];
                }
                if(!in_array($key['dep'], $deptos)){
                    $deptos[] = $key['dep'];
                }
                if(!in_array($key['idc'], $idcamps)){
                    $idcamps[] = $key['idc'];
                }
                if(!in_array($key['cam'], $campos)){
                    $campos[] = $key['cam'];
                }
            }

            asort($datax);
            // print_r($datax);
            // echo '<br>';

            $array_auxi = array(); $no = 0;
            foreach ($datax as $key) {
                $array_auxi[$no] = $key;
                $no += 1;
            }
            $datax = $array_auxi;


            $completos = array();
            foreach ($datax as $keyx) {
                foreach ($deptos as $keyz) {
                    foreach ($idcamps as $keyy) {
                        $auxiliark['x'] = $keyx;
                        $auxiliark['y'] = $keyy;
                        $auxiliark['z'] = $keyz;
                        $auxiliark['llave'] = $keyx.'-'.$keyy.'-'.$keyz;
                        $auxiliark['valor'] = 0;
                        $completos[] = $auxiliark;
                    }
                }
            }
            
            $comval = array();
            // print_r($completos);
            // echo "<br> completos <br>";
            foreach ($completos as $keyc) {
                $sw = 0;
                foreach ($datos2 as $key) {
                    if($keyc['llave'] == $key['lor']){
                        $auxiliark['x'] = $keyc['x'];
                        $auxiliark['y'] = $keyc['y'];
                        $auxiliark['z'] = $keyc['z'];
                        $auxiliark['llave'] = $keyc['llave'];
                        $auxiliark['valor'] = $key['num'];
                        $comval[] = $auxiliark;
                        $sw = 1;
                        break;
                    }else{

                    }
                }
                if($sw == 0){
                    $auxiliark['x'] = $keyc['x'];
                    $auxiliark['y'] = $keyc['y'];
                    $auxiliark['z'] = $keyc['z'];
                    $auxiliark['llave'] = $keyc['llave'];
                    $auxiliark['valor'] = 0;
                    $comval[] = $auxiliark;
                }
            }

            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3];

            // print_r($comval);
            
            // echo '<br>'; $pin = 0; Array ( [0] => RADIO [1] => ENERGÍA [2] => OTROS [3] => REDLAN )
            $tope = 2; $nombre_imagenes = array();
            foreach ($datax as $keyx) {

                $dato_fe = explode('-',$keyx);
                $mes = '-'.que_mes($dato_fe[0]);

                $data1_2 = array();
                $data2_2 = array();
                $data3_2 = array();
                $data4_2 = array();
                $toda_cadena = array();
                for ($i=0; $i < sizeof($comval) ; $i++) { 
                    if($comval[$i]['z'] == 'RADIO' && $comval[$i]['x'] == $keyx){
                        $data1_2[] = $comval[$i]['valor'];
                    }elseif($comval[$i]['z'] == 'ENERGÍA' && $comval[$i]['x'] == $keyx){
                        $data2_2[] = $comval[$i]['valor'];
                    }elseif($comval[$i]['z'] == 'OTROS' && $comval[$i]['x'] == $keyx){
                        $data3_2[] = $comval[$i]['valor'];
                    }elseif($comval[$i]['z'] == 'REDLAN' && $comval[$i]['x'] == $keyx){
                        $data4_2[] = $comval[$i]['valor'];
                    }else{
                    }
                }
                // echo '<br>'.$tope.'<br>'.$keyx;

                // print_r($data1_2);
                // echo '<br>';
                // print_r($data2_2);
                // echo '<br>';
                // print_r($data3_2);
                // echo '<br>';
                // print_r($data4_2);

                $no = 1;
                foreach ($campos as $key) {
                    $toda_cadena[] = $key;
                }

                $grafica = new Graph(1000,1100,'auto');
                $grafica->SetScale("textlin");
                $grafica->img->SetMargin(30,100,30,40);
                $grafica->SetShadow();

                $x = $ubicacionTamamo[0];
                $y = $ubicacionTamamo[1]; 
                $ancho = $ubicacionTamamo[2];  
                $altura = $ubicacionTamamo[3]; 

                $grafica->SetScale("textlin");
                $grafica->title->Set($titulo2.$mes);
                $grafica->title->SetPos(0.05,0.1);
                $grafica->xaxis->SetTitle("Equipo");
                // $grafica->yaxis->SetTitle();
                $grafica->yaxis->title->SetPos(0.05,0.1);

                $grafica->xaxis->SetTickLabels($toda_cadena);
                $grafica->xaxis->title->SetFont(FF_FONT1,FS_BOLD,4);
                // echo '<br>'; $pin = 0; Array ( [0] => RADIO [1] => ENERGÍA [2] => OTROS [3] => REDLAN )
                $maegrupos = array();
                if(sizeof($data1_2)>0){
                    $grupo1 = new BarPlot($data1_2);
                    $grupo1->SetLegend("RADIO");
                    $maegrupos[]= $grupo1;
                }
                // $grupo1->SetFillColor("#E234A9");
                if(sizeof($data2_2)>0){
                    $grupo2 = new BarPlot($data2_2);
                    $grupo2->SetLegend("ENERGIA");
                    $maegrupos[]= $grupo2;
                }
                // $grupo2->SetFillColor("blue");
                if(sizeof($data3_2)>0){
                    $grupo3 = new BarPlot($data3_2);
                    $grupo3->SetLegend("OTROS");
                    $maegrupos[]= $grupo3;
                }

                if(sizeof($data4_2)>0){
                    $grupo4 = new BarPlot($data4_2);
                    $grupo4->SetLegend("REDLAN");
                    $maegrupos[]= $grupo4;
                }

                $grafica->legend->SetPos(0.0,0.0);
                
                $materias = new GroupBarPlot($maegrupos);
                
                $grafica->legend->SetFrameWeight(1);
                $grafica->legend->SetPos(0.7,0.04,'center','bottom');
                $grafica->Add($materias);
                $top = 70;
                $bottom = 30;
                $left = 150;
                $right = 30;
                $grafica->Set90AndMargin($left,$right,$top,$bottom);

                $grafica->Stroke($nombre_graficos[$tope]);
                $nombre_imagenes[] = $nombre_graficos[$tope];
                $tope = $tope + 1;
            }
                        
            // print_r($nombre_imagenes);
            if (sizeof($datos1)>0) {
                $graph = new PieGraph(900,600,'auto');
                $graph->SetMargin(100,1,40,1);
                if(!empty($titulo1)){
                    $graph->title->Set($titulo1);
                }
                $p1 = new PiePlot3D($data1);
                $p1->SetCenter(0.55,0.32);
                $p1->SetSliceColors($color1);
                $p1->value->SetFont(FF_FONT1,FS_BOLD);
                $p1->value->SetColor("darkred");
                $p1->SetLabelPos(0.6);
                $p1->SetLegends($nombres1);
                $graph->legend->Pos(0.05,0.65);
                $graph->legend->SetShadow(false);
                $graph->Add($p1);
                $p1->ExplodeSlice(0);
                $graph->Stroke($nombre_graficos[0]);
            } 
            
            if (sizeof($datos1)>0) {
                $this->Image($nombre_graficos[0],$x+10,$y,$ancho,$altura);
            }

            if (sizeof($datos2)>0) {
                $caso = true;
                foreach ($nombre_imagenes as $img) {
                    if (file_exists($img)) {
                        if($caso){
                            $this->AddPage();
                            $this->Image($img,10,10,180,135);
                            $caso = false;
                        }else{
                            $this->Image($img,10,145,180,135);
                            $caso = true;
                        }
                    }
                }
            }


        } 
    }
    public function graficoPDFunico($datos1 = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo1 = NULL){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos1) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            $grafica1 = $nombreGrafico.'_01.png';
            foreach ($datos1 as $key){
                $data1[] = $key[0];
                $nombres1[] = $key[2]; 
                $color1[] = $key[1];
            }
            // print_r($datos1);
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];
            $altura = $ubicacionTamamo[3];

            if (sizeof($datos1)>0) {
                $graph = new PieGraph(600,400,'auto');
                if(!empty($titulo1)){
                    $graph->title->Set($titulo1);
                }
                $p1 = new PiePlot3D($data1);
                $p1->SetCenter(0.65,0.32);
                $p1->SetSliceColors($color1);
                $p1->value->SetFont(FF_FONT1,FS_BOLD);
                $p1->value->SetColor("darkred");
                $p1->SetLabelPos(0.6);
                $p1->SetLegends($nombres1);
                $graph->legend->Pos(0.05,0.65);
                $graph->legend->SetShadow(false);
                $graph->Add($p1);
                $p1->ExplodeSlice(0);
                $graph->Stroke($grafica1);
                $this->Image($grafica1,$x,$y,$ancho,$altura);
            }
        } 
    }
    public function barrasgraficoPDF3($datos1 = array(),$datos2 = array(),$datos3 = array(),$deptos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo1 = NULL,$titulo2 = NULL,$titulo3 = NULL){
        //construccion de los arrays de los ejes x e y
        
        if(!is_array($datos1) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            
            $grafica1 = $nombreGrafico.'01.png';
            $grafica2 = $nombreGrafico.'02.png';
            $grafica3 = $nombreGrafico.'03.png';

            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1];
            $ancho = $ubicacionTamamo[2];
            $altura = $ubicacionTamamo[3];
            // print_r($datos1);
            foreach ($datos1 as $key){
                $datax[] = $key['mes'].'-'.$key['ani'];
                $datay[] = $key['num'];
            }

            $graph = new Graph(800,650,"auto");
            $graph->SetScale("textlin");
            $graph->img->SetMargin(50,100,20,40);
            $graph->SetShadow();
            $barra = new BarPlot($datay);
            $barra->SetFillColor("orange");
            $graph->Add($barra);
            $graph->title->Set($titulo1);

            $graph->xaxis->title->Set("Mes - Gestion");
            $graph->title->SetFont(FF_FONT1,FS_BOLD);
            $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
            $graph->xaxis->SetTickLabels($datax);
            $graph->Stroke($grafica1);

            // echo "<br> consulta <br>";
            $datax = array();
            // print_r($datos2);
            // echo "<br> datos2 <br>";
            foreach ($datos2 as $key){
                if(!in_array($key['mes'].'-'.$key['ani'], $datax)){
                    $datax[] = $key['mes'].'-'.$key['ani'];
                }
            }

            $completos = array();
            foreach ($datax as $keyx) {
                foreach ($deptos as $keyz) {
                    $auxiliark['llave'] = $keyx.'-'.$keyz['regional'];
                    $auxiliark['valor'] = 0;
                    $completos[] = $auxiliark;
                }
            }

            $comval = array();
            // print_r($completos);
            // echo "<br> completos <br>";
            foreach ($completos as $keyc) {
                $sw = 0;
                foreach ($datos2 as $key) {
                    // print_r($keyc['llave']);
                    // echo "<br> ---->>>>><br>";
                    // print_r($key);
                    // echo "<br> ---->>>><br>";
                    if($keyc['llave'] == $key['lor']){
                        // echo "<br> SI <br>";
                        $auxiliark['llave'] = $keyc['llave'];
                        $auxiliark['valor'] = $key['num'];
                        $comval[] = $auxiliark;
                        $sw = 1;
                        break;
                    }else{
                        // echo "<br> NO <br>";
                    }
                }
                if($sw == 0){
                    $auxiliark['llave'] = $keyc['llave'];
                    $auxiliark['valor'] = 0;
                    $comval[] = $auxiliark;
                }
            }
            // print_r($comval);
            // echo "<br> can valores <br>";
            $sw1 = true;  $sw2 = false; $sw3 = false;
            for ($i=0; $i < sizeof($comval) ; $i++) { 
                if($sw1){
                    $data1[] = $comval[$i]['valor']; $sw1 = false; $sw2 = true; $sw3 = false;
                }elseif($sw2){
                    $data2[] = $comval[$i]['valor']; $sw1 = false; $sw2 = false; $sw3 = true;
                }elseif($sw3){
                    $data3[] = $comval[$i]['valor']; $sw1 = false; $sw2 = false; $sw3 = false;
                }else{
                    $data4[] = $comval[$i]['valor']; $sw1 = true;  $sw2 = false; $sw3 = false;
                }
            }
            // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

            $grafica = new Graph(800,650);
            $grafica->img->SetMargin(40,100,50,40);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");
            $grafica->title->Set($titulo2);
            $grafica->title->SetPos(0.05,0.1);
            $grafica->xaxis->SetTitle("Mes - Gestion");
            $grafica->yaxis->SetTitle("Cantidades","middle");

            $grafica->xaxis->SetTickLabels($datax);

            $grupo1 = new BarPlot($data1);
            $grupo1->SetLegend("SANTA CRUZ");
            // $grupo1->SetFillColor("#E234A9");
            $grupo2 = new BarPlot($data2);
            $grupo2->SetLegend("COCHABAMBA");
            // $grupo2->SetFillColor("blue");
            $grupo3 = new BarPlot($data3);
            $grupo3->SetLegend("TARIJA");
            $grupo4 = new BarPlot($data4);
            $grupo4->SetLegend("CHUQUISACA");

            /*asigna el color de relleno de las barras, en este caso un relleno
            degradado vertical que va de naranja a rojo, los tipos de degradado
            los encuentras en la documentación*/
            // $grafica->legend->Pos(0.05,0.65);
            $grafica->legend->SetPos(0.2,0.0);
            // $grupo3->SetFillgradient('orange','red',GRAD_VER); 
            $materias = new GroupBarPlot(array($grupo1,$grupo2,$grupo3,$grupo4));
            $grafica->Add($materias);
            $grafica->legend->SetShadow(false);
            $grafica->Stroke($grafica2);

            foreach ($datos3 as $key){
                $datax_acu[] = $key['dep'];
                $datay_acu[] = $key['num'];
            }

            $grafico = new Graph(800,650,"auto");
            $grafico->SetScale("textlin");
            $grafico->img->SetMargin(50,100,20,40);
            $grafico->SetShadow();
            $barra = new BarPlot($datay_acu);
            $barra->SetFillColor("orange");
            $grafico->Add($barra);
            $grafico->title->Set($titulo3);
            $grafico->xaxis->title->Set("Regionales");
            $grafico->title->SetFont(FF_FONT1,FS_BOLD);
            $grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
            $grafico->xaxis->SetTickLabels($datax_acu);
            $grafico->Stroke($grafica3);

            $this->Image($grafica1,$x,$y,$ancho,$altura);
            $this->Image($grafica2,$x,$y+110,$ancho,$altura+20);
            $this->AddPage();
            $this->Image($grafica3,$x,$y,$ancho,$altura);
        }
    }
    public function barrasgraficoPDF2($datos1 = array(),$datos2 = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo1 = NULL,$titulo2 = NULL){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos1) || !is_array($ubicacionTamamo) || !is_array($datos2)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            // print_r($datos1);
            // echo '<br>';
            // print_r($datos2);
            $grafica1 = $nombreGrafico.'01.png';
            $grafica2 = $nombreGrafico.'02.png';

            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1];
            $ancho = $ubicacionTamamo[2];
            $altura = $ubicacionTamamo[3];

            $datax = array();
            $datay = array();
            foreach ($datos1 as $key){
                $datax[] = $key[1];
                $datay[] = $key[0];
            }

            $graph = new Graph(600,1200,"auto");
            $graph->SetScale('textlin');
            $graph->img->SetMargin(50,50,30,30);

            $graph->SetShadow();
            $barra = new BarPlot($datay);
            $barra->SetFillColor("orange");
            $graph->Add($barra);

            $graph->title->Set($titulo1);
            $graph->xaxis->title->Set("Por Tipo");
            $graph->title->SetFont(FF_FONT1,FS_BOLD);
            $graph->xaxis->SetTickLabels($datax);
            $graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,6);
            $graph->xaxis->SetColor('black','black');

            $top = 60;
            $bottom = 30;
            $left = 200;
            $right = 30;
            $graph->Set90AndMargin($left,$right,$top,$bottom);

            $graph->Stroke($grafica1);

            $datax_acu = array();
            $datay_acu = array();
            foreach ($datos2 as $key){
                $datax_acu[] = $key[1];
                $datay_acu[] = $key[0];
            }

            $grafico = new Graph(600,1200,"auto");
            $grafico->SetScale("textlin");
            $grafico->img->SetMargin(50,50,20,40);
            $grafico->SetShadow();
            $barra = new BarPlot($datay_acu);
            $barra->SetFillColor("orange");
            // $barra->SetValuePos('center');
            $grafico->Add($barra);

            $grafico->title->Set($titulo2);
            $grafico->xaxis->title->Set("Por sistema");
            // $grafico->xaxis->title->SetPos(0.5,0.5);
            $grafico->title->SetFont(FF_FONT1,FS_BOLD);
            $grafico->xaxis->SetTickLabels($datax_acu);
            $grafico->xaxis->SetFont(FF_ARIAL,FS_NORMAL,6);
            $grafico->xaxis->SetColor('black','black');
            $grafico->xaxis->title->SetMargin(-15);
            
            $top = 60;
            $bottom = 30;
            $left = 100;
            $right = 30;
            $grafico->Set90AndMargin($left,$right,$top,$bottom);

            $grafico->Stroke($grafica2);

            $this->Image($grafica1,$x,$y,$ancho,$altura);
            $this->AddPage();
            $this->Image($grafica2,$x,$y,$ancho,$altura);
        }
    }
    public function barrasgraficoPDF3v2($datos1 = array(),$datos2 = array(),$datos3 = array(),$deptos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos1) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            
            $datax0 = array();
            $datay0 = array();

            $grafica1 = $nombreGrafico.'01.png';
            $grafica2 = $nombreGrafico.'02.png';
            $grafica3 = $nombreGrafico.'03.png';

            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1];
            $ancho = $ubicacionTamamo[2];
            $altura = $ubicacionTamamo[3];
            asort($datos1);
            foreach ($datos1 as $key){
                $datax0[] = $key['mes'].'-'.$key['ani'];
                $datay0[] = $key['num'];
            }

            $graph = new Graph(900,400,"auto");
            $graph->SetScale("textlin");
            $graph->img->SetMargin(50,100,20,40);
            $graph->SetShadow();
            $barra = new BarPlot($datay0);
            $barra->SetFillColor("orange");
            $graph->Add($barra);
            $graph->title->Set("Items utilizados por meses");
            $graph->xaxis->title->Set("Mes - Gestion");
            $graph->title->SetFont(FF_FONT1,FS_BOLD);
            $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
            $graph->xaxis->SetTickLabels($datax0);
            $graph->Stroke($grafica1);

            $datax = array();
            $datay = array();
            // print_r($datos2);
            foreach ($datos2 as $key){
                $datax[] = $key['ite'];
                $datay[] = $key['num'];
            }

            $grafica = new Graph(900,400,"auto");
            $grafica->SetScale("textlin");
            $grafica->img->SetMargin(50,100,20,40);
            $grafica->SetShadow();
            $barra = new BarPlot($datay);
            $barra->SetFillColor("orange");
            $grafica->Add($barra);
            $grafica->title->Set("Items utilizados");
            $grafica->xaxis->title->Set("Items");
            $grafica->title->SetFont(FF_FONT1,FS_BOLD);
            $grafica->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
            $grafica->xaxis->SetTickLabels($datax);
            $grafica->Stroke($grafica2);

            foreach ($datos3 as $key){
                $datax_acu[] = $key['dep'];
                $datay_acu[] = $key['num'];
            }

            $grafico = new Graph(900,400,"auto");
            $grafico->SetScale("textlin");
            $grafico->img->SetMargin(50,100,20,40);
            $grafico->SetShadow();
            $barra = new BarPlot($datay_acu);
            $barra->SetFillColor("orange");
            $grafico->Add($barra);
            $grafico->title->Set("Items acumulado por regionales");
            $grafico->xaxis->title->Set("Regionales");
            $grafico->title->SetFont(FF_FONT1,FS_BOLD);
            $grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
            $grafico->xaxis->SetTickLabels($datax_acu);
            $grafico->Stroke($grafica3);

            $this->Image($grafica1,$x,$y,$ancho,$altura);
            $this->Image($grafica2,$x,$y+110,$ancho,$altura);
            $this->AddPage();
            $this->Image($grafica3,$x,$y,$ancho,$altura);
        }
    }
    public function barrasgraficoPDF3_1($todos = array(),$regionales = array(),$grupos = array(),$meses = array(),$por_regiones = array(),$por_grupos = array(),$por_decen = array(),$deptos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
        // $pdf->barrasgraficoPDF3_1($todos,$regionales,$grupos,$meses,$por_regiones,$por_grupos,$por_decen,$deptos,'ReportePdf',array(50,30,120,70),'Por meses','Por grupo');
        //construccion de los arrays de los ejes x e y
        if(!is_array($todos) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            
            $grafica1 = $nombreGrafico.'01.png';
            $grafica2 = $nombreGrafico.'02.png';
            $grafica3 = $nombreGrafico.'03.png';

            $dataz = array('OPTIMO','MORA');
            // echo "<br>";
            asort($meses);
            // asort($dataz);
            // echo "<br>";
            // print_r($meses);
            $array_auxi = array(); $no = 0;
            foreach ($meses as $key) {
                $array_auxi[$no] = $key;
                $no += 1;
            }
            $meses = $array_auxi;
            // echo "<br>";
            // print_r($meses);
            $completos = array();
            foreach ($meses as $keyx) {
                foreach ($dataz as $keyz) {
                    $auxiliark['llave'] = $keyx.'-'.$keyz;
                    $auxiliark['valor'] = 0;
                    $completos[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($completos); 
            // echo "<br>";
            // print_r($por_decen); 
            $comval = array();
            foreach ($completos as $keyc) {
                $sw = 0;
                foreach ($por_decen as $key) {
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

            $grafica = new Graph(900, 600);
            // $graph->Set90AndMargin(50,20,50,30);
            $grafica->img->SetMargin(50,100,20,50);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");
            $grafica->title->Set("Desempeño por mes.");
            $grafica->xaxis->SetTitle("Mes - Gestion");
            $grafica->yaxis->SetTitle("Desempeño","middle");
            $grafica->xaxis->SetTickLabels($meses);

            $grupo1 = new BarPlot($data1);
            $grupo1->SetColor("red");
            $grupo1->SetLegend($dataz[0]);
            $grupo1->SetFillColor("#014F9F"); 
            $grupo1->SetValuePos("top");
            $grupo1->value->SetFont(FF_ARIAL, FS_BOLD, 10);
            $grupo1->value->SetFormat('%d');
            $grupo1->value->Show();

            $grupo2 = new BarPlot($data2);
            $grupo2->SetColor("#137549");
            $grupo2->SetLegend($dataz[1]);
            $grupo1->SetFillColor("#DC143C"); 
            $grupo2->SetValuePos("top");
            $grupo2->value->SetFont(FF_ARIAL, FS_BOLD, 10);
            $grupo2->value->SetFormat('%d');
            $grupo2->value->Show();

            $materias = new GroupBarPlot(array($grupo1,$grupo2));
            $grafica->Add($materias);
            $grafica->legend->SetColumns(2);
            $grafica->legend->SetFrameWeight(1);
            $grafica->legend->SetPos(0.3,0.99,'center','bottom');
            $grafica->Stroke($grafica1);

            $completos = array();
            // echo "<br>";
            // print_r($meses);
            foreach ($meses as $keyx) {
                foreach ($grupos as $keyz) {
                    $auxiliark['llave'] = $keyx.'-'.$keyz;
                    $auxiliark['valor'] = 0;
                    $completos[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($completos);
            $comvalg = array();
            foreach ($completos as $keyc) {
                $sw = 0;
                foreach ($por_grupos as $key) {
                    if(in_array($keyc['llave'], $key)){
                        $auxiliark['llave'] = $keyc['llave'];
                        $auxiliark['valor'] = $key['num'];
                        $comvalg[] = $auxiliark;
                        $sw = 1;
                        break;
                    }
                }
                if($sw == 0){
                    $auxiliark['llave'] = $keyc['llave'];
                    $auxiliark['valor'] = 0;
                    $comvalg[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($comvalg); 
            $sw1 = true;  $sw2 = false;
            for ($i=0; $i < sizeof($comvalg) ; $i++) { 
                if($sw1){
                    $datag1[] = $comvalg[$i]['valor']; $sw1 = false; $sw2 = true;
                }elseif($sw2){
                    $datag2[] = $comvalg[$i]['valor']; $sw1 = false; $sw2 = false;
                }else{
                    $datag3[] = $comvalg[$i]['valor']; $sw1 = true; $sw2 = false;
                }
            }
            // echo "<br>";
            // print_r($datag1);
            // echo "<br>";
            // print_r($datag2);
            // echo "<br>";
            // print_r($datag3);
            $grafi = new Graph(900, 600);
            $grafi->img->SetMargin(50,100,20,50);
            $grafi->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafi->SetScale("textlin");
            $grafi->title->Set("Desempeño por mes de grupos");
            $grafi->xaxis->SetTitle("Mes - Gestion");
            $grafi->yaxis->SetTitle("Desempeño","middle");
            $grafi->xaxis->SetTickLabels($meses);
            // echo "<br>";
            // print_r($meses);
            $grupo1 = new BarPlot($datag1);
            $grupo1->SetLegend("Grupo 1");
            $grupo2 = new BarPlot($datag2);
            $grupo2->SetLegend("Grupo 2");
            $grupo3 = new BarPlot($datag3);
            $grupo3->SetLegend("Grupo 3");
            $materias = new GroupBarPlot(array($grupo1,$grupo2,$grupo3));
            $grafi->Add($materias);
            $grafi->legend->SetFrameWeight(1);
            $grafi->legend->SetPos(0.3,0.99,'center','bottom');
            $grafi->Stroke($grafica2);


            $completos = array();
            foreach ($deptos as $keyx) {
                foreach ($dataz as $keyz) {
                    $auxiliark['llave'] = $keyx.'-'.$keyz;
                    $auxiliark['valor'] = 0;
                    $completos[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($completos); 
            // echo "<br>";
            // print_r($por_regiones);
            $comvalre = array();
            foreach ($completos as $keyc) {
                $sw = 0;
                foreach ($por_regiones as $key) {
                    if(in_array($keyc['llave'], $key)){
                        $auxiliark['llave'] = $keyc['llave'];
                        $auxiliark['valor'] = $keyc['valor'] + $key['num'];
                        $comvalre[] = $auxiliark;
                        $sw = 1;
                        break;
                    }
                }
                if($sw == 0){
                    $auxiliark['llave'] = $keyc['llave'];
                    $auxiliark['valor'] = 0;
                    $comvalre[] = $auxiliark;
                }
            }
            // echo "<br>";
            // print_r($comvalre); 
            $sw1 = true;
            for ($i=0; $i < sizeof($comvalre) ; $i++) { 
                if($sw1){
                    $data1r[] = $comvalre[$i]['valor']; $sw1 = false;
                }else{
                    $data2r[] = $comvalre[$i]['valor']; $sw1 = true;
                }
            }

            $grafica = new Graph(900, 650);
            $grafica->img->SetMargin(50,100,20,50);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");
            $grafica->title->Set("Desempeño por Regionales.");
            $grafica->xaxis->SetTitle("Departamentos");
            $grafica->yaxis->SetTitle("Desempeño","middle");
            $grafica->xaxis->SetTickLabels($deptos);
            $grupo1 = new BarPlot($data1r);
            $grupo1->SetColor("red");
            $grupo1->SetLegend($dataz[0]);
            $grupo2 = new BarPlot($data2r);
            $grupo2->SetColor("#137549");
            $grupo2->SetLegend($dataz[1]);
            $materias = new GroupBarPlot(array($grupo1,$grupo2));
            $grafica->Add($materias);
            $grafica->legend->SetFrameWeight(1);
            $grafica->legend->SetPos(0.3,0.99,'center','bottom');

            $grafica->Stroke($grafica3);

            $this->Image($grafica1,$x,$y+110,$ancho,$altura);
            $this->Image($grafica2,$x,$y,$ancho,$altura);
            $this->AddPage();
            $this->Image($grafica3,$x,$y,$ancho,$altura);
        }
    }
    public function barrasgraficoPDFPromedioAgrupadosPares($datos = array(),$dataz= array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL,$num){
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos) || !is_array($ubicacionTamamo)){
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
            echo "debe indicar el nombre del grafico a crear";
        } else{
            #obtenemos los datos del grafico 
            //    print_r($datos);
            $nombreGrafico01 = 'ReportePdf01';
            $datax = array(); 
            foreach ($datos as $key){
                if(!in_array($key['mes'].'-'.$key['ani'], $datax)){
                    $datax[] = $key['mes'].'-'.$key['ani'];
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
            $valor01 = 0; $valor02 = 0; $valorsuma01 = 0; $valorsuma02 = 0; $promedioy = array(); $promediox = array(); $puntero02 = 0; $puntero01 = 0;
            for ($i=0; $i < sizeof($comval) ; $i++) { 
                if($sw1){
                    $data1[] = $comval[$i]['valor']; $sw1 = false; $sw2 = true; 
                    
                    $valorsuma01 += $comval[$i]['valor'];
                    if($valor01 < intval($comval[$i]['valor'])){
                        $promedioy[0] = $comval[$i]['valor'];
                        $valor01 = $comval[$i]['valor'];
                    }
                    if(intval($comval[$i]['valor']) >0){
                        $puntero01 += 1;
                    }
                }else{
                    $data2[] = $comval[$i]['valor']; $sw1 = true; $sw2 = false; 
                    
                    $valorsuma02 += $comval[$i]['valor'];
                    if($valor02 < intval($comval[$i]['valor'])){
                        $promedioy[1] = $comval[$i]['valor'];
                        $valor02 = $comval[$i]['valor'];
                    }
                    if(intval($comval[$i]['valor']) > 0){
                        $puntero02 += 1;
                    }
                }
            }

            // Creamos el objeto del gráfico de un tamaño de 500px * 200px y establecemos que el eje x es texto y el eje y es numérico:

            $promediox[0] = round(floatval($valorsuma01 / $puntero01),3);
            $promediox[1] = round(floatval($valorsuma02 / $puntero02),3);

            $grafica = new Graph(800, 650);
            $grafica->img->SetMargin(80,100,20,60);
            $grafica->SetShadow();
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1]; 
            $ancho = $ubicacionTamamo[2];  
            $altura = $ubicacionTamamo[3]; 
            $grafica->SetScale("textlin");

            $grafica->title->Set($titulo);
            $grafica->xaxis->SetTitle("Mes - Gestion");
            $grafica->yaxis->SetTitle("Promedios","middle");

            $grafica->xaxis->SetTickLabels($datax);
            $grupo1 = new BarPlot($data1);
            $grupo1->SetLegend($dataz[0]);
            $grupo1->SetFillColor("#E234A9");
            $grupo2 = new BarPlot($data2);
            $grupo2->SetLegend($dataz[1]);
            $grupo2->SetFillColor("blue");

            $materias = new GroupBarPlot(array($grupo1,$grupo2));
            $grafica->legend->SetFrameWeight(1);
            $grafica->legend->SetPos(0.3,0.99,'center','bottom');
            $grafica->Add($materias);
            // $graph->xaxis->SetTickLabels($dataz);
            $grafica->Stroke("$nombreGrafico.png");
            if(true){
                // grafico # 2
                $graph01 = new Graph(800,650,"auto");
                $graph01->SetScale("textlin");

                // Establecemos los márgenes del gráfico y le añadimos una sombra por detrás:

                // $graph->img->SetMargin($ubicacionTamamo);
                $graph01->img->SetMargin(50,100,20,40);
                $graph01->SetShadow();
                $x = $ubicacionTamamo[0];
                $y = $ubicacionTamamo[1]; 
                $ancho = $ubicacionTamamo[2];
                $altura = $ubicacionTamamo[3];
                // Creamos un objeto de gráfica de barras, decimos que su color sea naranja, que se muestre la leyenda y que añada esa gráfica al objeto general.

                $barra01 = new BarPlot($promedioy);
                $barra01->SetFillColor("orange");
                // $barra->SetLegend($titulo);
                // $graph->legend->Pos(0.03,0.90);
                // $graph->legend->SetShadow(false);
                $graph01->Add($barra01);

                // Le añadimos un título al gráfico y otro a uno de los ejes, poniendo ambos en negrita:

                $graph01->title->Set($titulo);
                $graph01->xaxis->title->Set("Promedio");
                $graph01->title->SetFont(FF_FONT1,FS_BOLD);
                $graph01->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

                // Añadimos el texto del eje x y finalmente lo mostramos:

                $graph01->xaxis->SetTickLabels($promediox);
                $graph01->Stroke("$nombreGrafico01.png");
            }
            $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
            if(true){
                $this->Image("$nombreGrafico01.png",$x,$y+120,$ancho,$altura);
            }

            
        }
    }
}
?>