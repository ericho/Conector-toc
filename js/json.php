<?

/**********

La Variable localizacion dentro de cada funcion define de que lugar se tomara la informacion
Para especificar de que lugar se va a obtener cada prototipo. 

Esto solo se aplicar para el servidor central, que es donde se concentra la informacion de varios lugares

***********/

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

function biodigestor_metano(){
  $query = "SELECT idbiodigestor_metano,
		       	 	 fecha_hora,
			 	 temp_mezcla,
				 temp_reactor,
			 	 nivel_reactor,
			 	 nivel_deposito_gas,
			 	 res_calentador_agua,
			 	 motor_agitador_a,
			 	 motor_agitador_b_time_on,
			 	 motor_agitador_c_frec,
                                 presion_gas
			 	 FROM biodigestor_metano ORDER BY idbiodigestor_metano DESC LIMIT 1";


  $res = mysql_query($query);

  $row = mysql_fetch_array($res);
  $arreglo = array("id" => $row[0],
		   "fecha" => $row[1],
		   "temp_mezcla" => $row[2],
		   "temp_reactor" => $row[3],
		   "nivel_reactor" => $row[4],
		   "nivel_deposito" => $row[5],
		   "calentador_agua" => $row[6],
		   "motor_agitador_a" => $row[7],
		   "motor_agitador_b_tiempo" => $row[8],
		   "motor_agitador_c_frec" => $row[9],
                   "presion_gas" => $row[10]);

  echo json_encode($arreglo);
}

function biodigestor_metano_diario($fecha, $act)
{
  if ($act==2)
    {
      $consulta = "SELECT idbiodigestor_metano,
		       	 	 fecha_hora,
			 	 temp_mezcla,
				 temp_reactor,
			 	 nivel_reactor,
			 	 nivel_deposito_gas,
			 	 res_calentador_agua,
			 	 motor_agitador_a,
			 	 motor_agitador_b_time_on,
			 	 motor_agitador_c_frec,
                                 presion_gas
			 	 FROM biodigestor_metano
                                 WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                 GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $row[0],
		       "fecha" => $row[1],
		       "temp_mezcla" => $row[2],
		       "temp_reactor" => $row[3],
		       "nivel_reactor" => $row[4],
		       "nivel_deposito" => $row[5],
		       "calentador_agua" => $row[6],
		       "motor_agitador_a" => $row[7],
		       "motor_agitador_b_tiempo" => $row[8],
		       "motor_agitador_c_frec" => $row[9],
                       "presion_gas" => $row[10]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function biodigestor_metano_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {
      $consulta = "SELECT idbiodigestor_metano,
		       	 	 fecha_hora,
			 	 temp_mezcla,
				 temp_reactor,
			 	 nivel_reactor,
			 	 nivel_deposito_gas,
			 	 res_calentador_agua,
			 	 motor_agitador_a,
			 	 motor_agitador_b_time_on,
			 	 motor_agitador_c_frec,
                                 presion_gas
			 	 FROM biodigestor_metano
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $row[0],
		       "fecha" => $row[1],
		       "temp_mezcla" => $row[2],
		       "temp_reactor" => $row[3],
		       "nivel_reactor" => $row[4],
		       "nivel_deposito" => $row[5],
		       "calentador_agua" => $row[6],
		       "motor_agitador_a" => $row[7],
		       "motor_agitador_b_tiempo" => $row[8],
		       "motor_agitador_c_frec" => $row[9],
                       "presion_gas" => $row[10]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function biodigestor_metano_intervalos($fecha, $act)
{
  if ($act==2) // Lo que va del dia
    {
      $consulta = "SELECT idbiodigestor_metano,
		       	 	 fecha_hora,
			 	 temp_mezcla,
				 temp_reactor,
			 	 nivel_reactor,
			 	 nivel_deposito_gas,
			 	 res_calentador_agua,
			 	 motor_agitador_a,
			 	 motor_agitador_b_time_on,
			 	 motor_agitador_c_frec,
                                 presion_gas
			 	 FROM biodigestor_metano
                                 WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                 GROUP BY HOUR(fecha_hora)";
    }
  else if ($act==3) // Una semana atras
    {
      $consulta = "SELECT idbiodigestor_metano,
		       	 	 fecha_hora,
			 	 temp_mezcla,
				 temp_reactor,
			 	 nivel_reactor,
			 	 nivel_deposito_gas,
			 	 res_calentador_agua,
			 	 motor_agitador_a,
			 	 motor_agitador_b_time_on,
			 	 motor_agitador_c_frec,
                                 presion_gas
			 	 FROM biodigestor_metano
                                 WHERE fecha_hora > DATE_ADD('$fecha', INTERVAL -7 DAY) AND fecha_hora < '$fecha'
                                 GROUP BY FLOOR(TIME_TO_SEC(fecha_hora)/(60*60*6)), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  else if ($act==4) // Un mes atras
    {
      $consulta = "SELECT idbiodigestor_metano,
		       	 	 fecha_hora,
			 	 temp_mezcla,
				 temp_reactor,
			 	 nivel_reactor,
			 	 nivel_deposito_gas,
			 	 res_calentador_agua,
			 	 motor_agitador_a,
			 	 motor_agitador_b_time_on,
			 	 motor_agitador_c_frec,
                                 presion_gas
			 	 FROM biodigestor_metano
                                 WHERE fecha_hora > DATE_ADD('$fecha', INTERVAL -30 DAY) AND fecha_hora < '$fecha' AND TIME(fecha_hora) > '12:00:00'
                                 GROUP BY DAY(fecha_hora)
                                 ORDER BY fecha_hora";
    }


  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $row[0],
		       "fecha" => $row[1],
		       "temp_mezcla" => $row[2],
		       "temp_reactor" => $row[3],
		       "nivel_reactor" => $row[4],
		       "nivel_deposito" => $row[5],
		       "calentador_agua" => $row[6],
		       "motor_agitador_a" => $row[7],
		       "motor_agitador_b_tiempo" => $row[8],
		       "motor_agitador_c_frec" => $row[9],
                       "presion_gas" => $row[10]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}



// TORRE BIOETANOL

// Registos en tiempo real
function torre_bioetanol(){
  $consulta = "SELECT idtorre_bioetanol,
			    	    fecha_hora,
				    presion_calderin,
				    presion_domo,
                                    presion_enchaquetado,
				    temp_domo,
				    temp_calderin,
				    temp_enchaquetado,
				    nivel_calderin,
				    nivel_almacenamiento
				    FROM torre_bioetanol ORDER BY idtorre_bioetanol DESC LIMIT 1";
  $res = mysql_query($consulta);

  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "presion_calderin" => $fila[2],
		   "presion_domo" => $fila[3],
		   "presion_enchaquetado" => $fila[4],
		   "temp_domo" => $fila[5],
		   "temp_calderin" => $fila[6],
		   "temp_enchaquetado" => $fila[7],
		   "nivel_calderin" => $fila[8],
		   "nivel_almacenamiento" => $fila[9]
		   );

  echo json_encode($arreglo);
}

function torre_bioetanol_diario($fecha, $act)
{
  if ($act==2)
    {
     $consulta = "SELECT idtorre_bioetanol,
			    	        fecha_hora,
        				    presion_calderin,
        				    presion_domo,
                                            presion_enchaquetado,
        				    temp_domo,
        				    temp_calderin,
        				    temp_enchaquetado,
        				    nivel_calderin,
        				    nivel_almacenamiento
                	         	    FROM torre_bioetanol
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $row[0],
                           "fecha" => $row[1],
                           "presion_calderin" => $row[2],
                           "presion_ domo"=> $row[3],
                           "presion_enchaquetado" => $row[4],
                           "temp_domo" => $row[5],
                           "temp_calderin" => $row[6],
                           "temp_enchaquetado" => $row[7],
                           "nivel_calderin" => $row[8],
                           "nivel_almacenamiento" => $row[9]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function torre_bioetanol_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {
      $consulta = "SELECT idbiodigestor_metano,
		       	 	 fecha_hora,
			 	 temp_mezcla,
				 temp_reactor,
			 	 nivel_reactor,
			 	 nivel_deposito_gas,
			 	 res_calentador_agua,
			 	 motor_agitador_a,
			 	 motor_agitador_b_time_on,
			 	 motor_agitador_c_frec,
                                 presion_gas
			 	 FROM biodigestor_metano
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $row[0],
                           "fecha" => $row[1],
                           "presion_calderin" => $row[2],
                           "presion_ domo"=> $row[3],
                           "presion_enchaquetado" => $row[4],
                           "temp_domo" => $row[5],
                           "temp_calderin" => $row[6],
                           "temp_enchaquetado" => $row[7],
                           "nivel_calderin" => $row[8],
                           "nivel_almacenamiento" => $row[9]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Reactor Biodiesel

function reactor_biodiesel(){
  $consulta = "SELECT idreactor_biodiesel,
                                         fecha_hora,
                                         sensor_temp_reactor,
                                         bomba_1,
                                         bomba_2,
                                         agitador_1a_estado,
                                         agitador_1b_tiempo_enc,
                                         agitador_2a_estado,
                                         agitador_2b_tiempo_enc,
                                         agitador_2c_tiempo_enc,
                                         res_calentador_estado,
                                         res_calentador_tiempo
                                         FROM reactor_biodiesel ORDER BY idreactor_biodiesel DESC LIMIT 1";
  $res = mysql_query($consulta);

  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_reactor" => $fila[2],
		   "bomba_1" => $fila[3],
		   "bomba_2" => $fila[4],
		   "agitador_1a_estado" => $fila[5],
		   "agitador_1b_tiempo_enc" => $fila[6],
		   "agitador_2a_estado" => $fila[7],
		   "agitador_2b_tiempo_enc" => $fila[8],
		   "agitador_2c_tiempo_enc" => $fila[9],
		   "res_calentador_estado" => $fila[10],
		   "res_calentador_tiempo" => $fila[11]
		   );
  echo json_encode($arreglo);
}

function reactor_biodiesel_diario($fecha, $act)
{
  if ($act==2)
    {
     
  $consulta = "SELECT idreactor_biodiesel,
                                                 fecha_hora,
                                                 sensor_temp_reactor,
                                                 bomba_1,
                                                 bomba_2,
                                                 agitador_1a_estado,
                                                 agitador_1b_tiempo_enc,
                                                 agitador_2a_estado,
                                                 agitador_2b_tiempo_enc,
                                                 agitador_2c_tiempo_enc,
                                                 res_calentador_estado,
                                                 res_calentador_tiempo
                        	         	 FROM reactor_biodiesel
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $row[0],
                           "fecha" => $row[1],
                           "sensor_temp_reactor" => $row[2],
                           "bomba_1"=> $row[3],
                           "bomba_2" => $row[4],
                           "agitador_1a_estado" => $row[5],
                           "agitador_1b_estado_enc" => $row[6],
                           "agitador_2a_estado" => $row[7],
                           "agitador_2b_tiempo_enc" => $row[8],
                           "agitador_2c_tiempo_enc" => $row[9],
                           "res_calentador_estado" => $row[10],
                           "res_calentador_tiempo" => $row[11]
);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function reactor_biodiesel_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idreactor_biodiesel,
                                                 fecha_hora,
                                                 sensor_temp_reactor,
                                                 bomba_1,
                                                 bomba_2,
                                                 agitador_1a_estado,
                                                 agitador_1b_tiempo_enc,
                                                 agitador_2a_estado,
                                                 agitador_2b_tiempo_enc,
                                                 agitador_2c_tiempo_enc,
                                                 res_calentador_estado,
                                                 res_calentador_tiempo
                        	         	 FROM reactor_biodiesel			 	 
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $row[0],
                           "fecha" => $row[1],
                           "sensor_temp_reactor" => $row[2],
                           "bomba_1"=> $row[3],
                           "bomba_2" => $row[4],
                           "agitador_1a_estado" => $row[5],
                           "agitador_1b_estado_enc" => $row[6],
                           "agitador_2a_estado" => $row[7],
                           "agitador_2b_tiempo_enc" => $row[8],
                           "agitador_2c_tiempo_enc" => $row[9],
                           "res_calentador_estado" => $row[10],
                           "res_calentador_tiempo" => $row[11]
);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}


// Calentador Solar

function calentador_solar(){
  $consulta = "SELECT idcalentador_solar,
                                                fecha_hora,
                                                temp_tuberia_1,
                                                temp_tuberia_2,
                                                temp_agua_caliente,
                                                temp_agua_fria
                                                FROM calentador_solar ORDER BY idcalentador_solar DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha_hora" => $fila[1],
		   "temp_tuberia_1" => $fila[2],
		   "temp_tuberia_2" => $fila[3],
		   "temp_agua_caliente" => $fila[5], // Los campos estan al reves
		   "temp_agua_fria" => $fila[4]);
  echo json_encode($arreglo);
}

function calentador_solar_diario($fecha, $act)
{
  if ($act==2)
    {
     
$consulta = "SELECT idcalentador_solar,
                                                fecha_hora,
                                                temp_tuberia_1,
                                                temp_tuberia_2,
                                                temp_agua_caliente,
                                                temp_agua_fria
                        	         	 FROM calentador_solar
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
    $arreglo_tmp = array("id" => $fila[0],
		   "fecha_hora" => $fila[1],
		   "temp_tuberia_1" => $fila[2],
		   "temp_tuberia_2" => $fila[3],
		   "temp_agua_caliente" => $fila[5], // Campos invertidos ;)
		   "temp_agua_fria" => $fila[4]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function calentador_solar_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {
$consulta = "SELECT idcalentador_solar,
                                                fecha_hora,
                                                temp_tuberia_1,
                                                temp_tuberia_2,
                                                temp_agua_caliente,
                                                temp_agua_fria
                        	         	 FROM calentador_solar
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha_hora" => $fila[1],
		   "temp_tuberia_1" => $fila[2],
		   "temp_tuberia_2" => $fila[3],
		   "temp_agua_caliente" => $fila[5], // Campos invertidos.
		   "temp_agua_fria" => $fila[4]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Generador Eolico

function generador_eolico(){
  $consulta = "SELECT idgenerador_eolico,
                                                        fecha_hora,
                                                        voltaje,
                                                        velocidad_viento,
                                                        potencia,
                                                        rpm
                                                        FROM generador_eolico ORDER BY idgenerador_eolico DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "voltaje" => $fila[2],
		   "velocidad_viento" => $fila[3],
		   "potencia" => $fila[4],
		   "rpm" => $fila[5]);

  echo json_encode($arreglo);

}

function generador_eolico_diario($fecha, $act)
{
  if ($act==2)
    {
  $consulta = "SELECT idgenerador_eolico,
                                                        fecha_hora,
                                                        voltaje,
                                                        velocidad_viento,
                                                        potencia,
                                                        rpm
                             	         	 FROM generador_eolico
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "voltaje" => $fila[2],
		   "velocidad_viento" => $fila[3],
		   "potencia" => $fila[4],
		   "rpm" => $fila[5]);

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function generador_eolico_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idgenerador_eolico,
                                                        fecha_hora,
                                                        voltaje,
                                                        velocidad_viento,
                                                        potencia,
                                                        rpm
                             	         	 FROM generador_eolico
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "voltaje" => $fila[2],
		   "velocidad_viento" => $fila[3],
		   "potencia" => $fila[4],
		   "rpm" => $fila[5]);

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}


// Generador magnetico

function generador_magnetico(){
  $consulta = "SELECT idgenerador_magnetico,
                                                        fecha_hora,
                                                        corriente,
                                                        voltaje,
                                                        rpm
                                                        FROM generador_magnetico ORDER BY idgenerador_magnetico DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "corriente" => $fila[2],
		   "voltaje" => $fila[3],
		   "rpm" => $fila[4]);

  echo json_encode($arreglo);
}

function generador_magnetico_diario($fecha, $act)
{
  if ($act==2)
    {
  $consulta = "SELECT idgenerador_magnetico,
                                                        fecha_hora,
                                                        corriente,
                                                        voltaje,
                                                        rpm
                             	         	 FROM generador_magnetico
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {

  $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "corriente" => $fila[2],
		   "voltaje" => $fila[3],
		   "rpm" => $fila[4]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function generador_magnetico_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

      $consulta = "SELECT idgenerador_magnetico,
                                                          fecha_hora,
                                                        corriente,
                                                        voltaje,
                                                        rpm
                             	         	 FROM generador_magnetico
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {

      $arreglo_tmp = array("id" => $fila[0],
                           "fecha" => $fila[1],
                           "corriente" => $fila[2],
                           "voltaje" => $fila[3],
                           "rpm" => $fila[4]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}


// Generador Stirling

function generador_calentador_stirling(){
  $consulta = "SELECT idgenerador_calentador_stirling,
                                                                        fecha_hora,
                                                                        temp_entrada_caliente,
                                                                        temp_entrada_fria,
                                                                        rpm,
                                                                        presion
                                                                        FROM generador_calentador_stirling ORDER BY idgenerador_calentador_stirling DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_entrada_caliente" => $fila[2],
		   "temp_entrada_fria" => $fila[3],
		   "rpm" => $fila[4],
		   "presion" => $fila[5]
		   );

  echo json_encode($arreglo);
}

function generador_calentador_stirling_diario($fecha, $act)
{
  if ($act==2)
    {
  $consulta = "SELECT idgenerador_calentador_stirling,
                                                                        fecha_hora,
                                                                        temp_entrada_caliente,
                                                                        temp_entrada_fria,
                                                                        rpm,
                                                                        presion
                             	         	 FROM generador_calentador_stirling
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_entrada_caliente" => $fila[2],
		   "temp_entrada_fria" => $fila[3],
		   "rpm" => $fila[4],
		   "presion" => $fila[5]
		   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function generador_calentador_stirling_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idgenerador_calentador_stirling,
                                                                        fecha_hora,
                                                                        temp_entrada_caliente,
                                                                        temp_entrada_fria,
                                                                        rpm,
                                                                        presion
                             	         	 FROM generador_calentador_stirling
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($row = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_entrada_caliente" => $fila[2],
		   "temp_entrada_fria" => $fila[3],
		   "rpm" => $fila[4],
		   "presion" => $fila[5]
		   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Bomba Stirling

function bomba_stirling(){
  $consulta = "SELECT idbomba_agua_stirling,
                                                        fecha_hora,
                                                        nivel,
                                                        rpm,
                                                        servo_motor
                                                        FROM bomba_agua_stirling ORDER BY idbomba_agua_stirling DESC LIMIT 1";

  
  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
                   "fecha" => $fila[1],
                   "nivel" => $fila[2],
                   "rpm" => $fila[3],
                   "servo_motor" => $fila[4]
                   );

  echo json_encode($arreglo);
}

function bomba_stirling_diario($fecha, $act)
{
  if ($act==2)  
{
  $consulta = "SELECT idbomba_agua_stirling,
                                                        fecha_hora,
                                                        nivel,
                                                        rpm,
                                                        servo_motor
                                                        FROM bomba_agua_stirling
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
                   "fecha" => $fila[1],
                   "nivel" => $fila[2],
                   "rpm" => $fila[3],
                   "servo_motor" => $fila[4]
                   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function bomba_stirling_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idbomba_agua_stirling,
                                                        fecha_hora,
                                                        nivel,
                                                        rpm,
                                                        servo_motor
                                                        FROM bomba_agua_stirling
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
                   "fecha" => $fila[1],
                   "nivel" => $fila[2],
                   "rpm" => $fila[3],
                   "servo_motor" => $fila[4]
                   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Lombricomposta

function lombricompostario(){
  $consulta = "SELECT idlombricompostario, 
                                                        fecha_hora, 
                                                        motor_estado,
                                                        motor_frecuencia,
                                                        humedad,
                                                        temperatura
                                                        FROM lombricompostario ORDER BY idlombricompostario DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "motor_estado" => $fila[2],
		   "motor_frecuencia" => $fila[3],
		   "humedad" => $fila[4],
		   "temperatura" => $fila[5]
		   );

  echo json_encode($arreglo);

}

function lombricompostario_diario($fecha, $act)
{
  if ($act==2)  
{

  $consulta = "SELECT idlombricompostario, 
                                                        fecha_hora, 
                                                        motor_estado,
                                                        motor_frecuencia,
                                                        humedad,
                                                        temperatura
                                                        FROM lombricompostario
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "motor_estado" => $fila[2],
		   "motor_frecuencia" => $fila[3],
		   "humedad" => $fila[4],
		   "temperatura" => $fila[5]
		   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function lombricompostario_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idlombricompostario, 
                                                        fecha_hora, 
                                                        motor_estado,
                                                        motor_frecuencia,
                                                        humedad,
                                                        temperatura
                                                        FROM lombricompostario
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "motor_estado" => $fila[2],
		   "motor_frecuencia" => $fila[3],
		   "humedad" => $fila[4],
		   "temperatura" => $fila[5]
		   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Acuaponia

function acuaponia(){
  $consulta = "SELECT idacuaponia,
                                        fecha_hora,
                                        temp_amb,
                                        temp_agua,
                                        ph,
                                        dispensador_1a,
                                        dispensador_1b_frec,
                                        dispensador_2a,
                                        dispensador_2b_frec,
                                        dispensador_3a,
                                        dispensador_3b_frec,
                                        bomba_1a,
                                        bomba_1b,
                                        bomba_1c,
                                        bomba_2a,
                                        bomba_2b,
                                        bomba_2c
                                        FROM acuaponia ORDER BY idacuaponia DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_amb" => $fila[2],
		   "temp_agua" => $fila[3],
		   "ph" => $fila[4],
		   "dispensador_1a" => $fila[5],
		   "dispensador_1b_frec" => $fila[6],
		   "dispensador_2a" => $fila[7],
		   "dispensador_2b_frec" => $fila[8],
		   "dispensador_3a" => $fila[9],
		   "dispensador_3b_frec" => $fila[10],
		   "bomba_1a" => $fila[11],
		   "bomba_1b" => $fila[12],
		   "bomba_1c" => $fila[13],
		   "bomba_2a" => $fila[14],
		   "bomba_2b" => $fila[15],
		   "bomba_2c" => $fila[16]
);

  echo json_encode($arreglo);
}

// Acuaponia diario

function acuaponia_diario($fecha, $act)
{
  if ($act==2)
    {

      $consulta = "SELECT idacuaponia,
                                        fecha_hora,
                                        temp_amb,
                                        temp_agua,
                                        ph,
                                        dispensador_1a,
                                        dispensador_1b_frec,
                                        dispensador_2a,
                                        dispensador_2b_frec,
                                        dispensador_3a,
                                        dispensador_3b_frec,
                                        bomba_1a,
                                        bomba_1b,
                                        bomba_1c,
                                        bomba_2a,
                                        bomba_2b,
                                        bomba_2c
                                        FROM acuaponia
                                        WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                        GROUP BY HOUR(fecha_hora)";


    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "temp_amb" => $fila[2],
			   "temp_agua" => $fila[3],
			   "ph" => $fila[4],
			   "dispensador_1a" => $fila[5],
			   "dispensador_1b_frec" => $fila[6],
			   "dispensador_2a" => $fila[7],
			   "dispensador_2b_frec" => $fila[8],
			   "dispensador_3a" => $fila[9],
			   "dispensador_3b_frec" => $fila[10],
			   "bomba_1a" => $fila[11],
			   "bomba_1b" => $fila[12],
			   "bomba_1c" => $fila[13],
			   "bomba_2a" => $fila[14],
			   "bomba_2b" => $fila[15],
			   "bomba_2c" => $fila[16]);

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Acuaponia rangos

function acuaponia_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

      $consulta = "SELECT idacuaponia,
                                        fecha_hora,
                                        temp_amb,
                                        temp_agua,
                                        ph,
                                        dispensador_1a,
                                        dispensador_1b_frec,
                                        dispensador_2a,
                                        dispensador_2b_frec,
                                        dispensador_3a,
                                        dispensador_3b_frec,
                                        bomba_1a,
                                        bomba_1b,
                                        bomba_1c,
                                        bomba_2a,
                                        bomba_2b,
                                        bomba_2c
                                        FROM acuaponia
                                        WHERE fecha_hora > '$fecha' AND fecha_hora < '$fecha2'
                                        GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";

    }
//	echo $consulta;
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {

      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "temp_amb" => $fila[2],
			   "temp_agua" => $fila[3],
			   "ph" => $fila[4],
			   "dispensador_1a" => $fila[5],
			   "dispensador_1b_frec" => $fila[6],
			   "dispensador_2a" => $fila[7],
			   "dispensador_2b_frec" => $fila[8],
			   "dispensador_3a" => $fila[9],
			   "dispensador_3b_frec" => $fila[10],
			   "bomba_1a" => $fila[11],
			   "bomba_1b" => $fila[12],
			   "bomba_1c" => $fila[13],
			   "bomba_2a" => $fila[14],
			   "bomba_2b" => $fila[15],
			   "bomba_2c" => $fila[16]);

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);
  
}



// Destilador solar 

function destilador_solar(){
  $consulta = "SELECT iddestilador_solar,
                                                fecha_hora,
                                                temp_sol,
                                                temp_lente,
                                                temp_interna,
                                                nivel_contenedor
                                                FROM destilador_solar ORDER BY iddestilador_solar DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temperatura_sol" => $fila[2],
		   "temperatura_lente" => $fila[3],
		   "temperatura_interna" => $fila[4],
		   "nivel_contenedor" => $fila[5]
);

  echo json_encode($arreglo);
}

function destilador_solar_diario($fecha, $act)
{
  if ($act==2)  
{
  $consulta = "SELECT iddestilador_solar,
                                                fecha_hora,
                                                temp_sol,
                                                temp_lente,
                                                temp_interna,
                                                nivel_contenedor
                                                FROM destilador_solar
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temperatura_sol" => $fila[2],
		   "temperatura_lente" => $fila[3],
		   "temperatura_interna" => $fila[4],
		   "nivel_contenedor" => $fila[5]
                       );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function destilador_solar_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {
      $consulta = "SELECT iddestilador_solar,
                                                fecha_hora,
                                                temp_sol,
                                                temp_lente,
                                                temp_interna,
                                                nivel_contenedor
                                                FROM destilador_solar
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
  $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temperatura_sol" => $fila[2],
		   "temperatura_lente" => $fila[3],
		   "temperatura_interna" => $fila[4],
		   "nivel_contenedor" => $fila[5]
);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Condensador atmosferico

function condensador_atmosferico(){
  $consulta = "SELECT idcondensador_atmosferico,
                                                                fecha_hora,
                                                                temp_ambiente,
                                                                temp_interior,
                                                                temp_agua,
                                                                humedad_1,
                                                                humedad_2,
                                                                ldr_estado,
                                                                motor_estado,
                                                                nivel_agua
                                                                FROM condensador_atmosferico ORDER BY idcondensador_atmosferico DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_ambiente" => $fila[2],
		   "temp_interior" => $fila[3],
		   "temp_agua" => $fila[4],
		   "humedad_1" => $fila[5],
                   "humedad_2" => $fila[6],
		   "ldr_estado" => $fila[7],
		   "motor_estado" => $fila[8],
		   "flujo_agua" => $fila[9]
);

  echo json_encode($arreglo);
}

function condensador_atmosferico_diario($fecha, $act)
{
  if ($act==2)  
{
  $consulta = "SELECT idcondensador_atmosferico,
                                                                fecha_hora,
                                                                temp_ambiente,
                                                                temp_interior,
                                                                temp_agua,
                                                                humedad_1,
                                                                humedad_2,
                                                                ldr_estado,
                                                                motor_estado,
                                                                nivel_agua
                                                FROM condensador_atmosferico
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
  
  $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_ambiente" => $fila[2],
		   "temp_interior" => $fila[3],
		   "temp_agua" => $fila[4],
		   "humedad_1" => $fila[5],
                   "humedad_2" => $fila[6],
		   "ldr_estado" => $fila[7],
		   "motor_estado" => $fila[8],
		   "flujo_agua" => $fila[9]
);
  
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function condensador_atmosferico_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idcondensador_atmosferico,
                                                                fecha_hora,
                                                                temp_ambiente,
                                                                temp_interior,
                                                                temp_agua,
                                                                humedad_1,
                                                                humedad_2,
                                                                ldr_estado,
                                                                motor_estado,
                                                                nivel_agua
                                                FROM condensador_atmosferico
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {

      $arreglo_tmp = array("id" => $fila[0],
                           "fecha" => $fila[1],
                           "temp_ambiente" => $fila[2],
                           "temp_interior" => $fila[3],
                           "temp_agua" => $fila[4],
                           "humedad_1" => $fila[5],
                           "humedad_2" => $fila[6],
                           "ldr_estado" => $fila[7],
                           "motor_estado" => $fila[8],
                           "flujo_agua" => $fila[9]
                       );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Agua de lluvia

function agua_de_lluvia(){
  $consulta = "SELECT idagua_de_lluvia, 
                             fecha_hora, 
                             Nivel_1,
                             nivel_2,
                             nivel_3,
                             nivel_4,
                             nivel_5,
                             nivel_6,
                             bomba_1,
                             bomba_2
                             FROM agua_de_lluvia ORDER BY idagua_de_lluvia DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);
  
  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "nivel_1" => $fila[2],
		   "nivel_2" => $fila[3],
		   "nivel_3" => $fila[4],
                   "nivel_4" => $fila[5],
                   "nivel_5" => $fila[6],
                   "nivel_6" => $fila[7],
		   "bomba_1" => $fila[8],
		   "bomba_2" => $fila[9]
 );

  echo json_encode($arreglo);
}

// Agua de lluvia DIARIO

function agua_de_lluvia_diario($fecha, $act){
  $consulta = "SELECT idagua_de_lluvia, 
                             fecha_hora, 
                             nivel_1,
                             nivel_2,
                             nivel_3,
                             nivel_4,
                             nivel_5,
                             nivel_6,
                             bomba_1,
                             bomba_2
                             FROM agua_de_lluvia
                             WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY) 
                             GROUP BY HOUR(fecha_hora)";
      

    
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "nivel_1" => $fila[2],
			   "nivel_2" => $fila[3],
			   "nivel_3" => $fila[4],
			   "nivel_4" => $fila[5],
			   "nivel_5" => $fila[6],
			   "nivel_6" => $fila[7],
			   "bomba_1" => $fila[8],
			   "bomba_2" => $fila[9]
			   );

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Agua de lluvia RANGOS
function agua_de_lluvia_rangos($fecha, $fecha2, $act){
  $consulta = "SELECT idagua_de_lluvia, 
                             fecha_hora, 
                             nivel_1,
                             nivel_2,
                             nivel_3,
                             nivel_4,
                             nivel_5,
                             nivel_6,
                             bomba_1,
                             bomba_2
                             FROM agua_de_lluvia
                             WHERE fecha_hora > '$fecha' AND fecha_hora < '$fecha2' 
                             GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
      
    
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "nivel_1" => $fila[2],
			   "nivel_2" => $fila[3],
			   "nivel_3" => $fila[4],
			   "nivel_4" => $fila[5],
			   "nivel_5" => $fila[6],
			   "nivel_6" => $fila[7],
			   "bomba_1" => $fila[8],
			   "bomba_2" => $fila[9]
			   );

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Autonomia de transporte
function autonomia_transporte(){
  $consulta = "SELECT idautonomia_transporte,
                                                        fecha_hora,
                                                        contador_alternador
                                                        FROM autonomia_transporte ORDER BY idautonomia_transporte DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0], 
		   "fecha_hora" => $fila[1], 
		   "alternador" => $fila[2]
		   );
  
  echo json_encode($arreglo);
}

function autonomia_transporte_diario($fecha, $act)
{
  if ($act==2)  
{
  $consulta = "SELECT idautonomia_transporte,
                                                        fecha_hora,
                                                        contador_alternador
                                                FROM autonomia_transporte
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
  
  $arreglo_tmp = array("id" => $fila[0], 
		   "fecha_hora" => $fila[1], 
		   "alternador" => $fila[2]
		   );
  
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function autonomia_transporte_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {
  $consulta = "SELECT idautonomia_transporte,
                                                        fecha_hora,
                                                        contador_alternador
                                                FROM autonomia_transporte
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0], 
		   "fecha_hora" => $fila[1], 
		   "alternador" => $fila[2]
		   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}


// Enfriamiento por adsorcion

function enfriamiento_adsorcion(){
  $consulta = "SELECT idenfriamiento_adsorcion,
                                                                fecha_hora,
                                                                presion,
                                                                presion_domo,
                                                                presion_tuberia,
                                                                temp_agua_fria,
                                                                temp_agua_caliente,
                                                                temp_salida_caliente,
                                                                temp_tuberia
                                                                FROM enfriamiento_adsorcion ORDER BY idenfriamiento_adsorcion DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);
  
  $arreglo = array("id" => $fila[0],
                   "fecha_hora" => $fila[1],
                   "presion" => $fila[2],
                   "presion_domo" => $fila[3],
                   "presion_tuberia" => $fila[4],
                   "temp_agua_fria" => $fila[5],
                   "temp_agua_caliente" => $fila[6],
                   "temp_salida_caliente" => $fila[7],
                   "temp_tuberia" => $fila[8]
                   );

  echo json_encode($arreglo);
}


function enfriamiento_adsorcion_diario($fecha, $act)
{
  if ($act==2)  
{
 $consulta = "SELECT idenfriamiento_adsorcion,
                                                                fecha_hora,
                                                                presion,
                                                                presion_domo,
                                                                presion_tuberia,
                                                                temp_agua_fria,
                                                                temp_agua_caliente,
                                                                temp_salida_caliente,
                                                                temp_tuberia
                                                                FROM enfriamiento_adsorcion
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
  
  $arreglo = array("id" => $fila[0],
                   "fecha_hora" => $fila[1],
                   "presion" => $fila[2],
                   "presion_domo" => $fila[3],
                   "presion_tuberia" => $fila[4],
                   "temp_agua_fria" => $fila[5],
                   "temp_agua_caliente" => $fila[6],
                   "temp_salida_caliente" => $fila[7],
                   "temp_tuberia" => $fila[8]
                   );
  
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function enfriamiento_adsorcion_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

      $consulta = "SELECT idenfriamiento_adsorcion,
                                                                fecha_hora,
                                                                presion,
                                                                presion_domo,
                                                                presion_tuberia,
                                                                temp_agua_fria,
                                                                temp_agua_caliente,
                                                                temp_salida_caliente,
                                                                temp_tuberia
                                                                FROM enfriamiento_adsorcion
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
                   "fecha_hora" => $fila[1],
                   "presion" => $fila[2],
                   "presion_domo" => $fila[3],
                   "presion_tuberia" => $fila[4],
                   "temp_agua_fria" => $fila[5],
                   "temp_agua_caliente" => $fila[6],
                   "temp_salida_caliente" => $fila[7],
                   "temp_tuberia" => $fila[8]
                   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

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
