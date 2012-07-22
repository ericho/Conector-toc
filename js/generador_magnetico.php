<?

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
?>