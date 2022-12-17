<?php
if (file_exists('ReportePdf.png')) {
   unlink("ReportePdf.png");
}
require_once("../fpdf182/fpdf.php");
require_once('../jpgraph-4.3.4/src/jpgraph.php');
require_once('../jpgraph-4.3.4/src/jpgraph_pie.php');
require_once ("../jpgraph-4.3.4/src/jpgraph_pie3d.php");
class Reporte extends FPDF{
    public function __construct($orientation='P', $unit='mm', $format='A4'){
        parent::__construct($orientation, $unit, $format);
    }
    public function gaficoPDF($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL){
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
}

$idregion = $_POST['idregion'];
$fechaini = $_POST['fechaini'];
$fechafin = $_POST['fechafin'];

$tipotrab = $_POST['tipotrab'];
$casogrup = $_POST['casogrup'];

switch ($tipotrab) {
    case 'CORRECTIVO':
        $sql_consulta = "SELECT * FROM tblSolicitudCorrectivos WHERE start BETWEEN '$fechaini' AND '$fechafin'";
        break;
    case 'PREVENTIVO':
        # code...
        break;
    case 'EXTRACANON':
        # code...
        break;
    default:
        # code...
        break;
}

$pdf=new Reporte();//creamos el documento pdf
$pdf->AddPage();//agregamos la pagina
$pdf->SetFont("Arial","B",16);//establecemos propiedades del texto tipo de letra, negrita, tamaño
// $pdf->Cell(40,10,'hola mundo',1);
$pdf->Cell(0,5,"GRAFICO REALIZADO CON FPDF Y JGRAPH",0,0,'C');
$pdf->SetFont("Arial","B",12);
$pdf->Cell(2,6,"$sql_consulta",0,0,'R');
$pdf->gaficoPDF(array('aprobados'=>array(1,'red'),'reprobados'=>array(1,'blue'),'no_sabe'=>array(10,'#FFFFFF'),'ni_responde'=>array(2,'gray')),'ReportePdf',array(50,30,100,50),'Grafico');
$pdf->Output(); 

?>