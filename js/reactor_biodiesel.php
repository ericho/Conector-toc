<?

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

function descargar_reactor_biodiesel($fecha)
{
    $archivo = "reactor_biodiesel_$fecha.csv";
    $consulta = "SELECT                          fecha_hora,
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
    array_push($cabecera, 'Temperatura reactor');
    array_push($cabecera, 'Bomba 1');
    array_push($cabecera, 'Bomba 2');
    array_push($cabecera, 'Agitador 1a');
    array_push($cabecera, 'Agitador 1b');
    array_push($cabecera, 'Agitador 2a');     
    array_push($cabecera, 'Agitador 2b'); 
    array_push($cabecera, 'Agitador 2c');
    array_push($cabecera, 'Calentador estado');
    array_push($cabecera, 'Calentador tiempo');
    
    
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