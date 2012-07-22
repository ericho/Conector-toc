<?

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

function descargar_condensador_atmosferico($fecha)
{
    $archivo = "condensador_atmosferico_$fecha.csv";
    $consulta = "SELECT                                         fecha_hora,
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
    array_push($cabecera, 'Temperatura ambiente');
    array_push($cabecera, 'Temperatura interior');
    array_push($cabecera, 'Temperatura agua');
    array_push($cabecera, 'Humedad 1');
    array_push($cabecera, 'Humedad 2');
    array_push($cabecera, 'Estado LDR');
    array_push($cabecera, 'Estado motor');
    array_push($cabecera, 'Nivel Agua');
    
    
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