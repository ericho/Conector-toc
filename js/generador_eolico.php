<?

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

?>