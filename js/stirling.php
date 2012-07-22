<?


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

function descargar_calentador_stirling($fecha)
{
    $archivo = "calentador_stirling_$fecha.csv";
    $consulta = "SELECT                                                 fecha_hora,
                                                                        temp_entrada_caliente,
                                                                        temp_entrada_fria,
                                                                        rpm,
                                                                        presion
                             	         	 FROM generador_calentador_stirling
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
    array_push($cabecera, 'Temperatura caliente');
    array_push($cabecera, 'Temperatura fria');
    array_push($cabecera, 'rpm');
    array_push($cabecera, 'presion');
    
    
    $archivo_csv = @fopen('php://output', 'w');
    fputcsv($archivo_csv, $cabecera);
    while ($fila = mysql_fetch_row($res))
    {
        fputcsv($archivo_csv, $fila);
    }
    
    fclose($archivo_csv);
    exit;
    
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

function descargar_bomba_stirling($fecha)
{
    $archivo = "bomba_stirling_$fecha.csv";
  $consulta = "SELECT                                   fecha_hora,
                                                        nivel,
                                                        rpm,
                                                        servo_motor
                                                        FROM bomba_agua_stirling
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
    array_push($cabecera, 'Nivel');
    array_push($cabecera, 'rpm');
    array_push($cabecera, 'Servo');
    
    
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