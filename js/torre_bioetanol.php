<?
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

function descargar_torre_bioetanol($fecha)
{
    $archivo = "torre_bioetanol_$fecha.csv";
  $consulta = "SELECT       fecha_hora,
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
    array_push($cabecera, 'Presion calderin');
    array_push($cabecera, 'Presion domo');
    array_push($cabecera, 'Presion enchaquetado');
    array_push($cabecera, 'Temperatura domo');
    array_push($cabecera, 'Temperatura calderin');
    array_push($cabecera, 'Temperatura enchaquetado');
    array_push($cabecera, 'Nivel calderin');
    array_push($cabecera, 'Nivel almacenamiento');
    
    
    $archivo_csv = @fopen('php://output', 'w');
    fputcsv($archivo_csv, $cabecera);
    while ($fila = mysql_fetch_row($res))
    {
        fputcsv($archivo_csv, $fila);
    }
    
    fclose($archivo_csv);
    exit;
    
}


?>
