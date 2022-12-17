<?php
// Array ( 
// [0] => Array ( [0] => 684 [idEstacion] => 684 [1] => ENTEL Correctivo sitio corporativo [title] => ENTEL Correctivo sitio corporativo [2] => 5 [idUsuarioEntel] => 5 [3] => DateTime Object ( [date] => 2020-09-16 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [start] => DateTime Object ( [date] => 2020-09-16 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [4] => 08:22 [hora] => 08:22 [5] => [justificativo] => [6] => 6-11-2020 7:30 [ini_intervalo] => 6-11-2020 7:30 [7] => 6-11-2020 12:00 [fin_intervalo] => 6-11-2020 12:00 ) 
// [1] => Array ( [0] => 820 [idEstacion] => 820 [1] => ENTEL Correctivo sitio particular [title] => ENTEL Correctivo sitio particular [2] => 5 [idUsuarioEntel] => 5 [3] => DateTime Object ( [date] => 2020-10-21 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [start] => DateTime Object ( [date] => 2020-10-21 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [4] => 08:00 [hora] => 08:00 [5] => [justificativo] => [6] => 14-10-2020 8:00 [ini_intervalo] => 14-10-2020 8:00 [7] => 14-10-2020 10:30 [fin_intervalo] => 14-10-2020 10:30 ) 
// [2] => Array ( [0] => 822 [idEstacion] => 822 [1] => ENTEL Correctivo sitio particular [title] => ENTEL Correctivo sitio particular [2] => 5 [idUsuarioEntel] => 5 [3] => DateTime Object ( [date] => 2020-10-21 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [start] => DateTime Object ( [date] => 2020-10-21 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [4] => 08:00 [hora] => 08:00 [5] => [justificativo] => [6] => 21-10-2020 15:30 [ini_intervalo] => 21-10-2020 15:30 [7] => 21-10-2020 18:00 [fin_intervalo] => 21-10-2020 18:00 ) 
// [3] => Array ( [0] => 981 [idEstacion] => 981 [1] => ENTEL Correctivo sitio particular [title] => ENTEL Correctivo sitio particular [2] => 5 [idUsuarioEntel] => 5 [3] => DateTime Object ( [date] => 2020-11-30 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [start] => DateTime Object ( [date] => 2020-11-30 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [4] => 08:48 [hora] => 08:48 [5] => [justificativo] => [6] => 18-11-2020 14:30 [ini_intervalo] => 18-11-2020 14:30 [7] => 18-11-2020 17:30 [fin_intervalo] => 18-11-2020 17:30 ) 
// [4] => Array ( [0] => 683 [idEstacion] => 683 [1] => ENTEL Correctivo sitio corporativo [title] => ENTEL Correctivo sitio corporativo [2] => 5 [idUsuarioEntel] => 5 [3] => DateTime Object ( [date] => 2020-12-15 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [start] => DateTime Object ( [date] => 2020-12-15 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [4] => 08:22 [hora] => 08:22 [5] => SI.jpg [justificativo] => SI.jpg [6] => 14-10-2020 11:00 [ini_intervalo] => 14-10-2020 11:10 [7] => 14-10-2020 15:00 [fin_intervalo] => 14-10-2020 15:00 ) 
// [5] => Array ( [0] => 820 [idEstacion] => 820 [1] => ENTEL Correctivo sitio corporativo [title] => ENTEL Correctivo sitio corporativo [2] => 5 [idUsuarioEntel] => 5 [3] => DateTime Object ( [date] => 2020-12-16 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [start] => DateTime Object ( [date] => 2020-12-16 00:00:00.000000 [timezone_type] => 3 [timezone] => Europe/Berlin ) [4] => 08:22 [hora] => 08:22 [5] => SI.jpg [justificativo] => SI.jpg [6] => 14-10-2020 8:00 [ini_intervalo] => 14-10-2020 8:00 [7] => 14-10-2020 10:30 [fin_intervalo] => 14-10-2020 10:30 ) )


// $Fecha = "14/10/2020  8:00:1";
$FechaP = "14-10-2020  8:00";
$FechaP = str_replace("/", "-", $FechaP);

$FechaF = "15-10-2020  9:00";
$FechaF = str_replace("/", "-", $FechaF);

// $fecah_econ = new DateTime($Fecha);
// echo date_format($fecah_econ,'Y-m-d H:i:s') . "<br>"; 
$fecah_prog = new DateTime($FechaP);
$fecah_fina = new DateTime($FechaF);
$diff = $fecah_prog->diff($fecah_fina);
print_r($diff);
$dias = $diff->days;
echo $dias."<br>";
$hora = $diff->h;
echo $hora."<br>";

Array ( [hola (12)] => Array ( [0] => 12 [1] => AntiqueWhite2 ) [Mikrotic (5)] => Array ( [0] => 5 [1] => aqua ) [sera (3)] => Array ( [0] => 3 [1] => aquamarine2 ) )
Notice: Array to string conversion in C:\xampp\htdocs\entel_lte\jpgraph-4.3.4\src\jpgraph_pie.php on line 315

Notice: Array to string conversion in C:\xampp\htdocs\entel_lte\jpgraph-4.3.4\src\jpgraph_pie.php on line 315

Notice: Array to string conversion in C:\xampp\htdocs\entel_lte\jpgraph-4.3.4\src\jpgraph_pie.php on line 315

Catchable fatal error: Argument 1 passed to JpGraphException::defaultHandler() must be an instance of Throwable, instance of Exception given in C:\xampp\htdocs\entel_lte\jpgraph-4.3.4\src\jpgraph_errhandler.inc.php on line 158


Array ( [aprobados] => Array ( [0] => 1 [1] => red ) [reprobados] => Array ( [0] => 1 [1] => blue ) [no_sabe] => Array ( [0] => 10 [1] => #FFFFFF ) [ni_responde] => Array ( [0] => 2 [1] => gray ) )
Catchable fatal error: Argument 1 passed to JpGraphException::defaultHandler() must be an instance of Throwable, instance of Exception given in C:\xampp\htdocs\entel_lte\jpgraph-4.3.4\src\jpgraph_errhandler.inc.php on line 158


Array ( [Con justificacion (6)] => Array ( [0] => 6 [1] => red ) [En el plazo (4)] => Array ( [0] => 4 [1] => blue ) [Fuera del plazo (9)] => Array ( [0] => 9 [1] => gray ) )
Catchable fatal error: Argument 1 passed to JpGraphException::defaultHandler() must be an instance of Throwable, instance of Exception given in C:\xampp\htdocs\entel_lte\jpgraph-4.3.4\src\jpgraph_errhandler.inc.php on line 158

?>