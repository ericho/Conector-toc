<?

/**********

La Variable localizacion dentro de cada funcion define de que lugar se tomara la informacion
Para especificar de que lugar se va a obtener cada prototipo. 

Esto solo se aplicar para el servidor central, que es donde se concentra la informacion de varios lugares

***********/

include 'biodigestor_metano.php';
include 'torre_bioetanol.php';
include 'reactor_biodiesel.php';
include 'calentador_solar.php';
include 'generador_eolico.php';
include 'stirling.php';
include 'lombricomposta.php';
include 'acuaponia.php';
include 'destilador_solar.php';
include 'condensador_atmosferico.php';
include 'agua_de_lluvia.php';
include 'autonomia_transporte.php';
include 'enfriamiento_adsorcion.php';


if(!isset($_GET['id']) && !isset($_POST['id'])){
  echo "No se recibieron variables";
 }
 else{
   if (isset($_GET['id']))
     {
       $id = $_GET['id'];
     }
   if (isset($_POST['id']))
     {
       $id = $_POST['id'];
     }
   if (isset($_GET['fecha']))
     {
       $fecha = $_GET['fecha'];
     }     
   if (isset($_POST['fecha']))
     {
       $fecha = $_POST['fecha'];
     }
   $conn = mysql_connect("localhost", "toc", "CIETOC06"); // <= Metodo inseguro
	  
   if (!$conn){
     die ("No se pudo realizar la conexion" . mysql_error());
   }
   
   mysql_select_db("toc_bd", $conn);
   
   
if ($id == 0){
	eventos($id, $fecha);
	}   
   else if($id == 1){ // Biodigestor Metano 
     $act = 1; // Act=1; Ultimos datos registrados
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 biodigestor_metano();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 biodigestor_metano_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	   }
	 biodigestor_metano_rangos($fecha, $fecha2, $act);
       }
     else if($act == 4)
       {
	 eventos($id, $fecha);
       }
   }
   else if($id == 2){
     // Torre de Bioetanol
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 torre_bioetanol();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 torre_bioetanol_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     torre_bioetanol_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 3){
     // Reactor Biodiesel
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 reactor_biodiesel();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 reactor_biodiesel_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     reactor_biodiesel_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 4){
     // Calentador solar 
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 calentador_solar();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 calentador_solar_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     calentador_solar_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
    else if ($act == 5)
    {
        descargar_calentador_solar($fecha);
    }
   

   }
   else if($id == 5){
     // Generador Eolico
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 generador_eolico();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 generador_eolico_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     generador_eolico_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 6){
     // Generador Magnetico
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 generador_magnetico();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 generador_magnetico_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     generador_magnetico_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 7){
     // Generador Stirling
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	generador_calentador_stirling();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 generador_calentador_stirling_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     generador_calentador_stirling_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id==8){
     // Bomba Stirling
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 bomba_stirling();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 bomba_stirling_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     bomba_stirling_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 9){
     // Lombricomposta
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	lombricompostario();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 lombricompostario_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     lombricompostario_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 10){
     // Acuaponia
     $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 acuaponia();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 acuaponia_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     acuaponia_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   }
   else if($id == 11){
     // Destilador solar 
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 destilador_solar();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 destilador_solar_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     destilador_solar_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 12){
     // Condensador atmosferico
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 condensador_atmosferico();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 condensador_atmosferico_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     condensador_atmosferico_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 13){
// AGUA DE LLUVIA
     $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	 agua_de_lluvia();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 agua_de_lluvia_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     agua_de_lluvia_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   
    
   }
   else if($id == 14){
     // Autonomia de transporte
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	autonomia_transporte();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 autonomia_transporte_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     autonomia_transporte_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else if($id == 15){
    $act = 1;
     if (isset($_GET['act'])){
       $act = $_GET['act'];
     }
     if (isset($_POST['act'])){
       $act = $_POST['act'];
     }

     if ($act == 1)
       {
	enfriamiento_adsorcion();
       }
     else if ($act == 2) // Reporte diario, se espera una fecha
       {
	 enfriamiento_adsorcion_diario($fecha, $act);
       }
     else if ($act == 3) // Reporte por rangos, se esperan dos fechas
       {
	 if(isset($_GET['fecha2']))
	   {
	     $fecha2 = $_GET['fecha2'];
	     enfriamiento_adsorcion_rangos($fecha, $fecha2, $act);
	   }
       }
     else if ($act == 4)
       {
	 eventos($id, $fecha);
       }
   

   }
   else{
     echo "Identificador incorrecto!";
   }
 }

function eventos($id, $fecha){

  $consulta = "SELECT idevento, id_modulo_fk, fecha_hora, evento 
                                        FROM bitacora 
                                        WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY) AND id_modulo_fk = $id 
                                        ";

//echo $consulta;
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
                   "idmodulo" => $fila[1],
                   "fecha" => $fila[2],
                           "evento" => $fila[3]);
      array_push($arreglo, $arreglo_tmp);
    }
  echo json_encode($arreglo);
}

?>
