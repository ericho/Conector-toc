<?
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


// Genera una consulta y descarga al informacion en formato CSV. 
function descargar_biodigestor_metano($fecha)
{
    $archivo = "biodigestor_metano_$fecha.csv";
  $consulta = "SELECT fecha_hora,
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
                            GROUP BY ROUND(UNIX_TIMESTAMP(fecha_hora) / 300)";

    $res = mysql_query($consulta);
    
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Description: File Transfer');
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$archivo}");
    header("Expires: 0");
    header("Pragma: public");
    
    //$fila = mysql_fetch_array($res);
    
    $cabecera = array();
    array_push($cabecera, 'Fecha');
    array_push($cabecera, 'Temperatura Mezcla');
    array_push($cabecera, 'Temperatura Reactor');
    array_push($cabecera, 'Nivel Reactor');
    array_push($cabecera, 'Nivel deposito gas');
    array_push($cabecera, 'Resistencia calentador agua');
    array_push($cabecera, 'Motor agitador a');
    array_push($cabecera, 'Motor agitador b On');
    array_push($cabecera, 'Motor agitador c frec');    
    array_push($cabecera, 'Presion gas');
    
    $archivo_csv = @fopen('php://output', 'w');
    fputcsv($archivo_csv, $cabecera);
    while ($fila = mysql_fetch_row($res))
    {
        fputcsv($archivo_csv, $fila);
    }
    
    fclose($archivo_csv);
    exit;
    

?>