<?

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

function descargar_autonomia_transporte($fecha)
{
    $archivo = "autonomia_transporte_$fecha.csv";
  $consulta = "SELECT              fecha_hora,
                                   contador_alternador
                                   FROM autonomia_transporte
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
    array_push($cabecera, 'Contador alternador');
    
    
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