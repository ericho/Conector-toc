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


?>